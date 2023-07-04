<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\keluarga;
use App\Models\pasien;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
//use Illuminate\Validation\Validator;

class PasienAnakController extends Controller
{
    public function index()
    {
        $pasien = pasien::with(['agama', 'pendidikan_terakhir', 'jenis_pelayanan', 'keluarga', 'keluarga.agama_suami', 'keluarga.pendidikan_suami', 'User'])->get();
        return response()->json(['message' => 'List pasien', 'data' => $pasien], 200);
    }


    public function show($tipe)
    {
        // $pasien = pasien::with(['agama', 'pendidikan_terakhir', 'jenis_pelayanan', 'keluarga.agama_suami', 'keluarga.pendidikan_suami', 'User'])->where('ID_PASIEN', $id)->get();
        // return response()->json([
        //     'data' => $pasien,
        // ]);
        {
            if ($tipe === 'anak') {
                $pasien = pasien::with('agama', 'pendidikan_terakhir', 'jenis_pelayanan')->where('TIPE_PASIEN', 'anak')->get();
            } elseif ($tipe === 'ibu') {
                $pasien = pasien::with('agama', 'pendidikan_terakhir', 'jenis_pelayanan', 'keluarga.agama_suami', 'keluarga.pendidikan_suami')->where('TIPE_PASIEN', 'ibu')->get();
            } else {
                return response()->json(['message' => 'Tipe pasien tidak valid'], 400);
            }

            if (!$pasien) {
                return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
            }

            return response()->json(['data' => $pasien], 200);
        }
    }

public function create(Request $request, User $user)
{
    try {
        $validatedData = $request->validate([
            'id_pendidikan_terakhir' => ['required_if:tipe_pasien,ibu', 'exists:pendidikan_terakhir,id_pendidikan_terakhir'],
            'id_agama' => ['required', 'exists:agama,id_agama'],
            'id_jenis_pelayanan' => ['required', 'exists:jenis_pelayanan,id_jenis_pelayanan'],
            'no_rm' => 'required|max:20|unique:pasien',
            'nama_lengkap' => ['required', 'max:50', 'min:3'],
            'tempat_lahir' => ['required', 'max:50', 'min:2'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'max:100'],
            'gol_darah' => ['required'],
            'no_nik' => 'required|max:16|unique:pasien',
            'no_kk' => 'required|max:16',
            'no_telp' => 'required_if:tipe_pasien,ibu',
            'pekerjaan' => ['required_if:tipe_pasien,ibu', 'max:100', 'min:3'],
            'jenis_kelamin' => ['required'],
            'nama_ayah' => ['max:50'],
            'nama_ibu' => ['max:50'],
            //'tipe_pasien' => ['required', 'in:anak,ibu'],
        ]);

        //$tipePasien = $request->input('tipe_pasien');
        if ($request->has('tipe_pasien')) {
            $tipePasien = $request->input('tipe_pasien');
        } else {
            // Misalnya, jika atribut 'nama_ayah' dan 'nama_ibu' diisi, maka tipe_pasien = 'anak'
            // Jika salah satu atau keduanya kosong, maka tipe_pasien = 'ibu'
            if (!empty($validatedData['nama_ayah']) && !empty($validatedData['nama_ibu'])) {
                $tipePasien = 'anak';
            } else {
                $tipePasien = 'ibu';
            }
        }

        if ($tipePasien === 'anak') {
            // Logika untuk tipe pasien anak
            $maxId = pasien::max('ID_PASIEN');
            $nextId = $maxId + 1;
            $pasien = pasien::create([
                "ID_PASIEN" => $nextId,
                "ID_USER" => $user->ID_USER,
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
                "JENIS_KELAMIN" => $validatedData['jenis_kelamin'],
                "NAMA_AYAH" => $validatedData['nama_ayah'],
                "NAMA_IBU" => $validatedData['nama_ibu'],
                "TIPE_PASIEN" => $tipePasien,
            ]);

            return response()->json(['message' => 'Berhasil membuat data pasien anak', 'data' => $pasien], 200);
        } elseif ($tipePasien === 'ibu') {
            // Logika untuk tipe pasien ibu
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

            if ($validator->fails()) {
                return response()->json(['message' => 'Gagal membuat data pasien ibu', 'errors' => $validator->errors()], 400);
            }

            $maxId = pasien::max('ID_PASIEN');
            $nextId = $maxId + 1;
            $pasien = pasien::create([
                "ID_PASIEN" => $nextId,
                "ID_USER" => $user->ID_USER,
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
                "TIPE_PASIEN" => $tipePasien,
            ]);

            $maxKeluargaId = keluarga::max('ID_KELUARGA');
            $nextKeluargaId = $maxKeluargaId + 1;
            $keluarga = keluarga::create([
                "ID_KELUARGA" => $nextKeluargaId,
                "ID_PASIEN" => $nextId,
                "NAMA_SUAMI" => $keluargaData['nama_suami'],
                "TEMPAT_LAHIR_SUAMI" => $keluargaData['tempat_lahir_suami'],
                "TANGGAL_LAHIR_SUAMI" => $keluargaData['tanggal_lahir_suami'],
                "AGAMA_SUAMI" => $keluargaData['agama_suami'],
                "PENDIDIKAN_SUAMI" => $keluargaData['pendidikan_suami'],
                "PEKERJAAN_SUAMI" => $keluargaData['pekerjaan_suami'],
                "GOL_DARAH_SUAMI" => $keluargaData['gol_darah_suami'],
                "JUMLAH_ANAK" => $keluargaData['jumlah_anak'],
                "UMUR_ANAK_TERAKHIR" => $keluargaData['umur_anak_terakhir'],
            ]);
            $pasien->ID_KELUARGA = $keluarga->ID_KELUARGA;
            $pasien->save();

            return response()->json(['message' => 'Berhasil membuat data pasien ibu', 'data' => $pasien], 200);
        } else {
            return response()->json(['message' => 'Tipe pasien tidak valid'], 400);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}

public function edit(Request $request, User $user, $id)
{
    try {
        $validatedData = $request->validate([
            'id_pendidikan_terakhir' => ['required_if:tipe_pasien,ibu', 'exists:pendidikan_terakhir,id_pendidikan_terakhir'],
            'id_agama' => ['required', 'exists:agama,id_agama'],
            'id_jenis_pelayanan' => ['required', 'exists:jenis_pelayanan,id_jenis_pelayanan'],
            'no_rm' => ['required', 'max:20', Rule::unique('pasien')->ignore($id, 'ID_PASIEN')],
            'nama_lengkap' => ['required', 'max:50', 'min:3'],
            'tempat_lahir' => ['required', 'max:50', 'min:2'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'max:100'],
            'gol_darah' => ['required'],
            'no_nik' => ['required', 'max:16', Rule::unique('pasien')->ignore($id, 'ID_PASIEN')],
            'no_kk' => 'required|max:16',
            'no_telp' => 'required_if:tipe_pasien,ibu',
            'pekerjaan' => ['required_if:tipe_pasien,ibu', 'max:100', 'min:3'],
            'jenis_kelamin' => ['required'],
            'nama_ayah' => ['required_if:tipe_pasien,!=,ibu', 'max:50'],
            'nama_ibu' => ['required_if:tipe_pasien,!=,ibu', 'max:50'],
            //'tipe_pasien' => ['required', 'in:anak,ibu'],
        ]);

        if ($request->has('tipe_pasien')) {
            $tipePasien = $request->input('tipe_pasien');
        } else {
            // Misalnya, jika atribut 'nama_ayah' dan 'nama_ibu' diisi, maka tipe_pasien = 'anak'
            // Jika salah satu atau keduanya kosong, maka tipe_pasien = 'ibu'
            if (!empty($validatedData['nama_ayah']) && !empty($validatedData['nama_ibu'])) {
                $tipePasien = 'anak';
            } else {
                $tipePasien = 'ibu';
            }
        }

        if ($tipePasien === 'anak') {
            // Logika untuk tipe pasien anak
            $pasien = pasien::where('ID_PASIEN', $id)->first();
            if (!$pasien) {
                return response()->json(['message' => 'Data pasien tidak ditemukan'], 404);
            }

            $pasien->ID_USER = $user->ID_USER;
            $pasien->ID_AGAMA = $validatedData['id_agama'];
            $pasien->ID_JENIS_PELAYANAN = $validatedData['id_jenis_pelayanan'];
            $pasien->NO_RM = $validatedData['no_rm'];
            $pasien->NAMA_LENGKAP = $validatedData['nama_lengkap'];
            $pasien->TEMPAT_LAHIR = $validatedData['tempat_lahir'];
            $pasien->TANGGAL_LAHIR = $validatedData['tanggal_lahir'];
            $pasien->ALAMAT = $validatedData['alamat'];
            $pasien->GOL_DARAH = $validatedData['gol_darah'];
            $pasien->NO_NIK = $validatedData['no_nik'];
            $pasien->NO_KK = $validatedData['no_kk'];
            $pasien->JENIS_KELAMIN = $validatedData['jenis_kelamin'];
            $pasien->NAMA_AYAH = $validatedData['nama_ayah'];
            $pasien->NAMA_IBU = $validatedData['nama_ibu'];
            $pasien->TIPE_PASIEN = $tipePasien;
            $pasien->save();

            return response()->json(['message' => 'Berhasil mengubah data pasien anak', 'data' => $pasien], 200);
        } elseif ($tipePasien === 'ibu') {
            // Logika untuk tipe pasien ibu
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

            $pasien = pasien::where('ID_PASIEN', $id)->first();
            if (!$pasien) {
                return response()->json(['message' => 'Data pasien tidak ditemukan'], 404);
            }

            $pasien->ID_USER = $user->ID_USER;
            $pasien->ID_PENDIDIKAN_TERAKHIR = $validatedData['id_pendidikan_terakhir'];
            $pasien->ID_AGAMA = $validatedData['id_agama'];
            $pasien->ID_JENIS_PELAYANAN = $validatedData['id_jenis_pelayanan'];
            //$pasien->ID_KELUARGA = $keluargaData->ID_KELUARGA;
            $pasien->NO_RM = $validatedData['no_rm'];
            $pasien->NAMA_LENGKAP = $validatedData['nama_lengkap'];
            $pasien->TEMPAT_LAHIR = $validatedData['tempat_lahir'];
            $pasien->TANGGAL_LAHIR = $validatedData['tanggal_lahir'];
            $pasien->ALAMAT = $validatedData['alamat'];
            $pasien->GOL_DARAH = $validatedData['gol_darah'];
            $pasien->NO_NIK = $validatedData['no_nik'];
            $pasien->NO_KK = $validatedData['no_kk'];
            $pasien->NO_TELP = $validatedData['no_telp'];
            $pasien->PEKERJAAN = $validatedData['pekerjaan'];
            $pasien->TIPE_PASIEN = $tipePasien;
            $pasien->save();

            $keluarga = keluarga::where('ID_PASIEN', $id)->first();
            if (!$keluarga) {
                return response()->json(['message' => 'Data keluarga tidak ditemukan'], 404);
            }

            $keluarga->NAMA_SUAMI = $keluargaData['nama_suami'];
            $keluarga->TEMPAT_LAHIR_SUAMI = $keluargaData['tempat_lahir_suami'];
            $keluarga->TANGGAL_LAHIR_SUAMI = $keluargaData['tanggal_lahir_suami'];
            $keluarga->AGAMA_SUAMI = $keluargaData['agama_suami'];
            $keluarga->PENDIDIKAN_SUAMI = $keluargaData['pendidikan_suami'];
            $keluarga->PEKERJAAN_SUAMI = $keluargaData['pekerjaan_suami'];
            $keluarga->GOL_DARAH_SUAMI = $keluargaData['gol_darah_suami'];
            $keluarga->JUMLAH_ANAK = $keluargaData['jumlah_anak'];
            $keluarga->UMUR_ANAK_TERAKHIR = $keluargaData['umur_anak_terakhir'];
            $keluarga->save();

            return response()->json(['message' => 'Berhasil mengubah data pasien ibu', 'data' => $pasien], 200);
        } else {
            return response()->json(['message' => 'Tipe pasien tidak valid'], 400);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}

    public function delete($pasien)
    {
        try {
            $pasien = pasien::find($pasien);
            $pasien->delete();
            if ($pasien->keluarga) {
                $pasien->keluarga->delete();
            }
            return response()->json(['message' => 'Data pasien berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
