@extends('layouts.master')

@section('title')
    Daftar Penjualan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Penjualan</li>
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
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered table-penjualan">
                    <thead class="header_table">
                        <th class="text-center" width="5%">NO</th>
                        <th class="text-center" width="15%">TANGAL</th>
                        <th class="text-center" width="10%">KODE MEMBER</th>
                        <th class="text-center" width="8%">TOTAL ITEM</th>
                        <th class="text-center" width="15%">TOTAL HARGA</th>
                        <th class="text-center" width="5%">DISKON</th>
                        <th class="text-center" width="15%">TOTAL BAYAR</th>
                        <th class="text-center" width="15%">KASIR</th>
                        <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody style="font-weight: normal;">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@includeIf('penjualan.detail')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        $('body').addClass('sidebar-collapse');
    //untuk menampilkan penjualan di view penjualan 
        table = $('.table-penjualan').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('penjualan.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'created_at'},
                {data: 'kode_member'},
                {data: 'total_item'},
                {data: 'total_harga'},  
                {data: 'diskon'},  
                {data: 'bayar'},  
                {data: 'kasir'},  
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

         // untuk menampilkan view di detail pembelian by id
        table1 = $('.table-detail-penjualan').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
                columns:[
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'jumlah'},  
                {data: 'subtotal'},  
                ]
            });
    // end
    });

    // end

// menampilkan detail produk penjualan
    function showDetail(url){
        $('#modal-detail').modal('show');
        
        table1.ajax.url(url);
        table1.ajax.reload();
    }
// end


    function editForm() {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Penjualan');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_supplier]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_supplier]').val(response.nama);
                $('#modal-form [name=telepon]').val(response.telepon);
                $('#modal-form [name=alamat]').val(response.alamat);
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

    // function deleteData(url) {
    //     if (confirm('Yakin ingin menghapus data terpilih?')) {
    //         $.post(url, {
    //                 '_token': $('[name=csrf-token]').attr('content'),
    //                 '_method': 'delete'
    //             })
    //             .done((response) => {
    //                 table.ajax.reload();
    //             })
    //             .fail((errors) => {
    //                 alert('Tidak dapat menghapus data');
    //                 return;
    //             });
    //     }
    // }
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