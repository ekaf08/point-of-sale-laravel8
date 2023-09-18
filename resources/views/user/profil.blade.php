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
                <form action="{{ route('user.update_profil') }}" class="form-profil" data-toggle="validator" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="alert alert-info alert-dismissible" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon fa fa-check"></i> Perubahan Berhasil Disimpan
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-lg-2 col-lg-offset-1 control-label text-uppercase">Nama</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" onkeyup="kapital()" name="name" id="name"
                                    required autofocus value="{{ $profil->name }}">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        {{-- @dd($profil) --}}
                        <div class="form-group row">
                            <label for="foto" class="col-lg-2 col-lg-offset-1 control-label">Foto Profil</label>
                            <div class="col-lg-3">
                                <input type="file" class="form-control" name="foto" id="foto"
                                    onchange="preview('.tampil-foto', this.files[0])">
                                <span class="help-block with-errors"></span>
                                <br>
                                <div class="tampil-foto">
                                    <img src="{{ url($profil->foto ?? '/') }}" width="200">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="passwordLama"class="col-lg-2 col-lg-offset-1 control-label">Password Lama</label>
                            <div class="col-md-4">
                                <input type="password" name="passwordLama" id="passwordLama" class="form-control"> <span
                                    class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password"class="col-lg-2 col-lg-offset-1 control-label">Password</label>
                            <div class="col-md-4">
                                <input type="password" name="password" id="password" class="form-control"><span
                                    class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation"class="col-lg-2 col-lg-offset-1 control-label">Konfirmasi
                                Password</label>
                            <div class="col-md-4">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" data-match="#password"><span class="help-block with-errors"></span>
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
        function kapital() {
            var nama = document.getElementById("name");
            nama.value = nama.value.toUpperCase();
            //   var almt = document.getElementById("alamat");
            //   almt.value = almt.value.toUpperCase();
        }
    </script>

    <script>
        $(function() {
            // showData();
            $('#passwordLama').on('keyup', function() {
                if ($(this).val() != "") {
                    $('#password').attr('required', true);
                    $('#password_confirmation').attr('required', true);
                } else {
                    $('#password').attr('required', false);
                    $('#password_confirmation').attr('required', false);
                }
            })

            $('.form-profil').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                            url: $('.form-profil').attr('action'),
                            type: $('.form-profil').attr('method'),
                            data: new FormData($('.form-profil')[0]),
                            async: false,
                            processData: false,
                            contentType: false
                        })
                        .done(response => {
                            $('[name=name]').val(response.name);

                            // untuk preview gambar
                            $('.tampil-foto').html(
                                `<img src="{{ url('/') }}${response.foto}" width="200">`);
                            $('.img-profil').attr('src', `{{ url('/') }}/${response.foto}`);

                            $('.alert').fadeIn();
                            $('[name=name]').focus();
                            setTimeout(() => {
                                $('.alert').fadeOut();
                            }, 2000);
                            // $('#modal-form [name=nama_kategori]').focus();
                        })
                        .fail(errors => {
                            if (errors.status == 422) {
                                // alert(errors.responseJSON);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Passowrd lama tidak sesuai',
                                    // footer: '<a href="">Why do I have this issue?</a>'
                                })
                            } else {
                                // alert('tidak dapat menyimpan data');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tidak dapat menyimpan data',
                                    // footer: '<a href="">Why do I have this issue?</a>'
                                })
                            }
                            return;
                        });
                }
            });
        });
    </script>
@endpush
