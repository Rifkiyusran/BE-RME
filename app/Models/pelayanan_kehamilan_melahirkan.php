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
        'NO_RM',
        'TANGGAL_DATANG',
        'TANGGAL_DILAYANI',
        'BERAT_BADAN',
        'TINGGI_BADAN',
        'HPHT',
        'HTP',

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
