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
                           <div class=" d-flex justify-content-between">
                               <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 ">Orders Details</h3>
                                <div>
                                    <span class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Edit Order Details</span>
                                </div>
                           </div>
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
                            @foreach ($order->orderItems as $orderItem)
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
                                    <p>Subtotal</p>
                                </div>
                                <div class="col text-end me-5">
                                    <p>${{$totalPrice}}</p>
                                </div>
                            </div>
                            @if($order->orderDiscounts)
                                @foreach($order->orderDiscounts as $orderDiscount)
                                       @if($orderDiscount->type == 'percentage')
                                            <div class="row {{ $orderDiscount->amount <= 0 ? 'd-none' : ''}}">
                                                <div class="col">
                                                    <p>{{$orderDiscount->discount_name == 'gift_card' ? 'Gift card' : $orderDiscount->discount_name}} : {{$orderDiscount->code}}</p>
                                                </div>
                                                <div class="col text-end me-5">
                                                    <p>{{$orderDiscount->amount}}%</p>
                                                </div>
                                            </div>
                                       @else
                                            <div class="row {{ $orderDiscount->amount <= 0 ? 'd-none' : ''}}">
                                                <div class="col">
                                                    <p>{{$orderDiscount->discount_name == 'gift_card' ? 'Gift card' : $orderDiscount->discount_name}} : {{$orderDiscount->code}}</p>
                                                </div>
                                                <div class="col text-end me-5">
                                                    <p>${{$orderDiscount->amount}}</p>
                                                </div>
                                            </div>
                                    @endif
                                @endforeach
                            @endif

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
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                                @csrf
                                @method('PUT')
                                @include('orders.edit-fields')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-success  updateCheckoutAction">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).on('click' , '.updateCheckoutAction' , function (e){
            e.preventDefault()
            let form = $(this).closest('form')[0];
            let formData = new FormData(form);

            $.ajax({
                url: "{{route('order.update', $order->id)}}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    window.location.href = '{{route('order.show' , $order->id)}}';
                },
                error: function (response){
                    let errors = response.responseJSON.errors;
                    if (errors.firstName) {
                        $('.first_name-error').text(errors.firstName[0]);
                    }
                    if (errors.lastName) {
                        $('.last_name-error').text(errors.lastName[0]);
                    }
                    if (errors.delivery) {
                        $('.delivery-error').text(errors.delivery[0]);
                    }
                    if (errors.country) {
                        $('.country-error').text(errors.country[0]);
                    }
                    if (errors.state) {
                        $('.state-error').text(errors.state[0]);
                    }
                    if (errors.address) {
                        $('.address-error').text(errors.address[0]);
                    }
                }
            });
        });


    </script>
@endsection
