<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelayanan_kb extends Model
{
    use HasFactory;

    protected $table = 'pelayanan_kb';
    protected $primaryKey = 'ID_PELAYANAN_KB';
    public $timestamps = false;

    protected $fillable = [
        'ID_PELAYANAN_KB',
        'ID_PASIEN',
        'ID_METODE_KB',
        'DIAGNOSA',
        'TINDAKAN',
        'TANGGAL_DATANG',
        'TANGGAL_KEMBALI',
        'CATATAN',
        'TEKANAN_DARAH',
        'KELUHAN_PASIEN',
        'TANGGAL_DILAYANI',
        'BERAT_BADAN',
        'TINGGI_BADAN',
    ];

    public function metode_kb()
    {
        return $this->belongsTo(metode_kb::class, 'ID_METODE_KB', 'ID_PELAYANAN_KB');
    }

    public function pasien()
    {
        return $this->belongsTo(pasien::class, 'ID_PASIEN', 'ID_PELAYANAN_KB');
    }
}
