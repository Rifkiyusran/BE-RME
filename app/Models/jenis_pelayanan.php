<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenis_pelayanan extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelayanan';
    protected $primaryKey = 'ID_JENIS_PELAYANAN';
    public $timestamps = false;

    protected $fillable = [
        'ID_JENIS_PELAYANAN',
        'NAMA',
    ];

    public function pasien()
    {
        return $this->hasMany(pasien::class, 'ID_JENIS_PELAYANAN', 'ID_JENIS_PELAYANAN');
    }
}
