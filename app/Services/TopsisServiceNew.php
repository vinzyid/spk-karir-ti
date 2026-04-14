<?php

namespace App\Services;

use App\Models\Alternatif;
use App\Models\BobotKarir;
use App\Models\HasilRekomendasi;
use App\Models\Kriteria;
use App\Models\NilaiMahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TopsisServiceNew
{
    /**
     * Hitung TOPSIS untuk user tertentu berdasarkan nilai mata kuliah
     * @param User $user
     * @param bool $simpan
     * @return array
     */
    public function hitung(User $user, bool $simpan = true): array
    {
        $alternatifs = Alternatif::orderBy('id')->get();
        $kriteria = Kriteria::orderBy('id')->get();

        if ($alternatifs->isEmpty() || $kriteria->isEmpty()) {
            return ['error' => 'Data alternatif atau mata kuliah belum tersedia.'];
        }

        // Ambil nilai mahasiswa
        $nilaiMahasiswa = NilaiMahasiswa::where('user_id', $user->id)
            ->get()
            ->keyBy('kriteria_id');

        if ($nilaiMahasiswa->isEmpty()) {
            return ['error' => 'Mahasiswa belum mengisi nilai mata kuliah.'];
        }

        // Step 0: Hitung nilai untuk setiap alternatif
        // Nilai alternatif = Σ (nilai_mk × bobot_mk_untuk_karir) / 100
        $matriks = [];
        foreach ($alternatifs as $ai => $alt) {
            $bobotKarir = BobotKarir::where('alternatif_id', $alt->id)->get();
            
            $totalNilai = 0;
            foreach ($bobotKarir as $bobot) {
                $nilaiMk = $nilaiMahasiswa->get($bobot->kriteria_id);
                if ($nilaiMk) {
                    // Nilai × Bobot (dalam persen)
                    $totalNilai += ($nilaiMk->nilai * $bobot->bobot) / 100;
                }
            }
            
            $matriks[$ai][0] = $totalNilai; // Hanya 1 kriteria: nilai total
        }

        $jumlahAlternatif = count($alternatifs);

        // Step 1: Normalisasi matriks keputusan
        // rij = xij / sqrt(sum(xij^2))
        $sumSquare = 0;
        for ($i = 0; $i < $jumlahAlternatif; $i++) {
            $sumSquare += pow($matriks[$i][0], 2);
        }
        $sqrtSum = sqrt($sumSquare);
        
        $normalisasi = [];
        for ($i = 0; $i < $jumlahAlternatif; $i++) {
            $normalisasi[$i][0] = $sqrtSum > 0 ? $matriks[$i][0] / $sqrtSum : 0;
        }

        // Step 2: Matriks normalisasi terbobot (bobot = 1 karena hanya 1 kriteria)
        $terbobot = $normalisasi;

        // Step 3: Solusi ideal positif (A+) dan negatif (A-)
        $kolom = array_column($terbobot, 0);
        $idealPositif = [max($kolom)];
        $idealNegatif = [min($kolom)];

        // Step 4: Jarak ke solusi ideal positif (D+) dan negatif (D-)
        $dPositif = [];
        $dNegatif = [];
        for ($i = 0; $i < $jumlahAlternatif; $i++) {
            $dPositif[$i] = abs($terbobot[$i][0] - $idealPositif[0]);
            $dNegatif[$i] = abs($terbobot[$i][0] - $idealNegatif[0]);
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
                'nilai_total' => round($matriks[$i][0], 2),
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
            ],
        ];
    }
}
