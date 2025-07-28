@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Configuration</h3>
    <form action="{{ route('master.library.configurations.update', $configuration->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Series ID</label>
            <input type="number" name="series_id" class="form-control" value="{{ $configuration->series_id }}" required>
        </div>
        <div class="mb-3">
            <label>Series Type</label>
            <input type="text" name="series_type" class="form-control" value="{{ $configuration->series_type }}" required>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control" value="{{ $configuration->category }}">
        </div>
        <div class="mb-3">
            <label>Image (Filename only)</label>
            <input type="text" name="image" class="form-control" value="{{ $configuration->image }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
