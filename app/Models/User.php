<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'saved_skills',
        'saved_minat_1',
        'saved_minat_2',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'saved_skills'      => 'array',
            'saved_minat_1'     => 'integer',
            'saved_minat_2'     => 'integer',
        ];
    }

    public function mahasiswa(): HasOne
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function nilaiMahasiswa()
    {
        return $this->hasMany(NilaiMahasiswa::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
