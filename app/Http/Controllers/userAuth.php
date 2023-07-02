<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

    public function SignIn(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);
        $user = User::where('USERNAME', $credentials['username'])->first();

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

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('username', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();

    //         if ($user->tipe_user === 'admin') {
    //             // Logika setelah berhasil login sebagai admin
    //             return response()->json(['message' => 'Login success as admin']);
    //         } elseif ($user->tipe_user === 'bidan') {
    //             // Logika setelah berhasil login sebagai bidan
    //             return response()->json(['message' => 'Login success as bidan']);
    //         }
    //     }

    //     return response()->json(['message' => 'Invalid credentials'], 401);
    // }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }
}
