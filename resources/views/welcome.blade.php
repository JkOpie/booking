@extends('layouts')

@push('header')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary mb-4" style="margin-top: 59px">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row d-flex align-items-center justify-content-between ">
                <div class="mt-4 d-flex align-items-center justify-content-center">
                    <h1 class="page-header-title"> Find the best place for your Prestigious Event</h1>
                </div>
            </div>
            <div class="page-header-search mt-4">
                <div class="input-group input-group-joined">
                    <input class="form-control" type="text" placeholder="Search..." aria-label="Search" autofocus="" name="search">
                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span>
                </div>
            </div>
        </div>
    </div>
</header>
@endpush

@push('content')
<div class="container-xl px-4">



        @foreach ($types as $type)
            @php
                $count = App\Models\Item::where(['type_id' => $type->id])->where('status', 'available')->count();
            @endphp

            @if ($count > 0)
                <div class="text-center">
                    <h4 class="mb-0 mt-5">{{$type->name}}</h4>
                    <small class="">{{$type->description}}</small>
                    <hr class="mt-2 mb-4">
                </div>

                <div class="row">
                    @foreach ($categories as $category)
                        @php
                            $count = App\Models\Item::where(['type_id' => $type->id, 'category_id' => $category->id])->where('status', 'available')->count();
                        @endphp
                        @if ($count > 0)
                            <div class="col-lg-3 mb-4">
                                <a class="card lift lift-sm h-100" href="/user/places/{{$type->id.'/'.$category->id}}">
                                    @if ($category->filename)
                                        <img class="card-img-top" src="/categories/{{$category->filename}}" alt="...">
                                    @else
                                        <img class="card-img-top" src="{{asset('assets/no-image.jpg')}}" alt="...">
                                    @endif
                                    <div class="card-footer">
                                        <div class="small text-muted">{{$category->name}}</div>
                                        <div class="small text-muted text-lowercase">{{ $count }} main {{$category->name}}</div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

        @endforeach

        <script>
           $(document).keyup(function (e) {
                if ($("input[name=search]").is(":focus") && (e.keyCode == 13)) {
                    var val = $("input[name=search]").val();

                    if(val != ''){
                        window.location.replace("/user/search?title="+val);
                    }

                }
            });
        </script>


</div>
@endpush


