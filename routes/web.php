<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ItemStockController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemTransactionController;

// Halaman login
Route::get('/', function () {
    return view('auth.login');
});

// Logout
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Route fallback
Route::fallback(function () {
    return response()->view('error.404', [], 404);
});

// Auth routes default
Auth::routes();

// Routes untuk semua user yang sudah login
Route::middleware(['auth'])->group(function () {
    // Home/Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// =====================================================
// ADMIN ROUTES - Kelola Admin, Petugas, Pengguna
// =====================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/', [AdminController::class, 'index'])->name('index');
    
    // CRUD Admin
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/store', [AdminController::class, 'store'])->name('store');
    Route::get('/show/{id}', [AdminController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [AdminController::class, 'update'])->name('update');
    Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');
    Route::get('/export-pdf', [AdminController::class, 'exportPDF'])->name('exportPDF');
    
    // CRUD Petugas (Staff)
    Route::prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/', [AdminController::class, 'petugasIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'petugasCreate'])->name('create');
        Route::post('/store', [AdminController::class, 'petugasStore'])->name('store');
        Route::get('/show/{id}', [AdminController::class, 'petugasShow'])->name('show');
        Route::get('/edit/{id}', [AdminController::class, 'petugasEdit'])->name('edit');
        Route::put('/update/{id}', [AdminController::class, 'petugasUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'petugasDestroy'])->name('destroy');
        Route::get('/export-pdf', [AdminController::class, 'petugasExportPDF'])->name('exportPDF');
    });

    // CRUD Pengguna (Users)
    Route::prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/', [AdminController::class, 'penggunaIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'penggunaCreate'])->name('create');
        Route::post('/store', [AdminController::class, 'penggunaStore'])->name('store');
        Route::get('/show/{id}', [AdminController::class, 'penggunaShow'])->name('show');
        Route::get('/edit/{id}', [AdminController::class, 'penggunaEdit'])->name('edit');
        Route::put('/update/{id}', [AdminController::class, 'penggunaUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'penggunaDestroy'])->name('destroy');
        Route::get('/export-pdf', [AdminController::class, 'penggunaExportPDF'])->name('exportPDF');
    });
    
    // Rekap / Reports
    Route::get('/rekap', [AdminController::class, 'rekapIndex'])->name('rekap.index');
    Route::get('/rekap/export-pdf', [AdminController::class, 'rekapExportPDF'])->name('rekap.exportPDF');
});

// =====================================================
// PETUGAS ROUTES - Kelola Item, Kategori, Transaksi
// =====================================================
Route::middleware(['auth', 'petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    // Dashboard Petugas
    Route::get('/', [PetugasController::class, 'index'])->name('index');
    Route::get('/home', [PetugasController::class, 'index'])->name('home');
    Route::get('/dashboard', [PetugasController::class, 'index'])->name('dashboard');
    
    // CRUD Item Barang
    Route::prefix('item')->name('item.')->group(function () {
        Route::get('/', [PetugasController::class, 'Itemindex'])->name('index');
        Route::get('/create', [PetugasController::class, 'create'])->name('create');
        Route::post('/store', [PetugasController::class, 'store'])->name('store');
        Route::get('/export-pdf', [PetugasController::class, 'itemExportPDF'])->name('exportPDF');
        Route::get('/{id}', [PetugasController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PetugasController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PetugasController::class, 'update'])->name('update');
        Route::delete('/{id}', [PetugasController::class, 'destroy'])->name('destroy');
    });

    // CRUD Kategori Barang
    Route::get('/item-category', [ItemCategoryController::class, 'index'])->name('item-category.index');
    Route::get('/item-category/create', [ItemCategoryController::class, 'create'])->name('item-category.create');
    Route::post('/item-category/store', [ItemCategoryController::class, 'store'])->name('item-category.store');
    Route::get('/item-category/{itemCategory}', [ItemCategoryController::class, 'show'])->name('item-category.show');
    Route::get('/item-category/{itemCategory}/edit', [ItemCategoryController::class, 'edit'])->name('item-category.edit');
    Route::put('/item-category/{itemCategory}', [ItemCategoryController::class, 'update'])->name('item-category.update');
    Route::delete('/item-category/{itemCategory}', [ItemCategoryController::class, 'destroy'])->name('item-category.destroy');

    // Transaksi barang hanya untuk pengguna
});

// =====================================================
// PENGGUNA ROUTES - Ambil Barang dari Gudang
// =====================================================
Route::middleware(['auth', 'pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    // Dashboard Pengguna
    Route::get('/home', [PenggunaController::class, 'dashboard'])->name('home');
    Route::get('/dashboard', [PenggunaController::class, 'dashboard'])->name('dashboard');
    
    // Transaksi Pengguna (Ambil Barang - Keluar dari Gudang)
    Route::get('/transaction', [PenggunaController::class, 'index'])->name('transaction.index');
    Route::get('/transaction/create', [PenggunaController::class, 'create'])->name('transaction.create');
    Route::post('/transaction/store', [PenggunaController::class, 'store'])->name('transaction.store');
    Route::get('/transaction/export-pdf', [PenggunaController::class, 'transactionExportPDF'])->name('transaction.exportPDF');
    Route::get('/transaction/{id}', [PenggunaController::class, 'show'])->name('transaction.show');
    Route::get('/transaction/{id}/edit', [PenggunaController::class, 'edit'])->name('transaction.edit');
    Route::put('/transaction/{id}', [PenggunaController::class, 'update'])->name('transaction.update');
    Route::delete('/transaction/{id}', [PenggunaController::class, 'destroy'])->name('transaction.destroy');
});
