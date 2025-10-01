@include('layouts.header')


<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">Product List</h4>
            <h6>Manage your products</h6>
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
    <div class="page-btn">
        <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="ti ti-circle-plus me-1"></i>Add Product</a>
    </div>
</div>

<!-- Product List -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <div class="search-set">
            <div class="search-input">
                <!-- <input type="text" class="form-control" placeholder="Search..." id="search-input"> -->
                <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
            </div>
        </div>
        <!-- <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
            <div class="dropdown me-2">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
                    Category
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-category-id="">All</a>
                    </li>
                    @if (!empty($categories) && $categories->count() > 0)
                        @foreach ($categories as $category)
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1" data-category-id="{{ $category->id }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    @else
                        <li><a href="javascript:void(0);" class="dropdown-item rounded-1">No Categories</a></li>
                    @endif
                </ul>
            </div>
            <div class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
                    Brand
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-brand-id="">All</a>
                    </li>
                    @if (!empty($brands) && $brands->count() > 0)
                        @foreach ($brands as $brand)
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1" data-brand-id="{{ $brand->id }}">{{ $brand->name }}</a>
                            </li>
                        @endforeach
                    @else
                        <li><a href="javascript:void(0);" class="dropdown-item rounded-1">No Brands</a></li>
                    @endif
                </ul>
            </div>
        </div> -->
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table datatable">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all">
                                <span class="checkmarks"></span>
                            </label>
                        </th>
                        <!-- <th>Barcode</th> -->
                        <th>Product Name</th>
                        <th>Category</th>
                        <!-- <th>Subcategory</th> -->
                        <th>Brand</th>
                        <th>Unit Price</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Tax Type</th>
                        <th>Tax Category</th>
                        <th>Tax Percentage</th>
                        <th>HSN/SAC Code</th>
                        <!-- <th>Quantity Alert</th> -->
                        <th>Manufactured Date</th>
                        <th>Expiry Date</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" name="selected_products[]" value="{{ $product->id }}">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="avatar avatar-md bg-light-900 p-1 me-2">
                                        <img  src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/img/brand/apple.png') }}"
                                            class="object-fit-contain" alt="img">
                                    </a>
                                    <a href="javascript:void(0);">{{ $product->name }}</a>
                                </div>
                            </td>
                            <!-- <td>{{ $product->barcode ?? 'N/A' }}</td> -->
                            <!-- <td>{{ $product->name }}</td> -->
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <!-- <td>{{ $product->subcategory->name ?? 'N/A' }}</td> -->
                            <td>{{ $product->brand->name ?? 'N/A' }}</td>
                            <td>₹{{ number_format($product->unit_price, 2) }}</td>
                            <td>{{ ucfirst($product->unit_of_measure) }}</td>
                            <!-- <td>{{ number_format($product->quantity) }}</td> -->
                            <td>{{ rtrim(rtrim(number_format($product->quantity, 2, '.', ''), '0'), '.') }}</td>
                            <td>{{ ucfirst($product->tax_type) }}</td>
                            <td>{{ strtoupper($product->tax_category) }}</td>
                            <td>{{ $product->tax_percentage }}%</td>
                            <td>{{ $product->hsn_sac_code ?? 'N/A' }}</td>
                            <!-- <td>{{ $product->quantity_alert ? number_format($product->quantity_alert, 2) : 'N/A' }}</td> -->
                            <td>{{ $product->manufactured_date ?? 'N/A' }}</td>
                            <td>{{ $product->expiry_date ?? 'N/A' }}</td>
                            <td>
                                <span class="text-gray-9">
                                    @if ($product->employee_id && $product->employee)
                                        {{ $product->employee->name }}
                                    @elseif ($product->user_id && $product->user)
                                        {{ $product->user->name }}
                                    @else
                                        Unknown
                                    @endif
                                </span>
                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <!-- <a class="me-2 edit-icon p-2" href="product-details"> -->
                                    <a class="me-2 edit-icon p-2" href="{{ route('products.show', $product->id) }}">
                                        <i data-feather="eye" class="action-eye"></i>
                                    </a>
                                    <a class="me-2 p-2" href="{{ route('products.edit', $product->id) }}">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $product->id }}" class="p-2" href="javascript:void(0);">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>No products found.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@include('layouts.footer')

@foreach ($products as $product)
    <div class="modal fade" id="delete-modal-{{ $product->id }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content p-5 px-3 text-center">
                        <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i class="ti ti-trash fs-24 text-danger"></i></span>
                        <h4 class="fs-20 text-gray-9 fw-bold mb-2 mt-1">Delete Product</h4>
                        <p class="text-gray-6 mb-0 fs-16">Are you sure you want to delete {{ $product->name }}?</p>
                        <div class="modal-footer-btn mt-3 d-flex justify-content-center">
                            <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary fs-13 fw-medium p-2 px-3">Yes Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach


<!-- <script>
    $(document).ready(function() {
        // Hide success message after 3 seconds
        setTimeout(function() {
            $('#successMessage').fadeOut('slow');
            $('#errorMessage').fadeOut('slow');
        }, 3000); // 3000 ms = 3 seconds
    });
    // this script is in footer
</script> -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize DataTable
    // const dataTable = $('.datatable').DataTable({
    //     searching: true,
    //     paging: true,
    //     ordering: true,
    //     info: true,
    //     columnDefs: [
    //         { orderable: false, targets: ['no-sort'] }
    //     ],
    //     language: {
    //         emptyTable: "No products found."
    //     },
    //     drawCallback: function(settings) {
    //         if (settings.aoData.length === 0) {
    //             $(this.api().table().node()).find('tbody').html('<tr><td></td><td>No products found.</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>');
    //         }
    //     }
    // });

    // Select All Checkbox
    $('#select-all').on('click', function () {
        $('input[name="selected_products[]"]').prop('checked', this.checked);
    });

    // Filter by Category
    $('.dropdown-menu [data-category-id]').on('click', function () {
        const categoryId = $(this).data('category-id');
        dataTable.column(3).search(categoryId ? '^' + $(this).text() + '$' : '', true, false).draw();
    });

    // Filter by Brand
    $('.dropdown-menu [data-brand-id]').on('click', function () {
        const brandId = $(this).data('brand-id');
        dataTable.column(5).search(brandId ? '^' + $(this).text() + '$' : '', true, false).draw();
    });

    // Search Input
    $('#search-input').on('keyup', function () {
        dataTable.search(this.value).draw();
    });
});
</script>