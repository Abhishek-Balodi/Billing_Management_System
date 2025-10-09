@include('layouts.header')

<div class="page-header">
    <div class="page-title">
        <h4>Supplier Details</h4>
        <h6>Full details of a supplier</h6>
    </div>
</div>

<!-- Supplier Details -->
<div class="row">
    <div class="col-lg-8 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="productdetails">
                    <ul class="product-bar">
                        <li>
                            <h4>Supplier Name</h4>
                            <h6>{{ $supplier->first_name }} {{ $supplier->last_name }}</h6>
                        </li>
                        <li>
                            <h4>Email</h4>
                            <h6><a href="mailto:{{ $supplier->email }}">{{ $supplier->email }}</a></h6>
                        </li>
                        <li>
                            <h4>Phone</h4>
                            <h6>{{ $supplier->phone }}</h6>
                        </li>
                        <li>
                            <h4>Address</h4>
                            <h6>{{ $supplier->address }}</h6>
                        </li>
                        <li>
                            <h4>City</h4>
                            <h6>{{ $supplier->city }}</h6>
                        </li>
                        <li>
                            <h4>State</h4>
                            <h6>{{ $supplier->state }}</h6>
                        </li>
                        <li>
                            <h4>Country</h4>
                            <h6>{{ $supplier->country }}</h6>
                        </li>
                        <li>
                            <h4>Postal Code</h4>
                            <h6>{{ $supplier->postal_code }}</h6>
                        </li>
                        <li>
                            <h4>GSTIN</h4>
                            <h6>{{ $supplier->gstin ?? 'N/A' }}</h6>
                        </li>
                        <li>
                            <h4>PAN</h4>
                            <h6>{{ $supplier->pan ?? 'N/A' }}</h6>
                        </li>
                        <li>
                            <h4>Company Name</h4>
                            <h6>{{ $supplier->company_name ?? 'N/A' }}</h6>
                        </li>
                        <li>
                            <h4>Website</h4>
                            <h6><a href="{{ $supplier->website ?? '#' }}" target="_blank">{{ $supplier->website ?? 'N/A' }}</a></h6>
                        </li>
                        <li>
                            <h4>Created By</h4>
                            <h6>
                                @if ($supplier->employee_id && $supplier->employee)
                                    {{ $supplier->employee->name }}
                                @elseif ($supplier->user_id && $supplier->user)
                                    {{ $supplier->user->name }}
                                @else
                                    Unknown
                                @endif
                            </h6>
                        </li>
                        <li>
                            <h4>Created On</h4>
                            <h6>{{ \Carbon\Carbon::parse($supplier->created_at)->format('d M Y') }}</h6>
                        </li>
                        <li>
                            <h4>Status</h4>
                            <h6>{{ $supplier->status_display }}</h6>
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
                        <img src="{{ $supplier->image ? asset('storage/' . $supplier->image) : asset('assets/img/supplier/supplier-01.png') }}" alt="img">
                        <h4>{{ $supplier->company_name ?? ($supplier->first_name . ' ' . $supplier->last_name) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')