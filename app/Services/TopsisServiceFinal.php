<?php

namespace App\Services;

use App\Models\Alternatif;
use App\Models\BobotKarir;
use App\Models\HasilRekomendasi;
use App\Models\NilaiMahasiswa;
use App\Models\PenilaianKriteria;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TopsisServiceFinal
{
    // Bobot AHP dari dokumen
    const BOBOT_AHP = [
        'nilai_akademik' => 0.2507,  // 25.07%
        'skill_teknis' => 0.4967,     // 49.67%
        'minat' => 0.1027,            // 10.27%
        'sertifikat' => 0.1495,       // 14.95%
    ];

    /**
     * Hitung TOPSIS dengan 4 kriteria (Nilai Akademik, Skill Teknis, Minat, Sertifikat)
     * @param User $user
     * @param bool $simpan
     * @return array
     */
    public function hitung(User $user, bool $simpan = true): array
    {
        $alternatifs = Alternatif::orderBy('id')->get();

        if ($alternatifs->isEmpty()) {
            return ['error' => 'Data alternatif belum tersedia.'];
        }

        // Ambil nilai mahasiswa untuk mata kuliah
        $nilaiMahasiswa = NilaiMahasiswa::where('user_id', $user->id)
            ->get()
            ->keyBy('kriteria_id');

        if ($nilaiMahasiswa->isEmpty()) {
            return ['error' => 'Mahasiswa belum mengisi nilai mata kuliah.'];
        }

        // Ambil penilaian kriteria (skill, minat, sertifikat) untuk setiap alternatif
        $penilaianKriteria = PenilaianKriteria::where('user_id', $user->id)
            ->get()
            ->keyBy('alternatif_id');

        if ($penilaianKriteria->isEmpty()) {
            return ['error' => 'Mahasiswa belum mengisi penilaian skill, minat, dan sertifikat.'];
        }

        // Step 0: Buat matriks keputusan (8 alternatif × 4 kriteria)
        $matriks = [];
        foreach ($alternatifs as $ai => $alt) {
            // C1: Nilai Akademik - dihitung dari nilai mata kuliah × bobot mata kuliah untuk karir ini
            $bobotKarir = BobotKarir::where('alternatif_id', $alt->id)->get();
            $nilaiAkademik = 0;
            foreach ($bobotKarir as $bobot) {
                $nilaiMk = $nilaiMahasiswa->get($bobot->kriteria_id);
                if ($nilaiMk) {
                    $nilaiAkademik += ($nilaiMk->nilai * $bobot->bobot) / 100;
                }
            }
            
            // C2, C3, C4: Skill Teknis, Minat, Sertifikat
            $penilaian = $penilaianKriteria->get($alt->id);
            
            $matriks[$ai] = [
                $nilaiAkademik,                          // C1: Nilai Akademik
                $penilaian ? $penilaian->skill_teknis : 0,  // C2: Skill Teknis
                $penilaian ? $penilaian->minat : 0,         // C3: Minat
                $penilaian ? $penilaian->sertifikat : 0,    // C4: Sertifikat
            ];
        }

        $jumlahAlternatif = count($alternatifs);
        $jumlahKriteria = 4;

        // Step 1: Normalisasi matriks keputusan
        // rij = xij / sqrt(sum(xij^2))
        $normalisasi = [];
        for ($j = 0; $j < $jumlahKriteria; $j++) {
            $sumSquare = 0;
            for ($i = 0; $i < $jumlahAlternatif; $i++) {
                $sumSquare += pow($matriks[$i][$j], 2);
            }
            $sqrtSum = sqrt($sumSquare);
            for ($i = 0; $i < $jumlahAlternatif; $i++) {
                $normalisasi[$i][$j] = $sqrtSum > 0 ? $matriks[$i][$j] / $sqrtSum : 0;
            }
        }

        // Step 2: Matriks normalisasi terbobot (menggunakan bobot AHP)
        // vij = wj * rij
        $bobot = array_values(self::BOBOT_AHP);
        $terbobot = [];
        for ($i = 0; $i < $jumlahAlternatif; $i++) {
            for ($j = 0; $j < $jumlahKriteria; $j++) {
                $terbobot[$i][$j] = $normalisasi[$i][$j] * $bobot[$j];
            }
        }

        // Step 3: Solusi ideal positif (A+) dan negatif (A-)
        // Semua kriteria adalah benefit (semakin tinggi semakin baik)
        $idealPositif = [];
        $idealNegatif = [];
        for ($j = 0; $j < $jumlahKriteria; $j++) {
            $kolom = [];
            for ($i = 0; $i < $jumlahAlternatif; $i++) {
                $kolom[] = $terbobot[$i][$j];
            }
            $idealPositif[$j] = max($kolom);  // Benefit: max
            $idealNegatif[$j] = min($kolom);  // Benefit: min
        }

        // Step 4: Jarak ke solusi ideal positif (D+) dan negatif (D-)
        $dPositif = [];
        $dNegatif = [];
        for ($i = 0; $i < $jumlahAlternatif; $i++) {
            $sumDp = 0;
            $sumDn = 0;
            for ($j = 0; $j < $jumlahKriteria; $j++) {
                $sumDp += pow($terbobot[$i][$j] - $idealPositif[$j], 2);
                $sumDn += pow($terbobot[$i][$j] - $idealNegatif[$j], 2);
            }
            $dPositif[$i] = sqrt($sumDp);
            $dNegatif[$i] = sqrt($sumDn);
        }

        // Step 5: Nilai preferensi (Ci)
        // Ci = D- / (D+ + D-)
        $preferensi = [];
        for ($i = 0; $i < $jumlahAlternatif; $i++) {
            $total = $dPositif[$i] + $dNegatif[$i];
            $preferensi[$i] = $total > 0 ? $dNegatif[$i] / $total : 0;
        }

        // Step 6: Ranking
        $hasil = [];
        foreach ($alternatifs as $i => $alt) {
            $hasil[] = [
                'alternatif_id' => $alt->id,
                'nama' => $alt->nama,
                'nilai_akademik' => round($matriks[$i][0], 2),
                'skill_teknis' => round($matriks[$i][1], 2),
                'minat' => round($matriks[$i][2], 2),
                'sertifikat' => round($matriks[$i][3], 2),
                'skor' => round($preferensi[$i], 6),
            ];
        }

        usort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']);

        foreach ($hasil as $rank => &$h) {
            $h['ranking'] = $rank + 1;
        }

        // Simpan ke database jika diminta
        if ($simpan) {
            DB::transaction(function () use ($user, $hasil) {
                // Hapus hasil lama
                HasilRekomendasi::whereHas('mahasiswa', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->delete();
                
                // Cari atau buat mahasiswa
                $mahasiswa = $user->mahasiswa;
                if (!$mahasiswa) {
                    return; // Skip jika belum ada data mahasiswa
                }
                
                foreach ($hasil as $h) {
                    HasilRekomendasi::create([
                        'mahasiswa_id' => $mahasiswa->id,
                        'alternatif_id' => $h['alternatif_id'],
                        'skor' => $h['skor'],
                        'ranking' => $h['ranking'],
                    ]);
                }
            });
        }

        return [
            'hasil' => $hasil,
            'detail' => [
                'matriks_keputusan' => $matriks,
                'normalisasi' => $normalisasi,
                'terbobot' => $terbobot,
                'ideal_positif' => $idealPositif,
                'ideal_negatif' => $idealNegatif,
                'd_positif' => $dPositif,
                'd_negatif' => $dNegatif,
                'preferensi' => $preferensi,
                'alternatifs' => $alternatifs->toArray(),
                'bobot_ahp' => self::BOBOT_AHP,
            ],
        ];
    }
}
