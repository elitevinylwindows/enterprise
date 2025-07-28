@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New PW Unit</h1>
    <form action="{{ route('pw-unit.store') }}" method="POST">
        @csrf
        @include('schemas.pwunit.form')
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
