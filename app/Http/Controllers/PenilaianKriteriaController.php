<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\NilaiMahasiswa;
use App\Models\PenilaianKriteria;
use App\Services\TopsisServiceFinal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenilaianKriteriaController extends Controller
{
    // Mapping skill → karir (untuk menghitung skill_teknis per karir)
    const SKILL_MAP = [
        'Web Developer'    => ['HTML/CSS','JavaScript','TypeScript','PHP','React/Vue.js','REST API','MySQL/PostgreSQL','Bootstrap','Git/GitHub'],
        'Mobile Developer' => ['Flutter/Dart','React Native','Kotlin/Java','Swift','Android SDK','iOS Development','Firebase','Git/GitHub'],
        'Data Analyst'     => ['SQL','Python','Excel/Spreadsheet','Tableau','Power BI','Statistika','R','MySQL/PostgreSQL','Data Analysis'],
        'Network Engineer' => ['TCP/IP','Linux Server','Cisco/MikroTik','Network Security','Firewall/VPN','Wireshark','Shell/Bash Scripting'],
        'UI/UX Designer'   => ['Figma','Adobe XD','UI Design','UX Research','Prototyping','Wireframing','HTML/CSS','Canva Pro'],
        'QA Engineer'      => ['Manual Testing','Selenium/Playwright','Postman','JIRA','Test Automation','JUnit/PyTest','Python','Git/GitHub'],
        'Data Scientist'   => ['Python','R','Machine Learning','Deep Learning','Statistika','SQL','Data Analysis','Docker'],
        'DevOps Engineer'  => ['Docker','Kubernetes','AWS/GCP/Azure','CI/CD Pipeline','Shell/Bash Scripting','Terraform','Linux Server','Git/GitHub','Ansible'],
    ];

    public function create()
    {
        $user = auth()->user();
        $alternatifs = Alternatif::orderBy('id')->get();
        $hasNilaiAkademik = NilaiMahasiswa::where('user_id', $user->id)->exists();

        // Ambil data tersimpan
        $penilaianTersimpan = PenilaianKriteria::where('user_id', $user->id)
            ->get()
            ->keyBy('alternatif_id');

        // Reconstruct saved global values
        $savedSkills    = json_decode($user->saved_skills ?? '[]', true);
        $savedMinat1    = $user->saved_minat_1 ?? null;
        $savedMinat2    = $user->saved_minat_2 ?? null;
        $savedSertifikasi = null;
        $savedProyek    = null;

        if ($penilaianTersimpan->isNotEmpty()) {
            $first = $penilaianTersimpan->first();
            $savedSertifikasi = (int) $first->sertifikat;
            $savedProyek = (int) ($first->proyek ?? 0);
        }

        return view('penilaian_kriteria.create', compact(
            'alternatifs', 'penilaianTersimpan', 'hasNilaiAkademik',
            'savedSkills', 'savedMinat1', 'savedMinat2', 'savedSertifikasi', 'savedProyek'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'skills'       => 'nullable|array',
            'minat_1'      => 'required|exists:alternatifs,id',
            'minat_2'      => 'required|exists:alternatifs,id|different:minat_1',
            'proyek'       => 'required|integer|min:0|max:6',
            'sertifikasi'  => 'required|integer|min:0|max:6',
        ], [
            'minat_1.required'   => 'Pilih Minat Pilihan Pertama!',
            'minat_2.required'   => 'Pilih Minat Pilihan Kedua!',
            'minat_2.different'  => 'Pilihan 2 tidak boleh sama dengan Pilihan 1!',
            'proyek.required'    => 'Pilih jumlah proyek mandiri!',
            'sertifikasi.required' => 'Pilih jumlah sertifikasi!',
        ]);

        $user          = auth()->user();
        $alternatifs   = Alternatif::orderBy('id')->get();
        $selectedSkills = $request->input('skills', []);
        $minat1Id      = (int) $request->input('minat_1');
        $minat2Id      = (int) $request->input('minat_2');
        $sertifikasi   = (int) $request->input('sertifikasi');
        $proyek        = (int) $request->input('proyek');

        // Skor sertifikasi gabungan (rata-rata sertif + proyek, skala 0-10)
        $sertifSkor = round(($sertifikasi + $proyek) / 2, 1);

        // Simpan skills & minat ke user meta (untuk ditampilkan kembali)
        $user->saved_skills  = json_encode($selectedSkills);
        $user->saved_minat_1 = $minat1Id;
        $user->saved_minat_2 = $minat2Id;
        $user->save();

        DB::transaction(function () use ($user, $alternatifs, $selectedSkills, $minat1Id, $minat2Id, $sertifSkor, $proyek, $sertifikasi) {
            foreach ($alternatifs as $alt) {
                // --- Hitung Skill Teknis (0-100) ---
                $careerSkills = self::SKILL_MAP[$alt->nama] ?? [];
                $matched = 0;
                foreach ($selectedSkills as $s) {
                    if (in_array($s, $careerSkills)) $matched++;
                }
                $skillSkor = count($careerSkills) > 0
                    ? round(($matched / count($careerSkills)) * 100)
                    : 0;

                // --- Hitung Minat (1-5) ---
                if ($alt->id === $minat1Id) {
                    $minatSkor = 5; // Sangat Minat
                } elseif ($alt->id === $minat2Id) {
                    $minatSkor = 4; // Minat
                } else {
                    $minatSkor = 1; // Tidak dipilih
                }

                PenilaianKriteria::updateOrCreate(
                    ['user_id' => $user->id, 'alternatif_id' => $alt->id],
                    [
                        'skill_teknis' => $skillSkor,
                        'minat'        => $minatSkor,
                        'sertifikat'   => $sertifSkor,
                    ]
                );
            }
        });

        return redirect()->route('penilaian-kriteria.create')
            ->with('success', 'Kuisioner berhasil disimpan! Silakan klik "Hitung Rekomendasi Karir" untuk melihat hasilnya.');
    }

    public function calculate()
    {
        $user = auth()->user();

        if (!$user->mahasiswa) {
            return redirect()->route('mahasiswa.create')
                ->with('error', 'Silakan lengkapi data mahasiswa terlebih dahulu.');
        }

        $hasNilai = NilaiMahasiswa::where('user_id', $user->id)->exists();
        if (!$hasNilai) {
            return redirect()->route('nilai.create')
                ->with('error', 'Silakan isi nilai mata kuliah terlebih dahulu.');
        }

        $hasPenilaian = PenilaianKriteria::where('user_id', $user->id)->exists();
        if (!$hasPenilaian) {
            return redirect()->back()
                ->with('error', 'Silakan lengkapi kuisioner evaluasi karir terlebih dahulu.');
        }

        try {
            $service = new TopsisServiceFinal();
            $result  = $service->hitung($user, true);

            if (isset($result['error'])) {
                return redirect()->back()->with('error', $result['error']);
            }

            return redirect()->route('hasil.index')
                ->with('success', '✅ Rekomendasi karir berhasil dihitung!');

        } catch (\Exception $e) {
            Log::error('TOPSIS Calculate Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi error saat menghitung: ' . $e->getMessage());
        }
    }
}
