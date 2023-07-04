<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\pasien;
use App\Models\pelayanan_imunisasi;
use Illuminate\Http\Request;

class PelayananImunisasiController extends Controller
{
    public function index(){
        $pelayanan_kb = pelayanan_imunisasi::with(['pasien', 'jenis_imunisasi'])->get();
        return response()->json(['message' => 'List pelayanan kb', 'data' => $pelayanan_kb], 200);
    }

    public function show($id)
    {
        try {
            // Cari pasien berdasarkan ID
            $pasien = pasien::with('pelayanan_imunisasi', 'pelayanan_imunisasi.jenis_imunisasi')->findOrFail($id);
            // Ambil data pelayanan KB pada pasien
            return response()->json([
                'message' => 'Data pelayanan Imunisasi',
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
        $request->validate([
            'ID_JENIS_IMUNISASI' => 'required | exists:jenis_imunisasi,id_jenis_imunisasi',
            //'ID_PASIEN' => 'required | exists:pasien,id_pasien',
            'TANGGAL_PEMBERIAN' => 'required|date',
            'TEKANAN_DARAH' => 'required|string',
            'KELUHAN_PASIEN' => 'nullable|string',
            'TANGGAL_DATANG' => 'required|date',
            'TANGGAL_DILAYANI' => 'required|date',
            //'BERAT_BADAN' => 'required|string',
            //'TINGGI_BADAN' => 'required|string',
        ]);

        $maxId = pelayanan_imunisasi::max('ID_PELAYANAN_IMUNISASI');
        $nextId = $maxId + 1;
        $pelayanan_kb = pelayanan_imunisasi::create([
            'ID_PELAYANAN_IMUNISASI' => $nextId,
            'ID_PASIEN' => $id_pasien,
            'ID_JENIS_IMUNISASI' => $request->ID_JENIS_IMUNISASI,
            'TANGGAL_PEMBERIAN' => $request->TANGGAL_PEMBERIAN,
            'TEKANAN_DARAH' => $request->TEKANAN_DARAH,
            'KELUHAN_PASIEN' => $request->KELUHAN_PASIEN,
            'TANGGAL_DATANG' => $request->TANGGAL_DATANG,
            'TANGGAL_DILAYANI' => $request->TANGGAL_DILAYANI,
            'BERAT_BADAN' => $request->BERAT_BADAN,
            'TINGGI_BADAN' => $request->TINGGI_BADAN,
        ]);
        // $pelayanan_kb->save();

        return response()->json(['message' => 'Data Pelayanan Imunisasi Berhasil Disimpan', 'data' => $pelayanan_kb], 200);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
