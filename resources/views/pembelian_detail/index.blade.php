@extends('layouts.master')

@section('title')
    Transaksi Detail Pembelian
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Detail Pembelian</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                {{-- <button onclick="addForm()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Transaksi Baru</button> --}}
                <table>
                    <tr>
                        <td>SUPPLIER </td>
                        <td> : {{ $supplier->nama }}</td>
                    </tr>
                    <tr>
                        <td>TELEPON </td>
                        <td> : {{ $supplier->telepon }}</td>
                    </tr>
                    <tr>
                        <td>ALAMAT </td>
                        <td> : {{ $supplier->alamat }}</td>
                    </tr>
                </table>
            </div>
            <div class="box-body table-responsive">
                <div class="form-group row">
                    <label for="kode_produk" class="col-lg-1" style="font-size: 18px; font-weight: bold;">KODE PRODUK : </label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                                <span class="input-group-btn">
                                    <button onclick="tampilProduk()" type="button" class="btn btn-success btn-flat"><i class="fa fa-plus-circle"></i></button>
                                </span>
                            </div>                   
                        </div>
                    </div>
                <table class="table table-stiped table-bordered">
                    <thead class="header_table">
                        <th class="text-center" width="5%">NO</th>
                        <th class="text-center" width="15%">KODE</th>
                        <th class="text-center" width="15%">NAMA</th>
                        <th class="text-center" width="15%">HARGA</th>
                        <th class="text-center" width="15%">JUMLAH</th>
                        <th class="text-center" width="10%">SUB TOTAL</th>
                        <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody style="font-weight: normal;">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('pembelian_detail.produk')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            // responsive: true,
            // processing: true,
            // serverSide: true,
            // autoWidth: false,
            // ajax: {
            //     url: '{{ route('supplier.data') }}',
            // },
            // columns: [
            //     {data: 'DT_RowIndex', searchable: false, sortable: false},
            //     {data: 'nama'},
            //     {data: 'telepon'},
            //     {data: 'alamat'},
            //     {data: 'aksi', searchable: false, sortable: false},
            // ]
        });

        // $('#modal-form').validator().on('submit', function (e) {
        //     if (! e.preventDefault()) {
        //         $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
        //             .done((response) => {
        //                 $('#modal-form').modal('hide');
        //                 table.ajax.reload();
        //             })
        //             .fail((errors) => {
        //                 alert('Tidak dapat menyimpan data');
        //                 return;
        //             });
        //     }
        // });
    });

    function tampilProduk() {
        $('#modal-produk').modal('show');
        $('#modal-produk .modal-title').text('Daftar Produk');
    }

    function pilihProduk(id,kode){
        
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>

<script type="text/javascript" language="javascript">
     // upper halaman supplier
     function upsupplier(){
      var x = document.getElementById("nama_supplier");
       x.value = x.value.toUpperCase();
       var almt = document.getElementById("alamat");
       almt.value = almt.value.toUpperCase();
    }
</script>
@endpush