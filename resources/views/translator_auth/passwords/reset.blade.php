@extends('layouts.auth')

@section('content')
<div class="form-container">
      <div class="text-box py-5 text-center">
          <p class="text-uppercase">Trabslator Reset Password</p>
        </div>
        <form method="POST" action="{{ route('translator.password.update') }}" class="form login-form">

          @csrf
          <div class="form-group">
            <label for="emailInput" class="text-capitalize">email</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="far fa-envelope-open icon"></i></div>
              </div>
              <input type="email" class="@error('email') is-invalid @enderror form-control form-control-lg email" id="email" placeholder="Type your email" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus>

              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>


          <div class="form-group">
            <label for="passwordInput" class="text-capitalize">password</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-lock lock-icon"></i></div>
              </div>
              <input type="password" class="@error('password') is-invalid @enderror form-control form-control-lg password" id="password" placeholder="Type your password" name="password" autocomplete="current-password">

              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>

          <div class="form-group">
            <label for="passwordConfirmInput" class="text-capitalize">confirm password</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-lock icon"></i></div>
              </div>
              <input type="password" class="form-control form-control-lg passwordConfirm" name="password_confirmation" id="password-Confirm" placeholder="Type your password confirmation">
            </div>
          </div>

          <div class="button-container">
            <button type="submit" class="submit-button">login</button>
          </div>
        </form>
      </div>

@endsection

