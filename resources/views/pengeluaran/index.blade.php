@extends('layouts.master')

@section('title')
    Daftar Pengeluaran
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Pengeluaran</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-success btn-xs btn-flat" onclick="addForm('{{ route('pengeluaran.store') }}')"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead class="header_table">
                        <th class="text-center" width="5%">NO</th>
                        <th class="text-center" width="15%">TANGGAL</th>
                        <th class="text-center" width="45%">JENIS PENGELUARAN</th>
                        <th class="text-center" width="20%">NOMINAL</th>
                        <th class="text-center" width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody style="font-weight: normal;">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('pengeluaran.form')    
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('pengeluaran.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'created_at'},
                {data: 'deskripsi'},
                {data: 'nominal'},
                {data: 'aksi', searchable:false, sortable:false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()){
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                .done((response) => {
                Swal.fire({
                    // position : 'top-end',
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Pengeluaran Telah Ditambahkan',
                    // footer: '<a href="">Why do I have this issue?</a>'
                  })
                $('#modal-form').modal('hide');
                table.ajax.reload();
              })
              .fail((errors) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Data Sudah Ada !!',
                  })
                return;
              });
            }
        });
    })

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Pengeluaran');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=deskripsi]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Pengeluaran');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=deskripsi]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=deskripsi]').val(response.deskripsi);
                $('#modal-form [name=nominal]').val(response.nominal);
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
</script>

<script type="text/javascript" language="javascript">
    function pengeluaran(){
      var x = document.getElementById("deskripsi");
       x.value = x.value.toUpperCase();
    }
</script>


@endpush