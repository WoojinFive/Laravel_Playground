<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PhotoFeed') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/88c884fbda.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">


    <!-- Styles -->
{{--    cdn from db--}}
{{--    <link href="{{ asset(App\Theme::where('is_default', '=', '1')->first()->cdn_url) }}" rel="stylesheet">--}}

{{--    cdn from cookie--}}
{{--    {{ dd(Request::cookie('theme')) }}--}}
{{--    {{ dd(Request::cookie('theme')) }}--}}
{{--    {{ Request::cookie('theme') }}--}}
    @if(Request::cookie('theme'))
        <link href="{{ DB::table('themes')->where('id', '=', Request::cookie('theme'))->first()->cdn_url }}" rel="stylesheet">
    @else
        <link href="{{ asset(App\Theme::where('is_default', '=', '1')->first()->cdn_url) }}" rel="stylesheet">
    @endif

    <style>
        /*.navbar {*/
        /*    background-color: #c8c8c8;*/
        /*}*/

        body {
            overflow: hidden;
        }

        .left_side {
            height:750px; overflow:auto;
        }

        .table-responsive {
            height:500px; overflow:auto;
        }

    </style>
</head>
<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-9 py-4">
                    <nav class="navbar navbar-expand-md navbar-laravel pl-0 pr-0">
                    <a class="navbar-brand" href="{{ url('/feed') }}">
                        {{ config('app.name', 'PhotoFeed') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                <li class="nav-item">
                                    @if (Route::has('register'))
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    @endif
                                </li>
                            @else
                                <!-- Admin -->
                                @if(Auth::user()->roles->where('id', '!=', 1)->pluck('id')->count() !== 0)
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Admin <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @foreach(Auth::user()->roles->where('id', '!=', 1)->pluck('id') as $role)
                                            @if ($role === 3)
                                                <a class="dropdown-item" href="/admin/users">
                                                    Manage Users
                                                </a>
                                            @elseif ($role === 2)
                                                <a class="dropdown-item" href="/admin/themes">
                                                    Manage Themes
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </li>
                                @endif
                                <!-- Logout -->
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                    </nav>
                </div>
            </div>
        </div>


        <div class="container-fluid">
            <div class="row justify-content-center">
                <main class="col-lg-10 col-md-9 py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous">
    </script>
</body>
</html>
