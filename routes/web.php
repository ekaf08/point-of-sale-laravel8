<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProdukController,
    KategoriController,
    LaporanController,
    MemberController,
    PembelianController,
    PengeluaranController,
    SupplierController,
    PembelianDetailController,
    PenjualanController,
    PenjualanDetailController,
    SettingController,
    UserController,
};
use Doctrine\DBAL\Schema\Index;

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
    Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
    Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::resource('/pembelian', PembelianController::class)
        ->except('create');
    // ----------------Pembelian Detail-------------------------------
    Route::get('/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])->name('pembelian_detail.data');
    Route::get('/pembelian_detail/loadform/{diskon}/{total}', [PembelianDetailController::class, 'loadForm'])->name('pembelian_detail.load_form');
    Route::resource('/pembelian_detail', PembelianDetailController::class)
        ->except('create', 'show', 'edit');

    // ----------------Penjualan-------------------------------
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
    Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
    Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
    Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
    Route::get('/transaksi/selesai', [PenjualanController::class, 'selesai'])->name('transaksi.selesai');
    Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
    Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

    // ----------------Penjualan Detail-------------------------------
    Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
    Route::get('/transaksi/loadform/{diskon}/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])->name('transaksi.load_form');
    Route::resource('/transaksi', PenjualanDetailController::class)
        ->except('show',);

    // ----------------Laporan pendapatan-------------------------------
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/data/{awal}/{akhir}', [LaporanController::class, 'data'])->name('laporan.data');
    Route::get('/laporan/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDF'])->name('laporan.export_pdf');

    // ----------------User-------------------------------
    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::resource('/user', UserController::class);

    // ----------------Setting-------------------------------
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

    // ----------------user profil-------------------------------
    Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');

    // File Upload
    Route::post('/upload', [FileUploadController::class, 'store'])->name('upload');
    Route::delete('/revert', [FileUploadController::class, 'delete'])->name('revert');
});
