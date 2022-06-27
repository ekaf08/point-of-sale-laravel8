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
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <button onclick="addForm('{{ route('kategori.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i>Tambah Data</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-stiped table-bordered">
                <thead>
                  <th width="10%">No</th>
                  <th>Kategori</th>
                  <th width="15%"><i class="fa fa-cog"></i></th>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
            <!-- ./box-body -->
            {{-- <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                    <h5 class="description-header">$35,210.43</h5>
                    <span class="description-text">TOTAL REVENUE</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                    <h5 class="description-header">$10,390.90</h5>
                    <span class="description-text">TOTAL COST</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                    <h5 class="description-header">$24,813.53</h5>
                    <span class="description-text">TOTAL PROFIT</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                    <h5 class="description-header">1200</h5>
                    <span class="description-text">GOAL COMPLETIONS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div> --}}
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- /.row (main row) -->
      @include('kategori.form')    
@endsection

@push('scripts')
    <script>
      let table;

      $(function (){
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          // ajax:{
          //   url: '{{ route('kategori.data') }}',
          // }
        });

        $('#modal-form').validator().on('submit', function (e) {
          if (! e.preventDefault()){
              $.ajax({
                url: $('#modal-form form').attr('action'),
                type: 'post',
                data: $('#modal-form form').serialize()
              })
              .done((response) => {
                $('#modal-form').modal('hide');
                table.ajax.reload();
              })
              .fail((erros) => {
                alert('Gagal disimpan');
                return;
              });
          }
        });
      });

      function addForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Kategori');

        $('#model-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_kategori]').focus();
      }
    </script>
@endpush