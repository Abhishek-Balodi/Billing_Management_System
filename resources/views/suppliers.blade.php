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
        <!-- <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
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

                        <th>Supplier</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
    @forelse($suppliers as $supplier)
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox">
                <span class="checkmarks"></span>
            </label>
        </td>
        <td>
            <div class="d-flex align-items-center">
                <a href="#" class="avatar avatar-md">
                    <img src="{{ $supplier->image ? asset('storage/'.$supplier->image) : asset('assets/img/supplier/default.png') }}"
                        class="img-fluid rounded-2" alt="Supplier Image">
                </a>
                <div class="ms-2">
                    <p class="text-gray-9 mb-0">
                        <a href="#">{{ $supplier->first_name }} {{ $supplier->last_name }}</a>
                    </p>
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
                <a class="me-2 p-2" href="#"><i data-feather="eye" class="feather-eye"></i></a>
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
    @empty
   
    @endforelse
</tbody>

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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!-- larger modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit Supplier</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editSupplierForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Profile Image -->
                        <div class="col-lg-12 text-center mb-3">
                            <div class="profile-pic-upload edit-pic">
                                <div class="profile-pic rounded-circle overflow-hidden mx-auto"
                                    style="width:120px; height:120px;">
                                    <img id="editSupplierImage" src="{{ asset('assets/img/supplier/default.png') }}"
                                        alt="Supplier Image" class="img-fluid">

                                </div>
                                <div class="mt-2">
                                    <label class="btn btn-sm btn-outline-primary">
                                        Change Image
                                        <input type="file" name="image" accept="image/*" hidden>
                                    </label>
                                    <small class="text-muted d-block mt-1">JPEG, PNG up to 2 MB</small>
                                </div>
                            </div>
                        </div>

                        <!-- First & Last Name -->
                        <div class="col-md-6">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-12">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-12">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>

                        <!-- Address -->
                        <div class="col-md-12">
                            <label>Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" required>
                        </div>

                        <!-- City & State -->
                        <div class="col-md-6">
                            <label>City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>State <span class="text-danger">*</span></label>
                            <input type="text" name="state" class="form-control" required>
                        </div>

                        <!-- Country & Postal -->
                        <div class="col-md-6">
                            <label>Country <span class="text-danger">*</span></label>
                            <input type="text" name="country" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Postal Code <span class="text-danger">*</span></label>
                            <input type="text" name="postal_code" class="form-control" required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_status" name="status">
                                <label class="form-check-label" for="edit_status">Active</label>
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

<!-- /Edit Supplier -->

<!-- Delete Modal -->
<div class="modal fade" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-5">
            <div class="modal-body text-center p-0">
                <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2">
                    <i class="ti ti-trash fs-24 text-danger"></i>
                </span>
                <h4 class="fs-20 text-gray-9 fw-bold mb-2 mt-1">Delete Supplier</h4>
                <p class="text-gray-6 mb-0 fs-16">Are you sure you want to delete supplier?</p>
                <div class="d-flex justify-content-center mt-3">
                    <button class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                        data-bs-dismiss="modal">Cancel</button>
                    <button id="confirmDelete" class="btn btn-primary fs-13 fw-medium p-2 px-3">Yes Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
$(document).on('click', '[data-bs-target="#edit-supplier"]', function() {
    var supplierId = $(this).data('id');
    $.get('/suppliers/' + supplierId + '/edit', function(data) {
        $('#editSupplierImage').attr('src', data.image ? '/storage/' + data.image :
            '{{ asset("assets/img/supplier/default.png") }}');
        $('#edit-supplier input[name="first_name"]').val(data.first_name);
        $('#edit-supplier input[name="last_name"]').val(data.last_name);
        $('#edit-supplier input[name="email"]').val(data.email);
        $('#edit-supplier input[name="phone"]').val(data.phone);
        $('#edit-supplier input[name="address"]').val(data.address);
        $('#edit-supplier input[name="city"]').val(data.city);
        $('#edit-supplier input[name="state"]').val(data.state);
        $('#edit-supplier input[name="country"]').val(data.country);
        $('#edit-supplier input[name="postal_code"]').val(data.postal_code);
        $('#edit_status').prop('checked', data.status == 1);
        $('#editSupplierForm').attr('action', '/suppliers/' + supplierId);
    });
});

// Preview selected image immediately
function previewEditImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        $('#editSupplierImage').attr('src', reader.result);
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<script>
let deleteSupplierId = null;

// Open delete modal & set supplier ID
$(document).on('click', '[data-bs-target="#delete-modal"]', function() {
    deleteSupplierId = $(this).data('id'); // set supplier ID from clicked button

});

// Confirm delete
$('#confirmDelete').on('click', function() {
    if (deleteSupplierId) {
        $.ajax({
            url: '/suppliers/' + deleteSupplierId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                $('#delete-modal').modal('hide');
                 alert(res.success); // ya toastr
                location.reload(); // table refresh
            },
            error: function(err) {
                 alert('Error deleting supplier');
            }
        });
    }
});
</script>
<script>
$(document).ready(function() {
   $('.datatable').DataTable({
    destroy: true, // automatically destroy old instance
    "columnDefs": [
        { "orderable": false, "targets": [0,6] }
    ],
    "language": {
        "emptyTable": "No suppliers found"
    }
});
});

</script>
