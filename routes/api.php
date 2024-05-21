<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/kategori', [KategoriController::class, 'getAllKategori']);
Route::get('/sub-kategori/{idKategori}', [SubCategoryController::class, 'getAllSubKategori']);
Route::get('/obat', [ObatController::class, 'getAllObat']);
Route::get('/supplier', [SupplierController::class, 'getAllSupplier']);
Route::get('/stok', [StokController::class, 'getAllStok']);
Route::post('/stok/stok-keluar', [StokController::class, 'stokKeluar']);
