<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <div class="sidenav-menu-heading">Core</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link" href="/dashboard" data-type="dashboard">
                    <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="{{route('users.index')}}" data-type="users">
                    <div class="nav-link-icon"><i class="fa-solid fa-user"></i></div>
                    Users
                </a>
                <a class="nav-link" href="{{route('users.edit', Auth::user()->id)}}" data-type="profiles">
                    <div class="nav-link-icon"><i class="fa-solid fa-address-card"></i></div>
                    Profiles
                </a>
                <a class="nav-link collapsed" data-type="places" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                    <div class="nav-link-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                    Places
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseDashboards" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="{{route('items.available')}}" data-type="available">All</a>
                        <a class="nav-link" href="{{route('items.booked')}}" data-type="booked">Booked</a>
                        <a class="nav-link" href="{{route('items.confirmed')}}" data-type="confirmed">Confirmed</a>
                        <a class="nav-link" href="{{route('items.approved')}}" data-type="approved">Approved</a>
                        {{-- <a class="nav-link" href="{{route('items.index')}}">All</a> --}}
                    </nav>
                </div>
                <a class="nav-link" href="{{route('category.index')}}" data-type="categories">
                    <div class="nav-link-icon"><i class="fa-solid fa-c"></i></div>
                    Category
                </a>
                <a class="nav-link" href="{{route('types.index')}}" data-type="types">
                    <div class="nav-link-icon"><i class="fas fa-monument"></i></div>
                    Type
                </a>
                <a class="nav-link" href="/logout">
                    <div class="nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                    Logout
                </a>
            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">{{ Auth::user()->name }}</div>
            </div>
        </div>
    </nav>
</div>

<script>
    var url = new URL(window.location.href)
    var pathname = url.pathname;
    //console.log(pathname);
    var items = pathname.split('/');

    if(pathname.includes('items')){
        if(items[3]){
            $('#collapseDashboards').addClass('show');
            $('.sidenav .sidenav-menu .nav .nav-link[data-type='+items[3]+']').css('color', '#0061f2');
        }
    }

    if(items[1]){
        if(items[3] == undefined){
            $('.sidenav-light .sidenav-menu .nav-link[data-type='+items[1]+']').css('color', '#0061f2');
        }

        if(items.length = 4 && items[2] == '1'){
            $('.sidenav-light .sidenav-menu .nav-link[data-type=profiles').css('color', '#0061f2');
        }

    }




</script>
