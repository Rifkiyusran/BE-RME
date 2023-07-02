<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keluarga extends Model
{
    use HasFactory;

    protected $table = 'keluarga';
    protected $primaryKey = 'ID_KELUARGA';
    public $timestamps = false;


    protected $fillable = [
        'ID_KELUARGA',
        'ID_PASIEN',
        'NAMA_SUAMI',
        'TEMPAT_LAHIR_SUAMI',
        'TANGGAL_LAHIR_SUAMI',
        'AGAMA_SUAMI',
        'PENDIDIKAN_SUAMI',
        'PEKERJAAN_SUAMI',
        'GOL_DARAH_SUAMI',
        'JUMLAH_ANAK',
        'UMUR_ANAK_TERAKHIR',
    ];

    public function pasien()
    {
        return $this->belongsTo(pasien::class, 'ID_PASIEN', 'ID_PASIEN');
    }

    // public function agamaSuami()
    // {
    //     return $this->belongsTo(agama::class, 'AGAMA_SUAMI', 'id_agama');
    // }

    // public function pendidikanSuami()
    // {
    //     return $this->belongsTo(pendidikan_terakhir::class, 'PENDIDIKAN_SUAMI', 'id_pendidikan_terakhir');
    // }
}
