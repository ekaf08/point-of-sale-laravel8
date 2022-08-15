<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  {{-- <title>{{ config('app.name') }} | @yield('title')</title> --}}
  <title>{{ $setting->nama_perusahaan }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" >
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="rel" href="{{ url($setting->path_logo) }}" type="image/png">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2/dist/css/skins/_all-skins.min.css') }}">
  <!-- Data Table -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('aset/csscustom.css') }}">
<!--sweet alert-->
<script src="{{ asset('sweet-alert/sweetalert2-11.js') }}"></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
 
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
@stack('css')
</head>
<body class="hold-transition skin-red-light sidebar-mini">
<div class="wrapper">
  {{-- @dd($setting) --}}
@includeIf('layouts.header');
@includeIf('layouts.sidebar');

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('title')
        {{-- <small>Control panel</small> --}}
      </h1>
      <ol class="breadcrumb">
        @section('breadcrumb')
               <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>          
               
        @show
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @includeIf('layouts.footer')


</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('AdminLTE-2/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('AdminLTE-2/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Moment -->
  <script src="{{ asset('AdminLTE-2/bower_components/moment/min/moment.min.js') }}"></script>
<!-- Data Table -->
<script src="{{ asset('AdminLTE-2/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE-2/dist/js/adminlte.min.js') }}"></script>
<!-- Validator -->
<script src="{{ asset('js/validator.min.js') }}"></script>

<script>
  function preview(selector, temporaryFile, width = 200)  {
      $(selector).empty();
      $(selector).append(`<img src="${window.URL.createObjectURL(temporaryFile)}" width="${width}">`);
  }
</script>

 @stack('scripts')
 
 @if (session('success'))
  <script>
    Swal.fire(
      'Selamat',
      "{{ session('success') }}",
      'success'
    )
  </script>
 @endif

 @if (session('error'))
 <script>
   Swal.fire(
     'Oops!',
     "{{ session('error') }}",
     'error'
   )
 </script>
@endif
</body>
</html>
