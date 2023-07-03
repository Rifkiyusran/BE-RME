<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pasien extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_PASIEN';
    //protected $primaryKey = 'ID_PASIEN';
    //protected $guarded = ['id'];
    protected $table = 'pasien';
    public $timestamps = false;


    public $fillable = [
        'ID_PASIEN',
        'ID_KELUARGA',
        'ID_PENDIDIKAN_TERAKHIR',
        'ID_USER',
        'ID_AGAMA',
        'ID_JENIS_PELAYANAN',
        'NO_RM',
        'NAMA_LENGKAP',
        'TEMPAT_LAHIR',
        'TANGGAL_LAHIR',
        'ALAMAT',
        'GOL_DARAH',
        'NO_NIK',
        'NO_KK',
        'NO_TELP',
        'PEKERJAAN',
        'JENIS_KELAMIN',
        'NAMA_AYAH',
        'NAMA_IBU',
        'TIPE_USER'
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($pasien) {
            // Hapus data keluarga terkait
            $pasien->keluarga()->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'ID_USER', 'ID_USER');
    }

    public function agama()
    {
        return $this->belongsTo(agama::class, 'ID_AGAMA', 'ID_AGAMA');
    }

    public function jenis_pelayanan()
    {
        return $this->belongsTo(jenis_pelayanan::class, 'ID_JENIS_PELAYANAN', 'ID_JENIS_PELAYANAN');
    }

    public function riwayat_penyakit()
    {
        return $this->hasMany(riwayat_penyakit::class, 'ID_PASIEN', 'ID_PASIEN');
    }

    public function pendidikan_terakhir()
    {
        return $this->belongsTo(pendidikan_terakhir::class, 'ID_PENDIDIKAN_TERAKHIR', 'ID_PENDIDIKAN_TERAKHIR');
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

    public function keluarga()
    {
        return $this->hasOne(keluarga::class, 'ID_PASIEN', 'ID_PASIEN');
    }
}
