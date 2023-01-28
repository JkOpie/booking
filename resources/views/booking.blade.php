@extends('layouts')

@push('header')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary mb-4" style="margin-top: 85px">
</header>
@endpush

@push('content')
<style>
    .carousel-item{
        object-fit: cover;
        height: 100%;
        max-height: 12rem;
    }

    .img-fluid{
        width: 100%;
        object-fit: cover;
        height: 100%;
        max-height: 12rem;
    }

    .receipt{
        display: none;
    }

</style>
<div class="container-xl px-4">

    @if ($booked->isEmpty() && $confirmed->isEmpty() && $approved->isEmpty())
        <div class="text-center">
            <h1>Empty! to booking, click <a href="/">here</a> </h1>
        </div>
    @endif

    @if (!$booked->isEmpty())
    <h1>Booked places, please pay to confirm your booking</h1>
    <hr>
        @foreach ($booked as $item)
            <div class="card mb-3" style="">
                <div class="row g-0">
                    <div class="col-md-3">
                        @if ($item->item->attachments->isNotEmpty())
                            @if ($item->item->attachments->count() > 1)
                                <div id="carouselExample" class="carousel slide">
                                    <div class="carousel-inner">
                                        @foreach ($item->item->attachments as $key => $attachment)
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
                                <img src="/uploads/{{$item->item->attachments->first()->filename}}" class="img-fluid rounded-start" alt="...">
                            @endif
                        @else
                            <img src="/assets/no-image.jpg" class="img-fluid rounded-start" alt="...">
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="card-body h-100">
                            <div class="h-100 d-flex flex-column justify-content-center">
                                <h5 class="card-title">{{$item->item->name}}</h5>
                                <p class="card-text mb-0">{{$item->item->description}}</p>
                                <div class="d-flex flex-row">
                                    <i>
                                        <small class="fw-light">{{$item->start_date}}</small>
                                        <small class="fw-light mx-1">until</small>
                                        <small class="fw-light">{{$item->end_date}}</small>
                                    </i>
                                </div>
                                <div class="">
                                    <small>Total Price : RM{{$item->total_price ?? 0}}</small>
                                </div>
                                {{-- @if (isset($item->item->state))
                                    <div class="d-flex align-items-center">
                                        <small><i class="fa-solid fa-location-dot"></i> {{$item->item->state ?: 'NULL'}}, {{$item->item->city ? ucwords($item->item->city) : 'NULL'}}</small>
                                    </div>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex justify-content-end align-items-center h-100">
                                <input type="hidden" value="confirmed" name="status">
                                <button class="btn btn-success me-2" type="button" data-bs-toggle="modal" data-bs-target="#paymentModal" onclick="payment('{{$item->item->id}}', '{{$item->total_price}}', '{{$item->id}}')">Pay Now</button>
                                <button class="btn btn-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="edit('{{$item}}')">Edit</button>
                            <form action="{{route('itemuser.destroy', $item->id)}}" method="post">
                                @csrf
                                <input type="hidden" value="deleted" name="status">
                                <button class="btn btn-danger me-3" type="submit">Delete</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    @endif


    @if (!$confirmed->isEmpty())
        <h1>Waiting for admin to approved</h1>
        <hr>
        @foreach ($confirmed as $item)
            <div class="card mb-3" style="">
                <div class="row g-0">
                    <div class="col-md-3">
                        @if ($item->item->attachments->isNotEmpty())
                            @if ($item->item->attachments->count() > 1)
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
                                <img src="/uploads/{{$item->item->attachments->first()->filename}}" class="img-fluid rounded-start" alt="...">
                            @endif
                        @else
                            <img src="/assets/no-image.jpg" class="img-fluid rounded-start" alt="...">
                        @endif
                    </div>

                    <div class="col-md-7">
                        <div class="card-body h-100">
                            <div class="h-100 d-flex flex-column justify-content-center">
                                <h5 class="card-title">{{$item->item->name}}</h5>
                                <p class="card-text mb-0">{{$item->item->description}}</p>

                                <div class="d-flex flex-row">
                                    <i>
                                        <small class="fw-light">{{$item->start_date}}</small>
                                        <small class="fw-light mx-1">until</small>
                                        <small class="fw-light">{{$item->end_date}}</small>
                                    </i>
                                </div>
                                <div class="">
                                    <small>Total Price : RM{{$item->total_price ?? 0}}</small><br>
                                    <small>Payment Type : {{ isset($item->payment_type) ? ucwords($item->payment_type) : 'QR'}}</small>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <form action="{{route('itemuser.destroy', $item->id)}}" method="post">
                                @csrf
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if ($approved->isNotEmpty())
        <h1>Approved</h1>
        <hr>
        @foreach ($approved as $item)
            <div class="card mb-3" style="">
                <div class="row g-0">
                    <div class="col-md-3">
                        @if ($item->item->attachments->isNotEmpty())
                            @if ($item->item->attachments->count() > 1)
                                <div id="carouselExample" class="carousel slide">
                                    <div class="carousel-inner">
                                        @foreach ($item->item->attachments as $key => $attachment)
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
                                <img src="/uploads/{{$item->item->attachments->first()->filename}}" class="img-fluid rounded-start" alt="...">
                            @endif
                        @else
                            <img src="/assets/no-image.jpg" class="img-fluid rounded-start" alt="...">
                        @endif
                    </div>

                    <div class="col-md-7">
                        <div class="card-body h-100">
                            <div class="h-100 d-flex flex-column justify-content-center">
                                <h5 class="card-title">{{$item->item->name}}</h5>
                                <p class="card-text mb-0">{{$item->item->description}}</p>

                                <div class="d-flex flex-row">
                                    <i>
                                        <small class="fw-light">{{$item->start_date}}</small>
                                        <small class="fw-light mx-1">until</small>
                                        <small class="fw-light">{{$item->end_date}}</small>
                                    </i>
                                </div>
                                <div class="mb-2">
                                    <small>Total Price : RM{{$item->total_price ?? 0}}</small> <br>
                                    <small>Payment Type : {{ isset($item->payment_type) ? ucwords($item->payment_type) : 'QR'}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex justify-content-center align-items-center h-100">

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>


<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Booking Details</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="" method="post" id="UpdateBookingDate">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="datetime-local" class="form-control" name="start_date" required step="any">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">End Date</label>
                    <input type="datetime-local" class="form-control"  name="end_date" required step="any">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Total Price (RM)</label>
                    <input type="number" class="form-control" name="total_price" readonly>
                    <input type="hidden" class="form-control" name="price" >
                  </div>
                  <hr>
                  <div class="text-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Submit</button>
                  </div>
            </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="paymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="paymentModalLabel">Payment</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closePaymentModel()"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="" class="form-label">Payment Type</label>
                <select name="payment_type" class="form-select">
                    <option value="qr">QR</option>
                    <option value="receipt">Receipt</option>
                </select>
            </div>


            <div class="qr">
                <div class="mb-3 d-flex justify-content-center qr-generator">

                </div>
                <div class="mb-1 text-center">
                    <i>Scan above QR, to pay.</i>
                </div>
                <div class="mb-3">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="button" onclick="have_paid()">i Already Paid.</button>
                    </div>
                </div>
            </div>

            <div class="receipt">
                <form action="" method="post" id="UploadReceipt" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 ">
                        <label class="form-label">Receipt</label>
                        <input type="file" class="form-control" name="receipt">
                        <input type="hidden" name="payment_type" value="qr">
                        <input type="hidden" name="status" value="confirmed">
                        <input type="hidden" name="itemUserID">
                    </div>
                    <div class="mb-3">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit">Submit</button>
                          </div>
                    </div>
                </form>
            </div>


        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

  <script>

    function closePaymentModel(){
        $('.qr-generator').empty();
    }

    $('select[name=payment_type]').change((e)=>{
        //console.log();
        var value = $(e.currentTarget).val();
        var itemUserID = $('input[name=itemUserID]').val();
        if(value == 'qr'){
            $('.qr').show();
            $('input[name=payment_type]').val('qr');
            generate('https://booking.jkopie.com/user/payment/'+itemUserID);
            $('.receipt').hide();
        }

        if(value == 'receipt'){
            $('.receipt').show();
            $('input[name=payment_type]').val('receipt');
            $('.qr-generator').empty();
            $('.qr').hide();
        }
    })

    function generate(user_input) {
        var qrcode = new QRCode(document.querySelector(".qr-generator"), {
            text: `${user_input}`,
            width: 300, //default 128
            height: 300,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    }

    function payment(item_id, total_price, itemuserID){
        $('#UploadReceipt').attr('action', '/itemuser/booking/'+item_id);
        $('input[name=itemUserID]').val(itemuserID)
        generate('https://booking.jkopie.com/user/payment/'+itemuserID);
    }

    function edit(items){
        var items = JSON.parse(items);
        $('#UpdateBookingDate').attr('action', '/itemuser/update/'+items.id);

        if(items){
            //console.log(items);
            if(items.price == undefined){
                items.price = 0;
            }

            items.item.price == null ? items.item.price = 10 : null;

            $('input[name=start_date]').val(items.start_date);
            $('input[name=end_date]').val(items.end_date);
            $('input[name=total_price]').val(items.total_price);
            $('input[name=price]').val(items.item.price);
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

    function have_paid(){
        var item_id = $('input[name=itemUserID]').val();
        $.ajax({
            url: "/user/verify-payment/"+item_id,
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success:function(res){
                if(res == 'confirmed'){
                    alert('Payment success. Please wait for admin to approve payment.');
                    location.reload();
                }else{
                    alert('System not detected any form of payment, Please make payment to confirmed your booking!');
                }

            }
        })
    }

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


