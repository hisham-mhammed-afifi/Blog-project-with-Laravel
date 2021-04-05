<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!------------font awesome---------->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" crossorigin="anonymous" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-lg sticky-top">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Welcome') }}
            </a>
            <button class="btn btn-sm btn-dark navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @auth
                    <!-- Left Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.index') }}">Blog</a>
                    </li>
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                        </li>
                    @endif
                        <li class="nav-item dropdown">
                            <div class="dropdown">
                                <button class="btn btn-link nav-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Categories
                                </button>
                                <div class="dropdown-menu shadow-lg bg-dark"
                                    aria-labelledby="dropdownMenuButton">
                                    @if (auth()->user()->isAdmin())
                                    <a class="text-light text-center mx-3" href="{{ route('categories.index') }}">
                                        Create new Category
                                        <i class="fas fa-angle-double-right pl-3"></i>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    @endif
                                    <div class="container">
                                        <div class="row">
                                            @foreach ($categories as $category)
                                            <div class="col-6 mt-3">
                                                <a class="text-white" href="{{ route('categories.show', $category->id) }}">
                                                    {{ $category->name }}
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    @endauth
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item mr-5">
                            <form action="" method="GET" class="input-group input-group-sm m-2">
                                <input name="search" type="text" value="{{ request()->query('search') }}"
                                    class="form-control" placeholder="Search ...">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-light" type="submit">
                                        <i class="fas fa-search px-2"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                        @guest
                        <li class="nav-item mx-md-3">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt pr-3"></i>
                                {{ __('Login') }}
                            </a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item mx-md-3">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user pr-3"></i>
                                {{ __('Register') }}
                            </a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                                <img height="30px" width="30px" class="rounded-circle mx-3" src="{{ asset('/storage/' . Auth::user()->image) }}" alt="">
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('users.edit-profile') }}">
                                    <i class="fas fa-user pr-3"></i>
                                    My Profile
                                </a>
                                
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt pr-3"></i>
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
        </nav>

        <main class="pb-5 cnt">
            @if (session()->has('success'))
            <!-- Modal -->
        <div class="modal fade" id="mymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-success text-center py-3">
                {{ session()->get('success') }}
            </div>
        </div>
        </div>
            @endif
            @if (session()->has('error'))
             <!-- Modal -->
        <div class="modal fade" id="mymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-danger text-center py-3">
                {{ session()->get('error') }}
            </div>
        </div>
        </div>
            @endif
            @yield('content')
        </main>
        <!--///// --- fooooooooter --- //// -->
        <div class="card card-defult shadow-lg mt-5 bg-dark">
            <br>
            <br>
            <div class="row justify-content-center mx-1 pt-5">
                <div class="col-md-4 justify-space-between">
                    <div class="d-flex justify-content-between px-5">
                        <h1 class="text-secondary"><i class="fab fa-facebook"></i></h1>
                        <h1 class="text-secondary"><i class="fab fa-twitter"></i></h1>
                        <h1 class="text-secondary"><i class="fab fa-instagram-square"></i></h1>
                        <h1 class="text-secondary"><i class="fab fa-pinterest"></i></h1>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <p class="text-center text-muted py-5">All rights reserved &copy; Copyright 2021 Hisham-MyBlog</p>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    <script>
      $('#mymodal').modal('show')
    </script>
</body>
</html>
