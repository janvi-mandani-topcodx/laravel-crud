@extends('layout')
@section('content')
    <div>
        <h3 class="d-flex justify-content-center my-3">Update Gift Card</h3>
        <form method="POST" id="discountForm" enctype="multipart/form-data" action="">
            @include('gift_cards.edit_fields')
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

            $(document).on('click', '#updateGiftCard', function (e) {
                e.preventDefault()
                let form = $(this).closest('form')[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "{{route('gift-card.update' , $giftCard->id)}}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.location.href = '{{ route('gift-card.index') }}';
                    },
                    error: function (response){
                        let errors = response.responseJSON.errors;
                        if (errors.balance) {
                            $('.gift-card-balance-error').text(errors.balance[0]);
                        }
                    }
                });
            });

        });
    </script>
@endsection
