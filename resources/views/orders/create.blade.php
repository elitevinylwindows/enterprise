@extends('layouts.app')

@section('page-title', 'Add New Order')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Add New Order</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="order_number" class="form-label">Order Number</label>
                    <input type="text" name="order_number" id="order_number" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="product" class="form-label">Product</label>
                    <input type="text" name="product" id="product" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Order</button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
