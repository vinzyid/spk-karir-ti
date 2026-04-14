<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenilaianKriteria extends Model
{
    protected $table = 'penilaian_kriteria';
    
    protected $fillable = [
        'user_id',
        'alternatif_id',
        'skill_teknis',
        'minat',
        'sertifikat'
    ];

    protected $casts = [
        'skill_teknis' => 'decimal:2',
        'minat' => 'decimal:2',
        'sertifikat' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function alternatif(): BelongsTo
    {
        return $this->belongsTo(Alternatif::class);
    }
}
