<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    // public function index(){
    //     $pasien = pasien::all();
    //     return response()->json(['message' => 'List pasien', 'data' => $pasien], 200);
    // }

    public function index()
    {
        $pasien = pasien::all();
        return response()->json([
            'data' => $pasien
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \APP\Models\pasien $pasien
     * @return \Illuminate\Http\Response
     */
    public function show(pasien $pasien, $id)
    {
        //error_log(pasien::find($id));
        $pasien = pasien::where('ID_PASIEN', $id)->get();
        //dd($pasien);
        return response()->json([
            'data' => $pasien
            // 'data' => pasien::findORfail($id)
        ]);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_pendidikan_terakhir' => ['required', 'exists:pendidikan_terakhir,id_pendidikan_terakhir'],
                'id_agama' => ['required', 'exists:agama,id_agama'],
                //'id_user' => ['required','exists:users,id_user'],
                //'id_penyakit' => ['required','exists:penyakit,id_penyakit'],
                'id_jenis_pelayanan' => ['required', 'exists:jenis_pelayanan,id_jenis_pelayanan'],
                'nama_lengkap' => ['required', 'max:50', 'min:3'],
                'tempat_lahir' => ['required', 'max:50', 'min:2'],
                'tanggal_lahir' => ['required', 'date'],
                'alamat' => ['required', 'max:100'],
                // 'gol_darah' => ['required'],
                // 'no_nik' => ['required', 'max:24', 'min:3'],
                // 'no_kk' => ['required', 'max:24', 'min:3'],
                // 'pekerjaan' => ['required', 'max:100', 'min:3'],
                // 'jenis_kelamin' => ['required'],
                // 'nama_ayah' => ['required', 'max:50', 'min:3'],
                // 'nama_ibu' => ['required', 'max:50', 'min:3'],
                // 'nama_suami' => ['required', 'max:50', 'min:3'],
                // 'tempat_lahir_suami' => ['required', 'max:15', 'min:3'],
                // 'tanggal_lahir_suami' => ['required', 'date'],
                // 'agama_suami' => ['required', 'exists:agama,id_agama'],
                // 'pendidikan_suami' => ['required', 'exists:pendidikan_terakhir,id_pendidikan_terakhir'],
                // 'pekerjaan_suami' => ['required', 'max:50', 'min:3'],
                // 'gol_darah_suami' => ['required'],
                // 'jumlah_anak' => ['required'],
                // 'umur_anak_terakhir' => ['required'],
                //'tipe_pasien' => ['required'],
            ]);
            $maxId = pasien::max('ID_PASIEN');
            $nextId = $maxId + 1;
            $pasien = pasien::create([
                "ID_PASIEN" => $nextId,
                //"ID_USER" => auth()->user()->ID_USER,
                "ID_PENDIDIKAN_TERAKHIR" => $validatedData['id_pendidikan_terakhir'],
                "ID_AGAMA" => $validatedData['id_agama'],
                "ID_JENIS_PELAYANAN" => $validatedData['id_jenis_pelayanan'],
                "NAMA_LENGKAP" => $validatedData['nama_lengkap'],
                "TEMPAT_LAHIR" => $validatedData['tempat_lahir'],
                "TANGGAL_LAHIR" => $validatedData['tanggal_lahir'],
                "ALAMAT" => $validatedData['alamat'],
                //"GOL_DARAH" => $validatedData['gol_darah'],
                // "NO_NIK" => $validatedData['no_nik'],
                // "NO_KK" => $validatedData['no_kk'],
                // "PEKERJAAN" => $validatedData['pekerjaan'],
                // "JENIS_KELAMIN" => $validatedData['jenis_kelamin'],
                // "NAMA_AYAH" => $validatedData['nama_ayah'],
                // "NAMA_IBU" => $validatedData['nama_ibu'],
                // "NAMA_SUAMI" => $validatedData['nama_suami'],
                // "TEMPAT_LAHIR_SUAMI" => $validatedData['tempat_lahir_suami'],
                // "TANGGAL_LAHIR_SUAMI" => $validatedData['tanggal_lahir_suami'],
                // "PEKERJAAN_SUAMI" => $validatedData['pekerjaan_suami'],
                // "GOL_DARAH_SUAMI" => $validatedData['gol_darah_suami'],
                // "JUMLAH_ANAK" => $validatedData['jumlah_anak'],
                // "UMUR_ANAK_TERAKHIR" => $validatedData['umur_anak_terakhir'],
                // "TIPE_PASIEN" => $validatedData['tipe_pasien'],

            ]);

            // $pasien -> User()->associate($validatedData['id_user']);
            // $pasien -> pendidikan_terakhir()->associate($validatedData['id_pendidikan_terakhir']);
            // $pasien -> pendidikan_terakhir()->associate($validatedData['pendidikan_suami']);
            // $pasien -> agama()->associate($validatedData['id_agama']);
            // $pasien -> agama()->associate($validatedData['agama_suami']);
            // $pasien -> jenis_pelayanan()->associate($validatedData['id_jenis_pelayanan']);
            // $pasien -> penyakit()->associate($validatedData['id_penyakit']);

            return response()->json(['message' => 'Berhasil membuat pasien', 'data' => $pasien], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }



    public function delete($id)
    {
        $pasien = pasien::findOrFail($id);
        $pasien->delete();
        return response()->json(['message' => 'pasien berhasil dihapus'], 200);
    }
}
