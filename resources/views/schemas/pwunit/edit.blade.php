@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit PW Unit</h1>
    <form action="{{ route('pw-unit.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('schemas.pwunit.form')
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
