@extends('template_layouts.master')

@push('headers')

<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        Items Edit
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
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                   <form action="{{route('items.update', $item->id)}}" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="name" class="form-control" placeholder="Enter Name" name="name" required value="{{$item->name}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="type_id" class="form-select" required>
                                <option selected>Select Type</option>
                                @foreach ($types as $type)
                                    <option value="{{$type->id}}"
                                        @if ($type->id == $item->type_id)
                                        selected
                                        @endif>{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option selected>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}"
                                        @if ($category->id == $item->category_id)
                                            selected
                                        @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Availablity</label>
                            <select name="status" class="form-select" required>
                                <option value="available"
                                @if ($item->status == "available")
                                    selected
                                @endif>Available</option>
                                <option value="unavailable"
                                @if ($item->status == "unavailable")
                                    selected
                                @endif>Unvailable</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price per Hours (RM)</label>
                            <input type="number" name="price" placeholder="Ex: 10" class="form-control" value="{{$item->price}}" required>
                        </div>

                        {{-- <div class="mb-3">
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
                        </div> --}}

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                           <textarea name="description" rows="5" class="form-control" required>{{$item->description}}</textarea>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{route('items.update', $item->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label class="form-label">Attachment</label>
                            <input class="form-control" type="file" name="attachment[]" multiple>
                        </div>

                        @if (isset($item->attachments))
                            <div class="mt-2">
                                <ul class="list-group">
                                    @foreach ($item->attachments as $attachment)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{asset('/uploads/'.$attachment->filename)}}">{{$attachment->filename_original ?? $attachment->filename}}</a>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- <script src="/js/statecity.js"></script>
<script>
    var getStateCity = getStateCity();
    var userState = '{{$item->state}}';
    var userCity = '{{$item->city}}';

    document.querySelector('select[name=state]').addEventListener('change', (e) => {
      const val = e.currentTarget.value;
      document.querySelector('select[name=city]').innerHTML = '';

      Object.entries(getStateCity).forEach(([state, city]) => {
        if (state === val) {
          Object.entries(city).forEach(([k, v]) => {
            const option = document.createElement('option');
            option.text = v;
            option.value = v;
            document.querySelector('select[name=city]').appendChild(option);
          });
        }
      });
    });


    Object.entries(getStateCity).forEach(([state, city]) => {
    if (state === userState) {
      Object.entries(city).forEach(([k, v]) => {
        const option = document.createElement('option');
        option.text = v;
        option.value = v;
        document.querySelector('select[name=city]').appendChild(option);
      });
    }
  });


    Object.entries(getStateCity).forEach(([k, v]) => {
      const option = document.createElement('option');
      option.text = k;
      option.value = k;
      document.querySelector('select[name=state]').appendChild(option);
    });

    if(userState != ''){
        const selectElement = document.querySelector('select[name=state]');
        const Option1 = selectElement.querySelector("option[value='"+userState+"'");
        Option1.selected = true;
    }


    if(userCity != ''){
      const selectElement2 = document.querySelector('select[name=city]');
      const Option2 = selectElement2.querySelector("option[value='"+userCity+"'");
      Option2.selected = true;
    }


  </script> --}}

@endpush
