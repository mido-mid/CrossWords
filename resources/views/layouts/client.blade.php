<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CrossWords</title>

    <link href="{{ asset('fontawesome') }}/fontawesome-free/css/all.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css') }}/bootstrap.min.css">

    <!-- owl carousel -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.min.css') }}">
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

</head>
<body>
<header class="header">
    <!-- navbar start -->
    <nav class="navbar navbar-expand-lg fixed-top">
      <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="icon navbar-toggler-icon"><i class="fas fa-bars"></i></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
              @guest
                <li class="nav-item active">
                  <a class="nav-link" href="{{route('home')}}">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('login')}}">Login</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('register')}}">Register</a>
                </li>
              @endguest
                @auth
                @if(auth()->user()->role == 1)
                <li class="nav-item">
                  <a class="nav-link" href="{{route('admin.dashboard')}}">My dashboard</a>
                </li>
                <li class="nav-item">
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                  <a href="{{ route('translatorlogout') }}" class="nav-link" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                </li>
                @endif
                  @if(auth()->user()->role == 0)
                  <li class="nav-item active">
                    <a class="nav-link" href="{{route('home')}}">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('myfiles')}}">My Files</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('profile')}}">My Profile</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('paymentget')}}">Start Translation</a>
                  </li>
                  <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                  </li>
                  @endif
                @endauth
              </ul>
            </div>
      </div>
    </nav>


    @yield('content')

    @include('includes.footer')


    <script src="{{ asset('js') }}/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('js') }}/bootstrap.min.js"></script>
    <!-- owl carousel -->
    <script src="{{ asset('js') }}/owl.carousel.min.js"></script>

    <script src="{{ asset('js') }}/jquery.js"></script>
</body>
</html>
