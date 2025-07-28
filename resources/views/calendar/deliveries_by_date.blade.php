@extends('layouts.app')


@section('page-title')
    Deliveries on {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('calendar.index') }}">Calendar</a></li>
    <li class="breadcrumb-item active">{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</li>
@endsection

@section('content')
 <div class="row">
        <div class="col-sm-12">
<div class="card">
    <div class="card-body">
        <h5>{{ count($deliveries) }} Deliveries</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                     <th>City</th>
                     <th>Time Frame</th>
                     <th>Delivery Date</th>
                    <th>Comment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deliveries as $delivery)
                    <tr>
                        <td>{{ $delivery->order_number }}</td>
                        <td>{{ $delivery->customer_name }}</td>
                        <td>{{ $delivery->address }}</td>
                        <td>{{ $delivery->city }}</td>
                        <td>{{ $delivery->timeframe }}</td>
                        <td>{{ $delivery->delivery_date }}</td>
                        <td>{{ $delivery->comment }}</td>
                        <td>{{ $delivery->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    </div>
</div>
@endsection

