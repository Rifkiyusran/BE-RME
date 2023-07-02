<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\jenis_pelayanan;
use Illuminate\Http\Request;


class JenisPelayananController extends Controller
{
    public function index(){
        $services = jenis_pelayanan::all();
        return response()->json(['message' => 'List Jenis Pelayanan', 'data' => $services], 200);
    }

    public function delete($id)
    {
        $service = jenis_pelayanan::findOrFail($id);
        $service->delete();
        return response()->json(['message' => 'Layanan berhasil dihapus'], 200);
    }

    public function create(Request $request){
        try{
            $validatedData = $request->validate([
                'nama' => ['required', 'max:50', 'min:3'],
            ]);
            $maxId = jenis_pelayanan::max('ID_JENIS_PELAYANAN');
            $nextId = $maxId + 1;
            $services = jenis_pelayanan::create([
                "ID_JENIS_PELAYANAN" => $nextId,
                "NAMA" => $validatedData['nama'],
            ]);

        return response()->json(['message' => 'Berhasil membuat pelayanan baru', 'data' => $services], 200);
        }catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function edit(Request $request, $id){
        try{
        $validatedData = $request->validate([
            'nama' => ['required', 'max:30', 'min:3'],
        ]);
        $services = jenis_pelayanan::where('ID_JENIS_PELAYANAN', $id)
                ->update([
                "NAMA" => $validatedData['nama'],
                ]);
        return response()->json(['message' => 'Berhasil merubah pelayanan', 'data' => $services], 200);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
