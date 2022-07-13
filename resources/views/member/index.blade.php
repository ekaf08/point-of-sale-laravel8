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
        <div class="col-lg-12">
          <div class="box">
            <div class="box-header with-border">
              <button onclick="addForm('{{ route('member.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"> </i> Tambah Data</button>
              <button onclick="cetakMember('{{ route('member.cetak_member') }}')" class="btn btn-info btn-xs btn-flat "><i class="fa fa-print"> </i> Cetak Member</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <form action="" method="post" class="form-member">
                @csrf
                <table class="table table-striped table-bordered">
                  <thead class="header_tabel" style="font-family: 'Poppins', sans-serif;">
                    <th class="ditengah" width="5%">
                      <input type="checkbox" name="select_all" id="select_all">
                    </th>
                    <th class="ditengah" width="5%">NO</th>
                    <th class="ditengah">KODE MEMBER</th>
                    <th class="ditengah">NAMA</th>
                    <th class="ditengah">TELEPON</th>
                    <th class="ditengah">ALAMAT</th>
                    <th class="ditengah" width="10%"><i class="fa fa-cog"></i></th>
                  </thead>
                  <tbody style="font-weight: normal;">

                  </tbody>
                </table>
            </form>
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
            {data: 'select_all', searchable:false, sortable:false},
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
      
          $('[name=select_all]').on('click', function(){  
            $(':checkbox').prop('checked', this.checked);
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

      function cetakMember(url){
        if ($('input:checked').length < 1) {
          alert ('Pilih Member yang akan di cetak');
          return;
        } else {
          $('.form-member')
          .attr('target', '_blank')
          .attr('action', url)
            .submit();
        }
      }

    
    </script>
    <script type="text/javascript" language="javascript">
      // upper halaman member
      function hurufkapital() {
          var x = document.getElementById("nama");
          x.value = x.value.toUpperCase();

          var almt = document.getElementById("alamat");
          almt.value = almt.value.toUpperCase();
     }
    </script>
@endpush