@extends('layouts.admin')

@section('content')

@include('includes.cards')

              <div class="row my-5">
                <div class="col-12">
                  <div class="actions w-100">
                    <div class="row">
                    <div class="col-12">

                          @if (session('status'))
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                                  {{ session('status') }}
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                          @endif
                    </div>
                      <div class="col-12">
                        <div class="title-button-container d-flex justify-content-between align-items-center py-5 w-100">
                          <h4 class="heading-four">Languages</h4>
                          <button onclick="window.location.href='{{route('languages.create')}}'" class="submit-button text-capitalize">add language</button>
                        </div>
                      </div>
                    </div>
                      @if(count($languages) > 0)
                        <div class="row">
                          <div class="col-12">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th scope="col">name</th>
                                  <th scope="col">price/word</th>
                                  <th scope="col">No. of files being translated</th>
                                  <th scope="col">No. of files translated</th>
                                  <th scope="col">No. of translators</th>
                                  <th scope="col"></th>
                                </tr>
                              </thead>
                              <tbody>
                              @foreach ($languages as $language)
                                <tr>
                                  <td class="table-title"><a href="{{route('languages.show',$language)}}">{{ $language->name }}</a></td>
                                  <td class="table-title">{{ $language->price }} $</td>
                                  <td class="table-title">{{ count($language->clientfilessource) }}</td>
                                  <td class="table-title" >{{ count($language->translatorfilessource) }}</td>
                                  <td class="table-title">{{ count($language->translators) }}</td>
                                  <td>
                                    <div class="dropdown">
                                      <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                        <i class="fas fa-ellipsis-v"></i>
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <form action="{{ route('languages.destroy', $language) }}" method="post">
                                              @csrf
                                              @method('delete')

                                          <a class="dropdown-item" href="{{ route('languages.edit', $language) }}">{{ __('Edit') }}</a>
                                          <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this language?") }}') ? this.parentElement.submit() : ''">{{ __('Delete') }}</button>
                                        </form>

                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      @else

                          <p class="lead text-center"> No languages found</p>

                      @endif
                    <div class="row">
                      <div class="col-12">
                        <div class="d-flex justify-content-end w-100">
                          <nav aria-label="Page navigation example">
                          {{ $languages->links() }}
                          </nav>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


@endsection

