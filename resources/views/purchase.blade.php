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
            <h4 class="fw-bold">Create Purchase</h4>
            <h6>Add a new purchase</h6>
        </div>
    </div>
    <ul class="table-top-head">
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img"></a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img"></a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i class="ti ti-chevron-up"></i></a>
        </li>
    </ul>
</div>
<div class="card purchase_cards">
    <div class="card-body">
        <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
            @csrf
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
                                <select class="form-select" id="supplier_select" name="supplier_id">
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->company_name ?? ($supplier->first_name . ' ' . $supplier->last_name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Address</label>
                            <div class="col-md-8">
                                <textarea class="form-control" rows="2" id="supplier_address" name="supplier_address" placeholder="Address"></textarea>
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
                                <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" placeholder="Phone No">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">GSTIN / PAN</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="gstin_pan" name="gstin_pan" placeholder="GSTIN / PAN">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Rev. Charge</label>
                            <div class="col-md-8">
                                <select class="form-select" name="reverse_charge">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
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
                                <input type="text" class="form-control" name="place_of_supply" value="" placeholder="Place of Supply">
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
                                    <option value="Regular">Regular</option>
                                    <option value="Bill of Supply">Bill of Supply</option>
                                    <option value="Export">Export</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Invoice No. <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="invoice_no" placeholder="Invoice No.">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Invoice Date <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="invoice_date" value="">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Challan No.</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="challan_no" placeholder="Challan No.">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Challan Date</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="challan_date">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">L.R. No.</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="lr_no" placeholder="L.R. No.">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Entry Date</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="entry_date">
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
                    <tbody>
                        <!-- Dynamic rows will be added here -->
                    </tbody>
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
            <!-- Totals and Other Fields -->
            <div class="totlas_fields">
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date" class="form-control" name="due_date" value="{{ date('Y-m-d', strtotime('+15 days')) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <table class="table table-borderless w-auto">
                                <tr>
                                    <td>Total Taxable</td>
                                    <td id="total_taxable">0</td>
                                </tr>
                                <tr>
                                    <td>Total Tax</td>
                                    <td id="total_tax">0</td>
                                </tr>
                                <tr>
                                    <!-- <td>Round Off</td>
                                    <td>
                                        <div class="form-check form-switch d-inline"><input class="form-check-input" type="checkbox" name="round_off" id="round_off" checked></div> <span id="round_off_amount">0</span>
                                    </td> -->
                                    <td>Round Off</td>
                                    <td>
                                        <input type="hidden" name="round_off" id="round_off_value" value="0">
                                        <div class="form-check form-switch d-inline">
                                            <input class="form-check-input" type="checkbox" id="round_off_checkbox" {{ old('round_off') ? 'checked' : '' }}>
                                        </div>
                                        <span id="round_off_amount">0</span>
                                    </td>
                                </tr>
                                <tr class="bg-warning">
                                    <td>Grand Total</td>
                                    <td id="grand_total">0</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Total in words: <span id="total_in_words">ZERO RUPEES ONLY</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <label class="form-label">Document Note / Remark</label>
                    <textarea class="form-control" name="remarks" rows="2" placeholder="Document Note / Remark"></textarea>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">Save Purchase</button>
                    <button type="button" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
            <input type="hidden" name="total_amount" id="hidden_total_amount">
            <input type="hidden" name="discount_amount" id="hidden_discount_amount">
            <input type="hidden" name="tax_amount" id="hidden_tax_amount">
            <input type="hidden" name="grand_total" id="hidden_grand_total">
        </form>
    </div>
</div>
@include('layouts.footer')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@featherds/feather@v4.28.0/dist/feather.min.js"></script>
<script>
$(document).ready(function() {
    let sr = 1;
    let products = @json($products);

    // Add Product Row
    $('.add-product').click(function(e) {
        e.preventDefault();
        let row = `
            <tr>
                <td>${sr}</td>
                <td>
                    <select class="form-control product-select" name="items[${sr-1}][product_id]">
                        <option value="">Select Product</option>
                        ${products.map(product => `<option value="${product.id}" data-name="${product.name}" data-hsn="${product.hsn_sac_code}" data-unit="${product.unit_of_measure}" data-price="${product.unit_price}" data-tax="${product.tax_percentage}" data-tax-category="${product.tax_category}" data-expiry="${product.expiry_date}">${product.name}</option>`).join('')}
                    </select>
                </td>
                <td><input type="text" class="form-control barcode" name="items[${sr-1}][barcode]" placeholder="Barcode No."></td>
                <td><input type="text" class="form-control hsn_code" name="items[${sr-1}][hsn_code]" placeholder="HSN/SAC"></td>
                <td><input type="text" class="form-control qty" name="items[${sr-1}][qty]" placeholder="Qty."></td>
                <td><input type="text" class="form-control unit" name="items[${sr-1}][unit]" placeholder="UOM"></td>
                <td><input type="text" class="form-control price" name="items[${sr-1}][price]" placeholder="Price"></td>
                <td>
                    <input type="text" class="form-control mb-1 discount_percent" name="items[${sr-1}][discount_percent]" placeholder="%">
                    <span class="form-control">+</span>
                    <input type="text" class="form-control discount_rs" name="items[${sr-1}][discount_rs]" placeholder="Rs">
                </td>
                <td>
                    <select class="form-control form-select gst" name="items[${sr-1}][gst_percent]">
                        <option value="0">0%</option>
                        <option value="5">5%</option>
                        <option value="18">18%</option>
                        <option value="28">28%</option>
                    </select>
                    <input type="text" class="form-control gst_amount" name="items[${sr-1}][gst_amount]" readonly placeholder="Rs 0">
                </td>
                <td>
                    <select class="form-control form-select igst" name="items[${sr-1}][igst_percent]">
                        <option value="0">0%</option>
                        <option value="5">5%</option>
                        <option value="18">18%</option>
                        <option value="28">28%</option>
                    </select>
                    <input type="text" class="form-control igst_amount" name="items[${sr-1}][igst_amount]" readonly placeholder="Rs 0">
                </td>
                <td>
                    <input type="text" class="form-control mb-1 cess_percent" name="items[${sr-1}][cess_percent]" placeholder="%">
                    <span class="form-control">+</span>
                    <input type="text" class="form-control cess_rs" name="items[${sr-1}][cess_rs]" placeholder="Rs">
                </td>
                <td class="item_total"><input type="text" class="form-control item_total_input" name="items[${sr-1}][total_amount]" readonly value="0"></td>
                <td>
                    <button class="btn btn-danger remove-row">Remove</button>
                </td>
            </tr>`;
        $('#product_table tbody').append(row);
        sr++;
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
        $('#product_table tbody tr').each(function(index) {
            $(this).attr('data-sr', index + 1);
            $(this).find('td:first').text(index + 1);
            let itemIndex = index;
            $(this).find('select, input').each(function() {
                let name = $(this).attr('name');
                if (name && name.includes('items[')) {
                    let newName = name.replace(/items\[\d+\]/, `items[${itemIndex}]`);
                    $(this).attr('name', newName);
                }
            });
        });
        sr = $('#product_table tbody tr').length + 1;
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

        $('#product_table tbody tr').each(function() {
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

        let round_off_value = 0;
        let grand_total = base_grand_total;
        if ($('#round_off').is(':checked')) {
            let rounded = Math.round(base_grand_total);
            round_off_value = rounded - base_grand_total;
            grand_total = rounded;
        }

        $('#total_qty').text(total_qty);
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

        $('#hidden_total_amount').val(total_taxable.toFixed(2));
        $('#hidden_discount_amount').val(total_discount.toFixed(2));
        $('#hidden_tax_amount').val(total_tax.toFixed(2));
        $('#hidden_grand_total').val(grand_total.toFixed(2));

        updateTotalInWords(grand_total);
    }

    // Basic total in words function
    function updateTotalInWords(amount) {
        if (amount <= 0) {
            $('#total_in_words').text('ZERO RUPEES ONLY');
        } else {
            $('#total_in_words').text(`${amount.toFixed(2)} RUPEES ONLY`);
        }
    }

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
                    alert('Error fetching supplier data');
                }
            });
        } else {
            $('#supplier_address, #contact_person, #supplier_phone, #gstin_pan').val('');
        }
    });

    // Form validation before submit
    $('#purchaseForm').submit(function(e) {
        let hasItems = $('#product_table tbody tr').length > 0;
        if (!hasItems) {
            e.preventDefault();
            alert('Please add at least one product item');
            return false;
        }

        let totalAmount = parseFloat($('#hidden_grand_total').val()) || 0;
        if (totalAmount <= 0) {
            e.preventDefault();
            alert('Please add valid product items with amounts');
            return false;
        }

        let isValid = true;
        $('#product_table tbody tr').each(function() {
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

    // // Round Off Checkbox Change
    // $('#round_off').change(function() {
    //     calculateTotals();
    // });

    // Round Off Checkbox Change
    $('#round_off_checkbox').change(function() {
        $('#round_off_value').val($(this).is(':checked') ? '1' : '0');
        calculateTotals();
    });

});
</script>