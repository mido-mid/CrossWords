@extends('layouts.admin')

@section('content')
              <div class="row">
                <div class="col-12">
                  <div class="actions">
                    <div class="row">
                      <div class="col-12">
                        <div class="title-button-container d-flex justify-content-between align-items-center py-5">
                          <h4 class="heading-four">language</h4>
                          <a href="{{route('admin.dashboard')}}" class="button button-1">back to list</a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="language-info-panel">
                          <div class="row">
                            <div class="col-lg-4">
                              @if($language->photo)
                                <img src="{{asset('images')}}/{{$language->photo->filename}}" class="img-fluid" alt="">
                              @else
                                <img src="{{asset('images')}}/flags/united-kingdom-flag-medium.png" class="img-fluid" alt="">
                              @endif
                            </div>
                            <div class="col-lg-8">
                              <div class="language-info">
                                <h1 class="heading-one text-capitalize">{{$language->name}}</h1>
                                <h4 style="margin-top:40px;" class="heading-four">No .of Words Translated: {{$languagewords}}</h4>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>                       
              <div class="row my-5">
                <div class="col-12">
                  <div style="margin-top:-40px" class="actions w-100">
                    <div class="row">
                      <div class="col-12">
                        <div class="title-button-container d-flex justify-content-between align-items-center py-5 w-100">
                          <h4 class="heading-four">Language Files</h4>
                        </div>    
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th scope="col">Translator</th>
                              <th scope="col">Source Language</th>
                              <th scope="col">Price</th>
                              <th scope="col">no. of words</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($clientfiles as $clientfile)
                            <tr>
                              @if($clientfile->translator)
                              <td class="table-title"><a href="{{route('admin.showtranslator',$clientfile->translator)}}">{{ $clientfile->translator->first_name }}</a></td>
                              @else
                              <td class="table-title">No translator assigned</td>
                              @endif
                              <td class="table-title">{{ $clientfile->source_language }}</td>
                              <td class="table-title">{{ $clientfile->total_price }} $</td>
                              <td class="table-title">{{ $clientfile->words }}</td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="d-flex justify-content-end w-100">
                          <nav aria-label="Page navigation example">
                          {{ $clientfiles->links() }}
                          </nav>
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
                        