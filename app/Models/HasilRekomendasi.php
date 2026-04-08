<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilRekomendasi extends Model
{
    protected $fillable = ['mahasiswa_id', 'alternatif_id', 'skor', 'ranking'];

    protected $casts = [
        'skor' => 'decimal:6',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function alternatif(): BelongsTo
    {
        return $this->belongsTo(Alternatif::class);
    }
}
