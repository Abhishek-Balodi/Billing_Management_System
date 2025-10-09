@include('layouts.header')
<div class="page-header">
    <div class="page-title">
        <h4>Product Details</h4>
        <h6>Full details of a product</h6>
    </div>
</div>
<!-- /add -->
<div class="row">
    <div class="col-lg-8 col-sm-12">
        <div class="card">
            <div class="card-body">
                <!-- <div class="bar-code-view">
                    <img src="{{ $product->barcode ? asset('assets/img/barcode/barcode1.png') : asset('assets/img/barcode/barcode1.png') }}" alt="barcode">
                    <a class="printimg">
                        <img src="{{ asset('assets/img/icons/printer.svg') }}" alt="print">
                    </a>
                </div> -->
                <div class="productdetails">
                    <ul class="product-bar">
                        <li>
                            <h4>Product</h4>
                            <h6>{{ $product->name ?? 'N/A' }}</h6>
                        </li>
                        <li>
                            <h4>Category</h4>
                            <h6>{{ $product->category ? $product->category->name : 'None' }}</h6>
                        </li>
                        <li>
                            <h4>Sub Category</h4>
                            <h6>{{ $product->subcategory ? $product->subcategory->name : 'None' }}</h6>
                        </li>
                        <li>
                            <h4>Brand</h4>
                            <h6>{{ $product->brand ? $product->brand->name : 'None' }}</h6>
                        </li>
                        <li>
                            <h4>Unit</h4>
                            <h6>{{ $product->unit_of_measure ? ucfirst($product->unit_of_measure) : 'None' }}</h6>
                        </li>
                        <!-- <li>
                            <h4>SKU</h4>
                            <h6>{{ $product->barcode ?? 'N/A' }}</h6>
                        </li> -->
                        <li>
                            <h4>Minimum Qty</h4>
                            <h6>{{ $product->quantity_alert ? number_format($product->quantity_alert, 2) : 'None' }}</h6>
                        </li>
                        <li>
                            <h4>Quantity</h4>
                            <h6>{{ $product->quantity ? number_format($product->quantity, 2) : '0.00' }}</h6>
                        </li>
                        <li>
                            <h4>Tax</h4>
                            <h6>{{ $product->tax_percentage ? $product->tax_percentage . '%' : '0.00%' }}</h6>
                        </li>
                        <li>
                            <h4>Discount Type</h4>
                            <h6>{{ $product->discount_type ? ucfirst($product->discount_type) : 'None' }}</h6>
                        </li>
                        <li>
                            <h4>Price</h4>
                            <h6>{{ $product->unit_price ? number_format($product->unit_price, 2) : '0.00' }}</h6>
                        </li>
                        <li>
                            <h4>Status</h4>
                            <h6>{{ $product->status ?? 'Active' }}</h6>
                        </li>
                        <li>
                            <h4>Description</h4>
                            <h6>{{ $product->description ?? 'No description available' }}</h6>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="slider-product-details">
                    <div class="slider-product">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/img/products/phone-add-2.png') }}" alt="img">
                        <h4>{{ $product->name ? basename($product->name) : 'phone-add-2.png' }}</h4>
                        <!-- <h6>581kb</h6>  -->
                        <!-- Placeholder, as file size not in schema -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /add -->
@include('layouts.footer')