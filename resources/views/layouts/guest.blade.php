<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Account Settings - Billing - SB Admin Pro</title>
        <link href="/template/css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="/template/assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    </head>
    <body>
        @include('template_layouts.success-error-session')
        <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
            <div class="row w-100">
                <div class="col-md-4 ">
                    <div class="d-flex align-items-center h-100 ps-3">
                        <img src="/assets/logo.jpg" alt="" width="35" height="35">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center h-100 ps-3">
                        <a href="/" class="text-black me-3">Home</a>
                    @if (Auth::check())
                    @php
                        $bookingCount = App\Models\ItemUser::where('user_id', Auth::user()->id)->where('status', 'booked')->count();
                    @endphp
                        <a href="/user/profiles" class="me-3 text-black">Profiles</a>
                        @if ($bookingCount > 0)
                            <a href="/user/booked" class="text-black">Booking <span class=" bg-danger rounded-5 text-white px-1 py-1" style="top:0;right:0">{{$bookingCount}}</span></a>
                        @else
                            <a href="/user/booked" class="text-black">Booking</a>
                        @endif
                    @endif
                </div>
                </div>
                <div class="col-md-4 text-end">
                    @if (Auth::check())
                        <a class="btn btn-primary" href="/logout">Logout</a>
                    @else
                        <a class="btn btn-primary" href="/login">Login</a>
                        <a class="btn btn-primary" href="/register">Register</a>
                    @endif
                </div>
            </div>
        </nav>

        {{ $slot }}
    </body>
</html>
