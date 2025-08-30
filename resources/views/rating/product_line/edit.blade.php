{{-- resources/views/admin/nfrc/product_lines/edit.blade.php --}}
@extends('layouts.app')
@section('page-title','Edit Product Line')

@section('content')
<div class="card">
  <div class="card-header fw-semibold">Edit NFRC Product Line</div>
  <div class="card-body">
    <form method="POST" action="{{ route('rating.product-lines.update',$line) }}">
      @csrf @method('PUT')

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Window Type</label>
          <select name="window_type_id" class="form-select" required>
            @foreach($types as $t)
              <option value="{{ $t->id }}" @selected($line->window_type_id==$t->id)>{{ $t->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Manufacturer</label>
          <input type="text" name="manufacturer" value="{{ old('manufacturer',$line->manufacturer) }}" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Series / Model Number</label>
          <input type="text" name="series_model" value="{{ old('series_model',$line->series_model) }}" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Product Line</label>
          <input type="text" name="product_line" value="{{ old('product_line',$line->product_line) }}" class="form-control" required>
        </div>

        <div class="col-md-8">
          <label class="form-label">Product Line URL (optional)</label>
          <input type="url" name="product_line_url" value="{{ old('product_line_url',$line->product_line_url) }}" class="form-control">
        </div>
        <div class="col-md-4 d-flex align-items-center">
          <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" value="1" name="is_energy_star" id="es" @checked($line->is_energy_star)>
            <label class="form-check-label" for="es">Energy Star</label>
          </div>
        </div>
      </div>

      <div class="mt-3">
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('rating.product-lines.index') }}" class="btn btn-light">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
