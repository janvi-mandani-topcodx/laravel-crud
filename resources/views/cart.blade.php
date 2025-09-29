<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Cart</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @if(isset($carts))
            <div id="allCartData" style="overflow: auto; height: 85%; overflow-x: hidden;">
                @foreach($carts as $cart)
                    <div class="row my-3 bg-light cart-{{$cart->id}} cart-product-{{$cart->product->id}}" data-product="{{$cart->product->id}}" data-variant="{{$cart->variant->id}}" data-cart="{{$cart->id}}">
                        <div class="col">
                            <img class="card-img-top rounded" src="{{$cart->product->image_url[0]}}" alt="Card image cap" style="height: 100px; width: 100px;">
                        </div>
                        <div class="col">
                            <div class="row mb-2">
                                <span class="col text-muted">{{$cart->product->title}}</span>
                            </div>
                            <div class="row">
                                <span class="col">Size : {{$cart->variant->title}}</span>
                            </div>
                            <div class=" d-flex align-items-end justify-content-around pt-2 " data-product="{{$cart->product->id}}" data-variant="{{$cart->variant->id}}" >
                                <span class="fs-4 decrement decrement-cart-{{$cart->product->id}}-{{$cart->variant->id}}">-</span>
                                <span class="fs-5 quantity-cart">{{$cart->quantity}}</span>
                                <span class="fs-4 increment increment-cart-{{$cart->product->id}}-{{$cart->variant->id}}">+</span>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="row">
                                <button type="button" class="btn-close close-product dlt-{{$cart->id}}" aria-label="Close" data-product="{{$cart->product->id}}" data-id="{{$cart->id}}"></button>
                            </div>
                            <div class="pt-5 d-flex">
                                <p>$</p>
                                <p class="cart-price">{{$cart->variant->price}}</p>
                            </div>
                        </div>
                        {{--                        <hr class="my-3">--}}
                    </div>
                    <div class="position-absolute w-100" style="bottom: 20px; left:0;">
                        <div class="d-flex justify-content-center">
                            <input type="text" name="discount_code" class="discountCard form-control w-75">
                            <button class="btn btn-success" id="discountApply">Discount Apply</button>
                        </div>

                        <div class="d-flex justify-content-around">
                            <label>Sub Total</label>
                            <div class="d-flex">
                                <span>$</span>
                                <span class="total"></span>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-around">
                            <label>Total</label>
                            <div class="d-flex">
                                <span>$</span>
                                <span class="total"></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="btn btn-success w-75 checkoutBtn">Checkout</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
<script>
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
    $(document).on('click' , '.close-product' , function (){
        let deleteId = $(this).data('id');
        let productId = $(this).data('product');
        let cartId = $(this).data('id');
        let row = $(this).closest('.cart-'+cartId);
        let row1 = $('.checkoutAllItems').find('.dlt-'+cartId).parents('.cartData');

        $.ajax({
            url: route('delete.cart'),
            type: "GET",
            data: {
                delete_id : deleteId
            },
            success: function (response) {
                if(response.success){
                    row.remove();
                    row1.remove()
                    $('.product-' + productId).find('#addToCart').show();
                    $('.product-' + productId).find('#incrementDecrement').hide();
                    count();
                    updateTotal();
                }
            },
        });
    });
    $(document).on('click' , '#discountApply', function (){
        let discountCode = $(this).closest('.discountCard').val();
        $.ajax({
            url: route('discount.code.check'),
            type: "GET",
            data: {
                discount_code : discountCode
            },
            success: function (response) {
            },
        });
    })

</script>
