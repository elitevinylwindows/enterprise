@extends('layouts.app')

@php
    $title = 'Manage Addons';
    $subTitle = 'View and manage all addon groups and fees.';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Addons</li>
@endsection

@section('card-action-btn')
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createAddonModal">
        <i class="ti ti-plus"></i> Add Addon
    </button>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Addon List</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Group Name</th>
                    <th>Option Label</th>
                    <th>Fee ($)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($addons as $addon)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $addon->group_name }}</td>
                        <td>{{ $addon->option_label }}</td>
                        <td>{{ number_format($addon->fee, 2) }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAddonModal{{ $addon->id }}">
                                Edit
                            </button>
                            <form method="POST" action="{{ route('addons.destroy', $addon->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editAddonModal{{ $addon->id }}" tabindex="-1" aria-labelledby="editAddonModalLabel{{ $addon->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('addons.update', $addon->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editAddonModalLabel{{ $addon->id }}">Edit Addon</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Group Name</label>
                                            <input type="text" name="group_name" class="form-control" value="{{ $addon->group_name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Option Label</label>
                                            <input type="text" name="option_label" class="form-control" value="{{ $addon->option_label }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Fee ($)</label>
                                            <input type="number" name="fee" class="form-control" value="{{ $addon->fee }}" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No addons found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createAddonModal" tabindex="-1" aria-labelledby="createAddonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('addons.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAddonModalLabel">Add New Addon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Group Name</label>
                        <input type="text" name="group_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Option Label</label>
                        <input type="text" name="option_label" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Fee ($)</label>
                        <input type="number" name="fee" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
