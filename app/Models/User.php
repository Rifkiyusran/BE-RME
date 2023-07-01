<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;
    protected $primaryKey = 'ID_USER';
    protected $table = 'users';

    protected $fillable = [
        'ID_USER',
        'NAMA',
        'USERNAME',
        'NO_TELP',
        'EMAIL',
        'PASSWORD',
        'TIPE_USER',
    ];

    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'password' => 'hashed',
    // ];

    public function pasien()
    {
        return $this->hasMany(pasien::class, 'ID_USER', 'ID_USER');
    }
}
