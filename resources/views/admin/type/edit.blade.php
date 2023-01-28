@extends('template_layouts.master')

@push('headers')

<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        Type Edit
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3 ">
                    <a class="btn btn-sm btn-light text-primary text-center" href="{{route('types.index')}}">Back</a>
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
           <form action="{{route('types.update', $type->id)}}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="name" class="form-control" placeholder="Enter Name" name="name" required value="{{$type->name}}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                   <textarea name="description" rows="5" class="form-control">{{$type->description}}</textarea>
                </div>
              <button class="btn btn-primary">Submit</button>
           </form>
        </div>
    </div>
</div>

@endpush