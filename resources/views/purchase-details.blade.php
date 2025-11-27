<div class="purchase-details">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold">Purchase Invoice</h4>
            <p class="mb-1"><strong>Invoice No:</strong> {{ $purchase->invoice_no }}</p>
            <p class="mb-1"><strong>Invoice Date:</strong> {{ \Carbon\Carbon::parse($purchase->invoice_date)->format('d M, Y') }}</p>
            <p class="mb-1"><strong>Purchase Type:</strong> {{ $purchase->purchase_type }}</p>
        </div>
        <div class="col-md-6 text-end">
            <span class="status-badge 
                @if($purchase->status == 'pending') status-pending
                @elseif($purchase->status == 'completed') status-completed
                @else status-cancelled @endif">
                {{ ucfirst($purchase->status) }}
            </span>
        </div>
    </div>

    <!-- Supplier Information -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h6 class="fw-bold">Supplier Information</h6>
            @if($purchase->supplier)
                <p class="mb-1"><strong>Name:</strong> {{ $purchase->supplier->company_name ?? $purchase->supplier->first_name . ' ' . $purchase->supplier->last_name }}</p>
                <p class="mb-1"><strong>Address:</strong> {{ $purchase->supplier->address }}, {{ $purchase->supplier->city }}, {{ $purchase->supplier->state }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $purchase->supplier->phone }}</p>
                <p class="mb-1"><strong>GSTIN:</strong> {{ $purchase->supplier->gstin ?? 'N/A' }}</p>
            @else
                <p class="text-muted">Supplier information not available</p>
            @endif
        </div>
        <div class="col-md-6">
            <h6 class="fw-bold">Shipping Information</h6>
            <p class="mb-1"><strong>Shipping Address:</strong> {{ $purchase->shipping_address }}</p>
            <p class="mb-1"><strong>Place of Supply:</strong> {{ $purchase->place_of_supply }}</p>
            <p class="mb-1"><strong>Delivery Mode:</strong> {{ $purchase->delivery_mode ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Items Table -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>HSN Code</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>GST %</th>
                    <th>IGST %</th>
                    <th>Tax Amount</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchase->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->hsn_code }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->gst_percent }}%</td>
                    <td>{{ $item->igst_percent }}%</td>
                    <td>₹{{ number_format($item->tax_amount, 2) }}</td>
                    <td>₹{{ number_format($item->total_amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="row">
        <div class="col-md-6">
            @if($purchase->remarks)
                <h6 class="fw-bold">Remarks</h6>
                <p>{{ $purchase->remarks }}</p>
            @endif
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
                <tr>
                    <td><strong>Total Amount:</strong></td>
                    <td>₹{{ number_format($purchase->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Discount:</strong></td>
                    <td>₹{{ number_format($purchase->discount_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Tax Amount:</strong></td>
                    <td>₹{{ number_format($purchase->tax_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Actual Total:</strong></td>
                    <td>₹{{ number_format($purchase->actual_total, 2) }}</td>
                </tr>
                @if($purchase->round_off_amount != 0)
                <tr>
                    <td><strong>Round Off:</strong></td>
                    <td>₹{{ number_format($purchase->round_off_amount, 2) }}</td>
                </tr>
                @endif
                <tr class="table-warning">
                    <td><strong>Grand Total:</strong></td>
                    <td><strong>₹{{ number_format($purchase->grand_total, 2) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>
</div>