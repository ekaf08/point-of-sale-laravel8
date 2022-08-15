@extends('layouts.master')

@section('title')
    Pengaturan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pengaturan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <form action="{{ route('setting.update') }}" class="form-setting" data-toggle="validator" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
                <div class="alert alert-info alert-dismissible" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i> Perubahan Berhasil Disimpan
                </div>
                <div class="form-group row">
                    <label for="nama_toko" class="col-lg-2 col-lg-offset-1 control-label text-uppercase">Nama Toko</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" onkeyup="kapital()" name="nama_toko" id="nama_toko" required autofocus>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="telepon" class="col-lg-2 col-lg-offset-1 control-label">Telepon</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" name="telepon" id="telepon" required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-lg-2 col-lg-offset-1 control-label">Alamat Toko</label>
                    <div class="col-lg-6">
                        <textarea rows="4" class="form-control" onkeyup="kapital()" name="alamat" id="alamat" required></textarea>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="path_logo" class="col-lg-2 col-lg-offset-1 control-label">Logo Toko</label>
                    <div class="col-lg-2">
                        <input type="file" class="form-control" name="path_logo" id="path_logo" onchange="preview('.tampil-logo', this.files[0])">
                        <span class="help-block with-errors"></span>
                        <br>
                        <div class="tampil-logo">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="path_kartu_member" class="col-lg-2 col-lg-offset-1 control-label">Kartu Member</label>
                    <div class="col-lg-2">
                        <input type="file" class="form-control" name="path_kartu_member" id="path_kartu_member" onchange="preview('.tampil-kartu-member', this.files[0], 300)">
                        <span class="help-block with-errors"></span>
                        <br>
                        <div class="tampil-kartu-member">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="diskon" class="col-lg-2 col-lg-offset-1 control-label">Diskon (%)</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" name="diskon" id="diskon" required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tipe_nota" class="col-lg-2 col-lg-offset-1 control-label">Tipe Nota</label>
                    <div class="col-lg-3">
                        <select class="form-control text-uppercase" name="tipe_nota" id="tipe_nota" required>
                            <option value="1">Nota Kecil</option>
                            <option value="2">Nota Besar</option>
                        </select>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
            </div>
                <div class="box-footer text-right">
                    <div class="form-group row">
                        <div class="col-lg-8 col-lg-offset-1">
                            <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    
@endsection

@push('scripts')
<script type="text/javascript" language="javascript">

    function kapital(){
      var nama = document.getElementById("nama_toko");
      nama.value = nama.value.toUpperCase();
      var almt = document.getElementById("alamat");
      almt.value = almt.value.toUpperCase();
    }
</script>

<script>
    $(function(){
        showData();

        $('.form-setting').validator().on('submit', function (e){
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('.form-setting').attr('action'),
                    type: $('.form-setting').attr('method'),
                    data: new FormData($('.form-setting')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                .done(response => {
                    showData();
                    $('.alert').fadeIn();
                    $('[name=nama_toko]').focus();
                    setTimeout(() => {
                        $('.alert').fadeOut();
                    }, 2000);
                    // $('#modal-form [name=nama_kategori]').focus();
                })
                .fail(errors => {
                    alert('tidak dapat menyimpan data');
                    return;
                });
            }
        });
    });

    function showData() {
        $.get('{{ route('setting.show') }}')
        .done(response=> {
            // console.log(response);
            $('[name=nama_toko]').val(response.nama_perusahaan);
            $('[name=telepon]').val(response.telepon);
            $('[name=alamat]').val(response.alamat);
            $('[name=diskon]').val(response.diskon);
            $('[name=tipe_nota]').val(response.tipe_nota);
            // untuk preview gambar
            $('.tampil-logo').html(`<img src="{{ url('/') }}${response.path_logo}" width="200">`);
            $('.tampil-kartu-member').html(`<img src="{{ url('/') }}${response.path_kartu_member}" width="300">`)
            $('[rel=icon]').attr('href', `{{ url('/') }}/${response.path_logo}`);
        })
        .fail(errors => {
            alert('Tidak dapat menyimpan data')
            return
        })
    }
</script>

@endpush