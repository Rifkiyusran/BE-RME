<?php

use App\Http\Controllers\AgamaController;
use App\Http\Controllers\BidanController;
use App\Http\Controllers\JenisImunisasiController;
use App\Http\Controllers\JenisPelayananController;
use App\Http\Controllers\MetodeKbController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PelayananKB;
use App\Http\Controllers\PelayananKbController;
use App\Http\Controllers\PendidikanTerakhirController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\userAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test-database', function () {
    try {
        DB::connection()->getPdo();
        return "Database connection successful!";
    } catch (\Exception $e) {
        return "Database connection failed: " . $e->getMessage();
    }
});

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cek_login:admin']], function () {
        Route::resource('admin', AdminController::class);
    });
    Route::group(['middleware' => ['cek_login:editor']], function () {
        Route::resource('editor', AdminController::class);
    });
});

// AUTH
Route::post('/signup', [userAuth::class, 'SignUp']);
Route::post('/signin', [userAuth::class, 'SignIn']); //login untuk admin dan bidan
Route::post('/login', [userAuth::class, 'login']); // login untuk pasien
Route::get('/logout', [userAuth::class, 'logout']);

//BIDAN
Route::post('/addbidan', [BidanController::class, 'signUpBidan']);
Route::get('/getbidan', [BidanController::class, 'show']);
Route::delete('/deletebidan/{id}', [BidanController::class, 'delete']);

// PASIEN
Route::post('/addpasien', [PasienController::class, 'create']);
Route::get('/getpasien', [PasienController::class, 'index']);
Route::get('/getpasien/{id}', [PasienController::class, 'show']);
Route::put('/updatepasien/{id}', [PasienController::class, 'edit']);
Route::delete('/deletepasien/{id}', [PasienController::class, 'delete']);

// AGAMA
Route::post('/addagama', [AgamaController::class, 'create']);
Route::get('/getagama', [AgamaController::class, 'index']);
Route::put('/updateagama/{id}', [AgamaController::class, 'edit']);
Route::delete('/deleteagama/{id}', [AgamaController::class, 'delete']);

// JENIS PELAYANAN
Route::post('/addpelayanan', [JenisPelayananController::class, 'create']);
Route::get('/getpelayanan', [JenisPelayananController::class, 'index']);
Route::put('/updatepelayanan/{id}', [JenisPelayananController::class, 'edit']);
Route::delete('/deletepelayanan/{id}', [JenisPelayananController::class, 'delete']);

// JENIS IMUNISASI
Route::post('/addimunisasi', [JenisImunisasiController::class, 'create']);
Route::get('/getimunisasi', [JenisImunisasiController::class, 'index']);
Route::put('/updateimunisasi/{id}', [JenisImunisasiController::class, 'edit']);
Route::delete('/deleteimunisasi/{id}', [JenisImunisasiController::class, 'delete']);

// METODE KB
Route::post('/addmetodekb', [MetodeKbController::class, 'create']);
Route::get('/getmetodekb', [MetodeKbController::class, 'index']);
Route::put('/updatemetodekb/{id}', [MetodeKbController::class, 'edit']);
Route::delete('/deletemetodekb/{id}', [MetodeKbController::class, 'delete']);

// PENDIDIKAN TERAKHIR
Route::post('/addpendidikan', [PendidikanTerakhirController::class, 'create']);
Route::get('/getpendidikan', [PendidikanTerakhirController::class, 'index']);
Route::put('/updatependidikan/{id}', [PendidikanTerakhirController::class, 'edit']);
Route::delete('/deletependidikan/{id}', [PendidikanTerakhirController::class, 'delete']);

// PENYAKIT
Route::post('/addpenyakit', [PenyakitController::class, 'create']);
Route::get('/getpenyakit', [PenyakitController::class, 'index']);
Route::put('/updatepenyakit/{id}', [PenyakitController::class, 'edit']);
Route::delete('/deletepenyakit/{id}', [PenyakitController::class, 'delete']);

// DATA KESEHATAN PELAYANAN KB
Route::get('getkesehatanKb/{id}', [PelayananKbController::class, 'show']);
Route::post('postkesehatanKb', [PelayananKbController::class, 'store']);
