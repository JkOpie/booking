@extends('template_layouts.master')

@push('headers')
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        Users List
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{route('users.create')}}">
                        <i class="me-1" data-feather="user-plus"></i>
                        Add New User
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
@endpush

@push('content')
<div class="container-fluid px-4">
    <div class="card">
        <div class="card-body">
            <livewire:user-table/>
        </div>
    </div>
</div>

@endpush
