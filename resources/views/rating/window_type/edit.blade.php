{{-- resources/views/admin/nfrc/window_types/edit.blade.php --}}
@extends('layouts.app')
@section('page-title','Edit Window Type')

@section('content')
<div class="card">
  <div class="card-header fw-semibold">Edit NFRC Window Type</div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.nfrc.window-types.update',$type) }}">
      @csrf @method('PUT')
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" value="{{ old('name',$type->name) }}" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" value="{{ old('slug',$type->slug) }}" class="form-control" required>
      </div>
      <button class="btn btn-primary">Update</button>
      <a href="{{ route('admin.nfrc.window-types.index') }}" class="btn btn-light">Cancel</a>
    </form>
  </div>
</div>
@endsection
