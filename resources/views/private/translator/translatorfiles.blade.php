@extends('layouts.translator')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="actions">
                <div class="row">
                    <div class="col-12">
                        <div class="title-button-container d-flex justify-content-between align-items-center py-5">
                            <h4 class="heading-four">language</h4>
                            <a href="{{route('translator.dashboard')}}" class="button button-1">back to dashboard</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="language-info-panel">
                            <div class="row">
                                <div class="col-lg-4">
                                    @if($language->photo)
                                        <img src="{{ asset('images') }}/{{$language->photo->filename}}" alt="" class="img-fluid">
                                    @else
                                        <img src="{{ asset('images') }}/flags/united-kingdom-flag-medium.png" class="img-fluid" alt="">
                                    @endif
                                </div>
                                <div class="col-lg-8">
                                    <div class="language-info">
                                        <h1 class="heading-one text-capitalize">{{auth()->user()->language->name}}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="heading-four">Translated Files</h4>
                @if(count($translatorfiles) > 0)
                    <div class="row mt-5">
                        <div class="col-12">
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">filename</th>
                                    <th scope="col">File Language</th>
                                    <th scope="col">No. of words</th>
                                    <th scope="col">controls</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($translatorfiles as $file)
                                    <tr>
                                        <td class="table-title">{{ $file->filename }}</td>
                                        <td class="table-title">{{ $file->language->name }}</td>
                                        <td class="table-title">{{ $file->words }}</td>
                                        <td class="table-title">
                                            <button type="submit" class="submit-button" class="submit-button" onclick="window.location.href='{{route('translator.downloadtranslator',$file)}}'"><i class="fas fa-download"></i> download</button>
                                            <button type="submit" class="submit-button" onclick="window.location.href='{{route('translator.uploadedit',$file)}}'" id="translator_upload_btn"><i class="fas fa-cloud-upload-alt"></i> edit</button>

                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
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
                                {{ $translatorfiles->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
