<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BobotKarir extends Model
{
    protected $table = 'bobot_karir';
    
    protected $fillable = [
        'alternatif_id',
        'kriteria_id',
        'bobot',
        'pasangan_kriteria_id',
    ];

    protected $casts = [
        'bobot' => 'decimal:2',
    ];

    public function alternatif(): BelongsTo
    {
        return $this->belongsTo(Alternatif::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}
