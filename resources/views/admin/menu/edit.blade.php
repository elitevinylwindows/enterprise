@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Menu</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Edit Menu</h5>
                    <small class="text-muted">Update menu item details</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('menu.update', $menu->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Name</label>
                                <input type="text" name="name" value="{{ $menu->name }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Route</label>
                                <input type="text" name="route" value="{{ $menu->route }}" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Icon</label>
                                <input type="text" name="icon" value="{{ $menu->icon }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Type</label>
                                <select name="type" class="form-control">
                                    <option value="header" {{ $menu->type == 'header' ? 'selected' : '' }}>Header</option>
                                    <option value="menu" {{ $menu->type == 'menu' ? 'selected' : '' }}>Menu</option>
                                    <option value="submenu" {{ $menu->type == 'submenu' ? 'selected' : '' }}>Submenu</option>
                                    <option value="sub-submenu" {{ $menu->type == 'sub-submenu' ? 'selected' : '' }}>Sub-Submenu</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Order</label>
                                <input type="number" name="order" value="{{ $menu->order }}" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Parent</label>
                            <select name="parent_id" class="form-control">
                                <option value="">None</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ $menu->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label>Roles</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($roles as $role)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}" {{ in_array($role->name, json_decode($menu->roles ?? '[]')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Menu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
