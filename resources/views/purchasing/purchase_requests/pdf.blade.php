<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Request - {{ $request->purchase_request_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 14px;
        }

        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .info-table, .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px 10px;
        }

        .item-table th, .item-table td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        .item-table th {
            background-color: #f0f0f0;
        }

        .total-row td {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">Purchase Request</div>
        <div>Request ID: <strong>{{ $request->purchase_request_id }}</strong></div>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Requested By:</strong> {{ $request->requested_by }}</td>
            <td><strong>Department:</strong> {{ $request->department }}</td>
        </tr>
        <tr>
            <td><strong>Request Date:</strong> {{ \Carbon\Carbon::parse($request->request_date)->format('M d, Y') }}</td>
            <td><strong>Expected Date:</strong> {{ \Carbon\Carbon::parse($request->expected_date)->format('M d, Y') }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Notes:</strong> {{ $request->notes ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Supplier:</strong> 
                {{ $request->supplier->name ?? 'N/A' }} <br>
                {{ $request->supplier->address ?? '' }}<br>
                {{ $request->supplier->phone ?? '' }} | {{ $request->supplier->email ?? '' }}
            </td>
        </tr>
    </table>

    <table class="item-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($request->items as $index => $item)
                @php $grandTotal += $item->total; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5" align="right">Grand Total</td>
                <td>${{ number_format($grandTotal, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <small>Generated on {{ now()->format('M d, Y h:i A') }}</small>
    </div>

</body>
</html>
