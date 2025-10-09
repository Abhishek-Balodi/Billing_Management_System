@include('layouts.header')

<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">Suppliers</h4>
            <h6>Manage your suppliers</h6>
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
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-supplier"><i class="ti ti-circle-plus me-1"></i>Add Supplier</a>
    </div>
</div>

<!-- Supplier List -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <div class="search-set">
            <div class="search-input">
                <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
            </div>
        </div>
        <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
            <div class="dropdown me-2">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown" id="sortByBtn">
                    Sort By : Latest
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-sort="latest">Latest</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-sort="asc">Ascending</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-sort="desc">Descending</a>
                    </li>
                </ul>
            </div>
            <div class="dropdown">
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
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table datatable" id="suppliersTable">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all">
                                <span class="checkmarks"></span>
                            </label>
                        </th>
                        <!-- <th>Image</th> -->
                        <th>Supplier</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Postal Code</th>
                        <th>GSTIN</th>
                        <th>PAN</th>
                        <th>Company Name</th>
                        <th>Website</th>
                        <th>Created By</th>
                        <th>Created On</th>
                        <th>Status</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" name="selected_suppliers[]" value="{{ $supplier->id }}">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <!-- <td>
                                <a class="avatar avatar-md bg-light-900 p-1 me-2">
                                    <img src="{{ $supplier->image ? asset('storage/' . $supplier->image) : asset('assets/img/supplier/supplier-01.png') }}" class="object-fit-contain" alt="img">
                                </a>
                            </td> -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="avatar avatar-md bg-light-900 p-1 me-2">
                                        <img  src="{{ $supplier->image ? asset('storage/' . $supplier->image) : asset('assets/img/supplier/supplier-01.png') }}"
                                            class="object-fit-contain" alt="img">
    
                                    </a>
                                    <div class="ms-2">
                                        <p class="text-gray-9"> <a href="#">{{ $supplier->first_name }} {{ $supplier->last_name }}
                                        </a></p>
                                    </div>
                                </div>
                            </td>
                            <!-- <td><span class="text-gray-9">{{ $supplier->first_name }} {{ $supplier->last_name }}</span></td> -->
                            <td><a href="mailto:{{ $supplier->email }}">{{ $supplier->email }}</a></td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>{{ $supplier->city }}</td>
                            <td>{{ $supplier->state }}</td>
                            <td>{{ $supplier->country }}</td>
                            <td>{{ $supplier->postal_code }}</td>
                            <td>{{ $supplier->gstin ?? 'N/A' }}</td>
                            <td>{{ $supplier->pan ?? 'N/A' }}</td>
                            <td>{{ $supplier->company_name ?? 'N/A' }}</td>
                            <td><a href="{{ $supplier->website ?? '#' }}" target="_blank">{{ $supplier->website ?? 'N/A' }}</a></td>
                            <td>
                                <span class="text-gray-9">
                                    @if ($supplier->employee_id && $supplier->employee)
                                        {{ $supplier->employee->name }}
                                    @elseif ($supplier->user_id && $supplier->user)
                                        {{ $supplier->user->name }}
                                    @else
                                        Unknown
                                    @endif
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($supplier->created_at)->format('d M Y') }}</td>
                            <td>
                                <span class="badge table-badge {{ $supplier->status ? 'bg-success' : 'bg-danger' }} fw-medium fs-10">
                                    {{ $supplier->status_display }}
                                </span>
                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-supplier-{{ $supplier->id }}">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a class="p-2" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $supplier->id }}">
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
                            <td></td>
                            <td colspan="18" class="text-center">No suppliers found.</td>
                            <td></td>
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

