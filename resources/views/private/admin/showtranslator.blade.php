@extends('layouts.admin')

@section('content')


              <div class="row">
                <div class="col-12">
                  <div class="actions">
                    <div class="row">
                      <div class="col-12">
                        <div class="title-button-container d-flex justify-content-between align-items-center py-5">
                          <h4 class="heading-four">translator</h4>
                          <a href="{{route('admin.dashboard')}}" class="button button-1">back to list</a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="translator-info-panel">
                          <div class="row">
                            <div class="col-lg-4">
                            @if($translator->photo)
                              <img src="{{asset('images')}}/{{$translator->photo->filename}}" class="img-fluid" alt="">
                            @else
                              <img src="{{asset('images')}}/user/translator.jpeg" class="img-fluid" alt="">
                            @endif
                            </div>
                            <div class="col-lg-8">
                              <div class="translator-info">
                                <h3 class="heading-three text-capitalize">{{$translator->first_name}} {{$translator->last_name}}</h3>
                                <a class="translator-email d-block" href="#">{{$translator->email}}</a>
                                <span style="margin-top:10px" class="translator-language text-capitalize d-block">{{$translator->language->name}}</span>
                                <span style="margin-top:10px" class="translator-language text-capitalize d-block">No. of files translated: {{count($translator->translatorfiles)}}</span>
                                <span style="margin-top:10px" class="translator-language text-capitalize d-block">No. of files being translated: {{count($translator->clientfiles)}}</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

 @endsection
