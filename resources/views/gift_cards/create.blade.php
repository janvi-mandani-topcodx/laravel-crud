@extends('layout')
@section('content')
    <div>
        <h3 class="d-flex justify-content-center my-3">Create Gift Card</h3>
        <form method="POST" id="discountForm" enctype="multipart/form-data" action="{{ route('gift-card.store') }}">
            @include('gift_cards.fields')
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

            $(document).on('click', '#createGiftCard', function (e) {
                e.preventDefault()
                let form = $(this).closest('form')[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "{{route('gift-card.store')}}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.location.href = '{{ route('gift-card.index') }}';
                    },
                    error: function (response){
                        let errors = response.responseJSON.errors;
                        if (errors.code) {
                            console.log(errors.code)
                            $('.gift-card-code-error').text(errors.code[0]);
                        }
                        if (errors.balance) {
                            $('.gift-card-balance-error').text(errors.balance[0]);
                        }
                    }
                });
            });

            $(document).on('keyup', '#searchCustomer' ,  function () {
                let query = $(this).val();
                $.ajax({
                    url: "{{route('gift.user.search')}}",
                    method: "GET",
                    data: {
                        search: query
                    },
                    success: function (response) {
                        $('#userSearchData').html(response.html);
                    },
                    error: function (response){
                        $('#userSearchData').html(response.html);
                    }
                });
            });
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
