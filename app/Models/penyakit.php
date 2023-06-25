<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penyakit extends Model
{
    use HasFactory;

    protected $table = 'penyakit';
    protected $primaryKey = 'ID_PENYAKIT';
    public $timestamps = false;

    protected $fillable = [
        'ID_PENYAKIT',
        'NAMA',
    ];

    public function pasien()
    {
        return $this->hasMany(pasien::class, 'ID_PENYAKIT', 'ID_PENYAKIT');
    }
}
