@extends('template_layouts.master')

@push('headers')
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        Places List
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{route('items.create')}}">
                        <i class="me-1" data-feather="user-plus"></i>
                        Add New Place
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
            <table id="datatablesSimple">
                <thead>
                    <tr>

                        <th>Place Name</th>
                        <th>Decsription</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->status}}</td>
                        <td>{{ isset($item->type) ? $item->type->name : null;}}</td>
                        <td>{{ isset($item->category) ? $item->category->name : null}}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{route('items.edit', ['item' => $item->id])}}">Edit</a></td>
                        <td>
                            <form action="{{route('items.destroy', ['item' => $item->id])}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>

                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endpush

@push('bottomScripts')
<script>
    const dataTable = new simpleDatatables.DataTable("#datatablesSimple", {
        fixedHeight: true,
        perPage: false,
        perPageSelect: false,

    })
</script>
@endpush
