@include('layouts.header')


<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">Category</h4>
            <h6>Manage your categories</h6>
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
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-category"><i class="ti ti-circle-plus me-1"></i>Add Category</a>
    </div>
</div>

<!-- Category List -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <div class="search-set">
            <div class="search-input">
                <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
            </div>
        </div>
        <!-- <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
            <div class="dropdown me-2">
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
        </div> -->
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table datatable" id="categoriesTable">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all">
                                <span class="checkmarks"></span>
                            </label>
                        </th>
                        <th>Category</th>
                        <th>Created On</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" name="selected_categories[]" value="{{ $category->id }}">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td><span class="text-gray-9">{{ $category->name }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d M Y') }}</td>
                            <td>
                                <span class="text-gray-9">
                                    @if ($category->employee_id && $category->employee)
                                        {{ $category->employee->name }}
                                    @elseif ($category->user_id && $category->user)
                                        {{ $category->user->name }}
                                    @else
                                        Unknown
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge table-badge {{ $category->status == 1 ? 'bg-success' : 'bg-danger' }} fw-medium fs-10">
                                    {{ $category->status_display }}
                                </span>
                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $category->id }}" class="p-2" href="javascript:void(0);">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td></td>
                            <td></td>
                            <td>No categories found.</td>
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

<!-- Add Category Modal -->
<div class="modal fade" id="add-category">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="page-title">
                    <h4>Add Category</h4>
                </div>
                <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
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
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modals -->
@foreach ($categories as $category)
    <div class="modal fade" id="edit-category-{{ $category->id }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="page-title">
                        <h4>Edit Category</h4>
                    </div>
                    <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-0">
                            <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                <span class="status-label">Status</span>
                                <input type="checkbox" id="user-{{ $category->id }}" class="check" name="status" value="1" {{ old('status', $category->status) == 1 ? 'checked' : '' }}>
                                <label for="user-{{ $category->id }}" class="checktoggle"></label>
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


<!-- Delete Category Modals -->
@foreach ($categories as $category)
    <div class="modal fade" id="delete-modal-{{ $category->id }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content p-5 px-3 text-center">
                        <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i class="ti ti-trash fs-24 text-danger"></i></span>
                        <h4 class="fs-20 fw-bold mb-2 mt-1">Delete Category</h4>
                        <p class="mb-0 fs-16">Are you sure you want to delete {{ $category->name }}?</p>
                        <div class="modal-footer-btn mt-3 d-flex justify-content-center">
                            <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
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
        // // Hide success/error messages after 3 seconds
        // setTimeout(function() {
        //     $('#successMessage').fadeOut('slow');
        //     $('#errorMessage').fadeOut('slow');
        // }, 3000);

        // let table = $('#categoriesTable').DataTable({
        //     columnDefs: [
        //         { orderable: false, targets: ['no-sort'] },
        //         // Strip HTML from status column for search
        //         {
        //             targets: 4, // Status column
        //             render: function(data, type, row) {
        //                 if (type === 'filter' || type === 'sort') {
        //                     // Return plain text (Active/Inactive) for filtering/sorting
        //                     return data.includes('Active') ? 'Active' : 'Inactive';
        //                 }
        //                 return data; // Return HTML for display
        //             }
        //         }
        //     ],
        //     language: {
        //         emptyTable: "No categories found."
        //     }
        // });

        // Initialize DataTable (Commented as per requirement)
        // $('.datatable').DataTable({
        //     searching: true,
        //     paging: true,
        //     ordering: true,
        //     info: true,
        //     columnDefs: [
        //         { orderable: false, targets: ['no-sort'] }
        //     ],
        //     language: {
        //         emptyTable: "No categories found."
        //     },
        //     drawCallback: function(settings) {
        //         if (settings.aoData.length === 0) {
        //             $(this.api().table().node()).find('tbody').html('<tr><td></td><td></td><td>No categories found.</td><td></td><td></td></tr>');
        //         }
        //     }
        // });

        // Select All Checkbox
        $('#select-all').on('click', function () {
            $('input[name="selected_categories[]"]').prop('checked', this.checked);
        });

        // Status Filter Logic
    //     $('.dropdown-menu [data-status]').on('click', function(e) {
    //         e.preventDefault();
    //         var status = $(this).data('status');
    //         var btnText = status === '' ? 'Status' : `Status: ${status == 1 ? 'Active' : 'Inactive'}`;
    //         $('#statusFilterBtn').text(btnText);
    //         if (status !== '') {
    //             // Map numeric status to display text for search
    //             var searchValue = status == 1 ? 'Active' : 'Inactive';
    //             table.column(4).search(searchValue, true, false).draw();
    //         } else {
    //             table.column(4).search('').draw();
    //         }
    //     });
    });
</script>