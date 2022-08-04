@extends('layouts.master')

@section('title')
    Transaksi Penjualan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Penjualan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            {{-- <div class="box-header with-border">
                <button onclick="addForm()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Transaksi Baru</button>
                cek apakah ada transaksi aktif atau tidak
                @empty(!session('id_penjualan'))                  
                    <a href="{{ route('penjualan_detail.index') }}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit"></i> Transaksi Aktif</a>
                @endempty
            </div> --}}
            <div class="box-body">
                <div class="alert alert-success alert-dismissible">
                    <i class="fa fa-check icon"></i>
                    Data Transaksi Telah Disimpan
                </div>
            </div>
            <div class="box-footer">
                @if ($setting->tipe_nota == 1)
                    <button class="btn btn-warning btn-flat" onclick="notaKecil('{{ route('transaksi.nota_kecil') }}', 'Nota Kecil')"><i class="fa fa-print"></i> Cetak Nota</button>                       
                @else
                    <button class="btn btn-warning btn-flat" onclick="notaBesar('{{ route('transaksi.nota_besar') }}', 'Nota Besar'"><i class="fa fa-print"></i> Cetak Nota</button>
                @endif
         
                <a href="{{ route('transaksi.baru') }}" class="btn btn-primary btn-flat"><i class="fa fa-cart-arrow-down"></i> Transaksi Baru</a>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    function notaKecil(url, title) {
        //720 = ukuran, 675 = width
        popupCenter(url, title, 625, 500);
    }

    function notaBesar(url, title) {
        popupCenter(url, title, 720, 675);
    }

    function popupCenter({url, title, w, h}){
        // Fixes dual-screen position                             Most browsers      Firefox
        const dualScreenLeft    = window.screenLeft !==  undefined   ? window.screenLeft : window.screenX;
        const dualScreenTop     = window.screenTop  !==  undefined   ? window.screenTop  : window.screenY;

        const width    = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height   = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        const systemZoom    = width / window.screen.availWidth;
        const left          = (width - w) / 2 / systemZoom + dualScreenLeft
        const top           = (height - h) / 2 / systemZoom + dualScreenTop
        const newWindow     = window.open(url, title, 
        `
            scrollbars=yes,
            width   =${w / systemZoom}, 
            height  =${h / systemZoom}, 
            top     =${top}, 
            left    =${left}
      `
    );

    if (window.focus) newWindow.focus();
}
</script>

{{-- <script type="text/javascript" language="javascript">
     // upper halaman supplier
     function upsupplier(){
      var x = document.getElementById("nama_supplier");
       x.value = x.value.toUpperCase();
       var almt = document.getElementById("alamat");
       almt.value = almt.value.toUpperCase();
    }
</script> --}}
@endpush