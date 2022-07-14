<?php


namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;

use Illuminate\Http\Request;

class PembelianDetailController extends Controller
{
    public function index()
    {
        $id_pembelian = session('id_pembelian');
        $produk = Produk::orderBy('nama_produk')->get();
        $supplier = Supplier::find(session('id_supplier'));

        // return session('id_supplier');
        if (!$supplier) {
            abort(404);
        }
        return view('pembelian_detail.index', compact('id_pembelian', 'produk', 'supplier'));
    }

    public function store(Request $request)
    {
        $produk = Produk::where('id', $request->id_produk)->first();
        if (!$produk) {
            return response()->json('Data Gagal Disimpan', 400);
        }
        $detail = new PembelianDetail();
        $detail->id_pembelian = $request->id_pembelian;
        $detail->id_produk = $request->id_produk;
        $detail->harga_beli = $produk->harga_beli;
        $detail->jumlah = 1;
        $detail->subtotal = $produk->harga_beli;

        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }
}
