<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Member;
use App\Models\Penjualan;
use App\Models\Setting;
use App\Models\PenjualanDetail;

class PenjualanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk  = Produk::orderBy('nama_produk')->get();
        $member  = Member::orderBy('nama')->get();
        // $setting = Setting::all();
        $setting = Setting::first();
        // dd($produk, $member, $setting);

        // cek apakah ada transaksi yang sedang berjalan
        if ($id_penjualan = session('id')) {
            return view('penjualan_detail.index', compact('produk', 'member', 'setting', 'id_penjualan'));
        } else {
            if (auth()->user()->level == 1) {
                return redirect()->route('transaksi.baru');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function data($id)
    {
        $detail = PenjualanDetail::leftJoin('produk', 'produk.id', 'detail_penjualan.id_produk')
            ->select('detail_penjualan.*', 'produk.nama_produk', 'produk.kode_produk')
            ->where('detail_penjualan.id_penjualan', $id)->get();

        // return $detail;
        // menggunakan Eloquent
        // $detail = PenjualanDetail::with('produk')
        //     ->where('id_penjualan', $id)
        //     ->get();

        // return $detail;

        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $key => $item) {
            $row = array();
            // $row['DT_RowIndex'] = $key + 1;
            $row['kode_produk'] = '<span class="label label-success">' . $item->produk['kode_produk'] . '</span>';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_jual']  = '<p class="text-right">' . 'Rp. ' .  format_uang($item->harga_jual) . '</p>';
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="' . $item->id . '" value="' . $item->jumlah . '">';
            $row['subtotal']    = ' <p class="text-right">' . 'Rp. ' .  format_uang($item->subtotal) . '</p>';
            $row['diskon']      = ' <p class="text-right">' . ($item->diskon) . '% </p>';
            $row['aksi']        = '<div class="btn-group">
                                        <button onclick="deleteData(`' . route('transaksi.destroy', $item->id) . '`)" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                                    </div>';
            $data[] = $row;

            $total += $item->harga_jual * $item->jumlah;
            $total_item += $item->jumlah;
        }
        $data[] = [
            // '<div class="total hide">' . $total . '</div> <div class = "total_item hide">' . $total_item . '</div>',
            'kode_produk' => '
                            <div class="total hide">' . $total . '</div> 
                            <div class = "total_item hide">' . $total_item . '</div>
                            ',
            'nama_produk' => '',
            'harga_jual' => '',
            'jumlah' => '',
            'diskon' => '',
            'subtotal' => '',
            'aksi' => '',
        ];

        // return $data;

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'harga_jual', 'jumlah', 'diskon', 'subtotal'])
            ->make(true);

        // return datatables()
        //     ->of($detail)
        //     ->addIndexColumn()
        //     ->addColumn('nama_produk', function ($detail) {
        //         return $detail->produk['nama_produk'];
        //     })
        //     ->addColumn('kode_produk', function ($detail) {
        //         return '<span class="label label-success">' . $detail->produk['kode_produk'] . '</span>';
        //     })
        //     ->addColumn('harga_beli', function ($detail) {
        //         return '<p class="text-right">' . 'Rp. ' .  format_uang($detail->harga_beli) . '</p>';
        //     })
        //     ->addColumn('jumlah', function ($detail) {

        //         return '<input type="number" class="form-control input-sm quantity" data-id="' . $detail->id . '" value="' . $detail->jumlah . '">';
        //     })
        //     ->addColumn('subtotal', function ($detail) {
        //         return ' <p class="text-right">' . 'Rp. ' .  format_uang($detail->subtotal) . '</p>';
        //     })
        //     ->addColumn('aksi', function ($detail) {
        //         return '
        //         <div class="btn-group">
        //             <button onclick="deleteData(`' . route('penjualan_detail.destroy', $detail->id) . '`)" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i> Hapus</button>
        //         </div>
        //         ';
        //     })
        //     ->rawColumns(['aksi', 'kode_produk', 'harga_beli', 'jumlah', 'subtotal'])
        //     ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produk = Produk::where('id', $request->id_produk)->first();
        if (!$produk) {
            // cek apakah produk 0 atau tidak
            return response()->json('Data Gagal Disimpan', 400);
        }
        $detail = new PenjualanDetail();
        $detail->id_penjualan = $request->id_penjualan;
        $detail->id_produk = $request->id_produk;
        $detail->harga_jual = $produk->harga_jual;
        $detail->jumlah = 1;
        $detail->diskon = 0;
        $detail->subtotal = $produk->harga_jual;

        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    public function loadForm($diskon = 0, $total, $diterima)
    {
        $bayar   = $total - ($diskon / 100 * $total);
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        //cek diterima = 0 apa tidak, apablia diterima tidak = 0 maka $diterima - $bayar.. apabila belum bayar maka akan di set menjadi 0.
        $data    = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar) . 'Rupiah'),
            'kembalirp' => format_uang($kembali)
            //note : ucwords di buat untuk membuat huruf terbilang pertama menjadi kapital
        ];

        return response()->json($data);
    }
}
