<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KomplainController;
use App\Http\Controllers\KunjunganController;

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
    return view('auth.login');
})->name('login');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/login', [AuthController::class, 'login'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/captcha-refresh', function () {
    return response()->json(['captcha' => captcha_src()]);
})->name('captcha.refresh');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/check-username', function (Request $request) {
        $query = User::where('username', $request->query('username'));

        // Abaikan pengecekan jika sedang edit dan ID dikirim
        if ($request->has('id')) {
            $query->where('id', '!=', $request->query('id'));
        }

        $exists = $query->exists();
        return response()->json(['exists' => $exists]);
    });


    Route::resource('auth', AuthController::class);
    Route::resource('komplain', KomplainController::class);
    Route::get('/api/komplain', [KomplainController::class, 'getKomplain']);
    Route::resource('kunjungan', KunjunganController::class);
    Route::get('/api/kunjungan', [KunjunganController::class, 'getKunjungan']);
    Route::post('/kunjungan/{kunjungan}/absen', [KunjunganController::class, 'absen'])
        ->name('kunjungan.absen');
});
