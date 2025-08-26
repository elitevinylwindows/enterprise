@extends('layouts.app')

@section('content')
<div class="container">
    <h1>PW Unit</h1>
    <a href="#" class="btn btn-primary customModal"
        data-size="lg"
        data-url="{{ route('sh-unit.import.modal') }}"
        data-title="{{ __('Import SH Unit') }}">
        <i data-feather="plus"></i> {{ __('Import') }}
    </a>
    <a href="{{ route('pw-unit.create') }}" class="btn btn-primary mb-3">Add New PW Unit</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Schema ID</th>
                <th>Product ID</th>
                <th>Product Code</th>
                <th>Retrofit</th>
                <th>Nailon</th>
                <th>Block</th>
                <th>LE3 CLR</th>
                <th>CLR CLR</th>
                <th>LE3 LAM</th>
                <th>CLR TEMP</th>
                <th>LE3 CLR LE3</th>
                <th>ONELE3 ONECLR TEMP</th>
                <th>STA GRD</th>
                <th>TPI</th>
                <th>TPO</th>
                <th>ACID EDGE</th>
                <th>SOLAR COOL</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->schema_id }}</td>
                    <td>{{ $unit->product_id }}</td>
                    <td>{{ $unit->product_code }}</td>
                    <td>{{ $item->retrofit }}</td>
                    <td>{{ $item->nailon }}</td>
                    <td>{{ $item->block }}</td>
                    <td>{{ $item->le3_clr }}</td>
                    <td>{{ $item->clr_clr }}</td>
                    <td>{{ $item->le3_lam }}</td>
                    <td>{{ $item->clr_temp }}</td>
                    <td>{{ $item->le3_clr_le3 }}</td>
                    <td>{{ $item->onele3_oneclr_temp }}</td>
                    <td>{{ $item->sta_grd }}</td>
                    <td>{{ $item->tpi }}</td>
                    <td>{{ $item->tpo }}</td>
                    <td>{{ $item->acid_edge }}</td>
                    <td>{{ $item->solar_cool }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        <a href="{{ route('pw-unit.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pw-unit.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
