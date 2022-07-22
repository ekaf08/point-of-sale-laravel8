<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use App\Models\setting;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('penjualan.index');
    }

    public function data()
    {
        // menggunakan eloquent
        // $pembelian = Pembelian::orderBy('id', 'desc')->get();


        // $penjualan = DB::table('penjualan')
        //     ->join('member', 'member.id', '=', 'penjualan.id_member')
        //     ->join('users', 'users.id', '=', 'penjualan.id_user')
        //     ->select('penjualan.*', 'member.kode_member', 'penjualan.id_user', 'users.name')
        //     ->orderBy('penjualan.id', 'desc')
        //     ->get();

        // $penjualan = Penjualan::leftJoin('member', 'member.id', 'penjualan.id_member', 'detail_penjualan', 'detail_penjualan.id_penjualan', 'penjualan.id')
        //     ->select('penjualan.*', 'member.kode_member', 'penjualan.id_user')
        //     ->orderBy('penjualan.id', 'desc')
        //     ->get();

        $penjualan = Penjualan::leftJoin('member', 'member.id', 'penjualan.id_member')
            ->leftJoin('users', 'users.id', 'penjualan.id_user')
            ->select('penjualan.*', 'member.kode_member', 'users.name')
            ->orderBy('penjualan.id', 'desc')
            ->get();

        // return $penjualan;

        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('created_at', function ($penjualan) {
                return tanggal_indonesia($penjualan->created_at);
            })
            ->addColumn('kode_member', function ($penjualan) {
                return '<span class="label label-success">' . $penjualan->kode_member ?? '' . '</span>';
            })
            ->addColumn('total_item', function ($penjualan) {
                return ' <p class="text-right">' . format_uang($penjualan->total_item) . '</p>';
            })
            ->addColumn('total_harga', function ($penjualan) {
                return ' <p class="text-right">' . 'Rp. ' .  format_uang($penjualan->total_harga) . '</p>';
            })
            ->editColumn('diskon', function ($penjualan) {
                return ' <p class="text-right">' . ($penjualan->diskon) .  ' % </p>';
            })
            ->addColumn('bayar', function ($penjualan) {
                return ' <p class="text-right">' . 'Rp. ' .  format_uang($penjualan->bayar) . '</p>';
            })
            ->addColumn('kasir', function ($penjualan) {
                return $penjualan->name ?? '';
            })

            ->addColumn('aksi', function ($penjualan) {
                return '
                    <div class="">
                        <button onclick="showDetail(`' . route('penjualan.show', $penjualan->id) . '`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-eye"></i></button>
                        <button onclick="deleteData(`' . route('penjualan.destroy', $penjualan->id) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_member', 'kasir', 'total_harga', 'total_item', 'diskon', 'bayar'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $penjualan = new Penjualan();

        $penjualan->id_member = null;
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->diskon = 0;
        $penjualan->bayar = 0;
        $penjualan->diterima = 0;
        $penjualan->id_user = auth()->id();
        $penjualan->save();

        session(['id' => $penjualan->id]);
        return redirect()->route('transaksi.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;

        $penjualan = Penjualan::findOrFail($request->id_penjualan);
        $penjualan->total_item = $request->total_item;
        $penjualan->total_harga = $request->total;
        $penjualan->diskon = $request->diskon;
        $penjualan->bayar = $request->bayar;
        $penjualan->diterima = $request->diterima;
        $penjualan->id_member = $request->id_member;
        $penjualan->update();
        // return $penjualan;

        // update stok yang ada di tabel produk
        $detail = PenjualanDetail::where('id_penjualan', $penjualan->id)->get();
        // dd($detail);
        // return $detail;
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $produk->stok -= $item->jumlah;
            $produk->update();
        }
        // return redirect()->route('penjualan.index')->with('success', 'Data Berhasil Disimpan');
        return redirect()->route('transaksi.selesai');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = PenjualanDetail::leftJoin('produk', 'produk.id', 'detail_penjualan.id_produk')
            ->select('detail_penjualan.*', 'produk.*')
            ->where('detail_penjualan.id_penjualan', $id)
            ->get();

        // return $detail;

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
            ->addColumn('harga_jual', function ($detail) {
                return ' <p class="text-right">' . 'Rp. ' .  format_uang($detail->harga_jual) . '</p>';
            })
            ->addColumn('jumlah', function ($detail) {
                return ' <p class="text-right">' . format_uang($detail->jumlah) . '</p>';
            })
            ->addColumn('subtotal', function ($detail) {
                return ' <p class="text-right">' . 'Rp. ' .  format_uang($detail->subtotal) . '</p>';
            })
            ->rawColumns(['kode_produk', 'harga_jual', 'jumlah', 'subtotal'])
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
        $penjualan = Penjualan::find($id);

        // hapus tabel detail_penjualan by id penjualan
        $detail    = PenjualanDetail::where('id_penjualan', $penjualan->id)->get();

        // return $detail;

        // $detail    = penjualanDetail::leftJoin('penjualan', 'penjualan.id', 'detail_penjualan.id_penjualan')
        //     ->select('detail_penjualan.*', 'penjualan.*')
        //     ->where('detail_penjualan.id_penjualan', $id)
        //     ->get();
        foreach ($detail as $item) {
            // mengurangi stok tabel produk by id penjualan
            $produk = Produk::find($item->id_produk);
            if ($produk) {
                $produk->stok += $item->jumlah;
                $produk->update();
            }
            $item->delete();
        }
        $penjualan->delete();
        return response(null, 204);
    }

    public function selesai()
    {
        $setting = Setting::first();
        return view('penjualan.selesai', compact('setting'));
    }

    public function notaKecil()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id'));
        // cek apakah ada penjualan aktif atau tidak
        if (!$penjualan) {
            // abort(404);
            return redirect()->route('penjualan.index')->with('error', 'Tidak Ada Penjualan Aktif');
        }

        $detail = PenjualanDetail::join('produk', 'produk.id', 'detail_penjualan.id_produk')
            ->select('detail_penjualan.*', 'produk.*')
            ->where('detail_penjualan.id_penjualan', session('id'))
            ->get();

        //di bawah ini menggunakan eloquent
        // $detail = PenjualanDetail::with('produk')
        //     ->where('id_penjualan', session('id'))
        // ->get();

        return view('penjualan.nota_kecil', compact('setting', 'penjualan', 'detail'));
    }

    public function notaBesar()
    {
        //
    }
}
