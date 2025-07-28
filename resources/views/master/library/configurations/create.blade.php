@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Add Configuration</h3>
    <form action="{{ route('master.library.configurations.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Series ID</label>
            <input type="number" name="series_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Series Type</label>
            <input type="text" name="series_type" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control">
        </div>
        <div class="mb-3">
            <label>Image (Filename only)</label>
            <input type="text" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
