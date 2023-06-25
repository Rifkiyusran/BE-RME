<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User;
        $admin-> id_user = 1;
        $admin->nama = 'Admin';
        $admin->username = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = Hash::make('admin123');
        $admin->tipe_user = 'admin';
        $admin->save();
        //$admin->roles()->attach(Role::where('name','admin')->first());
    }
}
