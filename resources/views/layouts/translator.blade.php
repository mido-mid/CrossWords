<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CrossWords</title>

    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css') }}/bootstrap.min.css">

    <!-- owl carousel -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.min.css') }}">
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

</head>
<body class="dashboard-body">
  <header>
    <div class="icons-container">
      <span class="icon toggler-icon"><i class="fas fa-bars"></i></span>
      <span class="icon close-icon"><i class="fas fa-times"></i></span>
    </div>
    <nav class="side-navigation">
      <a class="text-center pb-5 sidnav-brand">Cross Word</a>
      <ul class="nav-list">
        <li class="nav-item">
          <a href="{{route('translator.dashboard')}}" class="nav-link">dashboard</a>
        </li>
        <li class="nav-item">
          <a href="{{route('translator.files')}}" class="nav-link">My Files</a>
        </li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="section-dashboard">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="dashboard">
              <div class="row mb-5">
                <div class="col-12">
                  <div class="title-account-container d-flex justify-content-between align-items-center w-100">
                    <h2 class="heading-three">dashboard</h2>
                    <div class="account-info">
                      <div class="img-container">
                      @if(auth()->user()->photo)
                        <img src="{{ asset('images') }}/{{auth()->user()->photo->filename}}" alt="" class="img-fluid">
                      @else
                        <img src="{{ asset('images') }}/user/man-300x300.png" alt="" class="img-fluid">
                      @endif
                      </div>
                      <div class="dropdown d-inline-block">
                        <button style="cursor:pointer;" class="account-name text-capitalize" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Mohamed Osama
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                          <a class="dropdown-item dropdown-link" href="{{ route('translatorprofile') }}"><i class="fas fa-user mr-2"></i>my profile</a>
                          <a class="dropdown-item dropdown-link" href="{{ route('translatorhome') }}"><i class="fas fa-home mr-2"></i>go to homepage</a>
                          <hr>
                          <form id="logout-form" action="{{ route('translatorlogout') }}" method="POST" style="display: none;">
                            @csrf
                          </form>
                          <a class="dropdown-item dropdown-link" onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();" href="{{ route('translatorlogout') }}"><i class="fas fa-sign-out-alt mr-2"></i>logout</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


    @yield('content')

    @include('includes.adminfooter')

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="{{ asset('js') }}/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('js') }}/bootstrap.min.js"></script>
    <!-- owl carousel -->
    <script src="{{ asset('js') }}/owl.carousel.min.js"></script>
    <script src="{{ asset('js') }}/jquery.js"></script>
    

</body>
</html>