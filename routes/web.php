<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProdukController,
    KategoriController,
    MemberController,
    PembelianController,
    PengeluaranController,
    SupplierController,
};

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
    return redirect()->route('login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');
});

Route::group(['middleware' => 'auth'], function () {
    // ----------------Kategori-------------------------------
    Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('/kategori', KategoriController::class);
    // ----------------produk-------------------------------
    Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
    Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
    Route::post('/produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetak_barcode');
    Route::resource('/produk', ProdukController::class);
    // ----------------Member-------------------------------
    Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
    Route::post('/member/cetak-member', [MemberController::class, 'cetakMember'])->name('member.cetak_member');
    Route::resource('/member', MemberController::class);
    // ----------------Supplier-------------------------------
    Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
    Route::resource('/supplier', SupplierController::class);
    // ----------------Pengeluaran-------------------------------
    Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
    Route::resource('/pengeluaran', PengeluaranController::class);

    // ----------------Pembelian-------------------------------
    // Route::get('/pembelian/data', [PengeluaranController::class, 'data'])->name('pembelian.data');
    Route::get('/pembelian/{id}/create', PembelianController::class, 'create')->name('pembelian.create');
    Route::resource('/pembelian', PembelianController::class)
        ->except('create');
});
