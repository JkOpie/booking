<!DOCTYPE html>
<html lang="en">
<head>

</head>
<style>
    table, th, td {
        border-collapse: collapse;
    }
    th ,td {
        padding:5px;
        text-align: left;
    }
</style>
<body>
    <div class="card invoice">
        <div style="text-align: center">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-start">
                    <!-- Invoice branding-->
                    <img class="invoice-brand-img rounded-circle mb-4" src="C:\Users\addra\OneDrive\Desktop\NewBooking\booking\public\assets\logo.jpg" alt="" width="100" height="100">
                    <div class="h2 text-white mb-0"> Kulim Hi-Tech Park Sports Complex </div>
                </div>
                <div class="col-12 col-lg-auto text-center text-lg-end">
                    <!-- Invoice details-->
                    <div class="h3 text-white">Booking Number</div>
                    {{$data['booking_number']}}
                </div>
            </div>
        </div>
        <hr>
        <div class="card-body p-4 p-md-5">
            <!-- Invoice table-->
            <div class="table-responsive">
                <br>

                <table>
                    <tr>
                        <th style="border-bottom:1px solid black;">User Detais</th>
                        <th></th>
                        <th style="border-bottom:1px solid black;">Booking Detais</th>
                        <th style="border-bottom:1px solid black;"></th>

                    </tr>
                    <tr>
                        <td><b>Name : </b> {{$data['user']['name']}}</td>
                        <td></td>
                        <td><b>Place Name : </b> {{$data['item']['name']}}</td>
                        <td> <b>Status : </b> {{$data['status']}}</td>
                    </tr>
                    <tr>
                        <td> <b>Email : </b> {{ $data['user']['email']}}</td>
                        <td></td>
                        <td> <b>Start Date :</b> {{$data['start_date']}}</td>
                        <td> <b>End Date :</b> {{$data['end_date']}}</td>
                    </tr>
                    <tr>
                        <td> <b>Phone : </b>  {{ $data['user']['phone']}}</td>
                        <td></td>
                        <td> <b>Price/Hours (RM) : </b> {{ isset($data['item']['price']) ? $data['item']['price'] : 10 }}</td>
                        <td> <b>Total Price (RM) : </b>{{ isset($data['total_price']) ? $data['total_price']: 0 }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>

                        <td></td>

                    </tr>
                    <tr>
                        <td></td>
                        <td></td>

                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>

                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
