<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kontrol_kehamilan extends Model
{
    use HasFactory;

    protected $table = 'kontrol_kehamilan';
    protected $primaryKey = 'ID_KONTROL_KEHAMILAN';
    public $timestamps = false;

    protected $fillable = [
        'ID_KONTROL_KEHAMILAN',
        'TANGGAL_PEMERIKSAAN',
        'KELUHAN_SEKARANG',
        'UMUR_KEHAMILAN_SEKARANG',
        'TINGGI_FUNDUS',
        'LETAK_JANIN',
        'DENYUT_JANTUNG',
        'KAKI_BENGKAK',
        'HASIL_LAB',
        'TINDAKAN',
        'NASIHAT',
        'KETERANGAN',
        'TANGGAL_KEMBALI',
        'CATATAN_KHUSUS',
        'TEKANAN_DARAH'
    ];

    public function pelayanan_kehamilan_melahirkan()
    {
        return $this->belongsTo(pelayanan_kehamilan_melahirkan::class, 'ID_PELAYANAN_KEHAMILAN_MELAHIRKAN', 'ID_KONTROL_KEHAMILAN');
    }
}
