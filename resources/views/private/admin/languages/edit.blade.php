@extends('layouts.admin')

@section('content')

@include('includes.cards')


              <div class="row my-5">
                <div class="col-12">
                  <div class="actions">
                    <div class="row">
                      <div class="col-12">
                        <div class="title-button-container d-flex justify-content-between align-items-center py-5">
                          <h4 class="heading-four">Edit Language</h4>
                          <a href="{{route('languages.index')}}" class="button button-1">back to list</a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <form method="post" action="{{ route('languages.update',$language) }}" enctype="multipart/form-data" autocomplete="off" >

                          @csrf
                          @method('PUT')
                          <div class="form-group">
                            <label for="titleInput" class="text-capitalize">language name</label>
                            <input type="text" class="@error('name') is-invalid @enderror form-control form-control-lg" placeholder="Type language name" name="name" value="{{ $language->name }}" autocomplete="name" required>

                            @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                          </div>
                          <div class="form-group">
                            <label for="descriptionInput" class="text-capitalize">Price/Word</label>
                            <input type="number" class="@error('price') is-invalid @enderror form-control form-control-lg" placeholder="price" name="price" autocomplete="name" value="{{ $language->price }}" required>

                                    @if ($errors->has('price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @endif
                            </div>
                            <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                    <label class="text-capitalize form-control-label" for="input-image">{{ __('Image') }}</label>
                                    <input type="file" name="image" id="input-image" class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}">

                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                            </div>

                          <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="submit-button rounded">Save</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


@endsection
