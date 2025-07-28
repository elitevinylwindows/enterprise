@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Menu</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<section class="mt-4"> {{-- 👈 Add spacing here --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="card shadow-sm rounded">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Create Menu</h5>
                        <small class="text-muted">Add a new menu item</small>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('menu.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g. Dashboard" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Route</label>
                                    <input type="text" name="route" class="form-control" placeholder="e.g. dashboard.index">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Icon</label>
                                    <input type="text" name="icon" class="form-control" placeholder="e.g. fa-solid fa-user">
                                </div>
                                <div class="col-md-4">
                                    <label>Type</label>
                                    <select name="type" class="form-control" required>
                                        <option value="header">Header</option>
                                        <option value="menu" selected>Menu</option>
                                        <option value="submenu">Submenu</option>
                                        <option value="sub-submenu">Sub-Submenu</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Order</label>
                                    <input type="number" name="order" class="form-control" value="0">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Parent</label>
                                <select name="parent_id" class="form-control">
                                    <option value="">None</option>
                                    @foreach($menus as $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label>Roles</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($roles as $role)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}">
                                            <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Menu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
