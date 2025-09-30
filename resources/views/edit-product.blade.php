@include('layouts.header')

<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">Edit Product</h4>
            <h6>Update product details</h6>
        </div>
    </div>
    <ul class="table-top-head">
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i class="ti ti-chevron-up"></i></a>
        </li>
    </ul>
    <div class="page-btn mt-0">
        <a href="{{ route('products.index') }}" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back to Product</a>
    </div>
</div>

<form action="{{ route('products.update', $product->id) }}" method="POST" class="add-product-form">
    @csrf
    @method('PUT')
    <div class="add-product">
        <div class="accordions-items-seperate" id="accordionSpacingExample">
            <div class="accordion-item border mb-4">
                <h2 class="accordion-header" id="headingSpacingOne">
                    <div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingOne" aria-expanded="true" aria-controls="SpacingOne">
                        <div class="d-flex align-items-center justify-content-between flex-fill">
                            <h5 class="d-flex align-items-center"><i data-feather="info" class="text-primary me-2"></i><span>Product Information</span></h5>
                        </div>
                    </div>
                </h2>
                <div id="SpacingOne" class="accordion-collapse collapse show" aria-labelledby="headingSpacingOne">
                    <div class="accordion-body border-top">
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Product Name<span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">HSN/SAC Code</label>
                                    <input type="text" class="form-control" name="hsn_sac_code" value="{{ old('hsn_sac_code', $product->hsn_sac_code) }}">
                                    @error('hsn_sac_code') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <!-- <div class="add-newplus"> -->
                                        <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
                                        <!-- <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add-product-category"><i data-feather="plus-circle" class="plus-down-add"></i><span>Add New</span></a> -->
                                    <!-- </div> -->
                                    <select class="select" name="category_id" required>
                                        <option value="">Select</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Sub Category<span class="text-danger ms-1">*</span></label>
                                    <select class="select" name="subcategory_id" required>
                                        <option value="">Select</option>
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('subcategory_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <div class="add-newplus">
                                        <label class="form-label">Brand<span class="text-danger ms-1">*</span></label>
                                    </div>
                                    <select class="select" name="brand_id" required>
                                        <option value="">Select</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <div class="add-newplus">
                                        <label class="form-label">Unit of Measure<span class="text-danger ms-1">*</span></label>
                                    </div>
                                    <select class="select" name="unit_of_measure" required>
                                        <option value="">Select</option>
                                        @foreach (['kg', 'liter', 'piece', 'meter', 'dozen', 'gram', 'ml'] as $unit)
                                            <option value="{{ $unit }}" {{ old('unit_of_measure', $product->unit_of_measure) == $unit ? 'selected' : '' }}>{{ ucfirst($unit) }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_of_measure') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="mb-3 list position-relative">
                                    <label class="form-label">Barcode</label>
                                    <input type="text" class="form-control list" name="barcode" value="{{ old('barcode', $product->barcode) }}">
                                    <button type="button" class="btn btn-primaryadd">Generate</button>
                                    @error('barcode') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <!-- <div class="summer-description-box">
                                <label class="form-label">Description</label>
                                <div class="editor pages-editor">{!! old('description', $product->description) !!}</div>
                                <textarea name="description" style="display: none;">{{ old('description', $product->description) }}</textarea>
                                <p class="fs-14 mt-1">Maximum 60 Words</p>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div> -->
                             <div class="summer-description-box">
                                <label for="description" class="form-label">Description</label>
                                
                                <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                                
                                <p class="fs-14 mt-1">Minimum 60 Words</p>

                                {{-- @error('description') 
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item border mb-4">
                <h2 class="accordion-header" id="headingSpacingTwo">
                    <div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingTwo" aria-expanded="true" aria-controls="SpacingTwo">
                        <div class="d-flex align-items-center justify-content-between flex-fill">
                            <h5 class="d-flex align-items-center"><i data-feather="life-buoy" class="text-primary me-2"></i><span>Pricing & Stocks</span></h5>
                        </div>
                    </div>
                </h2>
                <div id="SpacingTwo" class="accordion-collapse collapse show" aria-labelledby="headingSpacingTwo">
                    <div class="accordion-body border-top">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Quantity<span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control" name="quantity" value="{{ old('quantity', rtrim(rtrim($product->quantity, '0'), '.')) }}" step="0.01" min="0" required>
                                    @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Unit Price<span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control" name="unit_price" value="{{ old('unit_price', $product->unit_price) }}" step="0.01" min="0" required>
                                    @error('unit_price') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tax Type<span class="text-danger ms-1">*</span></label>
                                    <select class="select" name="tax_type" required>
                                        <option value="">Select</option>
                                        @foreach (['inclusive', 'exclusive'] as $type)
                                            <option value="{{ $type }}" {{ old('tax_type', $product->tax_type) == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                        @endforeach
                                    </select>
                                    @error('tax_type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tax Category<span class="text-danger ms-1">*</span></label>
                                    <select class="select" name="tax_category" required>
                                        <option value="">Select</option>
                                        @foreach (['gst', 'sgst', 'cgst', 'igst'] as $category)
                                            <option value="{{ $category }}" {{ old('tax_category', $product->tax_category) == $category ? 'selected' : '' }}>{{ strtoupper($category) }}</option>
                                        @endforeach
                                    </select>
                                    @error('tax_category') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tax Percentage<span class="text-danger ms-1">*</span></label>
                                    <select class="select" name="tax_percentage" required>
                                        <option value="">Select</option>
                                        @foreach (['0', '5', '18', '40'] as $tax)
                                            <option value="{{ $tax }}" {{ old('tax_percentage', $product->tax_percentage) == $tax ? 'selected' : '' }}>{{ $tax }}%</option>
                                        @endforeach
                                    </select>
                                    @error('tax_percentage') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Quantity Alert</label>
                                    <input type="text" class="form-control" name="quantity_alert" value="{{ old('quantity_alert', rtrim(rtrim($product->quantity_alert, '0'), '.')) }}" step="0.01" min="0">
                                    @error('quantity_alert') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item border mb-4">
                <h2 class="accordion-header" id="headingSpacingFour">
                    <div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingFour" aria-expanded="true" aria-controls="SpacingFour">
                        <div class="d-flex align-items-center justify-content-between flex-fill">
                            <h5 class="d-flex align-items-center"><i data-feather="list" class="text-primary me-2"></i><span>Custom Fields</span></h5>
                        </div>
                    </div>
                </h2>
                <div id="SpacingFour" class="accordion-collapse collapse show" aria-labelledby="headingSpacingFour">
                    <div class="accordion-body border-top">
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Manufactured Date</label>
                                    <div class="input-groupicon calender-input">
                                        <i data-feather="calendar" class="info-img"></i>
                                        <input type="text" class="datetimepicker form-control" name="manufactured_date" value="{{ old('manufactured_date', $product->manufactured_date ? \Carbon\Carbon::parse($product->manufactured_date)->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy">
                                    </div>
                                    @error('manufactured_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Expiry Date</label>
                                    <div class="input-groupicon calender-input">
                                        <i data-feather="calendar" class="info-img"></i>
                                        <input type="text" class="datetimepicker form-control" name="expiry_date" value="{{ old('expiry_date', $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy">
                                    </div>
                                    @error('expiry_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="d-flex align-items-center justify-content-end mb-4">
            <button type="button" class="btn btn-secondary me-2">Cancel</button>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </div>
    </div>
</form>

<!-- Add Category -->
<div class="modal fade" id="add-product-category">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="page-title">
                    <h4>Add Category</h4>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <label class="form-label">Category<span class="ms-1 text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary text-white fs-13 fw-medium p-2 px-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Category -->

<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Daterangepicker for single date selection
        $('.datetimepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            locale: {
                format: 'DD/MM/YYYY',
                separator: ' - ',
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
                daysOfWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        });
    });
</script> -->

@include('layouts.footer')