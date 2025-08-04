@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <div class="alert alert-success">
        <h4 class="mb-3">Thank you!</h4>
        <p>{{ $message ?? 'Your response has been recorded successfully.' }}</p>
    </div>
</div>
@endsection
