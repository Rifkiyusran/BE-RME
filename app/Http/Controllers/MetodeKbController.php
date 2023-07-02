<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\metode_kb;
use Illuminate\Http\Request;

class MetodeKbController extends Controller
{
    public function index(){
        $services = metode_kb::all();
        return response()->json(['message' => 'Data Metode KB', 'data' => $services], 200);
    }

    public function delete($id)
    {
        try{
        $service = metode_kb::FindOrFail($id);
        $service->delete();
        return response()->json(['message' => 'Metode KB berhasil dihapus'], 200);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'nama' => ['required', 'max:30', 'min:3'],
        ]);
        $maxId = metode_kb::max('ID_METODE_KB');
        $nextId = $maxId + 1;
        $services = metode_kb::create([
            "ID_METODE_KB" => $nextId,
            "NAMA" => $validatedData['nama'],
        ]);
        return response()->json(['message' => 'Berhasil Membuat Data Metode KB', 'data' => $services], 200);
    }

    public function edit(Request $request, $id){
        $validatedData = $request->validate([
            'nama' => ['required', 'max:30', 'min:3'],
        ]);
        $services = metode_kb::where('ID_METODE_KB', $id)
                ->update([
                    "NAMA" => $validatedData['nama'],
                ]);
        return response()->json(['message' => 'Berhasil merubah Metode KB', 'data' => $services], 200);
    }
}
