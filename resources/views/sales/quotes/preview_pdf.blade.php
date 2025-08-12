<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Order #{{ $order->order_number }}</title>
    <style>
        @page {
            margin: 0.5cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #2c3e50;
        }

        .company-logo {
            width: 150px;
            height: auto;
        }

        .company-info {
            text-align: right;
        }

        .order-title {
            color: #2c3e50;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .order-meta {
            display: flex;
            flex-wrap: wrap;
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .meta-item {
            flex: 0 0 33.33%;
            margin-bottom: 8px;
        }

        .address-section {
            display: flex;
            margin: 25px 0;
        }

        .address-box {
            flex: 1;
            padding: 15px;
            margin: 0 10px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }

        .address-box.delivery {
            border-left-color: #2ecc71;
        }

        .section-title {
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }

        th {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .totals-table {
            width: 50%;
            margin-left: auto;
        }

        .totals-table td:last-child {
            text-align: right;
            font-weight: bold;
        }

        .grand-total {
            font-size: 16px;
            color: #2c3e50;
        }

        .notes {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-style: italic;
            color: #7f8c8d;
        }

        .highlight {
            color: #e74c3c;
            font-weight: bold;
        }

    </style>
</head>
<body>
   <table width="100%" style="margin-bottom: 20px; border-bottom: 2px solid #2c3e50;">
    <tr>
        <td width="50%" style="vertical-align: top;">
            <div style="font-size: 24px; font-weight: bold; color: #2c3e50; margin-bottom: 5px;">
                Order #{{ $order->order_number }}
            </div>
            <div>
                Date: {{ date('F j, Y') }}
            </div>
        </td>
        <td width="50%" style="vertical-align: top; text-align: right;">
            <div style="line-height: 1.6;">
                <strong>Elite Vinyl Windows</strong><br>
                4231 Liberty Blvd, CA 90280<br>
                Tel: (562) 945-7700 | Fax: (562) 800-7064<br>
                www.elitevinylwindows.com
            </div>
        </td>
    </tr>
</table>

    <div class="order-meta">
        <table>
            <tr>
                <td class="col-6">
                    <div class="meta-item">
                        <strong>Quotation #:</strong><br>
                        {{ $order->quote->quote_number ?? '-' }}
                    </div>
                </td>
                <td class="col-6">
                    <div class="meta-item">
                        <strong>Invoice #:</strong><br>
                        {{ $order->invoice->invoice_number ?? '-' }}
                    </div>
                </td>
                <td class="col-6">
                    <div class="meta-item">
                        <strong>Sales Agent:</strong><br>
                        {{ $order->customer->customer_name ?? '-' }}
                    </div>
                </td>
                <td class="col-6">
                    <div class="meta-item">
                        <strong>Direct Extension:</strong><br>
                        {{ $order->quote->user->phone_extension ?? '-' }}
                    </div>
                </td>
                <td class="col-6">
                    <div class="meta-item">
                        <strong>Delivery Date:</strong><br>
                        <span class="highlight">{{ $order->due_date ?? '-' }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table class="table-layout">
        <tr>
            <td class="col-6">
                <div class="address-box">
                    <div class="section-title">Billing Address</div>
                    {{ $order->customer->billing_address ?? $order->customer->billing_address }}<br>
                    {{ $order->customer->billing_city ?? $order->customer->billing_city }},
                    {{ $order->customer->billing_state ?? $order->customer->billing_state }}
                    {{ $order->customer->billing_zip ?? $order->customer->billing_zip }}<br>
                    {{ $order->customer->billing_phone }}
                </div>
            </td>
            <td class="col-6">
                <div class="address-box delivery">
                    <div class="section-title ">Delivery Address</div>
                    {{ $order->customer->delivery_address ?? $order->customer->delivery_address }}<br>
                    {{ $order->customer->delivery_city ?? $order->customer->delivery_city }},
                    {{ $order->customer->delivery_state ?? $order->customer->delivery_state }}
                    {{ $order->customer->delivery_zip ?? $order->customer->delivery_zip }}<br>
                    {{ $order->customer->delivery_phone }}
                </div>
            </td>
        </tr>
    </table>

    @if($order->quote->notes ?? false)
    <div class="notes">
        <div class="section-title">Order Notes</div>
        {{ $order->quote->notes }}
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Size</th>
                <th>Glass</th>
                <th>Grid</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->description ?? 'N/A' }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->width }}" x {{ $item->height }}"</td>
                <td>{{ $item->glass ?? 'N/A' }}</td>
                <td>{{ $item->grid ?? 'N/A' }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>${{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td>Subtotal:</td>
            <td>${{ number_format($order->items->sum('total'), 2) }}</td>
        </tr>
        <tr>
            <td>Discount:</td>
            <td>-${{ number_format($order->discount, 2) }}</td>
        </tr>
        <tr>
            <td>Shipping:</td>
            <td>${{ number_format($order->shipping, 2) }}</td>
        </tr>
        <tr>
            <td>Tax:</td>
            <td>${{ number_format($order->tax, 2) }}</td>
        </tr>
        <tr class="grand-total">
            <td>Total:</td>
            <td>${{ number_format(($order->items->sum('total') - $order->discount) + $order->shipping + $order->tax, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        Thank you for your business. Please contact us if you have any questions about this order.<br>
        Elite Vinyl Windows | (562) 945-7700 | info@elitevinylwindows.com
    </div>
</body>
</html>
