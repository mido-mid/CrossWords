@extends('layouts.client')

@section('content')
    <div class="gradient-header d-flex justify-content-center align-items-center">
      <div class="text-box">
        <h1 class="heading-one">profile</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eos, ullam.</p>
      </div>
    </div>
  </header>

  <main>
    <div class="client-profile-section">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-md-8 order-sm-2">
                <div class="account-edit-profile">
                  <div class="row">
                    <div class="col-12">
                      <h4 class="heading-four">edit profile</h4>
                    </div>
                  </div>
                        <div class="row">
                          <div class="col-12">
                            <h4 class="heading-four form-heading">user information</h4>
                            <form method="post" action="{{ route('profile.update') }}" autocomplete="off">
                                @csrf
                                @method('put')

                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                  <div class="pl-lg-4">
                                    <div class="form-row">
                                      <div class="col">
                                        <div class="form-group">
                                          <label for="firstNameInput" class="text-capitalize">first name</label>
                                          <div class="input-group mb-2">
                                            <input type="text" name="first_name" class="form-control form-control-lg firstName @error('first_name') is-invalid @enderror" id="firstNameInput" value="{{auth()->user()->first_name}}" placeholder="Type your username" autofocus>

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
                                            <input type="text" name="last_name" class="form-control form-control-lg lastName @error('last_name') is-invalid @enderror"  value="{{auth()->user()->last_name}}" placeholder="Type your username">

                                              @error('last_name')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                          <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                          <input type="email" name="email" id="input-email" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required>

                                          @if ($errors->has('email'))
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('email') }}</strong>
                                              </span>
                                          @endif
                                    </div>

                                    <div class="text-center">
                                      <button type="submit" class="submit-button">{{ __('Save') }}</button>
                                    </div>
                                  </div>
                            </form>
                              <hr class="my-4" />
                              <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                                  @csrf
                                  @method('put')

                                  <h4 class="heading-four form-heading">password</h4>

                                  @if (session('password_status'))
                                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                                          {{ session('password_status') }}
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                  @endif

                                  <div class="pl-lg-4">
                                      <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                          <label class="form-control-label" for="input-current-password">{{ __('Current Password') }}</label>
                                          <input type="password" name="old_password" id="input-current-password" class="form-control form-control-lg{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>

                                          @if ($errors->has('old_password'))
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('old_password') }}</strong>
                                              </span>
                                          @endif
                                      </div>
                                      <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                          <label class="form-control-label" for="input-password">{{ __('New Password') }}</label>
                                          <input type="password" name="password" id="input-password" class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" required>

                                          @if ($errors->has('password'))
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('password') }}</strong>
                                              </span>
                                          @endif
                                      </div>
                                      <div class="form-group">
                                          <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                                          <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-lg" placeholder="{{ __('Confirm New Password') }}" value="" required>
                                      </div>

                                      <div class="text-center">
                                        <button type="submit" class="submit-button">{{ __('Change password') }}</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 order-first order-md-2">
                      <div class="account-info-panel">
                        <div class="row">
                          <div class="col-4">
                            <div class="d-flex justify-content-center">

                                <div>
                                    <button type="submit" class="submit-button" id="upload_btn"><span class="mr-2"><i class="fas fa-cloud-upload-alt"></i></span> upload</button>
                                    <button id="cancel" onclick="window.location.href='{{route('profile')}}'" style="display: none" class="close-button mt-2">cancel</button>
                                </div>
                              <form id="profileform" style="display:none" action="{{ route('client.uploadimage') }}" method="POST" enctype="multipart/form-data">

                                  @csrf
                                  <input type="file" id="image_file" name="image">

                              </form>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="account-image-container">
                              @if(auth()->user()->photo)
                                <img src="{{ asset('images') }}/{{auth()->user()->photo->filename}}" alt="" class="img-fluid">
                              @else
                                <img src="{{ asset('images') }}/user/user.png" alt="" class="img-fluid">
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="account-details text-center">
                              <div class="account-name-age">
                              <h3 class="heading-four text-capitalize d-inline-block">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h3>
                              </div>
                              <span class="account-role text-capitalize">Client</span>
                              <a class="account-email" href="#"><i class="fas fa-home mr-3"></i>{{ auth()->user()->email }}</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection
