<?php

namespace App\Services;

use App\Models\Alternatif;
use App\Models\HasilRekomendasi;
use App\Models\Kriteria;
use App\Models\Mahasiswa;
use App\Models\Penilaian;
use Illuminate\Support\Facades\DB;

class TopsisService
{
    /**
     * Hitung TOPSIS untuk mahasiswa tertentu
     * @param bool $simpan — apakah menyimpan hasil ke DB
     */
    public function hitung(Mahasiswa $mahasiswa, bool $simpan = true): array
    {
        $kriteria = Kriteria::orderBy('kode')->get();
        $alternatifs = Alternatif::orderBy('id')->get();

        if ($kriteria->isEmpty() || $alternatifs->isEmpty()) {
            return ['error' => 'Data kriteria atau alternatif belum tersedia.'];
        }

        // Step 0: Ambil matriks keputusan
        $matriks = [];
        foreach ($alternatifs as $ai => $alt) {
            foreach ($kriteria as $ki => $krit) {
                $penilaian = Penilaian::where('mahasiswa_id', $mahasiswa->id)
                    ->where('alternatif_id', $alt->id)
                    ->where('kriteria_id', $krit->id)
                    ->first();
                $matriks[$ai][$ki] = $penilaian ? (float) $penilaian->nilai : 0;
            }
        }

        $jumlahAlternatif = count($alternatifs);
        $jumlahKriteria = count($kriteria);

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

        // Step 2: Matriks normalisasi terbobot
        // vij = wj * rij
        $bobot = $kriteria->pluck('bobot')->map(fn($b) => (float) $b)->toArray();
        $terbobot = [];
        for ($i = 0; $i < $jumlahAlternatif; $i++) {
            for ($j = 0; $j < $jumlahKriteria; $j++) {
                $terbobot[$i][$j] = $normalisasi[$i][$j] * $bobot[$j];
            }
        }

        // Step 3: Solusi ideal positif (A+) dan negatif (A-)
        $tipeKriteria = $kriteria->pluck('tipe')->toArray();
        $idealPositif = [];
        $idealNegatif = [];
        for ($j = 0; $j < $jumlahKriteria; $j++) {
            $kolom = [];
            for ($i = 0; $i < $jumlahAlternatif; $i++) {
                $kolom[] = $terbobot[$i][$j];
            }
            if ($tipeKriteria[$j] === 'benefit') {
                $idealPositif[$j] = max($kolom);
                $idealNegatif[$j] = min($kolom);
            } else {
                $idealPositif[$j] = min($kolom);
                $idealNegatif[$j] = max($kolom);
            }
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
                'skor' => round($preferensi[$i], 6),
            ];
        }

        usort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']);

        foreach ($hasil as $rank => &$h) {
            $h['ranking'] = $rank + 1;
        }

        // Simpan ke database jika diminta
        if ($simpan) {
            DB::transaction(function () use ($mahasiswa, $hasil) {
                HasilRekomendasi::where('mahasiswa_id', $mahasiswa->id)->delete();
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
                'kriteria' => $kriteria->toArray(),
                'alternatifs' => $alternatifs->toArray(),
                'bobot' => $bobot,
            ],
        ];
    }
}
