@extends('layouts.app')

@section('page-title', 'Reorder Menus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Menu</a></li>
    <li class="breadcrumb-item active">Reorder</li>
@endsection

@push('styles')
<style>
    .menu-column {
        min-height: 400px;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 6px;
        border: 1px solid #dee2e6;
        margin-bottom: 20px;
    }
    .menu-card {
        padding: 10px;
        margin-bottom: 10px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: move;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .menu-card i {
        font-size: 1.2rem;
    }
    .ui-state-highlight {
        height: 45px;
        background: #e2e6ea;
        border: 2px dashed #6c757d;
        margin-bottom: 10px;
        border-radius: 5px;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="menu-column" id="available-menu">
            <h5>Available Menu Items</h5>
            @foreach($availableMenus as $menu)
                <div class="menu-card" data-id="{{ $menu->id }}" data-icon="{{ $menu->icon }}" data-name="{{ $menu->name }}">
                    <i class="{{ $menu->icon }}"></i> {{ $menu->name }}
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-4">
        <div class="menu-column" id="left-menu">
            <h5>Left Menu</h5>
            @foreach($orderedMenus as $menu)
                <div class="menu-card" data-id="{{ $menu->id }}" data-icon="{{ $menu->icon }}" data-name="{{ $menu->name }}">
                    <i class="{{ $menu->icon }}"></i> {{ $menu->name }}
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-4">
        <div class="menu-column" id="preview-sidebar">
            <h5>Preview</h5>
            @foreach($orderedMenus as $menu)
                <div class="menu-card">
                    <i class="{{ $menu->icon }}"></i> {{ $menu->name }}
                </div>
            @endforeach
        </div>
    </div>
</div>
<form action="{{ route('menu.reorder.save') }}" method="POST" class="mt-4">
    @csrf
    <input type="hidden" name="menu_structure" id="menu-structure">
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Save Order</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
$(function () {
    $(".menu-column").sortable({
        connectWith: ".menu-column",
        placeholder: "ui-state-highlight",
        forcePlaceholderSize: true,
        tolerance: "pointer",
        update: function () {
            const items = $("#left-menu .menu-card").map(function () {
                return {
                    id: $(this).data("id"),
                    name: $(this).data("name"),
                    icon: $(this).data("icon")
                };
            }).get();

            $("#menu-structure").val(JSON.stringify(items));

            let previewHtml = '';
            items.forEach(function(item) {
                previewHtml += `<div class="menu-card"><i class="${item.icon}"></i> ${item.name}</div>`;
            });
            $('#preview-sidebar').html(previewHtml);
        }
    }).disableSelection();

    $("#left-menu").trigger("sortupdate");
});
</script>
@endpush
