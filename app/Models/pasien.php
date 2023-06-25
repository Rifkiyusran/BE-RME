<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pasien extends Model
{
    use HasFactory;

    protected $primarykey = 'ID_PASIEN';
    protected $table = 'pasien';
    public $timestamps = false;

    public $fillable = [
        'ID_PASIEN',
        'ID_PENDIDIKAN_TERAKHIR',
        'ID_USER',
        'ID_AGAMA',
        'ID_JENIS_PELAYANAN',
        'NAMA_LENGKAP',
        'TEMPAT_LAHIR',
        'TANGGAL_LAHIR',
        'ALAMAT',
        'GOL_DARAH',
        'NO_NIK',
        'NO_KK',
        'JENIS_KELAMIN',
        'TIPE_USER'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ID_USER', 'ID_PASIEN');
    }

    public function agama()
    {
        return $this->belongsTo(agama::class, 'ID_AGAMA', 'ID_PASIEN');
    }

    public function jenis_pelayanan()
    {
        return $this->belongsTo(jenis_pelayanan::class, 'ID_JENIS_PELAYANAN', 'ID_PASIEN');
    }

    public function penyakit()
    {
        return $this->belongsTo(penyakit::class, 'ID_PENYAKIT', 'ID_PASIEN');
    }

    public function pendidikan_terakhir()
    {
        return $this->belongsTo(pendidikan_terakhir::class, 'ID_PENDIDIKAN_TERAKHIR', 'ID_PASIEN');
    }

    public function pelayanan_kb()
    {
        return $this->hasMany(pelayanan_kb::class, 'ID_PASIEN', 'ID_PASIEN');
    }

    public function pelayanan_imunisasi()
    {
        return $this->hasMany(pelayanan_imunisasi::class, 'ID_PASIEN', 'ID_PASIEN');
    }

    public function pelayanan_kehamilan_melahirkan()
    {
        return $this->hasMany(pelayanan_kehamilan_melahirkan::class, 'ID_PASIEN', 'ID_PASIEN');
    }
}
