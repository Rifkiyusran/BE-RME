<?php

namespace App\Http\Controllers;

use App\Models\metode_kb;
use App\Models\pasien;
use App\Models\pelayanan_kb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelayananKbController extends Controller
{

    public function index(){
        $pelayanan_kb = pelayanan_kb::with(['pasien', 'metode_kb'])->get();
        return response()->json(['message' => 'List pelayanan kb', 'data' => $pelayanan_kb], 200);
    }


    public function show($id)
    {
        try {
            // Cari pasien berdasarkan ID
            $pasien = pasien::with('pelayanan_kb')->findOrFail($id);
            // Ambil data pelayanan KB pada pasien
            return response()->json([
                'message' => 'Data pelayanan KB',
                'data' => $pasien
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
        // $pelayanan_kb = pelayanan_kb::with('pasien', 'metode_kb')->where('ID_PELAYANAN_KB', $id)->get();
        // return response()->json($pelayanan_kb);
    }

    public function store(Request $request, $id_pasien)
    {
        try{
        $validatedData = $request->validate([
            'id_metode_kb' => 'required | exists:metode_kb,id_metode_kb',
            //'ID_PASIEN' => 'required | exists:pasien,id_pasien',
            'diagnosa' => 'required|max:100',
            'tindakan' => 'required|max:50',
            //'tanggal_datang ' => ['required', 'date'],
            'tanggal_kembali' => 'required|date',
            'catatan' => 'nullable|string',
            'tekanan_darah' => 'required|max:10',
            'keluhan_pasien' => 'nullable|max:100',
            'tanggal_dilayani' => 'required|date',
            //'BERAT_BADAN' => 'required|string',
            //'TINGGI_BADAN' => 'required|string',
        ]);

        $maxId = pelayanan_kb::max('ID_PELAYANAN_KB');
        $nextId = $maxId + 1;
        $pelayanan_kb = pelayanan_kb::create([
            'ID_PELAYANAN_KB' => $nextId,
            'ID_PASIEN' => $id_pasien,
            'ID_METODE_KB' => $validatedData['id_metode_kb'],
            'DIAGNOSA' => $validatedData['diagnosa'],
            'TINDAKAN' => $validatedData['tindakan'],
            'TANGGAL_DATANG' => $request->input('tanggal_datang'),
            'TANGGAL_KEMBALI' => $validatedData['tanggal_kembali'],
            'CATATAN' => $validatedData['catatan'],
            'TEKANAN_DARAH' => $validatedData['tekanan_darah'],
            'KELUHAN_PASIEN' => $validatedData['keluhan_pasien'],
            'TANGGAL_DILAYANI' => $validatedData['tanggal_dilayani'],
            'BERAT_BADAN' => $request->input('berat_badan'),
            'TINGGI_BADAN' => $request->input('tinggi_badan')
        ]);
        // $pelayanan_kb->save();

        return response()->json(['message' => 'Data Pelayanan KB Berhasil Disimpan', 'data' => $pelayanan_kb], 200);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function delete($id_pasien, $id_pelayanan_kb)
{
    try {
        $pelayanan_kb = pelayanan_kb::where('ID_PASIEN', $id_pasien)->find($id_pelayanan_kb);
        $pelayanan_kb->delete();

        return response()->json(['message' => 'Data Pelayanan KB berhasil dihapus'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}
}
