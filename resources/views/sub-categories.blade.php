@include('layouts.header')

@if (session('success'))
    <div id="successMessage" class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div id="errorMessage" class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">Sub Category</h4>
            <h6>Manage your sub categories</h6>
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
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-subcategory"><i class="ti ti-circle-plus me-1"></i>Add Sub Category</a>
    </div>
</div>

<!-- Subcategory List -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <div class="search-set">
            <div class="search-input">
                <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
            </div>
        </div>
        <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
            <div class="dropdown me-2">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown" id="categoryFilterBtn">
                    Category
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-category="">All</a>
                    </li>
                    @foreach ($categories as $category)
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item rounded-1" data-category="{{ $category->name }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- <div class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown" id="statusFilterBtn">
                    Status
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-status="">All</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-status="1">Active</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-status="0">Inactive</a>
                    </li>
                </ul>
            </div> -->
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table datatable" id="subcategoriesTable">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all">
                                <span class="checkmarks"></span>
                            </label>
                        </th>
                        <th>Image</th>
                        <th>Sub Category</th>
                        <th>Category</th>
                        <th>Created By</th>
                        <th>Created On</th>
                        <th>Status</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subcategories as $subcategory)
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" name="selected_subcategories[]" value="{{ $subcategory->id }}">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td>
                                <a class="avatar avatar-md bg-light-900 p-1 me-2">
                                    <img src="{{ $subcategory->image ? asset('storage/' . $subcategory->image) : asset('assets/img/brand/apple.png') }}" class="object-fit-contain" alt="img">
                                </a>
                            </td>
                            <td><span class="text-gray-9">{{ $subcategory->name }}</span></td>
                            <td><span class="text-gray-9">{{ $subcategory->category ? $subcategory->category->name : 'N/A' }}</span></td>
                            <td>
                                <span class="text-gray-9">
                                    @if ($subcategory->employee_id && $subcategory->employee)
                                        {{ $subcategory->employee->name }}
                                    @elseif ($subcategory->user_id && $subcategory->user)
                                        {{ $subcategory->user->name }}
                                    @else
                                        Unknown
                                    @endif
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($subcategory->created_at)->format('d M Y') }}</td>
                            <td>
                                <span class="badge table-badge {{ $subcategory->status == 1 ? 'bg-success' : 'bg-danger' }} fw-medium fs-10">
                                    {{ $subcategory->status_display }}
                                </span>
                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-subcategory-{{ $subcategory->id }}">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $subcategory->id }}" class="p-2" href="javascript:void(0);">
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
                            <td>No subcategories found.</td>
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

<!-- Add Subcategory Modal -->
<div class="modal fade" id="add-subcategory">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="page-title">
                    <h4>Add Sub Category</h4>
                </div>
                <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="add-image-upload">
                            <div class="add-image">
                                <span class="fw-normal"><i data-feather="plus-circle" class="plus-down-add"></i> Add Image</span>
                            </div>
                            <div class="new-employee-field">
                                <div class="mb-0">
                                    <div class="image-upload mb-2">
                                        <input type="file" name="image">
                                        <div class="image-uploads">
                                            <h4 class="fs-13 fw-medium">Upload Image</h4>
                                        </div>
                                    </div>
                                    <span>JPEG, PNG up to 2 MB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
                        <select class="select form-control" name="category_id">
                            <option value="">Select</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sub Category<span class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-0">
                        <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                            <span class="status-label">Status</span>
                            <input type="checkbox" id="user2" class="check" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                            <label for="user2" class="checktoggle"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Sub Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Subcategory Modals -->
@foreach ($subcategories as $subcategory)
    <div class="modal fade" id="edit-subcategory-{{ $subcategory->id }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="page-title">
                        <h4>Edit Sub Category</h4>
                    </div>
                    <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="add-image-upload">
                                <div class="add-image p-1 border-solid">
                                    <img src="{{ $subcategory->image ? asset('storage/' . $subcategory->image) : asset('assets/img/brand/apple.png') }}" alt="image">
                                    <a href="javascript:void(0);"><i data-feather="x" class="x-square-add image-close fs-12 text-white bg-danger rounded-1"></i></a>
                                </div>
                                <div class="new-employee-field">
                                    <div class="mb-0">
                                        <div class="image-upload mb-2">
                                            <input type="file" name="image">
                                            <div class="image-uploads">
                                                <h4 class="fs-13 fw-medium">Change Image</h4>
                                            </div>
                                        </div>
                                        <span>JPEG, PNG up to 2 MB</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
                            <select class="select form-control" name="category_id">
                                <option value="">Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sub Category<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $subcategory->name) }}">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-0">
                            <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                <span class="status-label">Status</span>
                                <input type="checkbox" id="user-{{ $subcategory->id }}" class="check" name="status" value="1" {{ old('status', $subcategory->status) == 1 ? 'checked' : '' }}>
                                <label for="user-{{ $subcategory->id }}" class="checktoggle"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach


@include('layouts.footer')


<!-- Delete Subcategory Modals -->
@foreach ($subcategories as $subcategory)
    <div class="modal fade" id="delete-modal-{{ $subcategory->id }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content p-5 px-3 text-center">
                        <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i class="ti ti-trash fs-24 text-danger"></i></span>
                        <h4 class="fs-20 fw-bold mb-2 mt-1">Delete Sub Category</h4>
                        <p class="mb-0 fs-16">Are you sure you want to delete {{ $subcategory->name }}?</p>
                        <div class="modal-footer-btn mt-3 d-flex justify-content-center">
                            <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('subcategories.destroy', $subcategory->id) }}" method="POST">
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


<script>
    $(document).ready(function() {
        // Hide success/error messages after 3 seconds
        setTimeout(function() {
            $('#successMessage').fadeOut('slow');
            $('#errorMessage').fadeOut('slow');
        }, 3000);

        let table = $('#subcategoriesTable').DataTable();

        // Select All Checkbox
        $('#select-all').on('click', function () {
            $('input[name="selected_subcategories[]"]').prop('checked', this.checked);
        });

        // Category Filter Logic
        $('.dropdown-menu [data-category]').on('click', function(e) {
            e.preventDefault();
            var categoryName = $(this).data('category');
            var btnText = categoryName === '' ? 'Category' : $(this).text();
            $('#categoryFilterBtn').text(btnText);
            if (categoryName !== '') {
                table.column(3).search(categoryName, true, false).draw();
            } else {
                table.column(3).search('').draw();
            }
        });

        // Status Filter Logic
        // $('.dropdown-menu [data-status]').on('click', function(e) {
        //     e.preventDefault();
        //     var status = $(this).data('status');
        //     var btnText = status === '' ? 'Status' : `Status: ${status == 1 ? 'Active' : 'Inactive'}`;
        //     $('#statusFilterBtn').text(btnText);
        //     if (status !== '') {
        //         var searchValue = status == 1 ? 'Active' : 'Inactive';
        //         table.column(6).search(searchValue, true, false).draw();
        //     } else {
        //         table.column(6).search('').draw();
        //     }
        // });
    });
</script>