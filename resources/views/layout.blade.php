<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('department.index') }}">{{ __('Department') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('section.index') }}">{{ __('Section') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('role.index') }}">{{ __('Role') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('designation.index') }}">{{ __('Designation') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('grade.index') }}">{{ __('Grade') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                                <li class="nav-item">
                                    <a class="nav-link" href="#">{{ __('Home') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">{{ __('Leavetype') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('department.index') }}">{{ __('Department') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('section.index') }}">{{ __('Section') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('designation.index') }}">{{ __('Designation') }}</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="{{ route('role.index') }}">{{ __('Role') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('grade.index') }}">{{ __('Grade') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.create') }}">{{ __('Employee') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}">{{ __('Logout') }}</a>
                                </li>

            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
