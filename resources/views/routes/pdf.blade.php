<!DOCTYPE html>
<html>
<head>
    <title>Route Sheet</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { margin-bottom: 5px; }
        .stop { margin-bottom: 30px; }
        .divider { border-top: 1px solid #ccc; margin: 20px 0; }
        .small { font-size: 14px; color: #666; }
    </style>
</head>
<body>
  <h2>Truck: {{ $truck }} | Driver: {{ $driver ?? 'N/A' }} | Date: {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}</h2>


    @if (empty($stops))
        <p>No deliveries found for this truck and date.</p>
    @else
        @foreach ($stops as $stop)
            <div class="stop">
                <strong>{{ $stop['customer'] }}</strong><br>
                {{ $stop['address'] }}, {{ $stop['city'] }} {{ $stop['zip'] }}<br><br>

                <strong>Orders:</strong>
               <ul>
@foreach ($stop['order_numbers'] as $index => $order)
    @php
        $delivery = \App\Models\Delivery::where('order_number', $order)
                    ->where('truck_number', $truck)
                    ->whereDate('delivery_date', $date)
                    ->first();

        $commission = $delivery->commission ?? '—';
        $units = $delivery->units ?? '—';

        // Get carts if stored as comma string or list
        $carts = $delivery->carts ?? '—';
        if (is_string($carts)) {
            $carts = implode(', ', explode(',', $carts));
        } elseif (is_array($carts)) {
            $carts = implode(', ', $carts);
        }
    @endphp

    <li>
        {{ $order }} | P.O {{ $commission }} | Unit: {{ $units }} | Carts: {{ $carts }}
    </li>
@endforeach
</ul>


                <div class="small">
                    <strong>Delivery Time:</strong> ___________ <br>
                    <strong>Payment Method:</strong> ___________
                </div>
            </div>
            <div class="divider"></div>
        @endforeach
    @endif
<div class="small">
                    <strong>Start Time:</strong> ___________ <br>
                    <strong>Lunch Time:</strong> ___________ <br>
                    <strong>End Time:</strong> ___________
                </div>
    <p class="small">&copy; {{ now()->year }} Elite Vinyl Windows</p>
</body>
</html>
