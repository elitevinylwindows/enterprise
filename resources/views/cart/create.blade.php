@extends('layouts.app')
@section('page-title', 'Add to Cart')
@section('content')
    <div class="card">
        <div class="card-header"><h5>Scan and Add Items to Cart</h5></div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Cart Barcode</label>
                    <input type="text" name="cart_barcode" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Item Barcode</label>
                    <input type="text" name="item_barcode" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Order #</label>
                    <input type="text" name="order_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Width</label>
                    <input type="text" name="width" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Height</label>
                    <input type="text" name="height" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Customer ID</label>
                    <input type="text" name="customer_id" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Customer Name</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Comment</label>
                    <input type="text" name="comment" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Add Item</button>
            </form>
        </div>
    </div>
@endsection
