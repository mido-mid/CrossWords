@extends('layouts.admin')

@section('content')

@include('includes.cards')

              <div class="row my-5">
                <div class="col-12">
                  <div class="actions w-100">
                    <div class="row">
                      <div class="col-12">
                        <div class="title-button-container d-flex justify-content-between align-items-center py-5 w-100">
                          <h4 class="heading-four">Translators</h4>
                        </div>
                      </div>
                    </div>
                      @if(count($translators) > 0)
                        <div class="row">
                          <div class="col-12">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th scope="col">firstname</th>
                                  <th scope="col">lastname</th>
                                  <th scope="col">email</th>
                                  <th scope="col">controls</th>
                                </tr>
                              </thead>
                              <tbody>
                              @foreach ($translators as $translator)
                                <tr>
                                  <td class="table-title"><a href="{{route('admin.showtranslator',$translator)}}">{{ $translator->first_name }}</a></td>
                                  <td class="table-title">{{ $translator->last_name }}</td>
                                  <td class="table-title">{{ $translator->email }}</td>
                                  <td class="table-title">
                                  @if($translator->approved == 0)
                                    <div class="approve-form">

                                        <form action="{{route('admin.approve',$translator)}}" method="POST">

                                            @csrf

                                            <input type="hidden" value="1" name="approve" class="btn btn-default">

                                            <input type="submit" value="approve" class="btn btn-danger">
                                        </form>
                                    </div>
                                  @else

                                    <p class="text-success">approved</p>

                                  @endif

                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>

                      @else
                          <p class="lead text-center"> No translators found</p>
                      @endif
                    <div class="row">
                      <div class="col-12">
                        <div class="d-flex justify-content-end w-100">
                          <nav aria-label="Page navigation example">
                          {{ $translators->links() }}
                          </nav>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


@endsection
