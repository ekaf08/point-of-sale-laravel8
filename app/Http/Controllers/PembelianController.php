<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\PembelianDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;


class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::orderBy('nama')->get();

        return view('pembelian.index', compact('supplier'));
    }

    public function data()
    {
        // menggunakan eloquent
        // $pembelian = Pembelian::orderBy('id', 'desc')->get();

        $pembelian = Pembelian::leftJoin('supplier', 'supplier.id', 'pembelian.id_supplier')
            ->select('pembelian.*', 'supplier.nama')
            ->orderBy('pembelian.id', 'desc')
            ->get();

        return datatables()
            ->of($pembelian)
            ->addIndexColumn()
            ->addColumn('created_at', function ($pembelian) {
                return tanggal_indonesia($pembelian->created_at);
            })
            // ->addColumn('supplier', function ($pembelian) {
            //     return $pembelian->supplier->nama;
            // })
            ->addColumn('total_harga', function ($pembelian) {
                return ' <p class="text-right">' . 'Rp. ' .  format_uang($pembelian->total_harga) . '</p>';
            })
            ->addColumn('bayar', function ($pembelian) {
                return ' <p class="text-right">' . 'Rp. ' .  format_uang($pembelian->bayar) . '</p>';
            })
            ->addColumn('total_item', function ($pembelian) {
                return ' <p class="text-right">' . format_uang($pembelian->total_item) . '</p>';
            })
            // ->addColumn('diskon', function ($pembelian) {
            //     return ' <p class="text-right">' . ($pembelian->diskon) . '</p>';
            // })
            ->editColumn('diskon', function ($pembelian) {
                return ' <p class="text-right">' . ($pembelian->diskon) .  ' % </p>';
            })
            ->addColumn('aksi', function ($pembelian) {
                return '
                    <div class="">
                        <button onclick="showDetail(`' . route('pembelian.show', $pembelian->id) . '`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-eye"></i></button>
                        <button onclick="deleteData(`' . route('pembelian.destroy', $pembelian->id) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    </div>
                ';
            })
            ->rawColumns(['aksi', 'supplier', 'total_harga', 'total_item', 'diskon', 'bayar'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pembelian = new Pembelian();
        $pembelian->id_supplier = $id;
        $pembelian->total_item  = 0;
        $pembelian->total_harga = 0;
        $pembelian->diskon = 0;
        $pembelian->bayar = 0;
        $pembelian->save();

        session(['id_pembelian' => $pembelian->id]);
        session(['id_supplier' => $pembelian->id_supplier]);

        return redirect()->route('pembelian_detail.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();

        $pembelian = Pembelian::findOrFail($request->id_pembelian);
        $pembelian->total_item = $request->total_item;
        $pembelian->total_harga = $request->total;
        $pembelian->diskon = $request->diskon;
        $pembelian->bayar = $request->bayar;
        $pembelian->update();
        // return $pembelian;

        // update stok yang ada di tabel produk
        $detail = PembelianDetail::where('id_pembelian', $pembelian->id)->get();
        // dd($detail);
        // return $detail;
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $produk->stok += $item->jumlah;
            $produk->update();
        }
        return redirect()->route('pembelian.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = PembelianDetail::leftJoin('produk', 'produk.id', 'detail_pembelian.id_produk')
            ->select('detail_pembelian.*', 'produk.*')
            ->where('detail_pembelian.id_pembelian', $id)
            ->get();

        // menggunakan eloquent
        // $detail = PembelianDetail::with('produk')
        //     ->where('id_pembelian', $id)->get();

        // $detail = PembelianDetail::where('id_pembelian', $id)->get();

        // return $detail;

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            // ->addColumn('created_at', function ($detail) {
            //     return tanggal_indonesia($detail->created_at);
            // })
            ->addColumn('kode_produk', function ($detail) {
                return '<span class="label label-success">' . $detail->kode_produk . '</span>';
            })
            ->addColumn('nama_produk', function ($detail) {
                return $detail->nama_produk;
            })
            ->addColumn('harga_beli', function ($detail) {
                return ' <p class="text-right">' . 'Rp. ' .  format_uang($detail->harga_beli) . '</p>';
            })
            ->addColumn('jumlah', function ($detail) {
                return ' <p class="text-right">' . format_uang($detail->jumlah) . '</p>';
            })
            ->addColumn('subtotal', function ($detail) {
                return ' <p class="text-right">' . 'Rp. ' .  format_uang($detail->subtotal) . '</p>';
            })
            // ->addColumn('aksi', function ($detail) {
            //     return '
            //         <div class="">
            //             <button onclick="showDetail(`' . route('detail.show', $pembelian->id) . '`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-eye"></i></button>
            //             <button onclick="deleteData(`' . route('pembelian_detail.destroy', $pembelian->id) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
            //         </div>
            //     ';
            // })
            ->rawColumns(['kode_produk', 'harga_beli', 'jumlah', 'subtotal'])
            ->make(true);

        // return $detail;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);

        // hapus tabel detail_pembelian by id pembelian
        $detail    = PembelianDetail::where('id_pembelian', $pembelian->id)->get();

        // return $detail;

        // $detail    = PembelianDetail::leftJoin('pembelian', 'pembelian.id', 'detail_pembelian.id_pembelian')
        //     ->select('detail_pembelian.*', 'pembelian.*')
        //     ->where('detail_pembelian.id_pembelian', $id)
        //     ->get();
        foreach ($detail as $item) {
            // mengurangi stok tabel produk by id pembelian
            $produk = Produk::find($item->id_produk);
            if ($produk) {
                $produk->stok -= $item->jumlah;
                $produk->update();
            }
            $item->delete();
        }

        // hapus tabel pembelian
        $pembelian->delete();

        return response(null, 204);
    }
}
