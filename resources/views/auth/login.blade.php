@extends('layouts.auth')

@section('content')
      <div class="form-container">
      <div class="text-box py-5 text-center">
          <p class="text-uppercase">if you're a translator you can sign in using</p>
          <a href="{{ route('translator.loginget') }}" class="button button-1">Translator Login</a>
        </div>
        <form method="POST" action="{{ route('login') }}" class="form login-form">

          @csrf
          <div class="form-group">
            <label for="emailInput" class="text-capitalize">email</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="far fa-user username-icon"></i></div>
              </div>
              <input type="email" class="@error('email') is-invalid @enderror form-control form-control-lg email" id="email" placeholder="Type your email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
            
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
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="form-link d-inline-block float-right">
                Forgot password?
              </a>
            @endif
          </div>
          <div class="button-container">
            <button type="submit" class="submit-button">login</button>
          </div>
        </form>
        <div class="or text-center">
          <p class="text-capitalize mb-0">or sign up using</p>
          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="text-uppercase form-link">sign up</a>
          @endif
        </div>
      </div>
    </section>
  </main>

@endsection