<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class metode_kb extends Model
{
    use HasFactory;

    protected $table = 'metode_kb';
    protected $primaryKey = 'ID_METODE_KB';
    public $timestamps = false;

    protected $fillable = [
        'ID_METODE_KB',
        'NAMA',
    ];

    public function pelayanan_kb()
    {
        return $this->hasMany(pelayanan_kb::class, 'ID_METODE_KB', 'ID_METODE_KB');
    }
}
