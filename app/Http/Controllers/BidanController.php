<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BidanController extends Controller
{

    public function signUpBidan(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama' => 'required|max:30',
                'username' => 'required|max:30|unique:users',
                'email' => 'required|unique:users',
                'password' => 'required|min:8',
                'nip' => 'required|min:18|max:18|unique:users',
                'alamat' => 'required|max:100',
                'no_telp' => 'required|max:13'
                //'confirm-password' => 'required|min:8|required_with:password|same:password'
            ]);
            $validatedData['password'] = Hash::make($validatedData['password']);

            $maxId = User::where('TIPE_USER', 'bidan')->max('ID_USER');
            $nextId = $maxId + 1;
            $user = User::create([
                "ID_USER" => $nextId,
                "NAMA" => $validatedData['nama'],
                "USERNAME" => $validatedData['username'],
                "EMAIL" => $validatedData['email'],
                "PASSWORD" =>  $validatedData['password'],
                "NIP" =>  $validatedData['nip'],
                "ALAMAT" =>  $validatedData['alamat'],
                "NO_TELP" =>  $validatedData['no_telp'],
                "TIPE_USER" => "bidan"
            ]);

            return response()->json(['message' => 'Berhasil mendaftar', 'data' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function getBidan()
    {
        try {
            // Ambil semua akun dengan tipe user 'bidan'
            $bidanAccounts = User::where('TIPE_USER', 'bidan')->get();

            return response()->json(['message' => 'Daftar akun bidan', 'data' => $bidanAccounts], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            //$userId = $request->user()->ID_USER;
            $user = User::find($id);

            if ($user && $user->TIPE_USER === 'bidan') {
                $user->delete();
                return response()->json(['message' => 'Akun berhasil dihapus'], 200);
            } elseif (!$user) {
                return response()->json(['message' => 'Akun tidak ditemukan'], 404);
            } else {
                return response()->json(['message' => 'Akun bukan tipe "bidan"'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }


}
