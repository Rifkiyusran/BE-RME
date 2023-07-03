<?php

namespace App\Http\Controllers;

use App\Models\metode_kb;
use App\Models\pasien;
use App\Models\pelayanan_kb;
use Illuminate\Http\Request;


class PelayananKbController extends Controller
{
    public function show($id)
    {
        $pelayanan_kb = pelayanan_kb::where('ID_PASIEN', $id)->get();

        return response()->json($pelayanan_kb);
    }

    public function store(Request $request, pasien $id)
    {
        error_log($request);
        $request->validate([
            'ID_METODE_KB' => 'required | exists:metode_kb,ID_METODE_KB',
            'DIAGNOSA' => 'required|string',
            'TINDAKAN' => 'required|string',
            'TANGGAL_DATANG ' => 'required|date',
            'TANGGAL_KEMBALI' => 'required|date',
            'CATATAN' => 'nullable|string',
            'TEKANAN_DARAH' => 'required|string',
            'KELUHAN_PASIEN' => 'nullable|string',
            'TANGGAL_DILAYANI' => 'required|date',
            'BERAT_BADAN' => 'required|string',
            'TINGGI_BADAN' => 'required|string',
        ]);

        // $pasien = pasien::find($id);
        // if (!$pasien) {
        //     return response()->json(['message' => 'Pasien Tidak Ditemukan'], 404);
        // }

        // $metode_kb = metode_kb::find($request->ID_METODE_KB);
        // if (!$metode_kb) {
        //     return response()->json(['message' => 'Metode Tidak Ditemukan'], 404);
        // }

        $maxId = pelayanan_kb::max('ID_PELAYANAN_KB');
        $nextId = $maxId + 1;
        $pelayanan_kb = pelayanan_kb::create([
            'ID_PELAYANAN_KB' => $nextId,
            'ID_PASIEN' => $id,
            'ID_METODE_KB' => $request->ID_METODE_KB,
            'DIAGNOSA' => $request->DIAGNOSA,
            'TINDAKAN' => $request->TINDAKAN,
            'TANGGAL_DATANG' => $request->TANGGAL_DATANG,
            'TANGGAL_KEMBALI' => $request->TANGGAL_KEMBALI,
            'CATATAN' => $request->CATATAN,
            'TEKANAN_DARAH' => $request->TEKANAN_DARAH,
            'KELUHAN_PASIEN' => $request->KELUHAN_PASIEN,
            'TANGGAL_DILAYANI' => $request->TANGGAL_DILAYANI,
            'BERAT_BADAN' => $request->BERAT_BADAN,
            'TINGGI_BADAN' => $request->TINGGI_BADAN,
        ]);

        // $pelayanan_kb->save();

        return response()->json(['message' => 'Data Pelayanan KB Berhasil Disimpan', 'data' => $pelayanan_kb], 200);
    }
}
