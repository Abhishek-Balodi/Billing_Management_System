@include('layouts.header')
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">Customers</h4>
            <h6>Manage your customers</h6>
        </div>
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>
    <ul class="table-top-head">
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="assets/img/icons/pdf.svg"
                    alt="img"></a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img src="assets/img/icons/excel.svg"
                    alt="img"></a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                    class="ti ti-chevron-up"></i></a>
        </li>
    </ul>
    <div class="page-btn">
        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add-customer"><i
                class="ti ti-circle-plus me-1"></i>Add Customer</a>
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
                        <!-- <th>Code</th> -->
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>
                            <label class="checkboxs">
                                <input type="checkbox">
                                <span class="checkmarks"></span>
                            </label>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                   <img src="{{ $customer->image ? asset('storage/'.$customer->image) : asset('assets/img/customer/default.png') }}" class="img-fluid rounded-2" alt="Customer Image">

                                </a>
                                <div class="ms-2">
                                    <p class="text-gray-9 mb-0">
                                        <a href="#">{{ $customer->first_name }} {{ $customer->last_name }}</a>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->country }}</td>
                        <td>
                            @if($customer->status)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Inactive</span>
                            @endif
                         </td>
                        <td>
                            <div class="edit-delete-action">
                               <a href="javascript:void(0);" 
   class="me-2" 
   data-bs-toggle="modal" 
   data-bs-target="#edit-customer" 
   data-id="{{ $customer->id }}"
   data-first_name="{{ $customer->first_name }}"
   data-last_name="{{ $customer->last_name }}"
   data-email="{{ $customer->email }}"
   data-phone="{{ $customer->phone }}"
   data-address="{{ $customer->address }}"
   data-city="{{ $customer->city }}"
   data-state="{{ $customer->state }}"
   data-country="{{ $customer->country }}"
   data-postal_code="{{ $customer->postal_code }}"
   data-status="{{ $customer->status }}"
   data-image="{{ $customer->image ? asset('storage/'.$customer->image) : asset('assets/img/customer/default.png') }}">
   <i data-feather="edit"></i>
</a>

                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete-modal" data-id="{{ $customer->id }}">
                                    <i data-feather="trash-2"></i>
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

</div>
<!-- /Main Wrapper -->

<!-- Add Customer -->
<div class="modal fade" id="add-customer">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="page-title">
                    <h4>Add Customer</h4>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="new-employee-field">
                        <div class="profile-pic-upload">
                            <div class="profile-pic">
                                <span><i data-feather="plus-circle" class="plus-down-add"></i> Add Image</span>
                            </div>
                            <div class="mb-3">
                                <div class="image-upload mb-0">
                                    <input type="file" name="image">
                                    <div class="image-uploads">
                                        <h4>Upload Image</h4>
                                    </div>
                                </div>
                                <p class="mt-2">JPEG, PNG up to 2 MB</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">First Name<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Last Name<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Email<span class="text-danger ms-1">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Phone<span class="text-danger ms-1">*</span></label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Address<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">City<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">State<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="state" class="form-control" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Country<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="country" class="form-control" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Postal Code<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="postal_code" class="form-control" required>
                        </div>
                        <div class="col-lg-12">
                            <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                <span class="status-label">Status</span>
                                <input type="checkbox" id="user1" name="status" class="check" value="1" checked>
                                <label for="user1" class="checktoggle"> </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fs-13 fw-medium p-2 px-3">Add Customer</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- /Add Customer -->