<!-- Add Supplier Modal -->
<div class="modal fade" id="add-supplier">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="page-title">
                    <h4>Add Supplier</h4>
                </div>
                <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">First Name <span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                                @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name <span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                                @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger ms-1">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Phone <span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Address <span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">City <span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="city" value="{{ old('city') }}">
                                @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">State <span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="state" value="{{ old('state') }}">
                                @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Country <span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="country" value="{{ old('country') }}">
                                @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Postal Code <span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code') }}">
                                @error('postal_code') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">GSTIN</label>
                                <input type="text" class="form-control" name="gstin" value="{{ old('gstin') }}">
                                @error('gstin') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">PAN</label>
                                <input type="text" class="form-control" name="pan" value="{{ old('pan') }}">
                                @error('pan') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Company Name</label>
                                <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}">
                                @error('company_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Website</label>
                                <input type="url" class="form-control" name="website" value="{{ old('website') }}">
                                @error('website') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-0">
                                <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                    <span class="status-label">Status</span>
                                    <input type="checkbox" id="user2" class="check" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                    <label for="user2" class="checktoggle"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('layouts.footer')


<!-- Edit Supplier Modals -->
@foreach ($suppliers as $supplier)
    <div class="modal fade" id="edit-supplier-{{ $supplier->id }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="page-title">
                        <h4>Edit Supplier</h4>
                    </div>
                    <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="add-image-upload">
                                <div class="add-image p-1 border-solid">
                                    <img src="{{ $supplier->image ? asset('storage/' . $supplier->image) : asset('assets/img/supplier/supplier-01.png') }}" alt="image">
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
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name <span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $supplier->first_name) }}">
                                    @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name <span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $supplier->last_name) }}">
                                    @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger ms-1">*</span></label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $supplier->email) }}">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Phone <span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $supplier->phone) }}">
                                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Address <span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address', $supplier->address) }}">
                                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">City <span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control" name="city" value="{{ old('city', $supplier->city) }}">
                                    @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">State <span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control" name="state" value="{{ old('state', $supplier->state) }}">
                                    @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Country <span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control" name="country" value="{{ old('country', $supplier->country) }}">
                                    @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Postal Code <span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code', $supplier->postal_code) }}">
                                    @error('postal_code') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">GSTIN</label>
                                    <input type="text" class="form-control" name="gstin" value="{{ old('gstin', $supplier->gstin) }}">
                                    @error('gstin') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">PAN</label>
                                    <input type="text" class="form-control" name="pan" value="{{ old('pan', $supplier->pan) }}">
                                    @error('pan') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control" name="company_name" value="{{ old('company_name', $supplier->company_name) }}">
                                    @error('company_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Website</label>
                                    <input type="url" class="form-control" name="website" value="{{ old('website', $supplier->website) }}">
                                    @error('website') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-0">
                                    <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                        <span class="status-label">Status</span>
                                        <input type="checkbox" id="user-{{ $supplier->id }}" class="check" name="status" value="1" {{ old('status', $supplier->status) == 1 ? 'checked' : '' }}>
                                        <label for="user-{{ $supplier->id }}" class="checktoggle"></label>
                                    </div>
                                </div>
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

<!-- Delete Supplier Modals -->
@foreach ($suppliers as $supplier)
    <div class="modal fade" id="delete-modal-{{ $supplier->id }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content p-5 px-3 text-center">
                        <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i class="ti ti-trash fs-24 text-danger"></i></span>
                        <h4 class="fs-20 fw-bold mb-2 mt-1">Delete Supplier</h4>
                        <p class="mb-0 fs-16">Are you sure you want to delete {{ $supplier->first_name }} {{ $supplier->last_name }}?</p>
                        <div class="modal-footer-btn mt-3 d-flex justify-content-center">
                            <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST">
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
        let table = $('#suppliersTable').DataTable();

        // Select All Checkbox
        $('#select-all').on('click', function () {
            $('input[name="selected_suppliers[]"]').prop('checked', this.checked);
        });

        // Sort By Logic
        $('.dropdown-menu [data-sort]').on('click', function(e) {
            e.preventDefault();
            var sortType = $(this).data('sort');
            var btnText = 'Sort By: ' + $(this).text();
            $('#sortByBtn').text(btnText);

            if (sortType === 'latest') {
                table.order([15, 'desc']).draw(); // Created On descending
            } else if (sortType === 'asc') {
                table.order([2, 'asc']).draw(); // Supplier Name ascending
            } else if (sortType === 'desc') {
                table.order([2, 'desc']).draw(); // Supplier Name descending
            }
        });

        // Status Filter Logic
        $('.dropdown-menu [data-status]').on('click', function(e) {
            e.preventDefault();
            var status = $(this).data('status');
            var btnText = status === '' ? 'Status' : `Status: ${status == 1 ? 'Active' : 'Inactive'}`;
            $('#statusFilterBtn').text(btnText);
            if (status !== '') {
                var searchValue = status == 1 ? 'Active' : 'Inactive';
                table.column(16).search(searchValue, true, false).draw();
            } else {
                table.column(16).search('').draw();
            }
        });
    });
</script>