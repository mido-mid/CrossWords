@extends('layouts.auth')

@section('content')
<div class="form-container">
        <div class="text-box py-5 text-center">
          <p class="text-uppercase">Translator Reset Password</p>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <form method="POST" action="{{ route('translator.password.email') }}" class="form login-form">

          @csrf
          <div class="form-group">
            <label for="emailInput" class="text-capitalize">{{ __('E-Mail Address') }}</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="far fa-envelope-open icon"></i></div>
              </div>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
          <div class="button-container">
            <button type="submit" class="submit-button">{{ __('Send Password Reset Link') }}</button>
          </div>
        </form>
      </div>
    </section>
  </main>
@endsection
