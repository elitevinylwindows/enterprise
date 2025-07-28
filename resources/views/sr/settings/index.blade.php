@extends('layouts.app')

@section('page-title', 'Shipping Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Settings</a></li>
    <li class="breadcrumb-item active">Shipping</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card border shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Truncate Shipping Tables</h5>
                <small class="text-muted">This action will permanently delete all data from each table.</small>
            </div>
            <div class="card-body d-flex flex-column gap-3">

                <!-- Truncate Orders -->
                <form action="{{ route('settings.shipping.truncate', ['table' => 'orders']) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to truncate the Orders table? This cannot be undone.')">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">
                        Truncate Orders Table
                    </button>
                </form>

                <!-- Truncate CIMS -->
                <form action="{{ route('settings.shipping.truncate', ['table' => 'cims']) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to truncate the CIMS table? This cannot be undone.')">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">
                        Truncate CIMS Table
                    </button>
                </form>

                <!-- Truncate Deliveries -->
                <form action="{{ route('settings.shipping.truncate', ['table' => 'deliveries']) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to truncate the Deliveries table? This cannot be undone.')">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">
                        Truncate Deliveries Table
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
