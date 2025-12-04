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
    background: transparent !important;
    text-align: center;
    border-radius: 0 !important;
}
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
            <h4 class="fw-bold">Create Sales</h4>
            <h6>Add a new sales invoice</h6>
        </div>
    </div>
    <ul class="table-top-head">
        <li><a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img"></a></li>
        <li><a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img"></a></li>
        <li><a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a></li>
        <li><a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i class="ti ti-chevron-up"></i></a></li>
    </ul>
</div>

<div class="card purchase_cards">
    <div class="card-body">
        <form action="{{ route('sales.store') }}" method="POST" id="salesForm">
            @csrf
            <div class="row">
                <!-- Customer Information Section -->
                <div class="col-lg-5 col-md-12">
                    <div class="all_format">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Customer Information</h5>
                            <a href="{{ route('customers.index') }}" class="btn btn-primary mb-0"><i class="ti ti-plus me-1"></i>Add Customer</a>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">M/S <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select class="form-select" id="customer_select" name="customer_id">
                                    <option value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->company_name ?? ($customer->first_name . ' ' . $customer->last_name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Address</label>
                            <div class="col-md-8">
                                <textarea class="form-control" rows="2" id="customer_address" name="customer_address" placeholder="Address"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Contact Person</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Phone No</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="Phone No">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">GSTIN / PAN</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="gstin_pan" name="gstin_pan" placeholder="GSTIN / PAN">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Shipping Address</label>
                            <div class="col-md-8">
                                <textarea class="form-control" rows="2" name="shipping_address" placeholder="Shipping Address"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Place of Supply <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="place_of_supply" placeholder="Place of Supply">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Invoice Detail Section -->
                <div class="col-lg-7 col-md-12">
                    <div class="all_format">
                        <h5 class="fw-bold mb-4 mt-2">Sales Invoice Detail</h5>
                        <hr>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Invoice No. <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="invoice_no" placeholder="Invoice No.">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Invoice Date <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="invoice_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Due Date</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="due_date" value="{{ date('Y-m-d', strtotime('+15 days')) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Delivery Mode</label>
                            <div class="col-md-8">
                                <select class="form-select" name="delivery_mode">
                                    <option value="">Select Delivery Mode</option>
                                    <option value="Transport">Transport</option>
                                    <option value="Direct Delivery">Direct Delivery</option>
                                    <option value="Courier">Courier</option>
                                    <option value="Self">Self</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Items Section -->
            <h5 class="fw-bold mt-4 mb-3">Product Items</h5>
            <a href="#" class="btn btn-primary mb-3 add-product"><i class="ti ti-plus me-1"></i>Add Items</a>
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
                    <tbody></tbody>
                    <tfoot>
                        <tr class="bg-warning">
                            <td colspan="4">Total Inv. Val.</td>
                            <td id="total_qty">0</td>
                            <td></td>
                            <td id="total_price">0</td>
                            <td id="total_discount">0</td>
                            <td id="total_gst">0</td>
                            <td id="total_igst">0</td>
                            <td id="total_cess">0</td>
                            <td id="total_amount">0</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Totals Section -->
            <div class="totlas_fields">
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Document Note / Remark</label>
                            <textarea class="form-control" name="remarks" rows="2" placeholder="Document Note / Remark"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <table class="table table-borderless w-auto">
                                <tr><td>Total Taxable</td><td id="total_taxable">0</td></tr>
                                <tr><td>Total Tax</td><td id="total_tax">0</td></tr>
                                <tr>
                                    <td>Round Off</td>
                                    <td>
                                        <div class="form-check form-switch d-inline"><input class="form-check-input" type="checkbox" id="round_off" checked></div>
                                        <span id="round_off_amount">0</span>
                                    </td>
                                </tr>
                                <tr class="bg-warning"><td>Grand Total</td><td id="grand_total">0</td></tr>
                                <tr><td colspan="2">Total in words: <span id="total_in_words">ZERO RUPEES ONLY</span></td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">Save Sales</button>
                    <button type="button" class="btn btn-secondary">Cancel</button>
                </div>
            </div>

            <input type="hidden" name="total_amount" id="hidden_total_amount">
            <input type="hidden" name="discount_amount" id="hidden_discount_amount">
            <input type="hidden" name="tax_amount" id="hidden_tax_amount">
            <input type="hidden" name="grand_total" id="hidden_grand_total">
            <input type="hidden" name="actual_total" id="hidden_actual_total">
            <input type="hidden" name="round_off_amount" id="hidden_round_off_amount">
        </form>
    </div>
</div>

@include('layouts.footer')

<script>
$(document).ready(function() {
    let sr = 1;
    let products = @json($products);

    $('.add-product').click(function(e) {
        e.preventDefault();
        let row = `
            <tr>
                <td>${sr}</td>
                <td>
                    <select class="form-control product-select" name="items[${sr-1}][product_id]">
                        <option value="">Select Product</option>
                        ${products.map(p => `<option value="${p.id}" data-hsn="${p.hsn_sac_code}" data-unit="${p.unit_of_measure}" data-price="${p.unit_price}" data-tax="${p.tax_percentage}" data-tax-category="${p.tax_category}">${p.name}</option>`).join('')}
                    </select>
                </td>
                <td><input type="text" class="form-control barcode" name="items[${sr-1}][barcode]" placeholder="Barcode"></td>
                <td><input type="text" class="form-control hsn_code" name="items[${sr-1}][hsn_code]" placeholder="HSN/SAC"></td>
                <td><input type="text" class="form-control qty" name="items[${sr-1}][qty]" value="1"></td>
                <td><input type="text" class="form-control unit" name="items[${sr-1}][unit]" placeholder="UOM"></td>
                <td><input type="text" class="form-control price" name="items[${sr-1}][price]" placeholder="Price"></td>
                <td>
                    <input type="text" class="form-control mb-1 discount_percent" name="items[${sr-1}][discount_percent]" placeholder="%">
                    <span class="form-control">+</span>
                    <input type="text" class="form-control discount_rs" name="items[${sr-1}][discount_rs]" placeholder="Rs">
                </td>
                <td>
                    <select class="form-control form-select gst" name="items[${sr-1}][gst_percent]">
                        <option value="0">0%</option><option value="5">5%</option><option value="12">12%</option><option value="18">18%</option><option value="28">28%</option>
                    </select>
                    <input type="text" class="form-control gst_amount" readonly>
                </td>
                <td>
                    <select class="form-control form-select igst" name="items[${sr-1}][igst_percent]">
                        <option value="0">0%</option><option value="5">5%</option><option value="12">12%</option><option value="18">18%</option><option value="28">28%</option>
                    </select>
                    <input type="text" class="form-control igst_amount" readonly>
                </td>
                <td>
                    <input type="text" class="form-control mb-1 cess_percent" name="items[${sr-1}][cess_percent]" placeholder="%">
                    <span class="form-control">+</span>
                    <input type="text" class="form-control cess_rs" name="items[${sr-1}][cess_rs]" placeholder="Rs">
                </td>
                <td class="item_total">0</td>
                <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
            </tr>`;
        $('#product_table tbody').append(row);
        sr++;
    });

    // Same JS logic as purchase (copy-paste with minor rename)
    $(document).on('click', '.remove-row', function() { $(this).closest('tr').remove(); updateSerialNumbers(); calculateTotals(); });
    function updateSerialNumbers() {
        $('#product_table tbody tr').each(function(i) {
            $(this).find('td:first').text(i+1);
            $(this).find('input, select').each(function() {
                let name = $(this).attr('name');
                if (name) $(this).attr('name', name.replace(/items\[\d+\]/, `items[${i}]`));
            });
        });
        sr = $('#product_table tbody tr').length + 1;
    }

    $(document).on('change', '.product-select', function() {
        let row = $(this).closest('tr');
        let opt = $(this).find('option:selected');
        row.find('.hsn_code').val(opt.data('hsn') || '');
        row.find('.unit').val(opt.data('unit') || '');
        row.find('.price').val(opt.data('price') || 0);
        let tax = opt.data('tax') || 0;
        if (opt.data('tax-category') === 'igst') {
            row.find('.igst').val(tax); row.find('.gst').val(0);
        } else {
            row.find('.gst').val(tax); row.find('.igst').val(0);
        }
        calculateItemTotal(row);
    });

    $(document).on('input change', '.qty, .price, .discount_percent, .discount_rs, .gst, .igst, .cess_percent, .cess_rs', function() {
        calculateItemTotal($(this).closest('tr'));
    });

    function calculateItemTotal(row) {
        let qty = parseFloat(row.find('.qty').val()) || 0;
        let price = parseFloat(row.find('.price').val()) || 0;
        let disc_p = parseFloat(row.find('.discount_percent').val()) || 0;
        let disc_r = parseFloat(row.find('.discount_rs').val()) || 0;
        let gst = parseFloat(row.find('.gst').val()) || 0;
        let igst = parseFloat(row.find('.igst').val()) || 0;
        let cess_p = parseFloat(row.find('.cess_percent').val()) || 0;
        let cess_r = parseFloat(row.find('.cess_rs').val()) || 0;

        let subtotal = qty * price;
        let discount = (subtotal * disc_p / 100) + disc_r;
        let taxable = subtotal - discount;
        let gst_amt = taxable * gst / 100;
        let igst_amt = taxable * igst / 100;
        let cess_amt = (taxable * cess_p / 100) + cess_r;
        let total = taxable + gst_amt + igst_amt + cess_amt;

        row.find('.gst_amount').val(gst_amt.toFixed(2));
        row.find('.igst_amount').val(igst_amt.toFixed(2));
        row.find('.item_total').text(total.toFixed(2));
        calculateTotals();
    }

    function calculateTotals() {
        let total_qty = 0, total_sub = 0, total_disc = 0, total_taxable = 0, total_tax = 0, base_total = 0;
        $('#product_table tbody tr').each(function() {
            let row = $(this);
            let qty = parseFloat(row.find('.qty').val()) || 0;
            let price = parseFloat(row.find('.price').val()) || 0;
            let disc_p = parseFloat(row.find('.discount_percent').val()) || 0;
            let disc_r = parseFloat(row.find('.discount_rs').val()) || 0;
            let gst = parseFloat(row.find('.gst').val()) || 0;
            let igst = parseFloat(row.find('.igst').val()) || 0;
            let cess_p = parseFloat(row.find('.cess_percent').val()) || 0;
            let cess_r = parseFloat(row.find('.cess_rs').val()) || 0;

            let subtotal = qty * price;
            let discount = (subtotal * disc_p / 100) + disc_r;
            let taxable = subtotal - discount;
            let tax = taxable * (gst + igst) / 100 + (taxable * cess_p / 100) + cess_r;

            total_qty += qty;
            total_sub += subtotal;
            total_disc += discount;
            total_taxable += taxable;
            total_tax += tax;
            base_total += taxable + tax;
        });

        let round_off = $('#round_off').is(':checked') ? Math.round(base_total) - base_total : 0;
        let grand_total = base_total + round_off;

        $('#total_qty').text(total_qty);
        $('#total_price').text(total_sub.toFixed(2));
        $('#total_discount').text(total_disc.toFixed(2));
        $('#total_taxable').text(total_taxable.toFixed(2));
        $('#total_tax').text(total_tax.toFixed(2));
        $('#round_off_amount').text(round_off.toFixed(2));
        $('#grand_total').text(grand_total.toFixed(2));
        $('#total_in_words').text(grand_total.toFixed(2) + ' RUPEES ONLY');

        $('#hidden_total_amount').val(total_taxable.toFixed(2));
        $('#hidden_discount_amount').val(total_disc.toFixed(2));
        $('#hidden_tax_amount').val(total_tax.toFixed(2));
        $('#hidden_actual_total').val(base_total.toFixed(2));
        $('#hidden_round_off_amount').val(round_off.toFixed(2));
        $('#hidden_grand_total').val(grand_total.toFixed(2));
    }

    $('#round_off').change(calculateTotals);

    // Customer auto-fill
    $('#customer_select').change(function() {
        let id = $(this).val();
        if (id) {
            $.get(`/sales/customer/${id}`, function(res) {
                if (res.success) {
                    $('#customer_address').val(res.data.full_address || '');
                    $('#contact_person').val(res.data.contact_person || '');
                    $('#customer_phone').val(res.data.phone || '');
                    $('#gstin_pan').val(res.data.gstin || res.data.pan || '');
                }
            });
        }
    });

    $('#salesForm').submit(function(e) {
        if ($('#product_table tbody tr').length === 0) {
            e.preventDefault();
            alert('Please add at least one item');
        }
    });
});
</script>