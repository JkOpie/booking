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
                        <th>Booking Number</th>
                        <th>User Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Place Name</th>
                        <th>Decsription</th>
                        <th>Price/hours (RM)</th>
                        <th>Total Price (RM)</th>
                        <th>Payment Type</th>
                        <th>Receipt</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                    <tr>
                        <td>{{ isset($item->booking_number) ? $item->booking_number : '-'}}</td>
                        <td>{{$item->user->name}}</td>
                        <td>{{$item->start_date}}</td>
                        <td>{{$item->end_date}}</td>
                        <td>{{$item->status}}</td>
                        <td>{{$item->item->name}}</td>
                        <td>{{$item->item->description}}</td>
                        <td>{{ isset($item->item->price) ? $item->item->price : 10}}</td>
                        <td>{{$item->total_price}}</td>
                        <td>{{$item->payment_type}}</td>
                        @if ($item->payment_type == 'qr')
                            @if (isset($item->receipt_original))
                                <td> <a href="{{route('items.receipts', $item->id)}}" target="_blank">{{$item->receipt_original.'.pdf'}}</a></td>
                            @else
                                <td>-</td>
                            @endif
                        @else
                            <td><a href="/receipts/{{$item->receipt}}" target="_blank">{{$item->receipt_original}}</a> </td>
                        @endif

                        <td><a class="btn btn-danger btn-sm" href="{{route('items.admin-update', ['item_id' => $item->id, 'status' => 'rejected'])}}">Removed</a></td>
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
