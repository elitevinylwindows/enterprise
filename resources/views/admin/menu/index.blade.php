@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">All Menus</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Menu List</h5>
                    <small class="text-muted">Manage your sidebar navigation</small>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Route</th>
                                <th>Type</th>
                                <th>Order</th>
                                <th>Parent</th>
                                <th>Roles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menus as $menu)
                                <tr>
                                    <td>{{ $menu->name }}</td>
                                    <td>{{ $menu->route }}</td>
                                    <td>{{ ucfirst($menu->type) }}</td>
                                    <td>{{ $menu->order }}</td>
                                    <td>{{ optional($menu->parent)->name ?? '—' }}</td>
                                    <td>
                                        @foreach(json_decode($menu->roles ?? '[]') as $role)
                                            <span class="badge bg-secondary">{{ $role }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No menu items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
