<?php

use App\Http\Controllers\JenisPelayananController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\userAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test-database', function () {
//     try {
//         DB::connection()->getPdo();
//         return "Database connection successful!";
//     } catch (\Exception $e) {
//         return "Database connection failed: " . $e->getMessage();
//     }
// });
// // AUTH
// Route::post('/signup', [userAuth::class, 'SignUp']);
// Route::post('/signin', [userAuth::class, 'SignIn']);

// // JENIS PELAYANAN
// Route::post('/addpelayanan', [JenisPelayananController::class, 'create']);
// Route::get('/getpelayanan', [JenisPelayananController::class, 'index']);
// Route::put('/updatepelayanan/{id}/update', [JenisPelayananController::class, 'edit']);
// Route::delete('/deletepelayanan/{id}/delete', [JenisPelayananController::class, 'delete']);

// // RESERVASI
// Route::post('/addreservasi', [ReservasiController::class, 'create']);
// Route::get('/getreservasi', [ReservasiController::class, 'index']);
// Route::delete('/deletereservasi/{id}/delete', [ReservasiController::class, 'delete']);
