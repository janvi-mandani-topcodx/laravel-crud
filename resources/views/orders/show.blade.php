@extends('layout')
@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="d-flex justify-content-end">
                        <div class="py-2">
                            <a href="{{route('order.index')}}" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Orders Details</h3>
                            <div class="row">
                                <div class="col">
                                    <label class="text-muted fw-bold">First Name</label>
                                    <p>{{$shippingDetails->first_name}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Last Name</label>
                                    <p>{{$shippingDetails->last_name}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Address</label>
                                    <p>{{$shippingDetails->address}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label class="text-muted fw-bold">State</label>
                                    <p>{{$shippingDetails->state}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Country</label>
                                    <p>{{$shippingDetails->country}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Delivery</label>
                                    <p>{{$order->delivery}}</p>
                                </div>
                            </div>
                    </div>
                </div>


                    <div class="card shadow-2-strong card-registration my-4" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-muted fw-bold fs-4 my-4 text-center">Order Items</div>
                            @foreach ($orderItems as $orderItem)
                                <div class="row my-3 bg-light">
                                    <div class="col">
                                        <img src="{{ $orderItem->product->image_url[0]}}" width="100px" height="100px">
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <p>Title : {{$orderItem->product->title}}</p>
                                        </div>
                                        <div class="row">
                                            <p>Size : {{$orderItem->variant->title}}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p>Quantity : {{$orderItem->quantity}}</p>
                                    </div>
                                    <div class="col">
                                        <p>Price : {{$orderItem->price}}</p>
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <p>Total</p>
                                </div>
                                <div class="col text-end me-5">
                                    <p>${{$order->total}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
