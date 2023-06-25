<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agama extends Model
{
    use HasFactory;

    protected $table = 'agama';
    protected $primarykey = 'ID_AGAMA';
    public $timestamps = false;

    protected $fillable = [
        'ID_AGAMA',
        'NAMA',
    ];

    public function pasien()
    {
        return $this->hasMany(pasien::class, 'ID_AGAMA', 'ID_AGAMA');
    }



}
