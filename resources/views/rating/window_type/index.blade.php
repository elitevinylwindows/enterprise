@extends('layouts.app')
@section('page-title','NFRC Window Types')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">NFRC Window Types</h4>
  <a href="{{ route('rating.window-types.create') }}" class="btn btn-primary">New Type</a>
</div>

<form class="row g-2 mb-3">
  <div class="col-md-4">
    <input type="text" name="s" class="form-control" placeholder="Search name or slug…" value="{{ $s ?? '' }}">
  </div>
  <div class="col-md-auto">
    <button class="btn btn-outline-secondary">Search</button>
  </div>
</form>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped align-middle mb-0">
      <thead class="table-dark">
        <tr>
          <th>Name</th>
          <th>Slug</th>
          <th style="width:130px" class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($types as $t)
          <tr>
            <td>{{ $t->name }}</td>
            <td class="text-muted">{{ $t->slug }}</td>
            <td class="text-end">
              <a href="{{ route('rating.window-types.edit',$t) }}" class="btn btn-sm btn-outline-primary">Edit</a>
              <form action="{{ route('rating.window-types.destroy',$t) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this type?');">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="text-center text-muted">No types.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">{{ $types->links() }}</div>
@endsection
