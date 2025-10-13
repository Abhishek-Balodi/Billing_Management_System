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

<form action="{{ route('products.update', $product->id) }}" method="POST" class="add-product-form" enctype="multipart/form-data">
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
                                    <label class="form-label">Store</label>
                                    <select class="select" name="store_id">
                                        <option value="">Select</option>
                                        <option value="1" {{ old('store_id', $product->store_id) == '1' ? 'selected' : '' }}>Electro Mart</option>
                                        <option value="2" {{ old('store_id', $product->store_id) == '2' ? 'selected' : '' }}>Quantum Gadgets</option>
                                        <option value="3" {{ old('store_id', $product->store_id) == '3' ? 'selected' : '' }}>Gadget World</option>
                                        <option value="4" {{ old('store_id', $product->store_id) == '4' ? 'selected' : '' }}>Volt Vault</option>
                                        <option value="5" {{ old('store_id', $product->store_id) == '5' ? 'selected' : '' }}>Elite Retail</option>
                                        <option value="6" {{ old('store_id', $product->store_id) == '6' ? 'selected' : '' }}>Prime Mart</option>
                                        <option value="7" {{ old('store_id', $product->store_id) == '7' ? 'selected' : '' }}>NeoTech Store</option>
                                    </select>
                                    @error('store_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Warehouse</label>
                                    <select class="select" name="warehouse_id">
                                        <option value="">Select</option>
                                        <option value="1" {{ old('warehouse_id', $product->warehouse_id) == '1' ? 'selected' : '' }}>Lavish Warehouse</option>
                                        <option value="2" {{ old('warehouse_id', $product->warehouse_id) == '2' ? 'selected' : '' }}>Quaint Warehouse</option>
                                        <option value="3" {{ old('warehouse_id', $product->warehouse_id) == '3' ? 'selected' : '' }}>Traditional Warehouse</option>
                                        <option value="4" {{ old('warehouse_id', $product->warehouse_id) == '4' ? 'selected' : '' }}>Cool Warehouse</option>
                                        <option value="5" {{ old('warehouse_id', $product->warehouse_id) == '5' ? 'selected' : '' }}>Overflow Warehouse</option>
                                        <option value="6" {{ old('warehouse_id', $product->warehouse_id) == '6' ? 'selected' : '' }}>Nova Storage Hub</option>
                                        <option value="7" {{ old('warehouse_id', $product->warehouse_id) == '7' ? 'selected' : '' }}>Retail Supply Hub</option>
                                        <option value="8" {{ old('warehouse_id', $product->warehouse_id) == '8' ? 'selected' : '' }}>EdgeWare Solutions</option>
                                    </select>
                                    @error('warehouse_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
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
                                    <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
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
                                <div class="mb-3">
                                    <label class="form-label">Barcode Symbology<span class="text-danger ms-1">*</span></label>
                                    <select class="select" name="barcode_symbology" required>
                                        <option value="">Select</option>
                                        @foreach (['Code 128', 'Code 39', 'UPC-A', 'UPC-E', 'EAN-8', 'EAN-13'] as $symbology)
                                            <option value="{{ $symbology }}" {{ old('barcode_symbology', $product->barcode_symbology) == $symbology ? 'selected' : '' }}>{{ $symbology }}</option>
                                        @endforeach
                                    </select>
                                    @error('barcode_symbology') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Selling Type<span class="text-danger ms-1">*</span></label>
                                    <select class="select" name="selling_type" required>
                                        <option value="">Select</option>
                                        @foreach (['online', 'cash'] as $type)
                                            <option value="{{ $type }}" {{ old('selling_type', $product->selling_type) == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                        @endforeach
                                    </select>
                                    @error('selling_type') <span class="text-danger">{{ $message }}</span> @enderror
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
                            <div class="summer-description-box">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                                <p class="fs-14 mt-1">Minimum 60 Words</p>
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
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Discount Type</label>
                                    <select class="select" name="discount_type">
                                        <option value="">Select</option>
                                        @foreach (['percentage', 'fixed'] as $type)
                                            <option value="{{ $type }}" {{ old('discount_type', $product->discount_type) == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                        @endforeach
                                    </select>
                                    @error('discount_type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Discount Value</label>
                                    <input type="text" class="form-control" name="discount_value" value="{{ old('discount_value', $product->discount_value) }}" step="0.01" min="0">
                                    @error('discount_value') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item border mb-4">
                <h2 class="accordion-header" id="headingSpacingThree">
                    <div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingThree" aria-expanded="true" aria-controls="SpacingThree">
                        <div class="d-flex align-items-center justify-content-between flex-fill">
                            <h5 class="d-flex align-items-center"><i data-feather="image" class="text-primary me-2"></i><span>Images</span></h5>
                        </div>
                    </div>
                </h2>
                <div id="SpacingThree" class="accordion-collapse collapse show" aria-labelledby="headingSpacingThree">
                    <div class="accordion-body border-top">
                        <div class="text-editor add-list add">
                            <div class="col-lg-12">
                                <div class="add-choosen">
                                    <div class="mb-3">
                                        <div class="image-upload image-upload-two">
                                            <input type="file" name="image" accept="image/*">
                                            <div class="image-uploads">
                                                <i data-feather="plus-circle" class="plus-down-add me-0"></i>
                                                <h4>Add Image</h4>
                                            </div>
                                        </div>
                                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="phone-img">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/img/products/phone-add-2.png') }}" alt="image" id="image-preview">
                                        <a href="javascript:void(0);"><i data-feather="x" class="x-square-add remove-product"></i></a>
                                    </div>
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
                                    <label class="form-label">Warranties</label>
                                    <select class="select" name="warranties">
                                        <option value="">Select</option>
                                        @foreach (['Replacement Warranty', 'On-Site Warranty', 'Accidental Protection Plan'] as $warranty)
                                            <option value="{{ $warranty }}" {{ old('warranties', $product->warranties) == $warranty ? 'selected' : '' }}>{{ $warranty }}</option>
                                        @endforeach
                                    </select>
                                    @error('warranties') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Manufacturer</label>
                                    <input type="text" class="form-control" name="manufacturer" value="{{ old('manufacturer', $product->manufacturer) }}">
                                    @error('manufacturer') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
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
                <form action="{{ route('categories.productpage_store') }}" method="POST">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Daterangepicker for single date selection
        // $('.datetimepicker').daterangepicker({
        //     singleDatePicker: true,
        //     showDropdowns: true,
        //     autoApply: true,
        //     locale: {
        //         format: 'DD/MM/YYYY',
        //         separator: ' - ',
        //         applyLabel: 'Apply',
        //         cancelLabel: 'Cancel',
        //         daysOfWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        //         monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        //         firstDay: 1
        //     }
        // });

        // Image preview logic
        const imageInput = document.querySelector('input[name="image"]');
        const phoneImgDiv = document.querySelector('.phone-img');
        const previewImg = document.querySelector('#image-preview');
        const removeBtn = document.querySelector('.remove-product');
        const defaultImage = "{{ asset('assets/img/products/phone-add-2.png') }}";
        const existingImage = "{{ $product->image ? asset('storage/' . $product->image) : '' }}";

        // Initialize image preview
        if (existingImage) {
            previewImg.src = existingImage;
            phoneImgDiv.style.display = 'block'; // Show existing image
        } else {
            previewImg.src = defaultImage;
            phoneImgDiv.style.display = 'none'; // Hide if no image
        }

        // Image preview on file selection
        imageInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result; // Set uploaded image
                    phoneImgDiv.style.display = 'block'; // Show preview div
                };
                reader.readAsDataURL(file);
            } else {
                previewImg.src = existingImage || defaultImage; // Reset to existing or default
                phoneImgDiv.style.display = existingImage ? 'block' : 'none';
            }
        });

        // Remove image on click
        removeBtn.addEventListener('click', function () {
            imageInput.value = ''; // Clear the file input
            previewImg.src = defaultImage; // Reset to default image
            phoneImgDiv.style.display = 'none'; // Hide the preview div
        });

        // Initialize Feather icons
        feather.replace();
    });
</script>

@include('layouts.footer')