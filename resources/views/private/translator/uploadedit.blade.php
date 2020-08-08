@extends('layouts.translator')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="actions">
                <h4 class="heading-four">Translated text upload Edit</h4>
                <div class="form-group col-4">
                    <label class="form-control-label" for="fromLanguage">{{ __('Translation language') }}</label>

                    <select name="language_id" class="custom-select custom-select-lg custom-select-from" id="toLanguage" required>
                        @foreach(\App\Language::all() as $language)
                            <option label="{{ $language->name }}" value="{{ $language->name }}">{{ $language->name }}</option>
                        @endforeach
                    </select>

                </div>

                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <p class="text-danger">{{$error}}</p>
                    @endforeach
                @endif

                <form method="post" action="{{ route('translator.uploadupdate',$translatorfile) }}" autocomplete="off">


                    @csrf

                    <div class="d-flex justify-content-center u-margin-top-huge">
                        <input type="hidden" value="" class="valueWordsHiddenInput">
                    </div>
                    <div class="d-flex justify-content-center u-margin-top-huge">
                        <input type="hidden" value="" class="valueCharsHiddenInput">
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" id="textToTranslate" name="text" rows="25"></textarea>
                        <div class="d-flex justify-content-end">
                            <div>
                                <small class="form-text text-muted mt-3">Words count: <span class="wordsCount">0</span></small>
                                <small class="form-text text-muted mt-3">Characters count: <span class="charsCount">0</span></small>
                            </div>
                        </div>
                    </div>
                    <div class="button-container mt-5 d-flex justify-content-center">
                        <button href="#" class="submit-button rounded">UPLOAD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





@endsection
