{{-- resources/views/admin/nfrc/product_lines/create.blade.php --}}
@extends('layouts.app')
@section('page-title','New Product Line')

@section('content')
<div class="card">
  <div class="card-header fw-semibold">Create NFRC Product Line</div>
  <div class="card-body">
    <form method="POST" action="{{ route('rating.product-line.store') }}">
      @csrf

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Window Type</label>
          <select name="window_type_id" class="form-select" required>
            <option value="">— Select Type —</option>
            @foreach($types as $t)
              <option value="{{ $t->id }}">{{ $t->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Manufacturer</label>
          <input type="text" name="manufacturer" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Series / Model Number</label>
          <input type="text" name="series_model" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Product Line</label>
          <input type="text" name="product_line" class="form-control" required>
        </div>

        <div class="col-md-8">
          <label class="form-label">Product Line URL (optional)</label>
          <input type="url" name="product_line_url" class="form-control" placeholder="https://…">
        </div>
        <div class="col-md-4 d-flex align-items-center">
          <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" value="1" name="is_energy_star" id="es">
            <label class="form-check-label" for="es">Energy Star</label>
          </div>
        </div>
      </div>

      <div class="mt-3">
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('rating.product-line.index') }}" class="btn btn-light">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
