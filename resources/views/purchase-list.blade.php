@include('layouts.header')
<style>
.btn-primary {
    background-color: #ff9500;
    border-color: #ff9500;
    color: white;
}

.btn-primary:hover {
    background-color: #e68500;
    border-color: #e68500;
    color: white;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.status-pending {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.status-completed {
    background-color: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

.status-cancelled {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.purchase-type {
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11px;
    background: #e9ecef;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.action-buttons .btn {
    padding: 4px 8px;
    font-size: 12px;
}
</style>

<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">Purchase List</h4>
            <h6>Manage your purchase orders</h6>
        </div>
    </div>
    <ul class="table-top-head">
        <li>
            <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>Add Purchase
            </a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img"></a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh" onclick="location.reload()"><i class="ti ti-refresh"></i></a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i class="ti ti-chevron-up"></i></a>
        </li>
    </ul>
</div>

<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-x me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover" id="purchaseTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Supplier</th>
                        <th>Purchase Type</th>
                        <th>Items</th>
                        <th>Total Amount</th>
                        <th>Tax Amount</th>
                        <th>Grand Total</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $purchase)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $purchase->invoice_no }}</strong>
                            @if($purchase->challan_no)
                                <br><small class="text-muted">Challan: {{ $purchase->challan_no }}</small>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($purchase->invoice_date)->format('d M, Y') }}</td>
                        <td>
                            @if($purchase->supplier)
                                <strong>{{ $purchase->supplier->company_name ?? $purchase->supplier->first_name . ' ' . $purchase->supplier->last_name }}</strong>
                                @if($purchase->supplier->phone)
                                    <br><small class="text-muted">{{ $purchase->supplier->phone }}</small>
                                @endif
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <span class="purchase-type">{{ $purchase->purchase_type }}</span>
                        </td>
                        <td>
                            @if($purchase->items->count() > 0)
                                <div class="item-list">
                                    @foreach($purchase->items->take(2) as $item)
                                        <div class="item-line">
                                            <small>{{ $item->product_name }} ({{ $item->qty }} {{ $item->unit }})</small>
                                        </div>
                                    @endforeach
                                    @if($purchase->items->count() > 2)
                                        <small class="text-primary">+{{ $purchase->items->count() - 2 }} more items</small>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted">No items</span>
                            @endif
                        </td>
                        <td>₹{{ number_format($purchase->total_amount, 2) }}</td>
                        <td>₹{{ number_format($purchase->tax_amount, 2) }}</td>
                        <td>
                            <strong>₹{{ number_format($purchase->grand_total, 2) }}</strong>
                            @if($purchase->round_off_amount != 0)
                                <br><small class="text-muted">Round off: ₹{{ number_format($purchase->round_off_amount, 2) }}</small>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusClass = 'status-pending';
                                if($purchase->status == 'completed') $statusClass = 'status-completed';
                                if($purchase->status == 'cancelled') $statusClass = 'status-cancelled';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ ucfirst($purchase->status) }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($purchase->created_at)->format('d M, Y h:i A') }}</td>
                        <td>
                            <div class="action-buttons d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary view-purchase" data-id="{{ $purchase->id }}" title="View Details">
                                    <i class="ti ti-eye"></i>
                                </button>
                                <a href="#" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center py-4">
                            <div class="empty-state">
                                <i class="ti ti-shopping-cart-off" style="font-size: 48px; color: #6c757d;"></i>
                                <h5 class="mt-3">No Purchases Found</h5>
                                <p class="text-muted">You haven't created any purchase orders yet.</p>
                                <a href="{{ route('purchases.create') }}" class="btn btn-primary mt-2">
                                    <i class="ti ti-plus me-1"></i>Create First Purchase
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($purchases->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Showing {{ $purchases->firstItem() }} to {{ $purchases->lastItem() }} of {{ $purchases->total() }} entries
            </div>
            <div>
                {{ $purchases->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Purchase Details Modal -->
<div class="modal fade" id="purchaseDetailsModal" tabindex="-1" aria-labelledby="purchaseDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="purchaseDetailsModalLabel">Purchase Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="purchaseDetailsContent">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="ti ti-printer me-1"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // View Purchase Details
    $('.view-purchase').click(function() {
        let purchaseId = $(this).data('id');
        
        // Show loading
        $('#purchaseDetailsContent').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading purchase details...</p>
            </div>
        `);
        
        $('#purchaseDetailsModal').modal('show');
        
        // Load purchase details via AJAX
        $.ajax({
            url: '/purchases/' + purchaseId + '/details',
            type: 'GET',
            success: function(response) {
                $('#purchaseDetailsContent').html(response);
            },
            error: function(xhr) {
                $('#purchaseDetailsContent').html(`
                    <div class="alert alert-danger">
                        <i class="ti ti-alert-triangle me-2"></i>
                        Error loading purchase details. Please try again.
                    </div>
                `);
            }
        });
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>