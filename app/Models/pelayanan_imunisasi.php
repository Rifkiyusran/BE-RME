<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelayanan_imunisasi extends Model
{
    use HasFactory;

    protected $table = 'pelayanan_imunisasi';
    protected $primaryKey = 'ID_PELAYANAN_IMUNISASI';
    public $timestamps = false;

    protected $fillable = [
        'ID_PELAYANAN_IMUNISASI',
        'ID_JENIS_IMUNISASI',
        'NO_RM',
        'TANGGAL_PEMBERIAN',
        'TEKANAN_DARAH',
        'KELUHAN_PASIEN',
        'TANGGAL_DATANG',
        'TANGGAL_DILAYANI',
        'BERAT_BADAN',
        'TINGGI_BADAN'
    ];

    public function jenis_imunisasi()
    {
        return $this->belongsTo(jenis_imunisasi::class, 'ID_JENIS_IMUNISASI', 'ID_PELAYANAN_IMUNISASI');
    }

    public function pasien()
    {
        return $this->belongsTo(pasien::class, 'ID_PASIEN', 'ID_PELAYANAN_IMUNISASI');
    }


}
