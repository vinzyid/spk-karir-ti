<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    protected $fillable = ['user_id', 'nama', 'nim', 'prodi'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }

    public function hasilRekomendasis(): HasMany
    {
        return $this->hasMany(HasilRekomendasi::class);
    }
}
