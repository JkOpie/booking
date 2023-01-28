@extends('template_layouts.master')

@push('headers')
<style>
    a:link {
      text-decoration: none;
    }

    a:visited {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    a:active {
        text-decoration: none;
    }
</style>
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="activity"></i></div>
                        Dashboard
                    </h1>
                </div>
            </div>
        </div>
    </div>
</header>
@endpush

@push('content')
<div class="container-xl" style="margin-top:-4rem">
    <div class="row">
        <div class="col-xxl-12 col-xl-12 mb-4">
            <div class="card h-100">
                <div class="card-body h-100 p-5">
                    <div class="row align-items-center">
                        <div class="col-xl-8 col-xxl-12">
                            <div class="text-center text-xl-start text-xxl-center">
                                <h1 class="text-primary mb-0">Kulim Hi-Tech Park Sports Complex</h1>
                                {{-- <p class="text-gray-700 mb-0"></p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Example Colored Cards for Dashboard Demo-->
    <div class="row">
        <div class="col-lg-6 col-xl-3 mb-4">
            <a href="/users">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                @php
                                    $userCount = App\Models\User::all()->count();
                                @endphp
                                <div class="text-white-75 small">User Registered</div>
                                <div class="text-lg fw-bold">{{$userCount}}</div>
                            </div>
                            {{-- <i class="feather-xl text-white-50" data-feather="calendar"></i> --}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-6 col-xl-3 mb-4">
            <a href="/admin/items/booked">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                @php
                                    $bookedCount = App\Models\ItemUser::where('status', 'booked')->count();
                                @endphp
                                <div class="text-white-75 small">Total Places Booked</div>
                                <div class="text-lg fw-bold">{{$bookedCount}}</div>
                            </div>
                            {{-- <i class="feather-xl text-white-50" data-feather="dollar-sign"></i> --}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-6 col-xl-3 mb-4">
            <a href="/admin/items/confirmed">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                @php
                                    $ConfirmedCount = App\Models\ItemUser::where('status', 'confirmed')->count();
                                @endphp
                                <div class="text-white-75 small">Total Places Confirmed</div>
                                <div class="text-lg fw-bold">{{$ConfirmedCount}}</div>
                            </div>
                            {{-- <i class="feather-xl text-white-50" data-feather="check-square"></i> --}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-6 col-xl-3 mb-4">
            <a href="/admin/items/approved">
                <div class="card bg-danger text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                @php
                                    $ApproveCount = App\Models\ItemUser::where('status', 'approved')->count();
                                @endphp
                                <div class="text-white-75 small">Total Places Approved</div>
                                <div class="text-lg fw-bold">{{$ApproveCount }}</div>
                            </div>
                            {{-- <i class="feather-xl text-white-50" data-feather="message-circle"></i> --}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endpush
