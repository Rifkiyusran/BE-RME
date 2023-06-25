<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\pendidikan_terakhir;
use Illuminate\Http\Request;

class PendidikanTerakhirController extends Controller
{
    public function index(){
        $services = pendidikan_terakhir::all();
        return response()->json(['message' => 'Data pendidikan terakhir', 'data' => $services], 200);
    }
    public function delete($id)
    {
        try{
        $service = pendidikan_terakhir::FindOrFail($id);
        $service->delete();
        return response()->json(['message' => 'pendidikan terakhir berhasil dihapus'], 200);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    public function create(Request $request){
        try{
        $validatedData = $request->validate([
            'nama' => ['required', 'max:50', 'min:1'],
        ]);
        $maxId = pendidikan_terakhir::max('ID_PENDIDIKAN_TERAKHIR');
        $nextId = $maxId + 1;
        $services = pendidikan_terakhir::create([
            "ID_PENDIDIKAN_TERAKHIR" => $nextId,
            "NAMA" => $validatedData['nama'],
        ]);
        return response()->json(['message' => 'Berhasil Membuat Data pendidikan terakhir', 'data' => $services], 200);
        }catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    public function edit(Request $request, $id){
        $validatedData = $request->validate([
            'nama' => ['required', 'max:50', 'min:3'],
        ]);
        $services = pendidikan_terakhir::where('ID_PENDIDIKAN_TERAKHIR', $id)
                ->update([
                    "NAMA" => $validatedData['nama'],
                ]);
        return response()->json(['message' => 'Berhasil merubah pendidikan terakhir', 'data' => $services], 200);
    }
}
