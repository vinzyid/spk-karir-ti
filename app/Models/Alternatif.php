<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alternatif extends Model
{
    protected $fillable = ['nama', 'deskripsi'];

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }

    public function hasilRekomendasis(): HasMany
    {
        return $this->hasMany(HasilRekomendasi::class);
    }
}
