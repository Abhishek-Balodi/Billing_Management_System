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

.card.purchase_cards {
    background: transparent !important;
    border: 0px !important;
}

.purchase_cards .card-body {
    padding: 0px !important;
}

.all_format {
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    min-height: 600px;
}

.totlas_fields {
    background: #fff;
    padding: 20px;
    border-radius: 5px;
}

.table-bordered td,
.table-bordered th {
    width: 100%;
}

.table-bordered input,
.table-bordered select {
    width: 100%;
    height: 50%;
}

.table td {
    vertical-align: top !important;
    padding: 0px !important;
}

table .form-control {
    border: 0px !important;
    border-color: none !important;
    background: transparent !important;
    text-align: center;
    border-radius: 0 !important;
}

/* Hover effect: orange border */
table .form-control:hover {
    border: 1px solid orange !important;
}

table .bg-warning td {
    text-align: center;
}

table td {
    text-align: center;
}
</style>

<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">Edit Purchase</h4>
            <h6>Update purchase order #{{ $purchase->invoice_no }}</h6>
        </div>
    </div>
</div>

<div class="card purchase_cards">
    <div class="card-body">
        <form action="{{ route('purchases.update', $purchase->id) }}" method="POST" id="purchaseForm">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Vendor Information Section -->
                <div class="col-lg-5 col-md-12">
                    <div class="all_format">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Supplier Information</h5>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-primary mb-0"><i class="ti ti-plus me-1"></i>Add Supplier</a>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">M/S <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select class="form-select" id="supplier_select" name="supplier_id" required>
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->company_name ?? ($supplier->first_name . ' ' . $supplier->last_name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Address</label>
                            <div class="col-md-8">
                                <textarea class="form-control" rows="2" id="supplier_address" name="supplier_address" placeholder="Address">{{ $purchase->supplier->address ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Contact Person</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person" value="{{ $purchase->supplier->first_name ?? '' }} {{ $purchase->supplier->last_name ?? '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Phone No</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" placeholder="Phone No" value="{{ $purchase->supplier->phone ?? '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">GSTIN / PAN</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="gstin_pan" name="gstin_pan" placeholder="GSTIN / PAN" value="{{ $purchase->supplier->gstin ?? $purchase->supplier->pan ?? '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Rev. Charge</label>
                            <div class="col-md-8">
                                <select class="form-select" name="reverse_charge">
                                    <option value="0" {{ $purchase->reverse_charge == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $purchase->reverse_charge == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Shipping Address</label>
                            <div class="col-md-8">
                                <textarea class="form-control" rows="2" name="shipping_address" placeholder="Shipping Address">{{ $purchase->shipping_address }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Place of Supply <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="place_of_supply" value="{{ $purchase->place_of_supply }}" placeholder="Place of Supply" required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Purchase Invoice Detail Section -->
                <div class="col-lg-7 col-md-12">
                    <div class="all_format">
                        <h5 class="fw-bold mb-4 mt-2">Purchase Invoice Detail</h5>
                        <hr>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Purchase Order Type</label>
                            <div class="col-md-8">
                                <select class="form-select" name="purchase_type">
                                    <option value="">Select</option>
                                    <option value="Regular" {{ $purchase->purchase_type == 'Regular' ? 'selected' : '' }}>Regular</option>
                                    <option value="Bill of Supply" {{ $purchase->purchase_type == 'Bill of Supply' ? 'selected' : '' }}>Bill of Supply</option>
                                    <option value="Export" {{ $purchase->purchase_type == 'Export' ? 'selected' : '' }}>Export</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Invoice No. <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="invoice_no" placeholder="Invoice No." value="{{ $purchase->invoice_no }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Invoice Date <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="invoice_date" value="{{ $purchase->invoice_date }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Status</label>
                            <div class="col-md-8">
                                <select class="form-select" name="status">
                                    <option value="pending" {{ $purchase->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ $purchase->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $purchase->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Challan No.</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="challan_no" placeholder="Challan No." value="{{ $purchase->challan_no }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Challan Date</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="challan_date" value="{{ $purchase->challan_date }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">L.R. No.</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="lr_no" placeholder="L.R. No." value="{{ $purchase->lr_no }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Entry Date</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="entry_date" value="{{ $purchase->entry_date }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Delivery Mode</label>
                            <div class="col-md-8">
                                <select class="form-select" name="delivery_mode">
                                    <option value="">Select Delivery Mode</option>
                                    <option value="Transport" {{ $purchase->delivery_mode == 'Transport' ? 'selected' : '' }}>Transport</option>
                                    <option value="Direct Delivery" {{ $purchase->delivery_mode == 'Direct Delivery' ? 'selected' : '' }}>Direct Delivery</option>
                                    <option value="Courier" {{ $purchase->delivery_mode == 'Courier' ? 'selected' : '' }}>Courier</option>
                                    <option value="Self" {{ $purchase->delivery_mode == 'Self' ? 'selected' : '' }}>Self</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product Items Section -->
            <h5 class="fw-bold mt-4 mb-3">Product Items</h5>
            <a href="#" class="btn btn-primary mb-3 add-product"><i class="ti ti-plus me-1"></i>Add Items</a>
            <div class="float-end mb-3"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="product_table">
                    <thead>
                        <tr>
                            <th>SR.</th>
                            <th>Product / Other Charges</th>
                            <th>Barcode No.</th>
                            <th>HSN/SAC Code</th>
                            <th>Qty.</th>
                            <th>UOM</th>
                            <th>Price (Rs)</th>
                            <th>Discount</th>
                            <th>GST</th>
                            <th>IGST</th>
                            <th>CESS</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="items_container">
                        @foreach($purchase->items as $index => $item)
                        <tr data-item-id="{{ $item->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <select class="form-control product-select" name="items[{{ $index }}][product_id]">
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" 
                                            data-name="{{ $product->name }}" 
                                            data-hsn="{{ $product->hsn_sac_code }}" 
                                            data-unit="{{ $product->unit_of_measure }}" 
                                            data-price="{{ $product->unit_price }}" 
                                            data-tax="{{ $product->tax_percentage }}" 
                                            data-tax-category="{{ $product->tax_category }}"
                                            {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                            </td>
                            <td><input type="text" class="form-control barcode" name="items[{{ $index }}][barcode]" value="{{ $item->barcode }}" placeholder="Barcode No."></td>
                            <td><input type="text" class="form-control hsn_code" name="items[{{ $index }}][hsn_code]" value="{{ $item->hsn_code }}" placeholder="HSN/SAC"></td>
                            <td><input type="number" step="0.01" class="form-control qty" name="items[{{ $index }}][qty]" value="{{ $item->qty }}" placeholder="Qty."></td>
                            <td><input type="text" class="form-control unit" name="items[{{ $index }}][unit]" value="{{ $item->unit }}" placeholder="UOM"></td>
                            <td><input type="number" step="0.01" class="form-control price" name="items[{{ $index }}][price]" value="{{ $item->price }}" placeholder="Price"></td>
                            <td>
                                <input type="number" step="0.01" class="form-control mb-1 discount_percent" name="items[{{ $index }}][discount_percent]" value="{{ $item->discount_percent }}" placeholder="%">
                                <span class="form-control">+</span>
                                <input type="number" step="0.01" class="form-control discount_rs" name="items[{{ $index }}][discount_rs]" value="{{ $item->discount_rs }}" placeholder="Rs">
                            </td>
                            <td>
                                <select class="form-control form-select gst" name="items[{{ $index }}][gst_percent]">
                                    <option value="0" {{ $item->gst_percent == 0 ? 'selected' : '' }}>0%</option>
                                    <option value="5" {{ $item->gst_percent == 5 ? 'selected' : '' }}>5%</option>
                                    <option value="12" {{ $item->gst_percent == 12 ? 'selected' : '' }}>12%</option>
                                    <option value="18" {{ $item->gst_percent == 18 ? 'selected' : '' }}>18%</option>
                                    <option value="28" {{ $item->gst_percent == 28 ? 'selected' : '' }}>28%</option>
                                </select>
                                <input type="number" step="0.01" class="form-control gst_amount" name="items[{{ $index }}][gst_amount]" value="{{ $item->gst_percent * ($item->price * $item->qty * (1 - $item->discount_percent/100) - $item->discount_rs) / 100 }}" readonly placeholder="Rs 0">
                            </td>
                            <td>
                                <select class="form-control form-select igst" name="items[{{ $index }}][igst_percent]">
                                    <option value="0" {{ $item->igst_percent == 0 ? 'selected' : '' }}>0%</option>
                                    <option value="5" {{ $item->igst_percent == 5 ? 'selected' : '' }}>5%</option>
                                    <option value="12" {{ $item->igst_percent == 12 ? 'selected' : '' }}>12%</option>
                                    <option value="18" {{ $item->igst_percent == 18 ? 'selected' : '' }}>18%</option>
                                    <option value="28" {{ $item->igst_percent == 28 ? 'selected' : '' }}>28%</option>
                                </select>
                                <input type="number" step="0.01" class="form-control igst_amount" name="items[{{ $index }}][igst_amount]" value="{{ $item->igst_percent * ($item->price * $item->qty * (1 - $item->discount_percent/100) - $item->discount_rs) / 100 }}" readonly placeholder="Rs 0">
                            </td>
                            <td>
                                <input type="number" step="0.01" class="form-control mb-1 cess_percent" name="items[{{ $index }}][cess_percent]" value="{{ $item->cess_percent }}" placeholder="%">
                                <span class="form-control">+</span>
                                <input type="number" step="0.01" class="form-control cess_rs" name="items[{{ $index }}][cess_rs]" value="{{ $item->cess_rs }}" placeholder="Rs">
                            </td>
                            <td class="item_total">
                                <input type="number" step="0.01" class="form-control item_total_input" name="items[{{ $index }}][total_amount]" value="{{ $item->total_amount }}" readonly>
                            </td>
                            <td>
                                <button class="btn btn-danger remove-row">Remove</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-warning">
                            <td colspan="4">Total Inv. Val.</td>
                            <td id="total_qty">{{ $purchase->items->sum('qty') }}</td>
                            <td></td>
                            <td id="total_price">{{ $purchase->items->sum(function($item) { return $item->qty * $item->price; }) }}</td>
                            <td id="total_discount">{{ $purchase->items->sum(function($item) { return ($item->qty * $item->price * $item->discount_percent/100) + $item->discount_rs; }) }}</td>
                            <td id="total_gst">{{ $purchase->items->sum('gst_percent') }}</td>
                            <td id="total_igst">{{ $purchase->items->sum('igst_percent') }}</td>
                            <td id="total_cess">{{ $purchase->items->sum(function($item) { return $item->cess_rs; }) }}</td>
                            <td id="total_amount">{{ $purchase->actual_total }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- Totals and Other Fields -->
            <div class="totlas_fields">
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" rows="2" placeholder="Document Note / Remark">{{ $purchase->remarks }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <table class="table table-borderless w-auto">
                                <tr>
                                    <td>Total Taxable</td>
                                    <td id="total_taxable">{{ $purchase->total_amount }}</td>
                                </tr>
                                <tr>
                                    <td>Total Tax</td>
                                    <td id="total_tax">{{ $purchase->tax_amount }}</td>
                                </tr>
                                <tr>
                                    <td>Round Off</td>
                                    <td>
                                        <div class="form-check form-switch d-inline">
                                            <input class="form-check-input" type="checkbox" id="round_off_checkbox" {{ $purchase->round_off_amount != 0 ? 'checked' : '' }}>
                                        </div>
                                        <span id="round_off_amount">{{ $purchase->round_off_amount }}</span>
                                        <input type="hidden" name="round_off" id="round_off_value" value="{{ $purchase->round_off_amount != 0 ? '1' : '0' }}">
                                    </td>
                                </tr>
                                <tr class="bg-warning">
                                    <td>Grand Total</td>
                                    <td id="grand_total">{{ $purchase->grand_total }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="total_amount" id="hidden_total_amount" value="{{ $purchase->total_amount }}">
                <input type="hidden" name="discount_amount" id="hidden_discount_amount" value="{{ $purchase->discount_amount }}">
                <input type="hidden" name="tax_amount" id="hidden_tax_amount" value="{{ $purchase->tax_amount }}">
                <input type="hidden" name="grand_total" id="hidden_grand_total" value="{{ $purchase->grand_total }}">
                <input type="hidden" name="actual_total" id="hidden_actual_total" value="{{ $purchase->actual_total }}">
                <input type="hidden" name="round_off_amount" id="hidden_round_off_amount" value="{{ $purchase->round_off_amount }}">
                
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">Update Purchase</button>
                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

@include('layouts.footer')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@featherds/feather@v4.28.0/dist/feather.min.js"></script>
<script>
$(document).ready(function() {
    let sr = {{ $purchase->items->count() + 1 }};
    let products = @json($products);
    let itemIndex = {{ $purchase->items->count() }};

    // Add Product Row
    $('.add-product').click(function(e) {
        e.preventDefault();
        let row = `
            <tr>
                <td>${sr}</td>
                <td>
                    <select class="form-control product-select" name="items[${itemIndex}][product_id]">
                        <option value="">Select Product</option>
                        ${products.map(product => `<option value="${product.id}" data-name="${product.name}" data-hsn="${product.hsn_sac_code}" data-unit="${product.unit_of_measure}" data-price="${product.unit_price}" data-tax="${product.tax_percentage}" data-tax-category="${product.tax_category}" data-expiry="${product.expiry_date}">${product.name}</option>`).join('')}
                    </select>
                </td>
                <td><input type="text" class="form-control barcode" name="items[${itemIndex}][barcode]" placeholder="Barcode No."></td>
                <td><input type="text" class="form-control hsn_code" name="items[${itemIndex}][hsn_code]" placeholder="HSN/SAC"></td>
                <td><input type="number" step="0.01" class="form-control qty" name="items[${itemIndex}][qty]" placeholder="Qty."></td>
                <td><input type="text" class="form-control unit" name="items[${itemIndex}][unit]" placeholder="UOM"></td>
                <td><input type="number" step="0.01" class="form-control price" name="items[${itemIndex}][price]" placeholder="Price"></td>
                <td>
                    <input type="number" step="0.01" class="form-control mb-1 discount_percent" name="items[${itemIndex}][discount_percent]" placeholder="%">
                    <span class="form-control">+</span>
                    <input type="number" step="0.01" class="form-control discount_rs" name="items[${itemIndex}][discount_rs]" placeholder="Rs">
                </td>
                <td>
                    <select class="form-control form-select gst" name="items[${itemIndex}][gst_percent]">
                        <option value="0">0%</option>
                        <option value="5">5%</option>
                        <option value="12">12%</option>
                        <option value="18">18%</option>
                        <option value="28">28%</option>
                    </select>
                    <input type="number" step="0.01" class="form-control gst_amount" name="items[${itemIndex}][gst_amount]" readonly placeholder="Rs 0">
                </td>
                <td>
                    <select class="form-control form-select igst" name="items[${itemIndex}][igst_percent]">
                        <option value="0">0%</option>
                        <option value="5">5%</option>
                        <option value="12">12%</option>
                        <option value="18">18%</option>
                        <option value="28">28%</option>
                    </select>
                    <input type="number" step="0.01" class="form-control igst_amount" name="items[${itemIndex}][igst_amount]" readonly placeholder="Rs 0">
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control mb-1 cess_percent" name="items[${itemIndex}][cess_percent]" placeholder="%">
                    <span class="form-control">+</span>
                    <input type="number" step="0.01" class="form-control cess_rs" name="items[${itemIndex}][cess_rs]" placeholder="Rs">
                </td>
                <td class="item_total"><input type="number" step="0.01" class="form-control item_total_input" name="items[${itemIndex}][total_amount]" readonly value="0"></td>
                <td>
                    <button class="btn btn-danger remove-row">Remove</button>
                </td>
            </tr>`;
        $('#items_container').append(row);
        sr++;
        itemIndex++;
        feather.replace();
        calculateTotals();
    });

    // Remove Row
    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
        updateSerialNumbers();
        calculateTotals();
    });

    // Update Serial Numbers after removal
    function updateSerialNumbers() {
        $('#items_container tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
        sr = $('#items_container tr').length + 1;
    }

    // Product Select Change
    $(document).on('change', '.product-select', function() {
        let row = $(this).closest('tr');
        let selectedOption = $(this).find('option:selected');
        let productId = $(this).val();

        if (productId) {
            row.find('.hsn_code').val(selectedOption.data('hsn') || '');
            row.find('.unit').val(selectedOption.data('unit') || '');
            row.find('.price').val(selectedOption.data('price') || 0);

            let tax_category = selectedOption.data('tax-category');
            let tax_percent = selectedOption.data('tax') || 0;

            if (tax_category === 'igst') {
                row.find('.igst').val(tax_percent);
                row.find('.gst').val(0);
            } else {
                row.find('.gst').val(tax_percent);
                row.find('.igst').val(0);
            }

            calculateItemTotal(row);
        }
    });

    // Input Changes for Calculations
    $(document).on('input change', '.qty, .price, .discount_percent, .discount_rs, .gst, .igst, .cess_percent, .cess_rs', function() {
        let row = $(this).closest('tr');
        calculateItemTotal(row);
    });

    // Calculate Individual Item Total
    function calculateItemTotal(row) {
        let qty = parseFloat(row.find('.qty').val()) || 1;
        let price = parseFloat(row.find('.price').val()) || 0;
        let discount_percent = parseFloat(row.find('.discount_percent').val()) || 0;
        let discount_rs = parseFloat(row.find('.discount_rs').val()) || 0;
        let gst = parseFloat(row.find('.gst').val()) || 0;
        let igst = parseFloat(row.find('.igst').val()) || 0;
        let cess_percent = parseFloat(row.find('.cess_percent').val()) || 0;
        let cess_rs = parseFloat(row.find('.cess_rs').val()) || 0;

        let subtotal = qty * price;
        let discount_total = (subtotal * discount_percent / 100) + discount_rs;
        let taxable = subtotal - discount_total;
        let gst_amount = taxable * gst / 100;
        let igst_amount = taxable * igst / 100;
        let cess_amount = (taxable * cess_percent / 100) + cess_rs;
        let tax_amount = gst_amount + igst_amount + cess_amount;
        let total = taxable + tax_amount;

        row.find('.item_total_input').val(total.toFixed(2));
        row.find('.gst_amount').val(gst_amount.toFixed(2));
        row.find('.igst_amount').val(igst_amount.toFixed(2));

        calculateTotals();
    }

    // Calculate Overall Totals
    function calculateTotals() {
        let total_qty = 0;
        let total_subtotal = 0;
        let total_discount = 0;
        let total_taxable = 0;
        let total_tax = 0;
        let total_gst = 0;
        let total_igst = 0;
        let total_cess = 0;
        let base_grand_total = 0;

        $('#items_container tr').each(function() {
            let row = $(this);
            let qty = parseFloat(row.find('.qty').val()) || 0;
            let price = parseFloat(row.find('.price').val()) || 0;
            let subtotal = qty * price;
            let discount_percent = parseFloat(row.find('.discount_percent').val()) || 0;
            let discount_rs = parseFloat(row.find('.discount_rs').val()) || 0;
            let discount_total = (subtotal * discount_percent / 100) + discount_rs;
            let taxable = subtotal - discount_total;
            let gst = parseFloat(row.find('.gst').val()) || 0;
            let igst = parseFloat(row.find('.igst').val()) || 0;
            let cess_percent = parseFloat(row.find('.cess_percent').val()) || 0;
            let cess_rs = parseFloat(row.find('.cess_rs').val()) || 0;
            let gst_amount = taxable * gst / 100;
            let igst_amount = taxable * igst / 100;
            let cess_amount = (taxable * cess_percent / 100) + cess_rs;
            let tax_amount = gst_amount + igst_amount + cess_amount;

            total_qty += qty;
            total_subtotal += subtotal;
            total_discount += discount_total;
            total_taxable += taxable;
            total_gst += gst_amount;
            total_igst += igst_amount;
            total_cess += cess_amount;
            total_tax += tax_amount;
            base_grand_total += taxable + tax_amount;
        });

        let round_off_enabled = $('#round_off_checkbox').is(':checked');
        let round_off_value = 0;
        let grand_total = base_grand_total;
        
        if (round_off_enabled) {
            let rounded = Math.round(base_grand_total);
            round_off_value = rounded - base_grand_total;
            grand_total = rounded;
        }

        // Update UI
        $('#total_qty').text(total_qty.toFixed(2));
        $('#total_price').text(total_subtotal.toFixed(2));
        $('#total_discount').text(total_discount.toFixed(2));
        $('#total_gst').text(total_gst.toFixed(2));
        $('#total_igst').text(total_igst.toFixed(2));
        $('#total_cess').text(total_cess.toFixed(2));
        $('#total_amount').text(base_grand_total.toFixed(2));
        $('#total_taxable').text(total_taxable.toFixed(2));
        $('#total_tax').text(total_tax.toFixed(2));
        $('#round_off_amount').text(round_off_value.toFixed(2));
        $('#grand_total').text(grand_total.toFixed(2));

        // Update hidden fields
        $('#hidden_total_amount').val(total_taxable.toFixed(2));
        $('#hidden_discount_amount').val(total_discount.toFixed(2));
        $('#hidden_tax_amount').val(total_tax.toFixed(2));
        $('#hidden_grand_total').val(grand_total.toFixed(2));
        $('#hidden_actual_total').val(base_grand_total.toFixed(2));
        $('#hidden_round_off_amount').val(round_off_value.toFixed(2));
    }

    // Round Off Checkbox Change
    $('#round_off_checkbox').change(function() {
        $('#round_off_value').val($(this).is(':checked') ? '1' : '0');
        calculateTotals();
    });

    // Supplier Select Auto Populate
    $('#supplier_select').change(function() {
        let supplierId = $(this).val();
        if (supplierId) {
            $.ajax({
                url: `/purchases/supplier/${supplierId}`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#supplier_address').val(data.address + ', ' + data.city + ', ' + data.state + ', ' + data.country + ' - ' + data.postal_code);
                        $('#contact_person').val(data.first_name + ' ' + data.last_name);
                        $('#supplier_phone').val(data.phone);
                        $('#gstin_pan').val(data.gstin || data.pan || '');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    });

    // Form validation before submit
    $('#purchaseForm').submit(function(e) {
        let hasItems = $('#items_container tr').length > 0;
        if (!hasItems) {
            e.preventDefault();
            alert('Please add at least one product item');
            return false;
        }

        let isValid = true;
        $('#items_container tr').each(function() {
            let qty = $(this).find('.qty').val();
            let price = $(this).find('.price').val();
            if (!qty || !price || parseFloat(qty) <= 0 || parseFloat(price) <= 0) {
                isValid = false;
                return false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill all quantity and price fields with valid values.');
            return false;
        }
    });

    // Initialize calculations
    calculateTotals();
});
</script>