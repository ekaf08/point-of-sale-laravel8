<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use PDF;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama', 'id');
        return view('produk.index', compact('kategori'));
    }

    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id', 'produk.id_kategori')
            ->select('produk.*', 'kategori.nama')
            ->orderBy('kode_produk', 'asc')
            ->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '<input type="checkbox" name="id[]" value="' . $produk->id . '">';
            })
            ->addColumn('kategori', function ($produk) {
                return $produk->nama_kategori;
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="label label-success">' . $produk->kode_produk . '</span>';
            })
            ->addColumn('harga_beli', function ($produk) {
                return format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {
                return format_uang($produk->harga_jual);
            })
            ->addColumn('stok', function ($produk) {
                return format_uang($produk->stok);
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`' . route('produk.update', $produk->id) . '`)" class="btn btn-info btn-xs btn-flat"><i class="fa fa-pencil" ></i> </button>
                    <button onclick="deleteData(`' . route('produk.destroy', $produk->id) . '`)" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i> </button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all'])
            ->make(true);
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
        // $this->validate($request, [
        //     'nama_produk' => 'required|string|max:255',
        //     'harga_beli' => 'required|integer',
        //     'harga_jual' => 'required|integer',
        //     'stok' => 'required|integer',
        // ]);

        $produk = Produk::latest()->first() ?? new Produk();
        $request['kode_produk'] = 'P' . tambah_nol_di_depan($produk->id + 1, 6);

        $produk = Produk::create($request->all());

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);
        return response()->json($produk);
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
        $produk = Produk::find($id);
        $produk->update($request->all());

        return response()->json('Data Berhasil Di Perbarui', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Produk::find($id);
        $kategori->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }
        return response(null, 204);
    }

    public function cetakBarcode(Request $request)
    {
        $dataProduk = array();
        foreach ($request->id as $id) {
            $produk = Produk::find($id);
            $dataProduk[] = $produk;
        }

        $pdf = PDF::loadView('produk.barcode', compact('dataProduk'));
        $pdf->setpaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');

        // dd($request->all());
    }
}
