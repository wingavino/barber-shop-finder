<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript" async>
      var app_url = "{{env('APP_URL')}}";
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Google Maps -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <style media="screen">
      /* Always set the map height explicitly to define the size of the div
             * element that contains the map. */
      #map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

    </style>
</head>
<body class="d-flex flex-column">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('index') }}">
                  <img class="img-fluid" src="{{ asset('img/logo.png') }}" alt="" width="100">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                      @include('layouts.admin-nav')
                      @include('layouts.shopowner-nav')
                      @include('layouts.employee-nav')
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                              <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->avatar }}">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ Route('profile') }}">
                                        {{ __('Profile') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div id="liveAlertPlaceholder">
          @if(session()->has('message'))
              <div class="alert alert-success alert-dismissible" role="alert">
                  {{ session()->get('message') }}
                  <button type="button" class="close" id="alertDismiss" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          @endif

          

          @if(Auth::user())
            @if(Auth::user()->pending_request->where('request_type', 'change-user-type')->where('approved', false)->where('rejected', false)->first())
              <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Your request to change account type to Shop Owner is currently pending approval. Please click <a href="{{ route('shopowner.img.id') }}">HERE</a> to upload documents to verify your profile. You may continue to create/manage your shop while it is being processed.</strong>
                <!-- <button type="button" class="close" id="alertDismiss" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button> -->
              </div>
            @elseif(Auth::user()->pending_request->where('request_type', 'change-user-type')->where('rejected', true)->first())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Your request to change account type to Shop Owner was rejected. Please click <a href="{{ route('shopowner.img.id') }}">HERE</a> to upload documents to verify your profile. You may contact the administrators at <a href="mailto:saber.shop.finder@gmail.com">saber.shop.finder@gmail.com</a> for further concerns.</strong>
                <button type="button" class="close" id="alertDismiss" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif

            @if(Auth::user()->pending_request->where('request_type', 'add-new-shop')->where('approved', false)->where('rejected', false)->first())
              <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Your request to add a new Shop is currently pending approval. Please click <a href="{{ route('shopowner.img.shop.doc') }}">HERE</a> to upload documents to verify your shop's legitimacy. It will appear on the list and map once it has been checked and approved. You may continue to edit the shop during this process.</strong>
                <!-- <button type="button" class="close" id="alertDismiss" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button> -->
              </div>
            @elseif(Auth::user()->pending_request->where('request_type', 'add-new-shop')->where('rejected', true)->first())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Your request to add a new Shop was rejected. Please click <a href="{{ route('shopowner.img.shop.doc') }}">HERE</a> to upload documents to verify your shop's legitimacy. You may contact the administrators at <a href="mailto:saber.shop.finder@gmail.com">saber.shop.finder@gmail.com</a> for further concerns.</strong>
                <button type="button" class="close" id="alertDismiss" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif

            <!-- Email Alert -->
            @if(Auth::user()->email_verified_at == '')
              @if(Auth::user()->type == 'shopowner')
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                  <form class="" action="{{ route('verification.send') }}" method="post">
                    @csrf
                    <strong>Your account's email has not been verified. Please verify your email address before you continue to create a shop. If you have not received an email containing the verification link, please click <button class="btn btn-link mx-n2" type="submit">HERE</button> to resend the link.</strong>
                  </form>
                  <!-- <button type="button" class="close" id="alertDismiss" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button> -->
                </div>
              @else
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                  <form class="" action="{{ route('verification.send') }}" method="post">
                    @csrf
                    <strong>Your account's email has not been verified. If you have not received an email containing the verification link, please click <button class="btn btn-link mx-n2" type="submit">HERE</button> to resend the link.</strong>
                  </form>
                  <!-- <button type="button" class="close" id="alertDismiss" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button> -->
                </div>
              @endif
            @endif
            <!-- /Email Alert -->

            <!-- Mobile Alert -->
            @if(Auth::user()->mobile && Auth::user()->mobile_verified_at == '')
              <div class="alert alert-info alert-dismissible fade show" role="alert">
                <form class="" action="{{ route('verify.mobile.send') }}" method="get">
                  @csrf
                  <strong>Your account's phone number has not been verified. Please click <button class="btn btn-link mx-n2" type="submit">HERE</button> to verify your phone number.</strong>
                </form>
                <button type="button" class="close" id="alertDismiss" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
            <!-- /Mobile Alert -->
          @endif
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer class="navbar mt-auto bg-white justify-content-center shadow">
      <div class="row">
        <div class="col-12 text-center">
          <p>
            Contact Us at: <a href="mailto:saber.shop.finder@gmail.com">saber.shop.finder@gmail.com</a>
          </p>
          <!-- <a href="{{ route('privacy-policy') }}">Privacy Policy</a> -->
        </div>

      </div>
    </footer>
</body>
@yield('custom-scripts')
</html>
