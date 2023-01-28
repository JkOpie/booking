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
        height: 100%;
        max-height: 22rem;
    }

    .receipt{
        display: none;
    }
    .card-body hr{
        margin: .5rem 0;
    }

</style>
<div class="container-xl px-4">

    @if ($itemuser->status == 'booked')
    <h1>Payment</h1>
    <hr>
    <div class="card mb-3" style="">
        <div class="row g-0">
            <div class="col-md-6">
                @if ($itemuser->item->attachments->isNotEmpty())
                    @if ($itemuser->item->attachments->count() > 1)
                        <div id="carouselExample" class="carousel slide">
                            <div class="carousel-inner">
                                @foreach ($itemuser->item->attachments as $key => $attachment)
                                    @if ($key == 1)
                                        <div class="carousel-item  active">
                                    @else
                                        <div class="carousel-item">
                                    @endif
                                        <img src="/uploads/{{$attachment->filename}}" class="d-block w-100" alt="...">
                                    </div>
                                @endforeach
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
                    @else
                        <img src="/uploads/{{$itemuser->item->attachments->first()->filename}}" class="img-fluid rounded-start" alt="...">
                    @endif
                @else
                    <img src="/assets/no-image.jpg" class="img-fluid rounded-start" alt="...">
                @endif
            </div>

            <div class="col-md-6">
                <div class="card-body h-100">
                    <div class="h-100 d-flex flex-column justify-content-center">
                        <h5 class="mb-0">User Details</h5>
                        <hr>
                        <p class="card-text mb-0">Name : {{$itemuser->user->name}}</p>
                        <p class="card-text mb-0">Email : {{$itemuser->user->email}}</p>
                        <hr>
                        <h5 class="mb-0">Booking Details</h5>
                        <hr>
                        <h5 class="card-title mb-0">{{$itemuser->item->name}}</h5>
                        <p class="card-text mb-0">{{$itemuser->item->description}}</p>
                        <div class="d-flex flex-row">

                            <i>
                                <small>Date : </small>
                                <small class="fw-light">{{$itemuser->start_date}}</small>
                                <small class="fw-light mx-1">until</small>
                                <small class="fw-light">{{$itemuser->end_date}}</small>
                            </i>
                        </div>
                        <div class="">
                            <small>Total Price : RM{{$itemuser->total_price ?? 0}}</small>
                        </div>
                        <div class="mt-2">
                            <div class="text-center">
                                <i style="font-size: 12px">Make sure all the information above is correct before press Pay button.</i>
                            </div>
                            <div class="d-grid grap-2">
                                <button class="btn btn-primary" onclick="payment('{{$itemuser->id}}','{{$itemuser->total_price}}' )">Pay RM{{$itemuser->total_price ?? 0}}</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    @else
        <h1>{{$itemuser->item->name}} booking payment success Please wait admin to approve payment</h1>
    @endif
</div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script>

    function payment(item_id, total_price){
        if(confirm('are you sure want to pay RM '+ total_price)){
            $.ajax({
                url: "/user/payment/"+item_id,
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success:function(res){
                    alert('Payment success. Please wait for admin to approve payment.');
                    location.reload();
                }
            })
        }
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
        //console.log();
        var diff = Math.abs(new Date($('input[name=start_date]').val()) - new Date($('input[name=end_date]').val()));
        var minutes = Math.floor((diff/1000)/60);
        var price = parseInt($('input[name=price]').val()) / 60;
        var total_price = minutes*price;
        console.log(total_price);
        $('input[name=total_price]').val(parseInt(total_price));

        if(total_price > 0){
            $('.submit_booking').prop('disabled', false);
        }else{
            $('.submit_booking').prop('disabled', true);
        }
    }
  </script>
@endpush


