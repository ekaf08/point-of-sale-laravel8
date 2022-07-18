@extends('layouts.master')

@section('title')
    Transaksi Detail Penjualan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Detail Penjualan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            
            <div class="box-body">
              <form class="form-produk">
                @csrf
                <div class="form-group row">
                    <label for="kode_produk" class="col-lg-1" style=" font-weight: bold;">KODE PRODUK </label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                                <span class="input-group-btn">
                                    <button onclick="tampilProduk()" type="button" class="btn btn-info btn-flat"><i class="fa fa-plus-circle"></i></button>
                                </span>
                            </div>                   
                        </div>
                </div>
              </form>
                <table class="table table-stiped table-bordered table-pembelian-detail">
                    <thead class="header_table">
                        <th class="text-center" width="5%">NO</th>
                        <th class="text-center" width="15%">KODE</th>
                        <th class="text-center" width="15%">NAMA</th>
                        <th class="text-center" width="15%">HARGA</th>
                        <th class="text-center" width="10%">JUMLAH</th>
                        <th class="text-center" width="10%">DISKON</th>
                        <th class="text-center" width="15%">SUB TOTAL</th>
                        <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody style="font-weight: normal;">
                       
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary"></div>
                        <div class="tampil-terbilang"></div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{ route('transaksi.store') }}" class="form-pembelian" method="POST">
                            @csrf
                            <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">
                            
                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">TOTAL</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diskon" class="col-lg-2 control-label">DISKON</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control" value="0" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayar" class="col-lg-2 control-label">BAYAR</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>
        </div>
    </div>
</div>

@includeIf('penjualan_detail.produk')
@includeIf('penjualan_detail.member')
@endsection

@push('scripts')
<script>
    // ini untuk membedakan tabel produk dan tabale detail pembelian, di bedakan dengan nama class 
    let table_ajax, table2;

    $(function () {
        $('body').addClass('sidebar-collapse');
        table_ajax = $('.table-penjualan-detail').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('transaksi.data', $id_penjualan) }}',    
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'jumlah'},
                {data: 'diskon'},
                {data: 'subtotal'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
        })
        .on('draw.dt', function(){
            loadForm($('#diskon').val()); 
        })
        ;

        //ini untuk data tabel produk
        table2 = $('table-produk').DataTable()

        // jumlah * harga beli
        $(document).on('input', '.quantity', function () {
            // console.log($(this).val());
            
            // console.log(id);
            // return;
            let id = $(this).data('id');
            let jumlah = parseInt($(this).val());
            if(jumlah < 1) {
                alert('Jumlah stok tidak bole kurang dari 1');
                $(this).val(10);
                return;
            }
            if(jumlah > 10000) {
                alert('Jumlah stok tidak boleh lebih dari 10.000');
                $(this).val(10000);
                return;
            }

            $.post(`{{ url('/penjualan_detail') }}/${id}`,{
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'put',
                'jumlah':jumlah 
            })
                .done(response => {
                    $(this).on('mouseout', function(){
                        table_ajax.ajax.reload();
                    });
                })
                .fail(errors => {
                    // alert('Tidak dapat menyimpan data');
                    return;
                });
        });

        // hitung diskon
        $(document).on('input', '#diskon', function(){
            let diskon = parseInt($(this).val())

            if(diskon > 100) {
                alert('Diskon tidak boleh melebihi 100%');
                $(this).val(100);
                return;
            }
            if ($(this).val() == ""){
                $(this).val(0).select();
            }

            loadForm($(this).val())
        });

        // aksi simpan transaksi
        $('.btn-simpan').on('click', function (){
            $('.form-pembelian').submit();
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
        $('#modal-produk .modal-title').text('Daftar Member');
    }

    function tampilMember() {
        $('#modal-member').modal('show');
        $('#modal-member .modal-title').text('Daftar Member');
    }

    function hideProduk() {
        $('#modal-produk').modal('hide');
    }

    //fungsi untuk menambah data pada tabel detail pembelian
    function pilihProduk(id,kode){
        $('#id_produk').val(id);
        $('#kode_produk').val(kode);
        hideProduk();
        tambahProduk();
    }

    function tambahProduk() {
        $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
        .done(response => {
            $('#kode_produk').focus();
            table_ajax.ajax.reload();
        })
        .fail(errors => {
            alert('Tidak dapat menyimpan data');
            return;
        });
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table_ajax.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }

    function loadForm(diskon = 0){
        $('#total').val($('.total').text());
        $('#total_item').val($('.total_item').text());

        $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${0}`)
            .done(response => {
                $('#totalrp').val('Rp. '+ response.totalrp);
                $('#bayarrp').val('Rp. '+ response.bayarrp);
                $('#bayar').val(response.bayar);
                $('.tampil-bayar').text('Rp. '+ response.bayarrp);
                $('.tampil-terbilang').text('Rp. '+ response.terbilang);
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data');
                return;
            })
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