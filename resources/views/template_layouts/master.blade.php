<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template_layouts.header')
        @livewireStyles
        @powerGridStyles

        <style>
            .btn-light{
                padding: 0.5rem 0.75rem
            }

            .power_grid, select{
                font-size: 0.875rem !important;
                padding: 0.875rem 3.375rem 0.875rem 1.125rem !important;
            }

            select option{
                line-height: 2;
            }
        </style>
    </head>
    <body class="nav-fixed">
        @include('template_layouts.success-error-session')
        @include('template_layouts.navbar')
        <div id="layoutSidenav">
            @include('template_layouts.sidenav')
            <div id="layoutSidenav_content">
                <main>
                    @stack('headers')
                    <!-- Main page content-->
                    @stack('content')
                </main>
               @include('template_layouts.footer')
            </div>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>


    @stack('bottomScripts')
    @livewireScripts
    @powerGridScripts

</html>
