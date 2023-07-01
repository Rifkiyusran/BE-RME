<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\agama;
use Illuminate\Http\Request;

class AgamaController extends Controller
{
    public function index(){
        $services = agama::all();
        return response()->json(['message' => 'Data agama', 'data' => $services], 200);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'nama' => ['required', 'max:30', 'min:3'],
        ]);
        $maxId = agama::max('ID_AGAMA');
        $nextId = $maxId + 1;
        $services = agama::create([
            "ID_AGAMA" => $nextId,
            "NAMA" => $validatedData['nama'],
        ]);
        return response()->json(['message' => 'Berhasil Membuat Data agama', 'data' => $services], 200);
    }

    public function edit(Request $request, $id){
        $validatedData = $request->validate([
            'nama' => ['required', 'max:50', 'min:3'],
        ]);
        $services = agama::where('ID_AGAMA', $id)
                ->update([
                    "NAMA" => $validatedData['nama'],
                ]);
        return response()->json(['message' => 'Berhasil merubah data agama', 'data' => $services], 200);
    }

    public function delete($id)
    {
        try{
        $service = agama::Find('ID_AGAMA', $id);
        $service->delete();
        return response()->json(['message' => 'Data agama berhasil dihapus'], 200);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
