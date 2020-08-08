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
<body class="form-body">
  <header class="header">
    <!-- navbar start -->
    <nav class="navbar navbar-expand-lg fixed-top form-nav">
      <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <i class="fas fa-bars toggler-icon"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="{{route('welcome')}}">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('login')}}">Login</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('register')}}">Register</a>
                </li>
              </ul>
            </div>
      </div>
    </nav>
  </header>

  <main>
    <section class="section-form">
      <h3 class="heading-three text-center text-capitalize">welcome to cross words</h3>



      @yield('content')

    </section>

  </main>

@include('includes.adminfooter')

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="{{ asset('js') }}/jquery-3.5.1.min.js"></script>
<script src="{{ asset('js') }}/bootstrap.min.js"></script>
<!-- owl carousel -->
<script src="{{ asset('js') }}/owl.carousel.min.js"></script>

</body>
</html>
