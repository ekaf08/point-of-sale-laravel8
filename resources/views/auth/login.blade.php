@extends('layouts.auth')

@section('login')
<div class="login-box">
    
    <div class="login-box-body" style="border-radius: 10%;">
        <div class="login-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/company-logo.png') }}" alt="company-logo" width="180">
            </a>
          </div>
          <!-- /.login-logo -->
  
      <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="form-group has-feedback @error('email') has-eror @enderror">
          <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          @error('email')
            <span class="help-block" style="color: red;">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group has-feedback @error('password') has-eror @enderror">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          @error('password')
            <span class="help-block" style="color: red;">{{ $message }}</span>
          @enderror
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
  
      {{-- <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
          Facebook</a>
        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
          Google+</a>
      </div> --}}
      <!-- /.social-auth-links -->
  
      <a href="#">I forgot my password</a><br>
      <a href="register.html" class="text-center">Register a new membership</a>
  
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->
    
@endsection