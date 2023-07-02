<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class riwayat_penyakit extends Model
{
    use HasFactory;

    protected $table = 'riwayat_penyakit';
    protected $primaryKey = 'ID_RIWAYAT_PENYAKIT';
    public $timestamps = false;

    protected $fillable = [
        'ID_PENYAKIT',
        'TANGGAL',
    ];

    public function penyakit()
    {
        return $this->belongsTo(penyakit::class, 'ID_PENYAKIT', 'ID_PENYAKIT');
    }

    public function riwayat_penyakit()
    {
        return $this->belongsTo(riwayat_penyakit::class, 'ID_RIWAYAT_PENYAKIT', 'ID_RIWAYAT_PENYAKIT');
    }
}
