<?php


namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

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

    public function data($id)
    {
        $detail = PembelianDetail::leftJoin('produk', 'produk.id', 'detail_pembelian.id_produk')
            ->select('detail_pembelian.*', 'produk.nama_produk', 'produk.kode_produk')
            ->where('detail_pembelian.id_pembelian', $id)->get();

        // menggunakan Eloquent
        // $detail = PembelianDetail::with('produk')
        //     ->where('id_pembelian', $id)
        //     ->get();

        // return $detail;

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk['nama_produk'];
            })
            ->addColumn('kode_produk', function ($detail) {
                return '<span class="label label-success">' . $detail->produk['kode_produk'] . '</span>';
            })
            ->addColumn('aksi', function ($detail) {
                return '
                <div class="btn-group">
                    <button onclick="deleteData(`' . route('pembelian_detail.destroy', $detail->id) . '`)" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'nama_produk', 'kode_produk'])
            ->make(true);
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
