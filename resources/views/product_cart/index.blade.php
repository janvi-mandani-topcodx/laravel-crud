@php use App\Models\Cart; @endphp
@extends('layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <div>
                        <div class="row">
                            <div class="col col-12 text-center">
                                <h2 class="">Products</h2>
                                <div class="row">
                                    @foreach($products as $product)
                                      <div class="col-3">
                                          <div class="card product-{{$product->id}}" id="product" style="width: 18rem;">
                                              <img class="card-img-top" src="{{$product->image_url[0]}}" alt="Card image cap" style="height: 200px;" data-url="{{$product->image_url[0]}}">
                                              <div class="card-body">
                                                  <h5 class="card-title">{{$product->title}}</h5>
                                                  <div class="d-flex">
                                                      @foreach($product->productVarients as $productVariants)
                                                          @php
                                                              $size = collect(explode(' ', $productVariants->title))
                                                                ->map(function ($word) {
                                                                  return Str::charAt(ucfirst($word), 0);
                                                                })->implode('');

//                                                              $checkVariant = Cart::where('variant_id' , $productVariants->id)->first();

                                                         @endphp
                                                          <div>
                                                              <button class="btn btn-outline-info m-2 size" data-id="{{$productVariants->id}}" data-price="{{$productVariants->price}}" data-title="{{$productVariants->title}}" data-product="{{$product->id}}">{{$size}}</button>
                                                          </div>
                                                      @endforeach
                                                  </div>
                                                  <div class="d-flex justify-content-between my-2">
                                                      <div class="">
                                                          <span class="fs-5 fw-bold">$</span>
                                                          <span class="fs-5 fw-bold price" data-title="{{$productVariants->title}}" data-variant="{{$productVariants->id}}">{{$productVariants->price}}</span>
                                                      </div>
{{--                                                      @if($checkVariant == null)--}}
                                                          <div class="">
                                                              <a href="#" class="btn btn-success addToCart" id="addToCart" data-id="{{$productVariants->id}}" data-product="{{$product->id}}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Add</a>
                                                          </div>
{{--                                                      @else--}}
{{--                                                          <div class="d-block" id="incrementDecrement">--}}
                                                          <div class="" id="incrementDecrement">
                                                              <div class=" d-flex align-items-end justify-content-around pt-2" data-variant="{{$productVariants->id}}" data-product="{{$product->id}}">
                                                                  <span class="fs-4 decrease decrement-card-{{$product->id}}-{{$productVariants->id}}" data-variant="{{$productVariants->id}}">-</span>
                                                                  <span class="fs-5 quantity" data-id="{{$productVariants->id}}" data-product="{{$product->id}}">
                                                                      {{ $carts->where('product_id', $product->id)->where('variant_id', $productVariants->id)->first()->quantity ?? 1 }}
                                                                  </span>
                                                                  <span class="fs-4 increase increment-card-{{$product->id}}-{{$productVariants->id}}" data-variant="{{$productVariants->id}}">+</span>
                                                              </div>
                                                          </div>
{{--                                                      @endif--}}
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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



            function buttons() {
                $('.card').each(function() {
                    if ($(this).find('#addToCart').show()) {
                        $(this).find('#addToCart').show();
                        $(this).find('#incrementDecrement').hide();
                    } else {
                        $(this).find('#addToCart').hide();
                        $(this).find('#incrementDecrement').show();
                    }
                });
            }

            function count() {
                let totalCount = 0;
                $('.quantity-cart').each(function() {
                    let qty = parseInt($(this).text());
                    totalCount += qty;
                });
                $('.count').text(totalCount);
            }

            function updateTotal(){
                    let totalPrice = 0;
                    $('.quantity-cart').each(function () {
                        let quantity = parseFloat($(this).text());
                        console.log(quantity)
                        let price = $(this).parents('.row').find('.cart-price').text();
                        console.log(price)
                        let total = quantity * price;
                        totalPrice += total;
                    });
                    $('.total').text(totalPrice)
            }
            updateTotal();
            buttons();
            count();
            $(document).on('click', '.size', function () {
                let price = $(this).data('price');
                let productId = $(this).data('product');
                let title = $(this).data('title');
                let variant = $(this).data('id');
                let product = $('.product-'+productId).find('.price')

                product.data('title' ,title);
                product.text(price)
                product.data('variant' , variant);
                $('.product-'+productId).find('.addToCart').data('id' , variant)
                $('.product-'+productId).find('#incrementDecrement').find('.d-flex').data('variant' , variant)
                // $('.increase').data('variant' , variant)
                // $('.decrease').data('variant' , variant)
                $.ajax({
                    url: route('cart.add'),
                    type: "GET",
                    data: {
                        variant  : variant,
                    },
                    success: function (response) {
                        if(response.status == true){
                            $('.product-'+productId).find('#addToCart').hide()
                            $('.product-'+productId).find('#incrementDecrement').show()
                            $('.product-'+productId).find('#incrementDecrement').find('.quantity').text(response.quantity)
                        }
                        else{
                            $('.product-'+productId).find('#addToCart').show()
                            $('.product-'+productId).find('#incrementDecrement').removeClass('d-block')
                            $('.product-'+productId).find('#incrementDecrement').hide()
                        }
                    },
                });
            })

            $(document).on('click' , '#addToCart', function (){
                let product = $(this).parents('#product');
                let size = product.find('.price').data('title');
                let price = product.find('.price').text();
                let title = product.find('.card-title').text();
                let image = product.find('.card-img-top').data('url');
                let productId = $(this).data('product');
                let variantId = product.find('.price').data('variant');
                $.ajax({
                    url: route('cart'),
                    type: "GET",
                    data: {
                        size  : size,
                        price : price,
                        title : title,
                        image : image,
                        product_id : productId,
                        variant_id : variantId,
                        quantity : 1
                    },
                    success: function (response) {
                        if(response.quantity){
                            let row = $('.offcanvas-body').find('.cart-' + response.cartId);
                            row.find('.quantity').text(response.quantity)
                        }
                        if(response.variant == variantId){
                            $('.product-'+productId).find('#addToCart').hide()
                            $('.product-'+productId).find('#incrementDecrement').show()
                        }
                        $('.offcanvas-body').append(response.html)
                        updateTotal();
                        count();
                    },
                });
            })

            function increment(quantity , productId , variantId , price){
                var currentQuantity = parseInt(quantity.text());
                var newQuantity = currentQuantity + 1;
                quantity.text(newQuantity);
                // console.log("aaa" + $('.increase').data('variant'))
                // $('.increase').data('variant' , variantId).siblings('.quantity').text(newQuantity);
                if(price == $('.product-' + productId).find('.price').text()){
                    $('.increment-card-'+ productId + '-' + variantId).siblings('.quantity').text(newQuantity);
                }
                $('.increment-cart-'+ productId + '-' + variantId).siblings('.quantity-cart').text(newQuantity);
                updateQuantity(productId, variantId , newQuantity)
            }

            function decrement(quantity , productId , variantId , price){
                var currentQuantity = parseInt(quantity.text());
                if(currentQuantity > 1){
                    var newQuantity = currentQuantity - 1;
                    quantity.text(newQuantity);
                    if(price == $('.product-' + productId).find('.price').text()){
                        $('.increment-card-'+ productId + '-' + variantId).siblings('.quantity').text(newQuantity);
                    }
                    $('.decrement-cart-'+ productId + '-' + variantId).siblings('.quantity-cart').text(newQuantity);
                    updateQuantity(productId, variantId , newQuantity)
                }
            }

            $(document).on('click' , '.increment' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity-cart');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                let price = $(this).parents('.row').find('.cart-price').text();
                increment(quantity , productId , variantId , price)
            })

            $(document).on('click' , '.increase' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                increment(quantity , productId , variantId)
            })

            $(document).on('click' , '.decrement' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity-cart');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                let price = $(this).parents('.row').find('.cart-price').text();
                decrement(quantity , productId , variantId , price)
            })

            $(document).on('click' , '.decrease' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                decrement(quantity , productId , variantId)
            })


            function updateQuantity(productId, variantId, quantity) {
                updateTotal();
                count();
                $.ajax({
                    url: route('update.cart'),
                    type: "POST",
                    data: {
                        product_id: productId,
                        variant_id: variantId,
                        quantity: quantity,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        console.log('Quantity updated');
                    },
                });
            }


            $(document).on('click' , '.close-product' , function (){
                let deleteId = $(this).data('id');
                let productId = $(this).data('product');
                let row = $(this).parents('.row');
                console.log($('.product-'+productId))
                $.ajax({
                    url: route('delete.cart'),
                    type: "GET",
                    data: {
                        delete_id : deleteId
                    },
                    success: function (response) {
                        if(response.success){
                            row.remove();
                            count();
                            updateTotal();
                            $('.product-'+productId).find('#addToCart').show()
                            $('.product-'+productId).find('#incrementDecrement').hide()
                        }
                    },
                });
            });

            $(document).on('click' , '.checkoutBtn' , function (){
                window.location.href = route('checkout.show');
            });
        });
    </script>
@endsection
