<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\keluarga;
use App\Models\pasien;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class userAuth extends Controller
{
    public function SignUp(Request $request){
        try {
            $validatedData = $request->validate([
                'nama' => 'required|max:30',
                'username' => 'required|max:30|unique:users',
                'email' => 'required|unique:users',
                'password' => 'required|min:8',
                //'confirm-password' => 'required|min:8|required_with:password|same:password'
            ]);
            $validatedData['password'] = Hash::make($validatedData['password']);

            $maxId = User::max('ID_USER');
            $nextId = $maxId + 1;
            $user = User::create([
                "ID_USER" => $nextId,
                "NAMA" => $validatedData['nama'],
                "USERNAME" => $validatedData['username'],
                "EMAIL" => $validatedData['email'],
                "PASSWORD" =>  $validatedData['password'],
                "TIPE_USER" => "bidan"
            ]);

            return response()->json(['message' => 'Berhasil daftar', 'data' => $user], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
            }
        //return redirect('/signin');
    }

    public function SignIn(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('USERNAME', $credentials['username'])->first();

        if (!$user) {
            return response()->json(['message' => 'Belum terdaftar'], 300);
        }

        if (!Hash::check($credentials['password'], $user->PASSWORD)) {
            return response()->json(['message' => 'Password salah'], 300);
        }

        // Menambahkan validasi tipe pengguna
        if ($user->TIPE_USER !== 'admin' && $user->TIPE_USER !== 'bidan') {
            return response()->json(['message' => 'Tipe pengguna tidak valid'], 300);
        }

        Auth::login($user);
        return response()->json(['message' => 'Berhasil masuk', 'data' => $user], 200);
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'no_nik' => 'required',
            'no_rm' => 'required',
        ]);

        // Ambil data dari input
        $nik = $request->input('no_nik');
        $rm = $request->input('no_rm');

        // Cari pasien berdasarkan nomor NIK dan nomor RM
        $pasien = pasien::where('NO_NIK', $nik)
                        ->where('NO_RM', $rm)
                        ->first();

        if ($pasien) {
            // Tampilkan nama, nomor NIK, dan nomor RM pasien
            return response()->json([
                'message' => 'Login berhasil',
                'id_pasien' => $pasien->ID_PASIEN,
                'nama lengkap' => $pasien->NAMA_LENGKAP,
                'no nik' => $pasien->NO_NIK,
                'no rm' => $pasien->NO_RM,
                'tipe_pasien' => $pasien->TIPE_PASIEN
                // 'data' => TIPE_USER-> ['pasien'],
                // "TIPE_USER" => "pasien"
            ], 200);
        } else {
            // Jika pasien tidak ditemukan
            return response()->json(['message' => 'Login gagal'], 401);
        }

        // // Jika pasien ditemukan
        // if ($pasien) {
        //     // Ambil data keluarga pasien
        //     $keluarga = keluarga::where('ID_PASIEN', $pasien->ID_PASIEN)->get();

        //     // Tampilkan data pasien dan data keluarga
        //     return response()->json([
        //         'message' => 'Login berhasil',
        //         'pasien' => $pasien,
        //         'keluarga' => $keluarga
        //     ], 200);
        // } else {
        //     // Jika pasien tidak ditemukan
        //     return response()->json(['message' => 'Login gagal'], 401);
        // }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }
}
