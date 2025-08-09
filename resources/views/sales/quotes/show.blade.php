<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header border-bottom">
                <h5 class="modal-title">Order #{{ $order->order_number }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Company Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                     {{-- Company Info --}}
    <div class="mb-3">
        <strong>Elite Vinyl Windows</strong><br>
        4231 Liberty Blvd, CA 90280<br>
        Tel: (562) 945-7700 | Fax: (562) 800-7064<br>
        Website: www.elitevinylwindows.com
    </div>
                    <div>
                        <a href="{{ route('sales.orders.download', $order->id) }}" class="btn btn-outline-primary me-2">Download PDF</a>
                        <a href="#" class="btn btn-success">Send Order</a>
                    </div>
                </div>

                <!-- Order & Quote Info -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Order Details</h6>
                        <p><strong>Order #:</strong> {{ $order->order_number }}</p>
                        <p><strong>Quote #:</strong> {{ $order->quote->quote_number }}</p>
                        <p><strong>Invoice #:</strong> {{ $order->invoice->invoice_number ?? '—' }}</p>
                        <p><strong>Delivery Date:</strong> {{ $order->due_date }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Sales Info</h6>
                        <p><strong>Sales Agent:</strong> {{ $order->entered_by }}</p>
                        <p><strong>Approved By:</strong> {{ $order->approved_by }}</p>
                    </div>
                </div>

                <!-- Billing & Shipping -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Billing Address</h6>
                        <p>{{ $order->customer->billing_name }}</p>
                        <p>{{ $order->customer->billing_address }}</p>
                        <p>{{ $order->customer->billing_city }}, {{ $order->customer->billing_state }} {{ $order->customer->billing_zip }}</p>
                        <p>{{ $order->customer->billing_phone }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Shipping Address</h6>
                        <p>{{ $order->customer->shipping_name }}</p>
                        <p>{{ $order->customer->shipping_address }}</p>
                        <p>{{ $order->customer->shipping_city }}, {{ $order->customer->shipping_state }} {{ $order->customer->shipping_zip }}</p>
                        <p>{{ $order->customer->shipping_phone }}</p>
                    </div>
                </div>

                <!-- Order Items Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Unit</th>
                                <th>Size</th>
                                <th>Frame Type</th>
                                <th>Glass</th>
                                <th>Grid</th>
                                <th>Pattern</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->quote->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->unit ?? 'Dynamic-XO' }}</td>
                                <td>W {{ $item->width }}" x H {{ $item->height }}"</td>
                                <td>{{ $item->frame_type }} {{ $item->fin_type }}</td>
                                <td>{{ $item->glass_type }}</td>
                                <td>{{ $item->grid_type }}</td>
                                <td>{{ $item->grid_pattern }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>${{ number_format($item->total, 2) }}</td>
                                <td><img src="{{ $item->preview_image_url ?? 'https://via.placeholder.com/50' }}" class="img-thumbnail" width="50"></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Summary -->
                <div class="d-flex justify-content-end mt-4">
                    <table class="table table-borderless w-50">
                        <tr>
                            <th>Subtotal:</th>
                            <td>${{ number_format($order->net_price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Tax (8.25%):</th>
                            <td>${{ number_format($order->net_price * 0.0825, 2) }}</td>
                        </tr>
                        <tr>
                            <th><strong>Total:</strong></th>
                            <td><strong>${{ number_format($order->net_price * 1.0825, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Amount Paid:</th>
                            <td>${{ number_format($order->paid_amount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Balance Due:</th>
                            <td>${{ number_format($order->remaining_amount ?? 0, 2) }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Footer Note -->
                <div class="text-center mt-5">
                    <p class="text-muted small">Thank you for your business. We appreciate your trust in Elite Vinyl Windows.</p>
                </div>
            </div>

        </div>
    </div>
</div>
