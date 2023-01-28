@extends('template_layouts.master')

@push('headers')
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        Category Create
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{route('categories.index')}}">
                        <i class="me-1" data-feather="user-plus"></i>
                        Back
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
            <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="name" class="form-control" placeholder="Enter Name" name="name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Attachment</label>
                    <input class="form-control" type="file" name="attachment">
                </div>
              <button class="btn btn-primary">Submit</button>
           </form>
        </div>
    </div>
</div>

@endpush