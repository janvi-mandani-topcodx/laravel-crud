@extends('layout')

@section('content')
    <div class="container py-5 h-100">
        <div class="row  h-100">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Edit Order</h3>
            <div class="col-8 h-100 mx-auto">
                <div class="m-2">
                    <div class="search-box">
                        <input type="text" class="form-control" id="search" name="search"
                               placeholder="Search...">
                    </div>
                </div>
                <section class="vh-100 gradient-custom my-5">
                    <div class="card shadow-2-strong card-registration h-75" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5 checkoutAllItems position-relative" id="checkoutAllItems">
                            <div class="order-item-data" style="overflow: auto ; height: 88%; overflow-x: hidden;">
                                @foreach($order->orderItems as $item)
                                    <div class="row my-3 bg-light item-{{$item->id}} itemData" data-product="{{$item->product->id}}" data-variant="{{$item->variant->id}}" data-item="{{$item->id}}" data-order="{{$item->order_id}}">
                                        <input type="hidden" id="orderItemEditId" name="item[]" value="{{$item->id}}">
                                        <div class="col">
                                            <img class="card-img-top rounded" src="{{$item->product->image_url[0]}}" alt="Card image cap" style="height: 100px; width: 100px;">
                                        </div>
                                        <div class="col">
                                            <div class="row mb-2">
                                                <span class="col text-muted">{{$item->product->title}}</span>
                                            </div>
                                            <div class="row">
                                                <span class="col">Size : {{$item->variant->title}}</span>
                                            </div>
                                            <div class=" d-flex align-items-end justify-content-around pt-2 " data-product="{{$item->product->id}}" data-variant="{{$item->variant->id}}" >
                                                <span class="fs-4 decrement-data decrement-checkout-{{$item->product->id}}-{{$item->variant->id}}">-</span>
                                                <span class="fs-5 quantity-checkout">{{$item->quantity}}</span>
                                                <span class="fs-4 increment-data increment-checkout-{{$item->product->id}}-{{$item->variant->id}}">+</span>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="row">
                                                <button type="button" class="btn-close close-product-edit-checkout dlt-{{$item->id}}" aria-label="Close" data-product="{{$item->product->id}}" data-id="{{$item->id}}"></button>
                                            </div>
                                            <div class="pt-5 d-flex">
                                                <p>$</p>
                                                <p class="item-price-edit-checkout">{{$item->variant->price}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                <div class="position-absolute w-100 pe-5" style="bottom: 20px; left:20px;">
                                    <div class="d-flex justify-content-between">
                                        <label>Subtotal</label>
                                        <div class="d-flex">
                                            <span>$</span>
                                            <span class="subtotal-order-edit" id=""></span>
                                        </div>
                                    </div>
                                    @if($orderDiscount)
                                        <div class="discountData">
                                            <div class="d-flex justify-content-between ">
                                                <label>Discount : {{$orderDiscount->code}}</label>
                                                <div class="d-flex">
                                                    <span>$</span>
                                                    <span class="discount-show-checkout" data-type="{{$orderDiscount->type}}" data-code="{{$orderDiscount->code}}">{{$orderDiscount->amount}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="d-flex justify-content-between">
                                        <label>Total</label>
                                        <div class="d-flex">
                                            <span>$</span>
                                            <span class="total-order-edit" id="totalAmount"></span>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-2 ">
                        <span class="btn btn-success w-50 update-order-items">Save</span>
                    </div>
                </section>
            </div>
        </div>
        <div id="productSearch" style=" position: absolute; top: 232px; left: 307px; width: 57%; background-color: white;">

        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // function count() {
            //     let totalCount = 0;
            //     $('.quantity-checkout').each(function() {
            //         let qty = parseInt($(this).text());
            //         totalCount += qty;
            //     });
            //     $('.count').text(totalCount);
            // }

            $(document).on('keyup', '#search' ,  function () {
                let query = $(this).val();
                $.ajax({
                    url: "{{route('order.item.search')}}",
                    method: "GET",
                    data: {
                        search: query
                    },
                    success: function (response) {
                        $('#productSearch').html(response.html);
                    },
                    error: function (response){
                        $('#productSearch').html(response.html);
                    }
                });
            });

            function updateTotalOrder(){
                let totalPrice = 0;
                $('.quantity-checkout').each(function () {
                    let quantity = parseInt($(this).text());
                    console.log(quantity)
                    let price = parseInt($(this).parents('.itemData').find('.item-price-edit-checkout').text());
                    console.log(price)
                    let total = quantity * price;
                    totalPrice += total;
                });
                $('.subtotal-order-edit').text(totalPrice)
            }

            function discountAddOrder() {
                let subtotal = ''
                // console.log($('.discountData').)
                if ($('.discountData').length > 0) {
                    console.log("aaa")
                    let type = $('.discount-show-checkout').data('type');
                    let amount = $('.discount-show-checkout').text();
                    subtotal = $('.subtotal-order-edit').text();
                    console.log("sub = " +subtotal);
                    if (type == 'percentage') {
                        let total = subtotal * (amount / 100);
                        console.log(total)
                        let mainTotal  = subtotal - total;
                        $('.total-order-edit').text(mainTotal)
                    }
                    else if(type == 'fixed'){
                        let totalPrice = subtotal - amount;
                        $('.total-order-edit').text(totalPrice)
                    }
                }
                else{
                    subtotal = $('.subtotal-order-edit').text();
                    $('.total-order-edit').text(subtotal)
                }
                // if($('.discountData').text() != ''){
                //     $('.total-order-edit').text(subtotal)
                // }
            }
            // function allDecrement(quantity ,productId , variantId){
            //     var currentQuantity = parseInt(quantity.text());
            //     if(currentQuantity > 1){
            //         var newQuantity = currentQuantity - 1;
            //         quantity.text(newQuantity);
            //         $('.decrement-card-'+ productId +'-'+ variantId).siblings('.quantity').text(newQuantity);
            //         $('.decrement-checkout-'+ productId +'-'+ variantId).siblings('.quantity-checkout').text(newQuantity);
            //         $('.decrement-item-'+ productId +'-'+ variantId).siblings('.quantity-item').text(newQuantity);
            //         updateQuantity(productId, variantId , newQuantity)
            //     }
            // }
            //
            // function  allIncrement(quantity ,productId , variantId , orderId){
            //     var currentQuantity = parseInt(quantity.text());
            //     var newQuantity = currentQuantity + 1;
            //     quantity.text(newQuantity);
            //     $('.increment-card-'+ productId +'-' +variantId ).siblings('.quantity').text(newQuantity);
            //     $('.increment-item-'+ productId +'-' +variantId ).siblings('.quantity-item').text(newQuantity);
            //     $('.increment-checkout-'+ productId +'-' +variantId ).siblings('.quantity-checkout').text(newQuantity);
            //     updateQuantity(productId, variantId , newQuantity , orderId)
            // }
            updateTotalOrder();
            discountAddOrder()
            // $(document).on('click' , '.increment-checkout' , function (){
            //     var quantity = $(this).closest('.d-flex').find('.quantity-checkout');
            //     var productId = $(this).closest('.d-flex').data('product');
            //     var variantId = $(this).closest('.d-flex').data('variant');
            //     var orderId = $(this).parents('.itemData').data('order');
            //     allIncrement(quantity , productId , variantId , orderId);
            // })
            //
            // $(document).on('click' , '.decrement-checkout' , function (){
            //     var quantity = $(this).closest('.d-flex').find('.quantity-checkout');
            //     var productId = $(this).closest('.d-flex').data('product');
            //     var variantId = $(this).closest('.d-flex').data('variant');
            //     allDecrement(quantity ,productId , variantId);
            // })

            //
            // function updateQuantity(productId, variantId, quantity , orderId) {
            //     console.log(productId , variantId,quantity)
            //     updateTotalOrder();
            //     $.ajax({
            //         url: route('update.item'),
            //         type: "POST",
            //         data: {
            //             product_id: productId,
            //             variant_id: variantId,
            //             quantity: quantity,
            //             order_id: orderId,
            //             _token: $('meta[name="csrf-token"]').attr('content'),
            //         },
            //         success: function (response) {
            //             console.log('Quantity updated');
            //         },
            //     });
            // }

            $(document).on('click' , '.update-order-items' , function (){
               let priceData = [];
               let ProductIdData = [];
               let variantIdData = [];
               let quantityData = [];
               let editIdData = [];
                $('.itemData').each(function () {
                    let productId = $(this).data('product');
                    let variantId = $(this).data('variant');
                    let quantity = $(this).find('.quantity-checkout').text();
                    let price = $(this).find('.item-price-edit-checkout').text();
                    let editId = $(this).find('#orderItemEditId').val();
                    priceData.push(price)
                    ProductIdData.push(productId)
                    variantIdData.push(variantId)
                    quantityData.push(quantity)
                    editIdData.push(editId);
                });
                let totalAmount = $('#totalAmount').text();
                $.ajax({
                    url: "{{route('order.items.update' , $order->id)}}",
                    method: "POST",
                    data:{
                        price: priceData,
                        product: ProductIdData,
                        variant: variantIdData,
                        quantity: quantityData,
                        editId :  editIdData,
                        total : totalAmount,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        window.location.href = '{{route('order.index')}}';
                    },
                });
            });

            $(document).on('click' , '#one-product' , function () {
                let productId =  $(this).data('id')
                let variantId =  $(this).data('variant')
                let url = $(this).find('.search-product-image').data('url');
                let productTitle = $(this).find('.search-product-title').text();
                let variantTitle = $(this).find('.search-variant-title').text();
                let price = $(this).find('.search-price').text();
                let existingProduct = $('#checkoutAllItems').find(`.itemData[data-product="${productId}"][data-variant="${variantId}"]`);
                if (existingProduct.length === 0) {
                    let html = '';
                    html =  `
                       <div class="row my-3 bg-light itemData" data-product="${productId}" data-variant="${variantId}">
                                    <div class="col">
                                        <img class="card-img-top rounded" src="${url}" alt="Card image cap" style="height: 100px; width: 100px;">
                                    </div>
                                    <div class="col">
                                        <div class="row mb-2">
                                            <span class="col text-muted">${productTitle}</span>
                                        </div>
                                        <div class="row">
                                            <span class="col">${variantTitle}</span>
                                        </div>
                                        <div class=" d-flex align-items-end justify-content-around pt-2 " data-product="${productId}" data-variant="${variantId}" >
                                            <span class="fs-4 decrement-data">-</span>
                                            <span class="fs-5 quantity-checkout">1</span>
                                            <span class="fs-4 increment-data">+</span>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="row">
                                            <button type="button" class="btn-close close-orderItem" aria-label="Close" data-product="${productId}" data-id=""></button>
                                        </div>
                                        <div class="pt-5 d-flex">
                                            <p class="item-price-edit-checkout">${price}</p>
                                        </div>
                                    </div>
                                </div>
                `;
                    $('.order-item-data').append(html);
                    updateTotalOrder();
                    discountAddOrder()
                }
                else{
                    let quantity = parseInt(existingProduct.find('.quantity-checkout').text());
                    let newQuantity = quantity + 1;
                    existingProduct.find('.quantity-checkout').text(newQuantity)
                    updateTotalOrder();
                    discountAddOrder()
                }
                $('#search').val('');
                $('#productSearch').text('')

            });

            $(document).on('click' , '.increment-data' , function (){
                let quantity = $(this).closest('.itemData').find('.quantity-checkout');
                let currentQuantity = parseInt(quantity.text());
                let newQuantity = currentQuantity + 1;
                quantity.text(newQuantity);
                updateTotalOrder()
                discountAddOrder()
            })
            $(document).on('click' , '.decrement-data' , function (){
                let quantity = $(this).closest('.itemData').find('.quantity-checkout');
                let currentQuantity = parseInt(quantity.text());
                if(currentQuantity > 1){
                    let newQuantity = currentQuantity - 1;
                    quantity.text(newQuantity);
                }
                updateTotalOrder()
                discountAddOrder()
            })
            $(document).on('click' , '.close-product-edit-checkout' , function (){
                let deleteId = $(this).data('id');
                let productId = $(this).data('product');
                let itemId = $(this).data('id');
                let row = $(this).closest('.item-'+itemId);
                console.log(row)
                $.ajax({
                    url: route('delete.order.item'),
                    type: "GET",
                    data: {
                        delete_id : deleteId
                    },
                    success: function (response) {
                        if(response.success){
                            row.remove();
                            updateTotalOrder();
                            discountAddOrder()
                        }
                    },
                });
            });

            $(document).on('click' , '.close-orderItem' ,function (){
                let row = $(this).parents('.itemData');
                row.remove();
            });
        });
    </script>
@endsection
