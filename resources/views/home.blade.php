<?php


$languages  = \App\Language::all();


?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CrossWords</title>

    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

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
            <a class="navbar-brand" href="{{route('home')}}"><img style="width:50px;height:50px" src="{{ asset('images') }}/crosswords.png" class="flag-img" alt=""> CrossWords</a>

            <div class="collapse navbar-collapse">
              <ul class="navbar-nav ml-auto">
              @guest
                <li class="nav-item active">
                  <a class="nav-link" href="{{route('home')}}">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('login')}}">Login</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">articles</a>
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
                    <a href="{{ route('translatorlogout') }}" class="nav-link" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                  </li>
                  @endif
                @endauth
              </ul>
            </div>
      </div>
    </nav>

<div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item carousel-item-1 active" data-interval="3000"></div>
        <div class="carousel-item carousel-item-2" data-interval="3000"></div>
        <div class="carousel-item carousel-item-3" data-interval="3000"></div>
        <div class="carousel-item carousel-item-4" data-interval="3000"></div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <!-- slider end -->
  </header>
  <main>
    <section class="section-services-languages">
      <div class="container">
        <div class="row u-margin-bottom-huge">
          <div class="col-12">
            <div class="text-box text-center">
              <h5 class="heading-four pb-2">our services <span class="colord-span-1">&&</span></h5>
              <h2 class="heading-two">languages</h2>
            </div>
          </div>
        </div>
        <div class="row align-items-center u-margin-top-medium">
          <div class="col-lg-12">
              <div class="languages owl-carousel">
              @foreach($languages as $language)
                <div class="language-card text-center p-5">
                  <h3 class="heading-three pb-5">{{ \Str::limit($language->name, 12) }}</h3>
                  <div class="img-flag-container pb-5">
                  @if($language->photo)
                    <img src="{{ asset('images') }}/{{$language->photo->filename}}" class="flag-img" alt="">
                  @else
                    <img src="{{ asset('images') }}/flags/france-flag-button-round-xs.png" class="flag-img" alt="">
                  @endif
                  </div>
                </div>
              @endforeach
              </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section-about-us">
      <div class="container">
        <div class="row u-margin-bottom-huge">
          <div class="col-lg-6 d-flex align-items-center">
            <div class="text-box pr-5">
              <h2 class="heading-two mb-5">about us</h2>
              <p class="paragraph mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius quos illo officia consequuntur atque esse magni quam minus nobis doloremque, ex maiores accusantium, odit labore ipsa quibusdam natus debitis necessitatibus architecto aspernatur repudiandae nostrum. Temporibus illum eos eius, assumenda cumque explicabo laboriosam accusantium, corporis sed fugit soluta natus vero nobis?</p>
            </div>
          </div>
          <div class="col-lg-6">
            <img src="{{ asset('images') }}/about-us-img.svg" class="img-fluid" alt="">
          </div>
        </div>
      </div>
    </section>

    <section class="section-prices">
      <div class="container">
        <div class="row u-margin-bottom-huge">
          <div class="col-12">
            <div class="text-box text-center">
              <h5 class="heading-four pb-2">our prices <span class="colord-span-1">&&</span></h5>
              <h2 class="heading-two">plans</h2>
            </div>
          </div>
        </div>
        <div class="row align-items-center u-margin-top-medium">
          <div class="col-lg-12">
              <div class="plans owl-carousel">
              @foreach($languages as $language)
                <div class="card">
                  <div class="card-body p-5">
                    <p class="price text-center">{{$language->price}} <span class="dollarSign">&#36;</span> </p>
                    <h3 class="heading-three text-center mb-5">{{$language->name}}</h3>
                    <ul class="list-unstyled pb-5">
                      <li class="card-item"><i class="fas fa-check check-icon pr-2"></i> Lorem ipsum dolor sit amet consect.</li>
                      <li class="card-item"><i class="fas fa-check check-icon pr-2"></i> Lorem ipsum dolor sit amet consect.</li>
                      <li class="card-item"><i class="fas fa-check check-icon pr-2"></i> Lorem ipsum dolor sit amet consect.</li>
                      <li class="card-item"><i class="fas fa-check check-icon pr-2"></i> Lorem ipsum dolor sit amet consect.</li>
                    </ul>
                  </div>
                </div>
              @endforeach
              </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-md-12">
          <div class="text-box">
            <h2 class="heading-three mb-5">translate with us</h2>
            <p class="paragraph">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Animi numquam nam, repellendus beatae repellat vero ipsa nisi tenetur cupiditate ex eveniet corporis eaque vel.</p>
          </div>
        </div>
        <div class="col-lg-2 col-md-12">
          <h4 class="heading-three mb-5">links</h4>
          <ul class="list-unstyled links-list">
            <li class="links-item">
              <a href="#" class="links-link">Home</a>
            </li>
            <li class="links-item">
              <a href="#" class="links-link">about</a>
            </li>
            <li class="links-item">
              <a href="#" class="links-link">Articles</a>
            </li>
            <li class="links-item">
              <a href="#" class="links-link">Contact</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-5 col-md-12">
          <img src="{{asset('images')}}/sliderImages/france.jpeg" class="img-fluid">
        </div>
      </div>
    </div>
  </footer>


  <div class="copyrights">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <p>Copyright<i class="far fa-copyright"></i>2020</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('js') }}/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('js') }}/bootstrap.min.js"></script>
    <!-- owl carousel -->
    <script src="./js/owl.carousel.min.js"></script>
    <script src="./js/jquery.js"></script>
</body>
</html>
