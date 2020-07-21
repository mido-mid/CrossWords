
<?php

$user = auth()->user();

$translatorfiles  = \App\TranslatorFiles::all()->count();
$clientfiles = \App\ClientFiles::all()->count();
$translatorscount = \App\Translator::all()->count();
$users = \App\User::where('role',0)->count();

?>


              <div class="row my-5">
                <div class="col-lg-3 col-md-6 col-sm-12">
                  <div class="statistics-box d-flex justify-content-between align-items-center">
                    <div class="statistics">
                      <span class="statistics-name text-uppercase d-block">Files Being Translated</span>
                      <span class="statistics-number">{{$clientfiles}}</span>
                    </div>
                    <span class="icon statistics-icon"><i class="far fa-chart-bar"></i></span>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                  <div class="statistics-box d-flex justify-content-between align-items-center">
                    <div class="statistics">
                      <span class="statistics-name text-uppercase d-block">Localized files</span>
                      <span class="statistics-number">{{$translatorfiles}}</span>
                    </div>
                    <span class="icon statistics-icon"><i class="far fa-chart-bar"></i></span>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                  <div class="statistics-box d-flex justify-content-between align-items-center">
                    <div class="statistics">
                      <span class="statistics-name text-uppercase d-block">Translators</span>
                      <span class="statistics-number">{{$translatorscount}}</span>
                    </div>
                    <span class="icon statistics-icon"><i class="far fa-chart-bar"></i></span>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                  <div class="statistics-box d-flex justify-content-between align-items-center">
                    <div class="statistics">
                      <span class="statistics-name text-uppercase d-block">Users</span>
                      <span class="statistics-number">{{$users}}</span>
                    </div>
                    <span class="icon statistics-icon"><i class="far fa-chart-bar"></i></span>
                  </div>
                </div>
              </div>
