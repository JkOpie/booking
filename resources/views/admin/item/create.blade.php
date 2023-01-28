@extends('template_layouts.master')

@push('headers')

<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        Places Create
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3 ">
                    <a class="btn btn-sm btn-light text-primary text-center" href="{{route('items.available')}}">Back</a>
                </div>
            </div>
        </div>
    </div>
</header>
@endpush

@push('content')
<style>
    .carousel-item img{
        width: 500px;
        height: 300px;
        object-fit: cover;
    }


</style>
<div class="container-fluid px-4">
    <form action="{{route('items.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="text-end" >
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>

            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="name" class="form-control" placeholder="Enter Name" name="name" required value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="type_id" class="form-select" required>
                                <option selected>Select Type</option>
                                @foreach ($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <option selected>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Availablity</label>
                                <select name="status" class="form-select" required>
                                    <option value="available">Available</option>
                                    <option value="unavailable">Unvailable</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                            <textarea name="description" rows="5" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Price per Hours (RM)</label>
                            <input type="number" name="price" placeholder="Ex: 10" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Attachment</label>
                            <input class="form-control" type="file" name="attachment[]" multiple>
                        </div>
                        <div class="mt-2">
                            <ul class="list-group">
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">State</label>
                            <select name="state" class="form-select" required>
                                <option>Please select State</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <select name="city" class="form-select" required>
                                <option>Please select City</option>
                            </select>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </form>


</div>

{{-- <script src='/js/statecity.js'></script>

<script>
    var getStateCity = getStateCity();

    $.each(getStateCity, (k,v) => {
        $('select[name=state]').append(
            $('<option>').text(k).val(k)
        )
    });

    $('select[name=state]').change((e)=>{
        var val = $(e.currentTarget).val();
        $('select[name=city]').empty();

        $.each(getStateCity, (state,city) => {
            if(state == val){
                $.each(city, (k,v)=> {
                    $('select[name=city]').append(
                        $('<option>').text(v).val(v)
                    )
                })
            }
        });
    })
</script> --}}

@endpush
