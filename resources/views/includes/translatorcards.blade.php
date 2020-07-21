
<?php

    $user = auth()->user();

    $translatorfiles  = \App\TranslatorFiles::where('translator_id',$user->id)->count();
    $clientfiles = \App\ClientFiles::where('translator_id',$user->id)->count();

?>


            <div class="row my-5">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="statistics-box d-flex justify-content-between align-items-center">
                    <div class="statistics">
                        <span class="statistics-name text-uppercase d-block"><a href="{{route('translator.clientfiles')}}" >Files Being Translated</a></span>
                        <span class="statistics-number">{{$clientfiles}}</span>
                    </div>
                    <span class="icon statistics-icon"><i class="far fa-chart-bar"></i></span>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="statistics-box d-flex justify-content-between align-items-center">
                    <div class="statistics">
                        <span class="statistics-name text-uppercase d-block"><a href="{{route('translator.translatorfiles')}}" >Localized files</a></span>
                        <span class="statistics-number">{{$translatorfiles}}</span>
                    </div>
                    <span class="icon statistics-icon"><i class="far fa-chart-bar"></i></span>
                  </div>
                </div>
            </div>
