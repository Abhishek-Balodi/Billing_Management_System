@include('layouts.header')
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Suppliers</h4>
            <h6>Manage your suppliers</h6>
        </div>
    </div>
    <ul class="table-top-head">
        <li class="me-2">
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="assets/img/icons/pdf.svg"
                    alt="img"></a>
        </li>
        <li class="me-2">
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img src="assets/img/icons/excel.svg"
                    alt="img"></a>
        </li>
        <li class="me-2">
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a>
        </li>
        <li class="me-2">
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                    class="ti ti-chevron-up"></i></a>
        </li>
    </ul>
    <div class="page-btn">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-supplier"><i
                class="ti ti-circle-plus me-1"></i>Add Supplier</a>
    </div>
</div>
<!-- /product list -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <div class="search-set">
            <div class="search-input">
                <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
            </div>
        </div>
        <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
            <div class="dropdown">
                <a href="javascript:void(0);"
                    class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                    data-bs-toggle="dropdown">
                    Status
                </a>
                <ul class="dropdown-menu  dropdown-menu-end p-3">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Active</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Inactive</a>
                    </li>
                </ul>
            </div>
        </div>
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

                        <th>Supplier</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliers as $supplier)
                    <tr>
                        <td>
                            <label class="checkboxs">
                                <input type="checkbox">
                                <span class="checkmarks"></span>
                            </label>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="#" class="avatar avatar-md"> <img
                                        src="{{ $supplier->image ? asset('storage/'.$supplier->image) : 'assets/img/supplier/default.png' }}"
                                        class="img-fluid rounded-2" alt="img"></a>
                                <div class="ms-2">
                                    <p class="text-gray-9 mb-0"> <a href="#">{{ $supplier->first_name }}
                                            {{ $supplier->last_name }}</a></p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $supplier->email }}</td>
                        <td>{{ $supplier->phone }}</td>
                        <td>{{ $supplier->country }}</td>
                        <td>
                            @if($supplier->status == 1)
                            <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                <i class="ti ti-point-filled me-1"></i>Active
                            </span>
                            @else
                            <span class="badge badge-danger d-inline-flex align-items-center badge-xs">
                                <i class="ti ti-point-filled me-1"></i>Inactive
                            </span>
                            @endif
                        </td>
                        <td class="action-table-data">
                            <div class="edit-delete-action">
                                <a class="me-2 p-2" href="#">
                                    <i data-feather="eye" class="feather-eye"></i>
                                </a>
                                <a class="me-2 p-2" href="javascript:void(0);" data-bs-toggle="modal"
                                    data-bs-target="#edit-supplier" data-id="{{ $supplier->id }}">
                                    <i data-feather="edit" class="feather-edit"></i>
                                </a>
                                <a class="p-2" href="javascript:void(0);" data-bs-toggle="modal"
                                    data-bs-target="#delete-modal" data-id="{{ $supplier->id }}">
                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
            </table>
        </div>
    </div>
</div>
<!-- /product list -->

@include('layouts.footer')
<!-- /Main Wrapper -->

<!-- Add Supplier -->
<div class="modal fade" id="add-supplier">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="page-title">
                    <h4>Add Supplier</h4>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Profile Image -->
                        <div class="col-lg-12">
                            <div class="new-employee-field">
                                <div class="profile-pic-upload mb-2">
                                    <div class="profile-pic">
                                        <span><i data-feather="plus-circle" class="plus-down-add"></i>Add Image</span>
                                    </div>
                                    <div class="mb-0">
                                        <div class="image-upload mb-2">
                                            <input type="file" name="image" accept="image/jpeg,image/png">
                                            <div class="image-uploads">
                                                <h4>Upload Image</h4>
                                            </div>
                                        </div>
                                        <p>JPEG, PNG up to 2 MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- First Name -->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                        </div>

                        <!-- City -->
                        <div class="col-lg-6 col-sm-10 col-10">
                            <div class="mb-3">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                        </div>

                        <!-- State -->
                        <div class="col-lg-6 col-sm-10 col-10">
                            <div class="mb-3">
                                <label class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" name="state" class="form-control" required>
                                   
                                </input>
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="col-lg-6 col-sm-10 col-10">
                            <div class="mb-3">
                                <label class="form-label">Country <span class="text-danger">*</span></label>
                                <input type="text" name="country" class="form-control" required>
                                    
                                </input>
                            </div>
                        </div>

                        <!-- Postal Code -->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                                <input type="text" name="postal_code" class="form-control" required>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-12">
                            <div class="mb-0">
                                <div
                                    class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                    <span class="status-label">Status</span>
                                    <input type="checkbox" name="status" id="status" class="check" checked>
                                    <label for="status" class="checktoggle mb-0"></label>
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

<!-- /Add Supplier -->

<!-- Edit Supplier -->
<div class="modal fade" id="edit-supplier">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="content">
                <div class="modal-header">
                    <div class="page-title">
                        <h4>Edit Supplier</h4>
                    </div>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="https://dreamspos.dreamstechnologies.com/html/template/suppliers.html">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="new-employee-field">
                                    <div class="profile-pic-upload edit-pic">
                                        <div class="profile-pic">
                                            <span><img src="assets/img/supplier/edit-supplier.jpg" alt="Img"></span>
                                            <div class="close-img">
                                                <i data-feather="x" class="info-img"></i>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <div class="image-upload mb-0">
                                                <input type="file">
                                                <div class="image-uploads">
                                                    <h4>Change Image</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="Apex">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="Computers">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" value="carlevans@example.com">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="+15964712634">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="46 Perry Street">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-10 col-10">
                                <div class="mb-3">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Varrel</option>
                                        <option selected>Los Angels</option>
                                        <option>Munich</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-10 col-10">
                                <div class="mb-3">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Bavaria</option>
                                        <option>New York City</option>
                                        <option selected>California</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-10 col-10">
                                <div class="mb-3">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Germany</option>
                                        <option>Mexico</option>
                                        <option selected>United States</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="10176">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-0">
                                    <div
                                        class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                        <span class="status-label">Status</span>
                                        <input type="checkbox" id="users6" class="check" checked>
                                        <label for="users6" class="checktoggle mb-0"></label>
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
</div>
<!-- /Edit Supplier -->

<!-- Delete Modal -->
<div class="modal fade" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-5">
            <div class="modal-body text-center p-0">
                <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i
                        class="ti ti-trash fs-24 text-danger"></i></span>
                <h4 class="fs-20 text-gray-9 fw-bold mb-2 mt-1">Delete Supplier</h4>
                <p class="text-gray-6 mb-0 fs-16">Are you sure you want to delete supplier?</p>
                <div class="d-flex justify-content-center mt-3">
                    <a class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                        data-bs-dismiss="modal">Cancel</a>
                    <a href="suppliers.html" class="btn btn-primary fs-13 fw-medium p-2 px-3">Yes Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->