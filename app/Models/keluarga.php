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

    // public function agama()
    // {
    //     return $this->belongsTo(agama::class, 'ID_AGAMA', 'ID_AGAMA');
    // }

    // public function pendidikan()
    // {
    //     return $this->belongsTo(pendidikan_terakhir::class, 'ID_PENDIDIKAN_TERAKHIR', 'ID_PENDIDIKAN_TERAKHIR');
    // }

    public function agama_suami()
    {
        return $this->belongsTo(agama::class, 'AGAMA_SUAMI', 'ID_AGAMA');
    }

    public function pendidikan_suami()
    {
        return $this->belongsTo(pendidikan_terakhir::class, 'PENDIDIKAN_SUAMI', 'ID_PENDIDIKAN_TERAKHIR');
    }
}
