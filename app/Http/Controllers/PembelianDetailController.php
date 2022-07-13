<?php

namespace App\Http\Controllers;

use App\Models\PembelianDetail;
use App\Models\PembelianDetailController;
use Illuminate\Http\Request;

class PembelianDetailControllerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pembelin_detail.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PembelianDetailController  $pembelianDetailController
     * @return \Illuminate\Http\Response
     */
    public function show(PembelianDetailController $pembelianDetailController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PembelianDetailController  $pembelianDetailController
     * @return \Illuminate\Http\Response
     */
    public function edit(PembelianDetailController $pembelianDetailController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PembelianDetailController  $pembelianDetailController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PembelianDetailController $pembelianDetailController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PembelianDetailController  $pembelianDetailController
     * @return \Illuminate\Http\Response
     */
    public function destroy(PembelianDetailController $pembelianDetailController)
    {
        //
    }
}
