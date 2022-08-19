<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Member;
use App\Models\Supplier;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $kategori = Kategori::count();
        $member = Member::count();
        $produk = Produk::count();
        $supplier = Supplier::count();

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');

        if (auth()->user()->level == 1) {
            return view('admin.dashboard', compact('kategori', 'supplier', 'member', 'produk', 'tanggal_awal', 'tanggal_akhir'));
        } else {
            return view('kasir.dashboard');
        }
    }
}
