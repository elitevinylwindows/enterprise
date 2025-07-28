@extends('layouts.app')

@section('page-title', 'Confirm Import')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>The following orders already exist:</h5>
            <ul>
                @foreach ($duplicates as $orderNumber)
                    <li>Order #{{ $orderNumber }}</li>
                @endforeach
            </ul>

            <form method="POST" action="{{ route('orders.import') }}">
                @csrf
                <input type="hidden" name="action_type" value="skip">
                <input type="hidden" name="import_file" value="{{ $originalFile }}">
                <button type="submit" class="btn btn-warning">Skip Existing</button>
            </form>

            <form method="POST" action="{{ route('orders.import') }}" class="mt-2">
                @csrf
                <input type="hidden" name="action_type" value="overwrite">
                <input type="hidden" name="import_file" value="{{ $originalFile }}">
                <button type="submit" class="btn btn-danger">Overwrite Existing</button>
            </form>
        </div>
    </div>
@endsection
