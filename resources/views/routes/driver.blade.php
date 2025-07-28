@extends('layouts.app')

@section('page-title', 'My Route')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">My Route</li>
@endsection

@section('content')
<div class="container">
    @forelse($routes as $route)
        <div class="row mt-4">
            <div class="col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header text-white" style="background-color: #A80000;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Truck: {{ $route['truck_number'] }}</strong><br>
                                Driver: {{ $route['driver'] ?? 'N/A' }}
                                
                            </div>
                             <a href="{{ route('routes.pdf', ['truck' => $route['truck_number'], 'date' => $date]) }}"
                                           class="btn btn-sm btn-white text-white"
                                           target="_blank" title="Show Route PDF">
                                            <i data-feather="eye"></i>
                                        </a>
                            <a href="#" class="btn btn-sm btn-outline-light text-white"
                           onclick='openGoogleRoute("{{ addslashes($warehouseAddress) }}", {!! json_encode(array_map(fn($s) => $s["address"] . ", " . $s["city"], $route["stops"])) !!})'>
                            Start Route
                        </a>
                        </div>
                    </div>

                    <div class="card-body overflow-auto" style="max-height: 350px;">
                        <ol class="list-group list-group-numbered">
                            <li class="list-group-item static-stop">Base: {{ $warehouseAddress }}</li>

                            @foreach ($route['stops'] as $stop)
                                @php
                                    $idsKey = implode('-', $stop['ids']);
                                @endphp
                                <li class="list-group-item" data-ids="{{ implode(',', $stop['ids']) }}">
                                    <div class="fw-bold mb-2">
                                        {{ $stop['label'] ?? $loop->iteration }} - {{ $stop['customer'] }}
                                    </div>

                                    <div>
                                        {{ $stop['address'] }}, {{ $stop['city'] }}<br>
                                        {{ $stop['contact'] ?? '' }}<br>
                                        Orders: {{ $stop['order'] ?? 'N/A' }}<br>
                                        <span class="badge stop-status"
                                              id="status-badge-{{ $idsKey }}"
                                              style="background-color: {{ ($stop['status'] ?? 'pending') === 'delivered' ? '#198754' : (($stop['status'] ?? 'pending') === 'cancelled' ? '#dc3545' : '#0dcaf0') }}">
                                            {{ ucfirst($stop['status'] ?? 'Pending') }}
                                        </span>
                                    </div>

                                    <div class="d-flex mt-2 align-items-center gap-2">
                                        <a href="https://www.google.com/maps/dir/?api=1&origin={{ urlencode($warehouseAddress) }}&destination={{ urlencode($stop['address']) }}"
                                           target="_blank" class="btn btn-sm text-white" style="background-color:#A80000;">Go</a>

                                        @if($stop['contact'])
                                            <a href="tel:{{ $stop['contact'] }}" class="btn btn-sm text-white" style="background-color:#A80000;" title="Call">
                                                <i class="ti ti-phone"></i>
                                            </a>
                                        @endif

                                        <button type="button" class="btn btn-sm btn-secondary open-status" data-stop="{{ $idsKey }}">
                                            Update Status
                                        </button>
                                    </div>



                                    {{-- Status Options --}}
                                    <div class="status-options mt-3 d-none" id="status-panel-{{ $idsKey }}">
                                        <p class="fw-bold">Mark Status:</p>
                                        <button class="btn btn-sm btn-success delivered-btn" data-stop="{{ $idsKey }}">Delivered</button>
                                        <button class="btn btn-sm btn-danger cancelled-btn" data-stop="{{ $idsKey }}">Cancelled</button>

                                        <div class="delivered-form d-none mt-2" id="delivered-form-{{ $idsKey }}">
                                            <label class="me-2"><input type="radio" name="payment_method_{{ $idsKey }}" value="cash"> Cash</label>
                                            <label class="me-2"><input type="radio" name="payment_method_{{ $idsKey }}" value="check"> Check</label>
                                            <label class="me-2"><input type="radio" name="payment_method_{{ $idsKey }}" value="card"> Card</label>
                                            <label class="me-2"><input type="radio" name="payment_method_{{ $idsKey }}" value="transfer"> Transfer</label>

                                            <input type="number" class="form-control mt-2 d-none" placeholder="Amount" id="amount-{{ $idsKey }}">
                                            <textarea class="form-control mt-2" placeholder="Delivery Note" id="delivery-note-{{ $idsKey }}"></textarea>
                                            <button class="btn btn-sm btn-primary mt-2 submit-delivery" data-stop="{{ $idsKey }}">Submit</button>
                                        </div>

                                        <div class="cancelled-form d-none mt-2" id="cancelled-form-{{ $idsKey }}">
                                            <textarea class="form-control" placeholder="Cancellation Note" id="cancel-note-{{ $idsKey }}"></textarea>
                                            <button class="btn btn-sm btn-danger mt-2 submit-cancelled" data-stop="{{ $idsKey }}">Submit</button>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                            <li class="list-group-item">Return: {{ $warehouseAddress }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No assigned routes for you.</div>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle panel
    document.querySelectorAll('.open-status').forEach(btn => {
        btn.addEventListener('click', function () {
            const stopId = this.dataset.stop;
            document.getElementById(`status-panel-${stopId}`).classList.toggle('d-none');
        });
    });

    // Show Delivered form
    document.querySelectorAll('.delivered-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const stopId = this.dataset.stop;
            document.getElementById(`delivered-form-${stopId}`).classList.remove('d-none');
            document.getElementById(`cancelled-form-${stopId}`).classList.add('d-none');
        });
    });

    // Show Cancelled form
    document.querySelectorAll('.cancelled-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const stopId = this.dataset.stop;
            document.getElementById(`cancelled-form-${stopId}`).classList.remove('d-none');
            document.getElementById(`delivered-form-${stopId}`).classList.add('d-none');
        });
    });

    // Handle Delivered Submit
   // Handle Delivered Submit
