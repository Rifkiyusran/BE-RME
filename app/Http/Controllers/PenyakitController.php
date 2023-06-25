<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\penyakit;
use Illuminate\Http\Request;

class PenyakitController extends Controller
{
    public function index(){
        $services = penyakit::all();
        return response()->json(['message' => 'Data Penyakit', 'data' => $services], 200);
    }

    public function delete($id)
    {
        try{
        $service = penyakit::FindOrFail($id);
        $service->delete();
        return response()->json(['message' => 'Data Penyakit berhasil dihapus'], 200);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'nama' => ['required', 'max:50', 'min:3'],
        ]);
        $maxId = penyakit::max('ID_PENYAKIT');
        $nextId = $maxId + 1;
        $services = penyakit::create([
            "ID_PENYAKIT" => $nextId,
            "NAMA" => $validatedData['nama'],
        ]);
        return response()->json(['message' => 'Berhasil Membuat Data Penyakit', 'data' => $services], 200);
    }

    public function edit(Request $request, $id){
        $validatedData = $request->validate([
            'nama' => ['required', 'max:50', 'min:3'],
        ]);
        $services = penyakit::where('ID_PENYAKIT', $id)
                ->update([
                    "NAMA" => $validatedData['nama'],
                ]);
        return response()->json(['message' => 'Berhasil merubah Penyakit', 'data' => $services], 200);
    }
}
