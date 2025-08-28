{{-- resources/views/admin/nfrc/window_types/create.blade.php --}}
@extends('layouts.app')
@section('page-title','New Window Type')

@section('content')
<div class="card">
  <div class="card-header fw-semibold">Create NFRC Window Type</div>
  <div class="card-body">
    <form method="POST" action="{{ route('rating.window-type.store') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control" required>
        <div class="form-text">Lowercase, hyphenated key (e.g., <code>casement</code>).</div>
      </div>
      <button class="btn btn-primary">Save</button>
      <a href="{{ route('rating.window-type.index') }}" class="btn btn-light">Cancel</a>
    </form>
  </div>
</div>
@endsection
