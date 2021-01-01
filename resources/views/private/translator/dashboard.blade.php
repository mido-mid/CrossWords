@extends('layouts.translator')

@section('content')

@include('includes.translatorcards')

              <div class="row my-5">
                <div class="col-12">
                  <div class="actions w-100">
                    <div class="row">
                      <div class="col-12">
                        <div class="title-button-container d-flex justify-content-between align-items-center py-5 w-100">
                          <h4 class="heading-four">Client Files</h4>
                          @if(session('status'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                              {{ session('status') }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                        @endif
                        </div>
                      </div>
                    </div>
                      @if(count($files) > 0)
                        <div class="row">
                          <div class="col-12">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th scope="col">filename</th>
                                  <th scope="col">Target Language</th>
                                  <th scope="col">No. of words</th>
                                  <th scope="col">controls</th>
                                </tr>
                              </thead>
                              <tbody>
                              @foreach ($files as $file)
                              <tr>
                                  <td class="table-title">{{ $file->filename }}</td>
                                  <td class="table-title"><a href="">{{ $file->languagetarget->name }}</a></td>
                                  <td class="table-title">{{ $file->words }}</td>
                                  <td class="table-title">
                                    <div class="assign-form">

                                        <form action="{{route('translator.assign',$file)}}" method="POST">

                                            @csrf
                                            @method('put')

                                            <input type="submit" value="take task" class="submit-button">
                                        </form>
                                    </div>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      @else
                          <p class="lead text-center"> No files found</p>
                      @endif
                    <div class="row">
                      <div class="col-12">
                        <div class="d-flex justify-content-end w-100">
                          <nav aria-label="Page navigation example">
                          {{ $files->links() }}
                          </nav>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

@endsection

