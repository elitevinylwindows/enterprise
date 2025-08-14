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
            color: #000000;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #000000;
        }

        .company-logo {
            width: 150px;
            height: auto;
        }

        .company-info {
            text-align: right;
        }

        .order-title {
            color: #000000;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .order-meta {
            display: flex;
            flex-wrap: wrap;
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
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #000000;
        }

        .address-box.delivery {
            border-left-color: #000000;
        }

        .section-title {
            font-size: 16px;
            color: #000000;
            margin-bottom: 10px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 2px 0;
        }

        th {
            background-color: #000000;
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
   <table width="100%" style="border-bottom: 2px solid #2c3e50; padding-bottom: 0px; margin-bottom: 0px;">
        <tr>
            <td style="vertical-align: top; padding-right: 0px;">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAG4AAAAoCAYAAAAfWs+KAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAEumlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSfvu78nIGlkPSdXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQnPz4KPHg6eG1wbWV0YSB4bWxuczp4PSdhZG9iZTpuczptZXRhLyc+CjxyZGY6UkRGIHhtbG5zOnJkZj0naHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyc+CgogPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9JycKICB4bWxuczpBdHRyaWI9J2h0dHA6Ly9ucy5hdHRyaWJ1dGlvbi5jb20vYWRzLzEuMC8nPgogIDxBdHRyaWI6QWRzPgogICA8cmRmOlNlcT4KICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0nUmVzb3VyY2UnPgogICAgIDxBdHRyaWI6Q3JlYXRlZD4yMDI1LTA1LTIxPC9BdHRyaWI6Q3JlYXRlZD4KICAgICA8QXR0cmliOkV4dElkPmJlMDczZWNhLTdkNmMtNGNlYi1hMDE4LTA1NGZkMTY3ODJmZDwvQXR0cmliOkV4dElkPgogICAgIDxBdHRyaWI6RmJJZD41MjUyNjU5MTQxNzk1ODA8L0F0dHJpYjpGYklkPgogICAgIDxBdHRyaWI6VG91Y2hUeXBlPjI8L0F0dHJpYjpUb3VjaFR5cGU+CiAgICA8L3JkZjpsaT4KICAgPC9yZGY6U2VxPgogIDwvQXR0cmliOkFkcz4KIDwvcmRmOkRlc2NyaXB0aW9uPgoKIDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PScnCiAgeG1sbnM6ZGM9J2h0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvJz4KICA8ZGM6dGl0bGU+CiAgIDxyZGY6QWx0PgogICAgPHJkZjpsaSB4bWw6bGFuZz0neC1kZWZhdWx0Jz5FbGl0ZSBTdGl0Y2ggKDExMCB4IDQwIHB4KSAtIDc8L3JkZjpsaT4KICAgPC9yZGY6QWx0PgogIDwvZGM6dGl0bGU+CiA8L3JkZjpEZXNjcmlwdGlvbj4KCiA8cmRm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" alt="Elite Vinyl Windows Logo" style="height: 80px;">
            </td>
            <td style="vertical-align: top; font-size: 12px; line-height: 1.4;">
                <strong>Elite Vinyl Windows Inc.</strong><br>
                4231 Liberty Blvd.<br>
                South Gate CA 90280<br>
                Tel: 562-945-7700<br>
                Fax: 562-945-5900<br>
                www.elitevinylwindows.com
            </td>
            <td style="vertical-align: top; text-align: left; font-size: 12px; line-height: 1.4; margin-left:20%">
                <div style="font-size: 14px; font-weight: bold;">
                    Quotation# <span style="text-decoration: underline;">{{ $order->quote->quote_number ?? '-' }}</span>
                </div>
                Commercial Order#: {{ $order->commercial_order ?? '' }}<br>
                Internal Order#: {{ $order->internal_order ?? '' }}<br>
                Sales Person: {{ $order->sales_person ?? '' }}<br>
                Direct Line: {{ $order->direct_line ?? '' }}<br>
                PO#: {{ $order->po_number ?? '' }}<br>
                Due/Delivery Date: {{ $order->due_date ?? '' }}
            </td>
        </tr>
    </table>

    
    <table class="">
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

        <table>
            <tr>
                <td class="col-6">
                    <div class="meta-item">
                        <strong>Order Summary:</strong><br>
                        Note: {{ $order->internal_notes ?? '-' }}
                    </div>
                </td>
            </tr>
        </table>

    <table>
        <thead>
            <tr>
                <th>Line</th>
                <th>Unit</th>
                <th>Size</th>
                <th>Frame Type</th>
                <th>Color</th>
                <th>Glass</th>
                <th>Grid</th>
                <th>Pattern</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->series?->series.'-'.$item->series_type ?? 'N/A' }}</td>
                <td>W {{ $item->width }}" x H {{ $item->height }}"</td>
                <td>{{ $item->frame_type . ' ' . $item->fin_type }}</td>
                <td>{{ $item->color_config ?? 'N/A' }}</td>
                <td>{{ $item->glass ?? 'N/A' }}</td>
                <td>{{ $item->grid ?? 'N/A' }}</td>
                <td>{{ $item->grid_pattern ?? 'N/A' }}</td>
                <td>{{ $item->qty }}</td>
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
