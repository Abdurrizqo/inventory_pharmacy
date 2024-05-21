<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiKeluarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home/home');
});

Route::get('/home', [HomeController::class, 'index']);

Route::get('/supplier', [SupplierController::class, 'index']);
Route::post('/supplier', [SupplierController::class, 'store']);
Route::post('/supplier/edit', [SupplierController::class, 'update']);

Route::get('/kategori', [KategoriController::class, 'index']);
Route::post('/kategori', [KategoriController::class, 'store']);
Route::post('/kategori/edit', [KategoriController::class, 'update']);
Route::get('/kategori/delete/{id}', [KategoriController::class, 'destroy']);

Route::get('/sub-kategori', [SubCategoryController::class, 'index']);
Route::post('/sub-kategori', [SubCategoryController::class, 'store']);
Route::post('/sub-kategori/edit', [SubCategoryController::class, 'update']);
Route::get('/sub-kategori/delete/{id}', [SubCategoryController::class, 'destroy']);

Route::get('/obat', [ObatController::class, 'index']);
Route::get('/obat/create', [ObatController::class, 'createView']);
Route::post('/obat/create', [ObatController::class, 'store']);
Route::get('/obat/edit/{id}', [ObatController::class, 'editView']);
Route::post('/obat/edit/{id}', [ObatController::class, 'update']);

Route::get('/stok', [StokController::class, 'index']);
Route::get('/stok/create', [StokController::class, 'createView']);
Route::post('/stok/create', [StokController::class, 'store']);
Route::get('/stok/edit/{id}', [StokController::class, 'editView']);
Route::post('/stok/edit/{id}', [StokController::class, 'update']);

Route::get('/transaksi-keluar', [TransaksiKeluarController::class, 'index']);