<!-- Edit Customer -->
<!-- Edit Customer Modal (Single modal for all rows) -->
<div class="modal fade" id="edit-customer">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Edit Customer</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                   <form id="edit-customer-form" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

                        <div class="modal-body">
                            <div class="new-employee-field">
                                <div class="profile-pic-upload image-field">
                                    <div class="profile-pic p-2">
                                        <img id="edit-preview" src="{{ asset('assets/img/customer/default.png') }}" class="object-fit-cover h-100 rounded-1" alt="Customer Image">
                                    </div>
                                    <div class="mb-3">
                                        <div class="image-upload mb-0">
                                            <input type="file" name="image" onchange="previewImage(this, 'edit-preview')">
                                            <div class="image-uploads">
                                                <h4>Change Image</h4>
                                            </div>
                                        </div>
                                        <p class="mt-2">JPEG, PNG up to 2 MB</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">First Name<span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="first_name" id="edit-first_name" class="form-control" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Last Name<span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="last_name" id="edit-last_name" class="form-control" required>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">Email<span class="text-danger ms-1">*</span></label>
                                    <input type="email" name="email" id="edit-email" class="form-control" required>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">Phone<span class="text-danger ms-1">*</span></label>
                                    <input type="tel" name="phone" id="edit-phone" class="form-control" required>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">Address<span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="address" id="edit-address" class="form-control" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">City<span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="city" id="edit-city" class="form-control" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">State<span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="state" id="edit-state" class="form-control" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Country<span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="country" id="edit-country" class="form-control" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Postal Code<span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="postal_code" id="edit-postal_code" class="form-control" required>
                                </div>
                                <div class="col-lg-12">
                                    <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                        <span class="status-label">Status</span>
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" id="edit-status" name="status" class="check">
                                        <label for="edit-status" class="checktoggle"> </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary fs-13 fw-medium p-2 px-3">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- /Edit Customer -->

<!-- delete modal -->
<div class="modal fade" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content p-5 px-3 text-center">
                    <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2">
                        <i class="ti ti-trash fs-24 text-danger"></i>
                    </span>
                    <h4 class="fs-20 fw-bold mb-2 mt-1">Delete Customer</h4>
                    <p class="mb-0 fs-16">Are you sure you want to delete this customer?</p>
                    <div class="modal-footer-btn mt-3 d-flex justify-content-center">
                        <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                                data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="confirmDelete" class="btn btn-primary fs-13 fw-medium p-2 px-3">Yes Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





@include('layouts.footer')


<script>
$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('.datatable')) {
        $('.datatable').DataTable({
            language: {
                emptyTable: "No Data Found"
            }
        });
    }
});
</script>

<script>
function previewImage(input, previewId) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>

<script>
let deleteCustomerId = null;

// Open modal & set customer ID
$(document).on('click', '[data-bs-target="#delete-modal"]', function() {
    deleteCustomerId = $(this).data('id'); // set clicked customer ID
});

// Confirm delete
$('#confirmDelete').on('click', function() {
    if(deleteCustomerId){
       $.ajax({
    url: '/customers/' + deleteCustomerId,
    type: 'DELETE',
    data: {
        _token: '{{ csrf_token() }}'
    },
            success: function(res){
                $('#delete-modal').modal('hide');
                alert(res.success); // ya toastr use kar sakte ho
                location.reload(); // reload table
            },
            error: function(err){
                alert('Error deleting customer');
            }
        });
    }
});
</script>


<!-- JS to populate modal -->
<script>
function previewImage(input, previewId) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>
<script>
/* Helper to read raw data-* attributes (no jQuery auto parsing issues) */
function dataAttr(el, name){
    return $(el).attr('data-' + name);
}
$('.edit-delete-action a[data-bs-target="#edit-customer"]').on('click', function() {
        // console.log($('#edit-customer-form').attr('action'));
    const btn = $(this);
    const id = btn.data('id'); // yahan .data() safe hai
    const form = $('#edit-customer-form');



    // Laravel route format
    form.attr('action', '{{ url("customers") }}/' + id);

    // Populate fields
    $('#edit-first_name').val(btn.data('first_name'));
    $('#edit-last_name').val(btn.data('last_name'));
    $('#edit-email').val(btn.data('email'));
    $('#edit-phone').val(btn.data('phone'));
    $('#edit-address').val(btn.data('address'));
    $('#edit-city').val(btn.data('city'));
    $('#edit-state').val(btn.data('state'));
    $('#edit-country').val(btn.data('country'));
    $('#edit-postal_code').val(btn.data('postal_code'));

    // Status
    $('#edit-status').prop('checked', btn.data('status') == 1);

    // Image preview
    const imageUrl = btn.data('image');
    $('#edit-preview').attr('src', imageUrl ? imageUrl : '{{ asset("assets/img/customer/default.png") }}');
});

</script>
<script>
    $('#edit-customer-form').on('submit', function() {
    const statusCheckbox = $('#edit-status');
    if(statusCheckbox.is(':checked')){
        statusCheckbox.val(1);
    } else {
        statusCheckbox.val(0);
    }
});


</script>