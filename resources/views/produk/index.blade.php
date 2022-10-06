@extends('layouts.master')

@section('title')
    Daftar Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Prouk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="">
                        <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"> </i> Tambah Produk</button>
                        <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"> </i> Hapus Produk</button>
                        <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-info btn-xs btn-flat"><i class="fa fa-barcode"> </i> Cetak Barcode</button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <form action="" method="post" class="form-produk">
                        @csrf
                        <table class="table table-striped table-bordered">
                            <thead class="header_table">
                                <th class="text-center" width="3%"><input type="checkbox" name="select_all" id="select_all"></th>
                                <th class="text-center" width="3%">NO</th>
                                <th class="text-center" width="5%">KODE</th>
                                <th class="text-center" width="25%">NAMA</th>
                                <th class="text-center" width="10%">KATEGORI</th>
                                <th class="text-center" width="8%">MERK</th>
                                <th class="text-center" width="13%">HARGA BELI</th>
                                <th class="text-center" width="13%">HARGA JUAL</th>
                                <th class="text-center" width="3">DISKON</th>
                                <th class="text-center" width="3%">STOK</th>
                                <th class="text-center" width="8%"><i class="fa fa-cog"></i></th>
                            </thead>
                            <tbody style="font-weight: normal;">

                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @includeIf('produk.form')
@endsection


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
<script>
    $(document).ready(function(){
        $('#harga_jual').inputmask();
        $('#harga_beli').inputmask();
        $('#stok').inputmask();
    })
</script>
<script>
    let table;

    $(function(){
        $('body').addClass('sidebar-collapse');
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('produk.data') }}',
            },
            columns: [
                {data: 'select_all', searchable:false, sortable:false},
                {data: 'DT_RowIndex', searchable: false, sortable:false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'nama'},
                {data: 'merk'},
                {data: 'harga_beli'},
                {data: 'harga_jual'},
                {data: 'diskon'},
                {data: 'stok'},
                {data: 'aksi', searchable:false, sortable:false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e){
            if (! e.preventDefault()){
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        Swal.fire({
                        // position : 'top-end',
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Produk Telah Ditambahkan',
                        // footer: '<a href="">Why do I have this issue?</a>'
                    })
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Produk Sudah Ada !!!',
                  })
                        return;
                    });
            }
        });

        $('[name=select_all]').on('click', function(){
            $(':checkbox').prop('checked', this.checked);
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_produk]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_produk]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_produk]').val(response.nama_produk);
                $('#modal-form [name=id_kategori]').val(response.id_kategori);
                $('#modal-form [name=merk]').val(response.merk);
                $('#modal-form [name=harga_beli]').val(response.harga_beli);
                $('#modal-form [name=harga_jual]').val(response.harga_jual);
                $('#modal-form [name=diskon]').val(response.diskon);
                $('#modal-form [name=stok]').val(response.stok);
                

            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
      Swal.fire({
        title: 'Yakin ?',
        text: "Menghapus Data Ini !!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
      }).then((result) => {
        if (result.isConfirmed) {
          $.post(url, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'delete'
          })
          .done((response)=> {
            Swal.fire(
            'Berhasil',
            'Data Anda Telah Di Hapus',
            'success'
          )
            table.ajax.reload();
          })
          .fail((errors) => {
            Swal.fire(
            'Oops',
            'Data Gagal Di Hapus',
            'error'
          )
              return;
            })
        }
      })
    }


    function deleteSelected(url){
        Swal.fire({
        title: 'Yakin ?',
        text: "Menghapus Data Ini !!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
        }).then((result) => {
            if ($('input:checked').length > 1) {
                if (result.isConfirmed){
                    $.post(url, $('.form-produk').serialize())
                    .done((response)=> {
                    Swal.fire(
                    'Berhasil',
                    'Data Anda Telah Di Hapus',
                    'success'
                )
                    table.ajax.reload();
                })
                .fail((errors) => {
                    Swal.fire(
                    'Oops',
                    'Data Gagal Di Hapus',
                    'error'
                )
                    return;
                    })
                }
            } else {
                Swal.fire(
                'Oops',
                'Pilih Data Yang Di Hapus!!',
                'error'
            )
                return;
            }
        })
    }

    // function deleteSelected(url){
    //     if ($('input:checked').length > 1) {
    //      if (confirm('Yakin menghapus data yang di pilih ?')){
    //         $.post(url, $('.form-produk').serialize())
    //         .done((response) => {
    //             table.ajax.reload();
    //         })
    //         .fail((errors) => {
    //             alert('Gagal menghapus data');
    //             return;
    //         });
    //      }
    //     } else {
    //         alert('Pilih data yang akan di hapus');
    //         return;
    //     }
    // }
        
    function cetakBarcode(url){
        if ($('input:checked').length < 1){
            alert('Pilih produk yang akan dicetak');
            return;
        }else if ($('input:checked').length < 3){
            alert('Produk yang di cetak minimal 3');
            return;
        }else {
            $('.form-produk')
            .attr('action', url)
            .attr('target', '_blank')
                .submit();
        }
    }
    
</script>

<script type="text/javascript" language="javascript">
    //  upper halaman produk
    function kapital(){
      var merk = document.getElementById("merk");
      merk.value = merk.value.toUpperCase();
      var np = document.getElementById("nama_produk");
      np.value = np.value.toUpperCase();
    }
</script>
@endpush