document.querySelectorAll('.submit-delivery').forEach(btn => {
    btn.addEventListener('click', function () {
        const stopId = this.dataset.stop;
        const ids = stopId.split('-');
        const method = document.querySelector(`input[name="payment_method_${stopId}"]:checked`);
        const amount = document.getElementById(`amount-${stopId}`).value;
        const note = document.getElementById(`delivery-note-${stopId}`).value; // fixed line

        if (!method) return alert('Select a payment method.');
        if (['cash', 'check'].includes(method.value) && (!amount || isNaN(amount))) {
            return alert('Enter a valid amount.');
        }

        fetch(`{{ route('route.updateStatus') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                stop_id: ids,
                status: 'delivered',
                payment_status: 'paid',
                payment_method: method.value,
                payment_amount: amount,
                note: note,
            })
        }).then(res => res.ok ? res.json() : Promise.reject())
          .then(() => {
              const badge = document.getElementById(`status-badge-${stopId}`);
              badge.textContent = 'Delivered';
              badge.className = 'badge bg-success stop-status';
              document.getElementById(`status-panel-${stopId}`).classList.add('d-none');
              toastr.success('Marked as Delivered');
          }).catch(() => toastr.error('Failed to update'));
    });
});


    // Handle Cancelled Submit
    document.querySelectorAll('.submit-cancelled').forEach(btn => {
        btn.addEventListener('click', function () {
            const stopId = this.dataset.stop;
            const ids = stopId.split('-');
            const note = document.getElementById(`cancel-note-${stopId}`).value;

            if (!note.trim()) return alert('Enter a cancellation note.');

            fetch(`{{ route('route.updateStatus') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    stop_id: ids,
                    status: 'cancelled',
                    note: note,
                })
            }).then(res => res.ok ? res.json() : Promise.reject())
              .then(() => {
                  const badge = document.getElementById(`status-badge-${stopId}`);
                  badge.textContent = 'Cancelled';
                  badge.className = 'badge bg-danger stop-status';
                  document.getElementById(`status-panel-${stopId}`).classList.add('d-none');
                  toastr.warning('Marked as Cancelled');
              }).catch(() => toastr.error('Failed to update'));
        });
    });

    // Show amount if cash/check is selected
    document.querySelectorAll('input[type=radio][name^="payment_method_"]').forEach(radio => {
        radio.addEventListener('change', function () {
            const stopId = this.name.replace('payment_method_', '');
            const method = this.value;
            const amountInput = document.getElementById(`amount-${stopId}`);

            if (['cash', 'check'].includes(method)) {
                amountInput.classList.remove('d-none');
            } else {
                amountInput.classList.add('d-none');
                amountInput.value = '';
            }
        });
    });
});
function openGoogleRoute(origin, stops) {
    if (!Array.isArray(stops) || stops.length === 0) return;

    let baseUrl = "https://www.google.com/maps/dir/?api=1";
    let destination = encodeURIComponent(origin); // Return to warehouse
    let allStops = [...stops, origin]; // Include return in stops

    let waypoints = allStops.map(encodeURIComponent).join('|');

    let url = `${baseUrl}&origin=${encodeURIComponent(origin)}&destination=${destination}&travelmode=driving&waypoints=${waypoints}`;

    window.open(url, '_blank');
}


</script>
@endpush
