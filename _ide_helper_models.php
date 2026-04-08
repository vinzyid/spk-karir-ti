<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string|null $deskripsi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HasilRekomendasi> $hasilRekomendasis
 * @property-read int|null $hasil_rekomendasis_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penilaian> $penilaians
 * @property-read int|null $penilaians_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alternatif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alternatif newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alternatif query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alternatif whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alternatif whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alternatif whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alternatif whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alternatif whereUpdatedAt($value)
 */
	class Alternatif extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $mahasiswa_id
 * @property int $alternatif_id
 * @property numeric $skor
 * @property int $ranking
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Alternatif $alternatif
 * @property-read \App\Models\Mahasiswa $mahasiswa
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRekomendasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRekomendasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRekomendasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRekomendasi whereAlternatifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRekomendasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRekomendasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRekomendasi whereMahasiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRekomendasi whereRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRekomendasi whereSkor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRekomendasi whereUpdatedAt($value)
 */
	class HasilRekomendasi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string $kode
 * @property numeric $bobot
 * @property string $tipe
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penilaian> $penilaians
 * @property-read int|null $penilaians_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kriteria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kriteria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kriteria query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kriteria whereBobot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kriteria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kriteria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kriteria whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kriteria whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kriteria whereTipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kriteria whereUpdatedAt($value)
 */
	class Kriteria extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $nama
 * @property string $nim
 * @property string $prodi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HasilRekomendasi> $hasilRekomendasis
 * @property-read int|null $hasil_rekomendasis_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penilaian> $penilaians
 * @property-read int|null $penilaians_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereNim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereProdi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereUserId($value)
 */
	class Mahasiswa extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $mahasiswa_id
 * @property int $alternatif_id
 * @property int $kriteria_id
 * @property numeric $nilai
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Alternatif $alternatif
 * @property-read \App\Models\Kriteria $kriteria
 * @property-read \App\Models\Mahasiswa $mahasiswa
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereAlternatifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereKriteriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereMahasiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereNilai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereUpdatedAt($value)
 */
	class Penilaian extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mahasiswa|null $mahasiswa
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

