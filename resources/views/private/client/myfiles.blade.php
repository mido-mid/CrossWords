@extends('layouts.client')

@section('content')

<div class="gradient-header d-flex justify-content-center align-items-center">
      <div class="text-box">
        <h1 class="heading-one">my files</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eos, ullam.</p>
      </div>
    </div>
  </header>

<main>
    <section class="section-my-files">
      <div class="container">
          @if(count($translatorfiles) > 0)
            <div class="row">
              <div class="col-12">
              <h3 class="heading-four mb-4">translated files</h3>
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">filename</th>
                      <th scope="col">Target Language</th>
                      <th scope="col">controls</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($translatorfiles as $file)
                    <tr>
                      <td class="table-title">{{ $file->filename }}</td>
                      <td class="table-title">{{ $file->language->name }}</td>
                      <td class="table-title">

                        <button type="submit" class="submit-button" onclick="window.location.href='{{route('client.download',$file)}}'"><i class="fas fa-download"></i> download</button>

                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          @else
              <p class="lead text-center"> No files translated yet</p>
          @endif
        <div class="row u-margin-top-huge">
          <div class="col-12">
            <div class="d-flex justify-content-end w-100">
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  {{ $translatorfiles->links() }}
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>


@endsection
