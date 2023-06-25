<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenis_imunisasi extends Model
{
    use HasFactory;

    protected $table = 'jenis_imunisasi';
    protected $primaryKey = 'ID_JENIS_IMUNISASI';
    public $timestamps = false;

    protected $fillable = [
        'ID_JENIS_IMUNISASI',
        'NAMA',
    ];

    public function pelayanan_imunisasi()
    {
        return $this->hasMany(pelayanan_imunisasi::class, 'ID_JENIS_IMUNISASI', 'ID_JENIS_IMUNISASI');
    }
}
