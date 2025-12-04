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
.card.sales_cards { background: transparent !important; border: 0px !important; }
.sales_cards .card-body { padding: 0px !important; }
.all_format { padding: 20px; background: #fff; border-radius: 5px; min-height: 600px; }
.totlas_fields { background: #fff; padding: 20px; border-radius: 5px; }
.table-bordered td, .table-bordered th { width: 100%; }
.table-bordered input, .table-bordered select { width: 100%; height: 50%; }
.table td { vertical-align: top !important; padding: 0px !important; }
table .form-control { border: 0px !important; background: transparent !important; text-align: center; border-radius: 0 !important; }
table .form-control:hover { border: 1px solid orange !important; }
table .bg-warning td { text-align: center; }
table td { text-align: center; }
</style>

<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">Create Sales Order</h4>
            <h6>Add a new sales order</h6>
        </div>
    </div>
    <ul class="table-top-head">
        <li><a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a></li>
        <li><a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img src="assets/img/icons/excel.svg" alt="img"></a></li>
        <li><a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a></li>
        <li><a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i class="ti ti-chevron-up"></i></a></li>
    </ul>
</div>

<div class="card sales_cards">
    <div class="card-body">
        <form action="#" method="POST" id="salesForm">
            <!-- @csrf removed -->

            <div class="row">
                <!-- Customer Information Section -->
                <div class="col-lg-5 col-md-12">
                    <div class="all_format">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Customer Information</h5>
                            <a href="#" class="btn btn-primary mb-0"><i class="ti ti-plus me-1"></i>Add Customer</a>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">M/S <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select class="form-select" id="customer_select" name="customer_id">
                                    <option value="">Select Customer</option>
                                    <!-- Customers will be populated via JS or manually -->
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
                            <label class="form-label col-md-4">Sales Order Type</label>
                            <div class="col-md-8">
                                <select class="form-select" name="sales_type">
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
                            <label class="form-label col-md-4">Delivery Note No.</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="delivery_note_no" placeholder="Delivery Note No.">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Delivery Date</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="delivery_date">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Dispatch Doc No.</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="dispatch_doc_no" placeholder="Dispatch Doc No.">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label col-md-4">Dispatch Date</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="dispatch_date">
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
                            <th>Product / Service</th>
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
                            <td colspan="4">Total Invoice Value</td>
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
                            <input type="date" class="form-control" name="due_date">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Terms</label>
                            <input type="text" class="form-control" name="payment_terms" placeholder="Payment Terms">
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
                                        <div class="form-check form-switch d-inline">
                                            <input class="form-check-input" type="checkbox" id="round_off_checkbox" checked>
                                        </div>
                                        <span id="round_off_amount">0</span>
                                        <input type="hidden" name="round_off" id="round_off_value" value="1">
                                    </td>
                                </tr>
                                <tr class="bg-warning"><td>Grand Total</td><td id="grand_total">0</td></tr>
                                <tr><td colspan="2">Total in words: <span id="total_in_words">ZERO RUPEES ONLY</span></td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <label class="form-label">Terms & Conditions</label>
                    <textarea class="form-control" name="terms_conditions" rows="2" placeholder="Terms & Conditions"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Customer Note</label>
                    <textarea class="form-control" name="customer_note" rows="2" placeholder="Customer Note"></textarea>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">Save Sales Order</button>
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