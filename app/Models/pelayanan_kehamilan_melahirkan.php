<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelayanan_kehamilan_melahirkan extends Model
{
    use HasFactory;

    protected $table = 'pelayanan_kehamilan_melahirkan';
    protected $primaryKey = 'ID_PELAYANAN_KEHAMILAN_MELAHIRKAN';
    public $timestamps = false;

    protected $fillable = [
        'ID_PELAYANAN_KEHAMILAN_MELAHIRKAN',
        'ID_PASIEN',
        'TANGGAL_DATANG',
        'TANGGAL_DILAYANI',
        // 'BERAT_BADAN',
        // 'TINGGI_BADAN',
        'HPHT',
        'HTP',
        'STATUS_IMUNISASI',
        'KEGUGURAN',
        'PREMATUR',
        'ABORSI',
        'USIA_KEHAMILAN',
        'JARAK_KEHAMILAN',
        'TANGGAL_RENCANA_PERSALINAN',
        'RENCANA_PENOLONG',
        'RENCANA_PENDONOR',
        'RENCANA_PENDAMPING',
        'RENCANA_TRANSPORTASI',
        'TANGGAL_KALA_SATU',
        'TANGGAL_KALA_DUA',
        'JAM_KALA_SATU',
        'JAM_KALA_DUA',
        'TANGGAL_BAYI_LAHIR',
        'JAM_BAYI_LAHIR',
        'BERAT_BADAN_BAYI',
        'TINGGI_BADAN_BAYI',
        'NILAI_APGAR',
        'JENIS_KELAMIN_BAYI',
        'TANGGAL_PLASENTA_LAHIR',
        'TEMPAT_PERSALINAN',
        'PENOLONG_PERSALINAN',
        'KOMPLIKASI_PERSALINAN',
        'ALAMAT_BERSALIN',
        'TAHUN_PARTUS_SEBELUMNYA',
        'TEMPAT_PARTUS_SEBELUMNYA',
        'UMUR_HAMIL_SEBELUMNYA',
        'JENIS_PERSALINAN',
        'PENOLONG_PERSALINAN',
        'KENDALA_SEBELUMNYA',
        'KONDISI_BAYI',
        'KONDISI_IBU',

    ];

    public function kontrol_kehamilan()
    {
        return $this->hasMany(kontrol_kehamilan::class, 'ID_PELAYANAN_KEHAMILAN_MELAHIRKAN', 'ID_PELAYANAN_KEHAMILAN_MELAHIRKAN');
    }

    public function pasien()
    {
        return $this->belongsTo(pasien::class, 'ID_PELAYANAN_KEHAMILAN_MELAHIRKAN', 'ID_PASIEN');
    }
}
