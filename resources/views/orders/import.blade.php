@extends('layouts.app')
@section('page-title', 'Import Orders')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Import Orders</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('orders.handleImport') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Choose CSV or Excel File</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <div class="form-group mt-3">
                <button class="btn btn-primary" type="submit">Upload</button>
            </div>
        </form>
    </div>
</div>
@endsection
