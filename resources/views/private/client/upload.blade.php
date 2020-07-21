@extends('layouts.client')

@section('content')
    <div class="gradient-header d-flex justify-content-center align-items-center">
      <div class="text-box">
        <h1 class="heading-one">Upload</h1>
        <p>Here,you can upload all your desired files to be translated</p>
      </div>
    </div>
  </header>


  <main>
    <section class="section-upload-file">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 d-flex align-items-center">
            <div class="form-container">
              <h2 class="heading-two">upload your file</h2>

              @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
              <form method="post" action="{{ route('paymentpost') }}" enctype="multipart/form-data" autocomplete="off" >

                @csrf

                  <input type="hidden" name="words" value="25">

                <div class="form-group u-margin-bottom-huge">
                  <label for="formControlFile1">File</label>
                    <textarea name="text" placeholder=" " class="input" required></textarea>
                  <small class="form-text text-muted mt-2">
                    ( You are allowed to upload only files with .doc, .docx, .text, .pdf )
                  </small>

                  @if ($errors->has('text'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('text') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-row u-margin-top-big">
                  <div class="form-group{{ $errors->has('source_language') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label" for="fromLanguage">{{ __('From') }}</label>


                                    <select name="source_language" class="custom-select custom-select-lg custom-select-from" id="fromLanguage" required>
                                      @foreach(\App\Language::all() as $language)
                                          <option label="{{ $language->name }}" value="{{ $language->name }}">{{ $language->name }}</option>
                                      @endforeach
                                    </select>

                                    @if ($errors->has('source_language'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('source_language') }}</strong>
                                        </span>
                                    @endif
                    </div>


                    <div class="form-group{{ $errors->has('language_id') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label" for="toLanguage">{{ __('To') }}</label>


                                    <select name="language_id" class="custom-select custom-select-lg custom-select-to" id="toLanguage" required>
                                        @foreach(\App\Language::all() as $language)
                                            <option label="{{ $language->name }}" value="{{ $language->id }}">{{ $language->name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('language_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('language_id') }}</strong>
                                        </span>
                                    @endif
                    </div>
                </div>
                <div class="d-flex justify-content-center u-margin-top-huge">
                  <button class="submit-button rounded" type="submit"><span class="paypal-icon mr-3"><i class="fab fa-paypal"></i></span>PayPal</button>
                </div>
                <small class="form-text text-muted mt-3 text-center">
                  pay to us with <a href="https://www.paypal.com/eg/home" class="paypal-link" target="_blank">PayPal</a>
                </small>
              </form>
            </div>
          </div>
          <div class="col-lg-6">
            <img src="./images/about-us-img.svg" class="img-fluid" alt="">
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection
