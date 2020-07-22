@extends('layouts.auth')

@section('content')
      <div class="form-container">
        <div class="text-box py-5 text-center">
          <p class="text-uppercase">if you're a translator you can sign up using</p>
          <a href="{{ route('translator.registerget') }}" class="button button-1">Translator sign up</a>
        </div>
        <form method="POST" action="{{ route('register') }}" class="form signup-form">

          @csrf
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label for="firstNameInput" class="text-capitalize">first name</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><i class="far fa-user icon"></i></div>
                  </div>
                  <input type="text" name="first_name" class="form-control form-control-lg firstName @error('first_name') is-invalid @enderror" id="firstNameInput" placeholder="Type your username" autofocus>

                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="lastNameInput" class="text-capitalize">last name</label>
                <div class="input-group mb-2">
                  <input type="text" name="last_name" class="form-control form-control-lg lastName @error('last_name') is-invalid @enderror" id="lastNameInput" placeholder="Type your username">

                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror


                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="emailInput" class="text-capitalize">email</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="far fa-envelope-open icon"></i></div>
              </div>
              <input type="email" class="@error('email') is-invalid @enderror form-control form-control-lg email" id="email" placeholder="Type your email" name="email" value="{{ old('email') }}" autocomplete="email">

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
                <div class="input-group-text"><i class="fas fa-lock icon"></i></div>
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
            <button class="submit-button" type="submit">sign up</button>
          </div>
        </form>
        <!-- <div class="or text-center">
          <p class="text-capitalize mb-0">or sign up using</p>
          <a href="#" class="text-uppercase form-link">sign up</a>
        </div> -->
      </div>


@endsection
