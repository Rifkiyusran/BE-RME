<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class userAuth extends Controller
{
    public function SignUp(Request $request){
        try {
            $validatedData = $request->validate([
                'nama' => 'required|max:50',
                'username' => 'required|max:30|unique:users',
                'email' => 'required|email:dns|unique:users',
                'no_telp' => 'required',
                'password' => 'required|min:8',
                'confirm-password' => 'required|min:8|required_with:password|same:password'
            ]);
            $validatedData['password'] = Hash::make($validatedData['password']);

            $maxId = User::max('ID_USER');
            $nextId = $maxId + 1;
            $user = User::create([
                "ID_USER" => $nextId,
                "NAMA" => $validatedData['nama'],
                "USERNAME" => $validatedData['username'],
                "EMAIL" => $validatedData['email'],
                "NO_TELP" => $validatedData['no_telp'],
                "PASSWORD" =>  $validatedData['password'],
                "TIPE_USER" => "bidan"
            ]);

            return response()->json(['message' => 'Berhasil daftar', 'data' => $user], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
            }
        //return redirect('/signin');
    }

    public function SignIn(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required']
        ]);
        $user = User::where('EMAIL', $credentials['email'])->first();

        if (!$user) {
            return response()->json(['message' => 'Belum terdaftar'], 300);
            //return redirect('/signin');
        }
        if (!Hash::check($credentials['password'], $user->PASSWORD)) {
            return response()->json(['message' => 'Password salah'], 300);
            //return redirect('/signin');
        }
        Auth::login($user);
        return response()->json(['message' => 'Berhasil masuk', 'data' => $user], 200);
        //return redirect('/');
    }
}
