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

/* table.input::placeholder {
	text-align: center;
} */
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
        <div class="row">
            <!-- Vendor Information Section -->
            <div class="col-lg-5 col-md-12">
                <div class="all_format">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Supplier Information</h5>
                        <a href="#" class="btn btn-primary mb-0"><i class="ti ti-plus me-1"></i>Add Supplier</a>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <label class="form-label col-md-4">M/S <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <select class="form-select">
                                <option value="">Select Supplier</option>
                                <option>Apex Computers</option>
                                <option>Dazzle Shoes</option>
                                <option>Best Accessories</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="form-label col-md-4">Address</label>
                        <div class="col-md-8">
                            <textarea class="form-control" rows="2" placeholder="Address"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="form-label col-md-4">Contact Person</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Contact Person">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="form-label col-md-4">Phone No</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Phone No">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="form-label col-md-4">GSTIN / PAN</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="GSTIN / PAN">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="form-label col-md-4">Rev. Charge</label>
                        <div class="col-md-8">
                            <select class="form-select">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="same_shipping">
                                <label class="form-check-label" for="same_shipping">Use Same Shipping Address</label>
                            </div>
                        </div>
                        <div class="col-md-8"></div>
                    </div> -->

                    <div class="row mb-3">
                        <label class="form-label col-md-4">Shipping Address</label>
                        <div class="col-md-8">
                            <textarea class="form-control" rows="2" placeholder="Shipping Address"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="form-label col-md-4">Place of Supply <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="" placeholder="Place of Supply">
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
                            <select class="form-select">
                                <option value="">Select</option>
                                <option value="Invoice">Regular</option>
                                <option value="Challan">Bill of Supply</option>
                                <option value="Challan">Export</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label col-md-4">Sequence No.</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="1" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="form-label col-md-4">Invoice No. <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Invoice No.">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label col-md-4">Date <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" value="2025-10-11">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="form-label col-md-4">Challan No.</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Challan No.">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label col-md-4">Challan Date</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="dd/mm/yyyy">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="form-label col-md-4">L.R. No.</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="L.R. No.">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label col-md-4">Entry Date</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="dd/mm/yyyy">
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                    <label class="form-label col-md-4">E-Way No.</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" placeholder="E-Way No.">
                    </div>
                </div> -->

                    <div class="row mb-3">
                        <label class="form-label col-md-4">Delivery Mode</label>
                        <div class="col-md-8">
                            <select class="form-select">
                                <option value="">Select Delivery Mode</option>
                                <option value="Transport">Transport</option>
                                <option value="Courier">Courier</option>
                                <option value="Self">Self</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Purchase Items Section -->
        <h5 class="fw-bold mt-4 mb-3">Purchase Items</h5>
        <a href="#" class="btn btn-primary mb-3"><i class="ti ti-plus me-1"></i>Add Product</a>
        <a href="#" class="btn btn-primary mb-3"><i class="ti ti-plus me-1"></i>Additional Charges</a>
        <div class="float-end mb-3">
            <label class="form-label d-inline">Discount: </label>
            <div class="btn btn-primary d-inline"><i class="ti ti-currency-rupee"></i> Rs % <i class="ti ti-plus"></i>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><input type="text" class="form-control bg-light" placeholder="Enter Product name"><br>
						<!-- <input type="text" class="form-control" placeholder="Item Note..."> -->
					</td>
                        <td><input type="text" class="form-control" placeholder="Barcode No."></td>
                        <td><input type="text" class="form-control" placeholder="HSN/SAC"></td>
                        <td><input type="text" class="form-control" placeholder="Qty."></td>
                        <td><input type="text" class="form-control" placeholder="UOM"></td>
                        <td><input type="text" class="form-control" placeholder="Price"></td>
                        <td>
                            <input type="text" class="form-control mb-1" placeholder="%">
                            <span class="form-control">+</span>
                            <input type="text" class="form-control" placeholder="Rs">
                        </td>
                        <td>
                            <select class="form-control form-select">
                                <option value="0">0%</option>
                                <option value="5">5%</option>
                                <option value="18">18%</option>
                                <option value="28">28%</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control form-select">
                                <option value="0">0%</option>
                                <option value="5">5%</option>
                                <option value="18">18%</option>
                                <option value="28">28%</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control mb-1" placeholder="%">
                            <span class="form-control">+</span>
                            <input type="text" class="form-control" placeholder="Rs">
                        </td>
                        <td>Total</td>
                    </tr>
                    <!-- More rows can be added statically or dynamically later -->
                </tbody>
                <tfoot>
                    <tr class="bg-warning">
                        <td colspan="4">Total Inv. Val.</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
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
                        <input type="date" class="form-control" value="2025-10-26">
                    </div>

                    <h6 class="fw-bold mb-3">Terms & Condition / Additional Note</h6>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" placeholder="Terms & Condition">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Detail</label>
                        <textarea class="form-control" rows="3" placeholder="Enter terms & condition"></textarea>
                    </div>
                    <a href="#" class="btn btn-light"><i class="ti ti-plus me-1"></i>Add Notes</a>
                </div>

                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <table class="table table-borderless w-auto">
                            <tr>
                                <td>Total Taxable</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Total Tax</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Round Off</td>
                                <td>
                                    <div class="form-check form-switch d-inline"><input class="form-check-input"
                                            type="checkbox" checked></div> 0
                                </td>
                            </tr>
                            <tr class="bg-warning">
                                <td>Grand Total</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td colspan="2">Total in words: ZERO RUPEES ONLY</td>
                            </tr>
                        </table>
                    </div>

                    <div class="mt-3 text-end">
                        <label class="form-label">Payment Type <span class="text-danger">*</span></label>
                        <div class="btn-group">
                            <!-- <button type="button" class="btn btn-warning">CREDIT</button> -->
                            <button type="button" class="btn btn-success">CASH</button>
                            <!-- <button type="button" class="btn btn-success">CHEQUE</button> -->
                            <button type="button" class="btn btn-primary">ONLINE</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" id="update_master">
                <label class="form-check-label" for="update_master">Update purchase product master as per this purchase
                    rate.</label>
            </div>
            <div class="mb-3 mt-3">
                <label class="form-label">Document Note / Remark</label>
                <textarea class="form-control" rows="2" placeholder="Document Note / Remark"></textarea>
            </div>
            <div class="text-end mt-4">
                <button type="button" class="btn btn-primary">Save Purchase</button>
                <button type="button" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')