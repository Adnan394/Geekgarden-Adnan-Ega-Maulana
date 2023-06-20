<?php

use App\Http\Controllers\KeranjangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\TransaksiController;
use App\Http\Resources\ProdukCollection;
use App\Models\Transaksi;

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
Route::middleware(['auth:sanctum'])->group(function(){
    Route::resource('produk', ProdukController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('keranjang', KeranjangController::class);
    Route::get('/logout', [LoginController::class, 'logout']);
});

Route::post('/login', [LoginController::class, 'index']);
Route::post('/signup', [SignupController::class, 'index']);