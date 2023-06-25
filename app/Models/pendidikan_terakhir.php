<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendidikan_terakhir extends Model
{
    use HasFactory;

    protected $table = 'pendidikan_terakhir';
    protected $primaryKey = 'ID_PENDIDIKAN_TERAKHIR';
    public $timestamps = false;

    protected $fillable = [
        'ID_PENDIDIKAN_TERAKHIR',
        'NAMA',
    ];

    public function pasien()
    {
        return $this->hasMany(pasien::class, 'ID_PENDIDIKAN_TERAKHIR', 'ID_PENDIDIKAN_TERAKHIR');
    }
}
