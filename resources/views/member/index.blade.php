@extends('layouts.master')

@section('title')
    Member
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Member</li>
@endsection

@section('content')
      <!-- Main row -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <button onclick="addForm('{{ route('member.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"> </i> Tambah Data</button>
              <button onclick="cetakMember('{{ route('member.cetak') }}')" class="btn btn-info btn-xs btn-flat "><i class="fa fa-print"> Cetak Member</i></button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <th>
                    <input type="checkbox" name="select_all" id="select_all">
                  </th>
                  <th width="15%">No</th>
                  <th>Kode Member</th>
                  <th>Nama</th>
                  <th>Telepon</th>
                  <th>Alamat</th>
                  <th width="10%"><i class="fa fa-cog"></i></th>
                </thead>
              </table>
            </div>            
          </div>
        </div>
      </div>
      @include('member.form')    
@endsection

@push('scripts')
    <script>
      let table;

      $(function (){
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax:{
            url: '{{ route('member.data') }}',
          },
          columns:[
            {data: 'DT_RowIndex', searchable:false, sortable:false},
            {data: 'kode_member'},
            {data: 'nama'},
            {data: 'telepon'},
            {data: 'alamat'},
            {data: 'aksi', searchable:false, sortable:false}
          ]
        });

        $('#modal-form').validator().on('submit', function (e) {
          if (! e.preventDefault()){
              $.post($('#modal-form form').attr('action'),  $('#modal-form form').serialize())
              .done((response) => {
                $('#modal-form').modal('hide');
                table.ajax.reload();
              })
              .fail((errors) => {
                alert('Gagal disimpan');
                return;
              });
          }
        });
      });

      function addForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Member');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama]').focus();
      }

      function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Member');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama]').focus();

        $.get(url)
          .done((response) => {
            $('#modal-form [name=nama]').val(response.nama);
            $('#modal-form [name=telepon]').val(response.telepon);
            $('#modal-form [name=alamat]').val(response.alamat);
          })
          .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
          })
      }

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
@endpush