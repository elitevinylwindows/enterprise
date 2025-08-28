{{-- resources/views/admin/nfrc/product_lines/index.blade.php --}}
@extends('layouts.app')
@section('page-title','NFRC Product Lines')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">NFRC Product Lines</h4>
  <a href="{{ route('admin.nfrc.product-lines.create') }}" class="btn btn-primary">New Product Line</a>
</div>

<form class="row g-2 mb-3">
  <div class="col-md-4">
    <select name="type_id" class="form-select" onchange="this.form.submit()">
      <option value="">— Filter by Window Type —</option>
      @foreach($types as $t)
        <option value="{{ $t->id }}" @selected($typeId==$t->id)>{{ $t->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-4">
    <input type="text" name="s" class="form-control" placeholder="Search manufacturer / series / product line…" value="{{ $s ?? '' }}">
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
          <th>Type</th>
          <th>Manufacturer</th>
          <th>Series/Model</th>
          <th>Product Line</th>
          <th>Energy Star</th>
          <th style="width:130px" class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($lines as $l)
          <tr>
            <td class="small text-muted">{{ $l->type?->name }}</td>
            <td>{{ $l->manufacturer }}</td>
            <td>{{ $l->series_model }}</td>
            <td>
              @if($l->product_line_url)
                <a href="{{ $l->product_line_url }}" target="_blank" rel="noopener">{{ $l->product_line }}</a>
              @else
                {{ $l->product_line }}
              @endif
            </td>
            <td>{!! $l->is_energy_star ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' !!}</td>
            <td class="text-end">
              <a href="{{ route('admin.nfrc.product-lines.edit',$l) }}" class="btn btn-sm btn-outline-primary">Edit</a>
              <form action="{{ route('admin.nfrc.product-lines.destroy',$l) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this product line?');">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted">No product lines.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">{{ $lines->links() }}</div>
@endsection
