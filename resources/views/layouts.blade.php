<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template_layouts.header')
        @livewireStyles
        <style>
            .btn-light{
                padding: 0.5rem 0.75rem
            }
            .card-img, .card-img-top{
                object-fit: cover;
                height: 12rem;
            }
        </style>
    </head>
    <body class="nav-fixed">
        @include('template_layouts.success-error-session')
        <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
            <div class="row w-100">
                <div class="col-md-4 ">
                    <div class="d-flex align-items-center h-100 ps-3">
                        <img src="/assets/logo.jpg" alt="" width="35" height="35">
                    </div>
                </div>
                <div class="col-md-4">
                    @if (!Str::contains(url()->full(), 'payment'))
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
                    @endif
                </div>
                @if (!Str::contains(url()->full(), 'payment'))
                    <div class="col-md-4 text-end">
                        @if (Auth::check())
                            <a class="btn btn-primary" href="/logout">Logout</a>
                        @else
                            <a class="btn btn-primary" href="/login">Login</a>
                            <a class="btn btn-primary" href="/register">Register</a>
                        @endif
                    </div>
                @endif

            </div>
        </nav>
        <main>
            @stack('header')
            @stack('content')
        </main>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/template/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="/template/js/datatables/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="/template/js/litepicker.js"></script>
    @livewireScripts
</html>
