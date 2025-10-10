@include('layouts.header')

<div class="page-header">
    <div class="page-title">
        <h4>Customer Details</h4>
        <h6>Full details of a customer</h6>
    </div>
</div>

<!-- Customer Details -->
<div class="row">
    <div class="col-lg-8 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="productdetails">
                    <ul class="product-bar">
                        <li>
                            <h4>Customer Name</h4>
                            <h6>{{ $customer->first_name }} {{ $customer->last_name }}</h6>
                        </li>
                        <li>
                            <h4>Email</h4>
                            <h6><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></h6>
                        </li>
                        <li>
                            <h4>Phone</h4>
                            <h6>{{ $customer->phone }}</h6>
                        </li>
                        <li>
                            <h4>Shipping Address</h4>
                            <h6>{{ $customer->shipping_address }}</h6>
                        </li>
                        <li>
                            <h4>Billing Address</h4>
                            <h6>{{ $customer->billing_address }}</h6>
                        </li>
                        <li>
                            <h4>City</h4>
                            <h6>{{ $customer->city }}</h6>
                        </li>
                        <li>
                            <h4>State</h4>
                            <h6>{{ $customer->state }}</h6>
                        </li>
                        <li>
                            <h4>Country</h4>
                            <h6>{{ $customer->country }}</h6>
                        </li>
                        <li>
                            <h4>Postal Code</h4>
                            <h6>{{ $customer->postal_code }}</h6>
                        </li>
                        <li>
                            <h4>GSTIN</h4>
                            <h6>{{ $customer->gstin ?? 'N/A' }}</h6>
                        </li>
                        <li>
                            <h4>PAN</h4>
                            <h6>{{ $customer->pan ?? 'N/A' }}</h6>
                        </li>
                        <li>
                            <h4>Company Name</h4>
                            <h6>{{ $customer->company_name ?? 'N/A' }}</h6>
                        </li>
                        <li>
                            <h4>Website</h4>
                            <h6><a href="{{ $customer->website ?? '#' }}" target="_blank">{{ $customer->website ?? 'N/A' }}</a></h6>
                        </li>
                        <li>
                            <h4>Created By</h4>
                            <h6>
                                @if ($customer->employee_id && $customer->employee)
                                    {{ $customer->employee->name }}
                                @elseif ($customer->user_id && $customer->user)
                                    {{ $customer->user->name }}
                                @else
                                    Unknown
                                @endif
                            </h6>
                        </li>
                        <li>
                            <h4>Created On</h4>
                            <h6>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</h6>
                        </li>
                        <li>
                            <h4>Status</h4>
                            <h6>{{ $customer->status_display }}</h6>
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
                        <img src="{{ $customer->image ? asset('storage/' . $customer->image) : asset('assets/img/supplier/supplier-01.png') }}" alt="img">
                        <h4>{{ $customer->company_name ?? ($customer->first_name . ' ' . $customer->last_name) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')

<!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->
