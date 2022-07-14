<?php


namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;
use DetailPembelian;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Svg\Tag\Rect;

class PembelianDetailController extends Controller
{
    public function index()
    {
        $id_pembelian = session('id_pembelian');
        $produk = Produk::orderBy('nama_produk')->get();
        // return $produk;
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

        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $key => $item) {
            $row = array();
            $row['DT_RowIndex'] = $key + 1;
            $row['kode_produk'] = '<span class="label label-success">' . $item->produk['kode_produk'] . '</span>';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_beli'] = '<p class="text-right">' . 'Rp. ' .  format_uang($item->harga_beli) . '</p>';
            $row['jumlah'] = '<input type="number" class="form-control input-sm quantity" data-id="' . $item->id . '" value="' . $detail->jumlah . '">';
            $row['subtotal'] = $item->subtotal;
            $data[] = $row;

            $total += $item->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk['nama_produk'];
            })
            ->addColumn('kode_produk', function ($detail) {
                return '<span class="label label-success">' . $detail->produk['kode_produk'] . '</span>';
            })
            ->addColumn('harga_beli', function ($detail) {
                return '<p class="text-right">' . 'Rp. ' .  format_uang($detail->harga_beli) . '</p>';
            })
            ->addColumn('jumlah', function ($detail) {

                return '<input type="number" class="form-control input-sm quantity" data-id="' . $detail->id . '" value="' . $detail->jumlah . '">';
            })
            ->addColumn('subtotal', function ($detail) {
                return ' <p class="text-right">' . 'Rp. ' .  format_uang($detail->subtotal) . '</p>';
            })
            ->addColumn('aksi', function ($detail) {
                return '
                <div class="btn-group">
                    <button onclick="deleteData(`' . route('pembelian_detail.destroy', $detail->id) . '`)" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'harga_beli', 'jumlah', 'subtotal'])
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

    public function update(Request $request, $id)
    {
        $detail = PembelianDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = PembelianDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }
}
