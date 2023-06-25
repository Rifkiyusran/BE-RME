<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\jenis_imunisasi;
use Illuminate\Http\Request;

class JenisImunisasiController extends Controller
{
    public function index(){
        $services = jenis_imunisasi::all();
        return response()->json(['message' => 'Data jenis imunisasi', 'data' => $services], 200);
    }

    public function delete($id)
    {
        try{
        $service = jenis_imunisasi::FindOrFail($id);
        $service->delete();
        return response()->json(['message' => 'jenis imunisasi berhasil dihapus'], 200);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'nama' => ['required', 'max:50', 'min:3'],
        ]);
        $maxId = jenis_imunisasi::max('ID_JENIS_IMUNISASI');
        $nextId = $maxId + 1;
        $services = jenis_imunisasi::create([
            "ID_JENIS_IMUNISASI" => $nextId,
            "NAMA" => $validatedData['nama'],
        ]);
        return response()->json(['message' => 'Berhasil Membuat Data jenis imunisasi', 'data' => $services], 200);
    }

    public function edit(Request $request, $id){
        $validatedData = $request->validate([
            'nama' => ['required', 'max:50', 'min:3'],
        ]);
        $services = jenis_imunisasi::where('ID_JENIS_IMUNISASI', $id)
                ->update([
                    "NAMA" => $validatedData['nama'],
                ]);
        return response()->json(['message' => 'Berhasil merubah jenis imunisasi', 'data' => $services], 200);
    }
}
