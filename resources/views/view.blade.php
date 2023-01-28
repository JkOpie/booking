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

    .recomandations .card-title{
        min-height: 2rem;
    }

    .recomandations .card-body p{
        font-weight: 14px;
        min-height: 3rem;
    }
</style>
<div class="container-xl px-4">

    @foreach ($items as $item)
        <div class="card mb-3" style="">
            <div class="row g-0">
                <div class="col-md-3">
                    @if ($item->attachments->isNotEmpty())
                        @if ($item->attachments->count() > 1)
                            <div id="carouselExample" class="carousel slide">
                                <div class="carousel-inner">
                                    @foreach ($item->attachments as $key => $attachment)
                                        @if ($key == 1)
                                            <div class="carousel-item  active">
                                        @else
                                            <div class="carousel-item">
                                        @endif
                                            <img src="/uploads/{{$attachment->filename}}" class="d-block w-100" alt="...">
                                        </div>
                                    @endforeach

                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                </div>
                            </div>
                        @else
                            <img src="/uploads/{{$item->attachments->first()->filename}}" class="img-fluid rounded-start" alt="...">
                        @endif
                    @else
                        <img src="/assets/no-image.jpg" class="img-fluid rounded-start" alt="...">
                    @endif
                </div>
                <div class="col-md-5">
                    <div class="card-body h-100">
                        <div class="h-100 d-flex flex-column justify-content-center">
                            <h5 class="card-title">{{$item->name}}</h5>
                            <p class="card-text">{{$item->description}}</p>
                            {{-- @if (isset($item->state))
                                <div class="d-flex align-items-center">
                                    <small><i class="fa-solid fa-location-dot"></i> {{$item->state ?: 'NULL'}}, {{$item->city ? ucwords($item->city) : 'NULL'}}</small>
                                </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex justify-content-end align-items-center h-100 w-100">
                        @if (Auth::check())
                            <button class="btn btn-primary w-50 me-5" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="displayBooked({{$item->id}}, '{{$item->price}}')">Book Now</button>
                        @else
                            <a class="btn btn-primary w-50 me-5" href="/login">Book Now</a>
                        @endif
                    </div>
                </div>
                <form action="{{route('itemuser.booking', $item->id)}}" method="post">
                    @csrf
            </form>
                {{-- <div class="col-md-2">
                    <div class="d-flex justify-content-center align-items-center h-100">
                    </div>
                </div> --}}
            </div>
        </div>
    @endforeach

    <div class="pt-3">
        <h1>Recommend For You</h1>
    </div>
    <hr>

    @php
        $notItems = $items->pluck('id')->toArray();
        $recommendItems = App\Models\Item::whereNotIn('id', $notItems)->where('status', 'available')->get();
    @endphp

    <div class="recomandations" style="display: grid;
    grid-template-columns: 25% 25% 25% 25%; ">
        @foreach ($recommendItems as $item)
        <div class="p-3">
            <div class="card w-100 h-100">
                @if ($item->attachments->isNotEmpty())
                @if ($item->attachments->count() > 1)
                    <div id="carouselExample" class="carousel slide">
                        <div class="carousel-inner">
                            @foreach ($item->attachments as $key => $attachment)
                                @if ($key == 1)
                                    <div class="carousel-item  active">
                                @else
                                    <div class="carousel-item">
                                @endif
                                    <img src="/uploads/{{$attachment->filename}}" class="d-block w-100" alt="...">
                                </div>
                            @endforeach

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        </div>
                    </div>
                @else
                    <img src="/uploads/{{$item->attachments->first()->filename}}" class="img-fluid rounded-start" alt="...">
                @endif
            @else
                <img src="/assets/no-image.jpg" class="img-fluid rounded-start" alt="...">
            @endif

                <div class="card-body">
                    <h5 class="card-title">{{$item->name}}</h5>
                    <p class="card-text">{{$item->description}}</p>
                    {{-- @if (isset($item->state))
                        <div class="d-flex align-items-center">
                            <small><i class="fa-solid fa-location-dot"></i> {{$item->state ?: 'NULL'}}, {{$item->city ? ucwords($item->city) : 'NULL'}}</small>
                        </div>
                    @endif --}}
                </div>

                <div class="card-footer">
                    <div class="d-grid gap-2">
                        @if (Auth::check())
                            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="displayBooked({{$item->id}}, '{{$item->total_price}}')">Book Now</button>
                        @else
                            <a class="btn btn-primary" href="/login">Book Now</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        @endforeach
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Booking</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="" method="post" id="formBooking">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 others-booked"></div>
                            <div class="col-md-6" style="border-left:1px solid #e0e5ec;">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <div class="py-2 me-2" style="width:48%">
                                        <label class="small mb-1">Start Date</label>
                                        <input type="datetime-local" step="any" name="start_date" class="form-control w-100" min="{{\Carbon\Carbon::now()->toDateTimeLocalString()}}">
                                    </div>
                                    <div class="py-2 me-2 " style="width:48%">
                                        <label class="small mb-1">End Date</label>
                                        <input type="datetime-local" step="any" name="end_date" class="form-control" min="{{\Carbon\Carbon::now()->toDateTimeLocalString()}}">
                                        <input type="hidden" value="booked" name="status">
                                        <input type="hidden" value="" name="price">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="small mb-1">Total Booking Price (RM)</label>
                                    <input type="number" name="total_price" class="form-control" placeholder="Please Select Start Date and End Date" readonly>
                                </div>
                            </div>
                            <div class="col-md-12 text-end pt-2" style="border-top: 1px solid #e0e5ec;">
                                <button class="btn btn-secondary me-1" type="button" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary submit_booking" type="submit" disabled>Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

<script>
    function displayBooked(id, price){
        //console.log(price);
        $('#formBooking').attr('action', '/itemuser/booking/'+id);

        $.ajax({
            url: "{{route('itemuser.index')}}",
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { id : id},
            success:function(res)
            {
                //console.log(res.length);
                price == '' ? price = 10 : null;
                $('input[name=price]').val(price);
                $('.submit_booking').prop('disabled', true);

                $('.others-booked').empty();

                if(res.length > 0){

                    $('.others-booked').append(
                        $('<p>').text('Others Booked :')
                    );

                    var ul =  $('<ul>').addClass('list-group');

                    $.each(res, (k,v) => {


                        var startDate = new Date( v.start_date+' GMT+08:00').toLocaleString('en-GB', {timeZone: 'Asia/Singapore'});
                        var endDate = new Date( v.end_date+' GMT+08:00').toLocaleString('en-GB', {timeZone: 'Asia/Singapore'});

                        ul.append(
                            $('<li>').addClass('list-group-item d-flex justify-content-between align-items-center')
                                .text('booked on '+ startDate
                                    + ' until '+ endDate ),
                        )



                    })

                    $('.others-booked').append(ul);
                }else{
                    //console.log(res);
                    $('.others-booked').append(
                        $('<p>').text('Others Booked : None')
                    );
                }
            }
        });

    }

    $('input[name=start_date]').change((e)=>{
        if($('input[name=end_date]').val() != ''){
            calculate_total_price();
        }

    })

    $('input[name=end_date]').change((e)=>{
        if($('input[name=start_date]').val() != ''){
            calculate_total_price()
        }
    })

    function calculate_total_price(){
        var diff = Math.abs(new Date($('input[name=start_date]').val()) - new Date($('input[name=end_date]').val()));
        var minutes = Math.floor((diff/1000)/60);
        var price = parseInt($('input[name=price]').val()) / 60;
        var total_price = minutes*price;
        $('input[name=total_price]').val(parseInt(total_price));

        if(total_price > 0){
            $('.submit_booking').prop('disabled', false);
        }else{
            $('.submit_booking').prop('disabled', true);
        }

    }
</script>
@endpush


