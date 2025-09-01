@extends('layout')
@section('content')
    <div class="container my-5 ">
        <div class="card" style="width: 35rem; height: 35rem; margin: 0 auto;">
            <div class="card-body">
                <h5 class="card-title bg-success p-2 text-light">A Email Verification link has been emailed to you</h5>
                <h2 class="card-subtitle mb-2 text-body-secondary">Verify e-mail address</h2>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                <form method="post" >
                    <input  type="button" class="btn btn-primary btn-lg emailVerify" name="verifyUser" value="Resend verification mail">
                </form>
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
            $(document).on('click', '.emailVerify', function (e) {
                e.preventDefault()
                let formData = []
                $.ajax({
                    url: "/verify",
                    method: "POST",
                    data: formData,
                    success: function (response) {
                    }
                });
            });
        });
    </script>
@endsection
