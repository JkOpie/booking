@extends('layouts')

@push('header')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary mb-4" style="margin-top: 85px">
</header>
@endpush

@push('content')
<style>
    .carousel-item{
        object-fit: cover;
        height: 10rem;
    }

    .img-fluid{
        width: 100%;
        object-fit: cover;
        height: 10rem;
    }
</style>
<div class="container-xl px-4">

    @foreach ($items as $item)
        <div class="card mb-3" style="">
            <div class="row g-0">
                <div class="col-md-3">
                    {{-- @if ($item->attachments->count() > 1) --}}
                        <div id="carouselExample" class="carousel slide">
                            <div class="carousel-inner">
                                {{-- @foreach ($item->attachments as $item)
                                    <div class="carousel-item active">
                                        <img src="/uploads/{{$item->filename}}" class="d-block w-100" alt="...">
                                    </div>
                                @endforeach --}}
                                <div class="carousel-item active">
                                    <img src="/assets/no-image.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="/assets/no-image.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="/assets/no-image.jpg" class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    {{-- @elseif($item->attachments->count() == 1)
                        <img src="/uploads/{{$item->attachments->first()->filename}}" class="img-fluid rounded-start" alt="...">
                    @else
                        <img src="/assets/no-image.jpg" class="img-fluid rounded-start" alt="...">
                    @endif --}}
                </div>
                <div class="col-md-5">
                    <div class="card-body h-100">
                        <div class="h-100 d-flex flex-column justify-content-center">
                            <h5 class="card-title">{{$item->name}}</h5>
                            <p class="card-text">{{$item->description}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <form action="{{route('itemuser.booking', $item->id)}}" method="post">
                        @csrf
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div class="my-2 me-2" style="width:48%">
                                <label class="small mb-1">Start Date</label>
                                <input type="datetime-local" name="start_date" class="form-control w-100">
                            </div>
                            <div class="my-2 me-2 " style="width:48%">
                                <label class="small mb-1">End Date</label>
                                <input type="datetime-local" name="end_date" class="form-control">
                                <input type="hidden" value="booked" name="status">
                            </div>
                            {{-- <div class="input-group input-group-joined border-0" style="width: 16.5rem;border: 1px solid grey !important;">
                                <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar text-primary"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>
                                <input class="form-control ps-0 pointer" id="litepickerRangePlugin" placeholder="Select date range...">
                            </div> --}}
                        </div>
                        <div class="d-grid gap-2 me-2">
                            @if (Auth::check())
                                <button class="btn btn-primary" type="submit">Book Now</button>
                            @else
                                <a class="btn btn-primary" href="/login">Book Now</a>
                            @endif
                        </div>
                    </form>
                </div>
                {{-- <div class="col-md-2">
                    <div class="d-flex justify-content-center align-items-center h-100">


                    </div>

                </div> --}}
            </div>
        </div>
    @endforeach

</div>
@endpush


