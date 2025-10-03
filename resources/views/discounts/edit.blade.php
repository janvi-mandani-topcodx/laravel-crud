@extends('layout')
@section('content')
    <div>
        <h3 class="d-flex justify-content-center my-3">Edit discount</h3>
        <form method="POST" id="discountForm" enctype="multipart/form-data" action="{{ route('discounts.update' , $discount->id) }}">
            @include('discounts.edit_fields')
        </form>
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
            $('#searchProduct').hide()
            $('#searchCustomer').hide()
            $('.end-date').hide()
            $('#minimumPurchase').hide()
            $('#minimumQuantity').hide()
            $('#limitDiscount').hide()
            $(document).on('change' , '#specificProduct' , function (){
                if($(this).prop('checked')){
                    $('#searchProduct').show();
                }
            })
            $(document).on('change' , '#allProducts' , function (){
                if($(this).prop('checked')){
                    $('#searchProduct').hide();
                    $('#searchProduct').val('');
                    $('#searchProduct').removeClass('d-block');
                    $('.hidden-product-id').val('');
                }
            })

            $(document).on('change' , '#specificCustomer' , function (){
                if($(this).prop('checked')){
                    $('#searchCustomer').show();
                }
            })
            $(document).on('change' , '#everyone' , function (){
                if($(this).prop('checked')){
                    $('#searchCustomer').hide();
                    $('#searchCustomer').val('');
                    $('#searchCustomer').removeClass('d-block');
                    $('.hidden-user-id').val('')
                }
            })
            $(document).on('change' , '#percentage' , function (){
                if($(this).prop('checked')){
                    $('#amounts').hide();
                }
            })
            $(document).on('change' , '#endDateCheckBox' , function (){
                if($(this).prop('checked')){
                    $('.end-date').show();
                }
                else{
                    $('.end-date').hide();
                    $('#endDate').val('');
                }
            })
            $(document).on('change' , '#purchaseAmount' , function (){
                if($(this).prop('checked')){
                    $('#minimumQuantity').hide();
                    $('#minimumPurchase').show();
                    $('#minimumQuantity').removeClass('d-block');
                    $('#minimumQuantity').val('');
                    $('#minimumPurchase').val('');
                }
            })
            $(document).on('change' , '#quantityAmount' , function (){
                if($(this).prop('checked')){
                    $('#minimumPurchase').hide();
                    $('#minimumPurchase').removeClass('d-block');
                    $('#minimumQuantity').show();
                    $('#minimumQuantity').val('');
                    $('#minimumPurchase').val('');
                }
            })
            $(document).on('change' , '#none' , function (){
                if($(this).prop('checked')){
                    $('#minimumPurchase').hide();
                    $('#minimumQuantity').hide();
                }
            })
            $(document).on('change' , '#limitNumber' , function (){
                if($(this).prop('checked')){
                    $('#limitDiscount').show();
                }
                else{
                    $('#limitDiscount').hide();
                    $('#limitDiscount').val('');
                    $('#limitDiscount').removeClass('d-block')
                }
            })

            // $(document).on('click' , '#updateDiscount' ,  function (e){
                {{--e.preventDefault()--}}
                {{--let form = $(this).closest('form')[0];--}}
                {{--let formData = new FormData(form);--}}

                {{--$.ajax({--}}
                {{--    url: "{{route('discounts.update' , $discount->id)}}",--}}
                {{--    method: "POST",--}}
                {{--    data: formData,--}}
                {{--    contentType: false,--}}
                {{--    processData: false,--}}
                {{--    success: function (response) {--}}
                {{--        window.location.href = '{{ route('discounts.index') }}';--}}
                {{--    }--}}
                {{--});--}}
            // })

            $(document).on('keyup', '#searchProduct' ,  function () {
                let query = $(this).val();
                $.ajax({
                    url: "{{route('discount.product.search')}}",
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

            $(document).on('keyup', '#searchCustomer' ,  function () {
                let query = $(this).val();
                $.ajax({
                    url: "{{route('discount.user.search')}}",
                    method: "GET",
                    data: {
                        search: query
                    },
                    success: function (response) {
                        console.log(response.html)
                        console.log( $('#userSearchData'))
                        $('#userSearchData').html(response.html);
                    },
                    error: function (response){
                        $('#userSearchData').html(response.html);
                    }
                });
            });

            $(document).on('click', '#one-product' ,  function () {
                let productTitle = $(this).find('.search-product-title').text();
                let id = $(this).data('id');
                $('#searchProduct').val(productTitle)
                $('.hidden-product-id').val(id);
                $('#productSearch').text('');
            })

            $(document).on('click', '#one-user' ,  function () {
                let name = $(this).find('.name').text();
                let id = $(this).data('id');
                $('#searchCustomer').val(name)
                $('.hidden-user-id').val(id);
                $('#userSearchData').text('');
            })
        });
    </script>
@endsection
