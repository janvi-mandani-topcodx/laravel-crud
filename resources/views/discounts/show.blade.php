@extends('layout')
@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="d-flex justify-content-end">
                        <div class="py-2">
                            <a href="{{route('discounts.index')}}" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Discount</h3>
                            <div class="row my-2">
                                <div class="col">
                                    <label class="text-muted fw-bold">Code</label>
                                    <p>{{$discount->code}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Amount</label>
                                    <p>{{$discount->amount}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Type</label>
                                    <p>{{$discount->type}}</p>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <label class="text-muted fw-bold">Minimum Requirements</label>
                                    <p>{{$discount->minimum_requirements== 'purchase_amount' ? 'Purchase Amount' : 'Quantity Amount'}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Minimum Amount</label>
                                    <p>{{$discount->minimum_amount}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Customer Eligibility</label>
                                    <p>{{$discount->customer_eligibility == 'all_customers' ? 'All Customers' : 'Specific Customer'}}</p>
                                </div>

                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <label class="text-muted fw-bold">Customer</label>
                                    <p>{{$discount->customer_id ? $discount->user->full_name : ''}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Applies Product</label>
                                    <p>{{$discount->applies_product == 'all_products' ? 'All Products' : 'Specific Product'}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Product</label>
                                    <p>{{$discount->product_id ? $discount->product->title : ''}}</p>
                                </div>

                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <label class="text-muted fw-bold">Number Of Times Use</label>
                                    <span>{{$discount->usage_limit_number}}</span>
                                    <span>{{$discount->usage_limit_number_of_times_use == 1 ? 'times use discounts' : ''}}</span>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">One Use Per Customer</label>
                                    <p>{{$discount->usage_limit_one_user_per_customer==1 ?  'yes' : 'No'}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">New Customer Only</label>
                                    <p>{{$discount->usage_limit_new_customer== 1 ? 'Yes' : 'No'}}</p>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <label class="text-muted fw-bold">start_date</label>
                                    <p>{{$discount->start_date}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">end_date </label>
                                    <p>{{$discount->end_date }}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">status</label>
                                    <p>{{$discount->status}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
