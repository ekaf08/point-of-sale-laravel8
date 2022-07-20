@extends('layouts.master')

@section('title')
    Kategori
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Kategori</li>
@endsection

@section('content')
      <!-- Main row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <div class="box-header with-border">
              <button onclick="addForm('{{ route('kategori.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"> </i> Tambah Data</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered">
                <thead class="header_table">
                  <th class="text-center" width="5%">No</th>
                  <th class="text-center">KATEGORI</th>
                  <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
                </thead>
                <tbody style="font-weight: normal;">

                </tbody>
              </table>
            </div>            
          </div>
        </div>
      </div>
      @include('kategori.form')    
@endsection

@push('scripts')
    <script>
      let table;

      $(function (){
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax:{
            url: '{{ route('kategori.data') }}',
          },
          columns:[
            {data: 'DT_RowIndex', searchable:false, sortable:false},
            {data: 'nama'},
            {data: 'aksi', searchable:false, sortable:false}
          ]
        });

        $('#modal-form').validator().on('submit', function (e) {
          if (! e.preventDefault()){
              $.post($('#modal-form form').attr('action'),  $('#modal-form form').serialize())
              .done((response) => {
                Swal.fire({
                    // position : 'top-end',
                    icon: 'success',
                    title: 'Kategori Berhasil Disimpan',
                    // text: 'Something went wrong!',
                    // footer: '<a href="">Why do I have this issue?</a>'
                  })
                $('#modal-form').modal('hide');
                table.ajax.reload();
              })
              .fail((errors) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Kategori Sudah Ada !!',
                  })
                return;
              });
          }
        });
      });

      function addForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_kategori]').focus();
      }

      function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_kategori]').focus();

        $.get(url)
          .done((response) => {
            $('#modal-form [name=nama_kategori]').val(response.nama);
          })
          .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
          })
      }

    //  function deleteData(url){
    //   Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You won't be able to revert this!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, delete it!'
    //       }).then((result) => {
    //         if (result.isConfirmed) {
    //           Swal.fire(
    //             $.post(url, {
    //             '_token': $('[name=csrf-token]').attr('content'),
    //             '_method': 'delete',
    //             'Deleted!',
    //             'Your file has been deleted.',
    //             'success',
    //             })
    //             .done((response)=> {
    //               table.ajax.reload();
    //             })
    //             .fail((errors) => {
    //               Swal.fire({
    //                 icon: 'error',
    //                 title: 'Oops...',
    //                 text: 'Gagal Menghapus Data !!'
    //                 return;
    //               })
    //         })
    //           )
    //         }
    //       })
    //  }

      // function deleteData(url) {
      //   if (result.isConfirmed){
      //     Swal.fire(
      //         'Deleted!',
      //         'Your file has been deleted.',
      //         'success'
      //       )
      //       $.post(url, {
      //       '_token': $('[name=csrf-token]').attr('content'),
      //       '_method': 'delete'
      //     })
      //     .done((response)=> {
      //       table.ajax.reload();
      //     })
      //     .fail((errors) => {
      //         alert('Tidak dapat menghapus data');
      //         return;
      //       })
      //   }
      // }

      function deleteData(url) {
        if (confirm('Yakin menghapus data ?')){
            $.post(url, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'delete'
          })
          .done((response)=> {
            table.ajax.reload();
          })
          .fail((errors) => {
              alert('Tidak dapat menghapus data');
              return;
            })
        }
      }
    
    </script>

    <script type="text/javascript" language="javascript">
        // upper halaman kategori
    function kapital1(){
      var nk = document.getElementById("nama_kategori");
      nk.value = nk.value.toUpperCase();
    }
    </script>
@endpush