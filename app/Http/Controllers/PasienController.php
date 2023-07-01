<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\keluarga;
use App\Models\pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index(){
        $pasien = pasien::with(['agama', 'pendidikan_terakhir', 'keluarga'])->get();
        return response()->json(['message' => 'List pasien', 'data' => $pasien], 200);
    }

    public function create(Request $request){
        try{
        $validatedData = $request->validate([
            'id_pendidikan_terakhir' => ['required', 'exists:pendidikan_terakhir,id_pendidikan_terakhir'],
            'id_agama' => ['required', 'exists:agama,id_agama'],
            //'id_user' => ['required','exists:users,id_user'],
            //'id_penyakit' => ['required','exists:penyakit,id_penyakit'],
            'id_jenis_pelayanan' => ['required', 'exists:jenis_pelayanan,id_jenis_pelayanan'],
            //'id_keluarga' => ['required', 'exists:keluarga,id_keluarga'],
            'no_rm' => 'required|max:20|unique:pasien',
            'nama_lengkap' => ['required', 'max:50', 'min:3'],
            'tempat_lahir' => ['required', 'max:50', 'min:2'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'max:100'],
            'gol_darah' => ['required'],
            'no_nik' => 'required|max:16|unique:pasien',
            'no_kk' => 'required|max:16|unique:pasien',
            'no_telp' => 'required',
            'pekerjaan' => ['required', 'max:100', 'min:3'],
            'jenis_kelamin' => ['required'],
            'nama_ayah' => ['required', 'max:50', 'min:3'],
            'nama_ibu' => ['required', 'max:50', 'min:3'],
            //'tipe_pasien' => ['required'],
        ]);

        $maxId = pasien::max('ID_PASIEN');
        $nextId = $maxId + 1;
        $pasien = pasien::create([
            "ID_PASIEN" => $nextId,
            //"ID_KELUARGA" => $keluargaData['ID_KELUARGA'],
            //"ID_USER" => auth()->user()->ID_USER,
            "ID_PENDIDIKAN_TERAKHIR" => $validatedData['id_pendidikan_terakhir'],
            "ID_AGAMA" => $validatedData['id_agama'],
            "ID_JENIS_PELAYANAN" => $validatedData['id_jenis_pelayanan'],
            "NO_RM" => $validatedData['no_rm'],
            "NAMA_LENGKAP" => $validatedData['nama_lengkap'],
            "TEMPAT_LAHIR" => $validatedData['tempat_lahir'],
            "TANGGAL_LAHIR" => $validatedData['tanggal_lahir'],
            "ALAMAT" => $validatedData['alamat'],
            "GOL_DARAH" => $validatedData['gol_darah'],
            "NO_NIK" => $validatedData['no_nik'],
            "NO_KK" => $validatedData['no_kk'],
            "NO_TELP" => $validatedData['no_telp'],
            "PEKERJAAN" => $validatedData['pekerjaan'],
            "JENIS_KELAMIN" => $validatedData['jenis_kelamin'],
            "NAMA_AYAH" => $validatedData['nama_ayah'],
            "NAMA_IBU" => $validatedData['nama_ibu'],
        ]);

        if ($request->has('keluarga')) {
            $keluargaData = $request->input('keluarga');
            $validator = Validator::make($keluargaData, [
                'nama_suami' => ['required', 'max:50', 'min:3'],
                'tempat_lahir_suami' => ['required', 'max:15', 'min:3'],
                'tanggal_lahir_suami' => ['required', 'date'],
                'agama_suami' => ['required', 'exists:agama,id_agama'],
                'pendidikan_suami' => ['required', 'exists:pendidikan_terakhir,id_pendidikan_terakhir'],
                'pekerjaan_suami' => ['required', 'max:50', 'min:3'],
                'gol_darah_suami' => ['required'],
                'jumlah_anak' => ['required'],
                'umur_anak_terakhir' => ['required'],
            ]);

            $maxKeluargaId = keluarga::max('ID_KELUARGA');
            $nextKeluargaId = $maxKeluargaId + 1;
            $keluargaData = keluarga::create([
                "ID_KELUARGA" => $nextKeluargaId,
                "ID_PASIEN" => $pasien->ID_PASIEN,
                "NAMA_SUAMI" => $keluargaData['nama_suami'],
                "TEMPAT_LAHIR_SUAMI" => $keluargaData['tempat_lahir_suami'],
                "TANGGAL_LAHIR_SUAMI" => $keluargaData['tanggal_lahir_suami'],
                "AGAMA_SUAMI" => $keluargaData['agama_suami'],
                "PENDIDIKAN_SUAMI" => $keluargaData['pendidikan_suami'],
                "PEKERJAAN_SUAMI" => $keluargaData['pekerjaan_suami'],
                "GOL_DARAH_SUAMI" => $keluargaData['gol_darah_suami'],
                "JUMLAH_ANAK" => $keluargaData['jumlah_anak'],
                "UMUR_ANAK_TERAKHIR" => $keluargaData['umur_anak_terakhir'],
            $pasien->ID_KELUARGA = $keluargaData['ID_KELUARGA']
            ]);

            // $pasien = pasien::find($validatedData['ID_PASIEN']);
            // $pasien->ID_KELUARGA = $keluarga->ID_KELUARGA;
            // $pasien->save();

        }

        return response()->json(['message' => 'Berhasil membuat pasien', 'data' => $pasien], 200);
        }catch (\Exception $e) {
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
