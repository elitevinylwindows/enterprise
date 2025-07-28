@extends('layouts.app')

@section('page-title')
    Raffle Draw
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Raffle Draw</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-2 mb-4">
        <form action="{{ route('executives.raffle.start') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary w-100">🎉 Start Raffle</button>
        </form>
    </div>
    <div class="col-md-2 mb-4">
        <form action="{{ route('executives.raffle.reset') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary w-100">♻️ Reset</button>
        </form>
    </div>
</div>

@if(session('raffle_winner'))
    @php $winner = session('raffle_winner'); @endphp

    <div class="card border-success">
        <div class="card-header bg-success text-white">
            🎊 Raffle Winner
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $winner->name }}</h5>
            <p class="card-text">
                <strong>Customer #:</strong> {{ $winner->customer_number ?? '—' }}<br>
                <strong>Tier:</strong> {{ $winner->tier ?? '—' }}<br>
                <strong>Total Spent:</strong> ${{ number_format($winner->total_spent ?? 0, 2) }}
            </p>
        </div>
    </div>
@endif
@endsection
