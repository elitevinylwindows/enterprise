@extends('layouts.app')
@section('page-title')
    {{ __('Cart Allocation') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Carts') }}</li>
@endsection

@section('card-action-btn')
    @if (Gate::check('manage carts'))
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#startScanModal">
                    <i class="ti ti-scan"></i> {{ __('Start Scanning') }}
                </button>
            @endif
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card table-card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th></th> <!-- Toggle column -->
                            <th>Cart Number</th>
                            <th>Order #</th>
                            <th>Customer Name</th>
                            <th>Barcode</th>
                            <th>Width</th>
                            <th>Height</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($carts as $cartBarcode => $items)
                            @php $firstItem = $items->first(); @endphp
                            <tr data-bs-toggle="collapse" data-bs-target="#cart-{{ $loop->index }}" aria-expanded="false" class="cursor-pointer">
                                <td class="text-center align-middle">
                                    <i class="ti ti-plus"></i>
                                </td>
                                <td>{{ $firstItem->cart_barcode }}</td>
                                <td>{{ $firstItem->order_number }}</td>
                                <td>{{ $firstItem->customer_short_name }}</td>
                                <td>{{ $firstItem->production_barcode }}</td>
                                <td>{{ $firstItem->width }}</td>
                                <td>{{ $firstItem->height }}</td>
                                <td>{{ $firstItem->comment }}</td>
                                <td>
                                    <a href="#"
                                        class="btn btn-sm btn-primary edit-cart-btn"
                                        data-cart-barcode="{{ $firstItem->cart_barcode }}"
                                        data-items='@json($items)'
                                        data-update-url="{{ route('cart.update', ['cart_barcode' => $firstItem->cart_barcode]) }}">
                                        Edit
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger delete-cart-btn">Delete</a>
                                </td>
                            </tr>
                            <tr class="collapse bg-light" id="cart-{{ $loop->index }}">
                                <td colspan="9">
                                    <strong>Items in this Cart:</strong>
                                    <table class="table table-sm table-bordered mt-2">
                                        <thead>
                                            <tr>
                                                <th>Barcode</th>
                                                <th>Description</th>
                                                <th>Width</th>
                                                <th>Height</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $item)
                                                <tr>
                                                    <td>{{ $item->production_barcode }}</td>
                                                    <td>{{ $item->description }}</td>
                                                    <td>{{ $item->width }}</td>
                                                    <td>{{ $item->height }}</td>
                                                    <td>{{ $item->comment }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No carts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('cart._scan_modal')
@include('cart._edit_modal')

@endsection


@push('scripts')
<script>
    document.querySelectorAll('.edit-cart-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const cartBarcode = this.getAttribute('data-cart-barcode');
            const items = JSON.parse(this.getAttribute('data-items'));
            const actionUrl = this.getAttribute('data-update-url');

            openEditModal(cartBarcode, items, actionUrl);
        });
    });
</script>
@endpush
