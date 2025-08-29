@extends('layout')
@section('content')
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Reset Password</p>
                                    <form class="mx-1 mx-md-4" action="{{route('reset.submit')}}" method="POST">
                                        @csrf
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="email" id="email" name="email" class="form-control"  value="{{old('email')}}"/>
                                                <span style="color: darkred">@error('email') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="oldPassword">Old password</label>
                                                <input type="password" id="oldPassword" name="oldPassword" class="form-control"  value="{{old('oldPassword')}}"/>
                                                <span style="color: darkred">@error('oldPassword') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="newPassword">New password</label>
                                                <input type="password" id="newPassword" name="newPassword" class="form-control"  value="{{old('newPassword')}}"/>
                                                <span style="color: darkred">@error('newPassword') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="confirmPassword">Confirm password</label>
                                                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control"  value="{{old('confirmPassword')}}"/>
                                                <span style="color: darkred">@error('confirmPassword') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button  type="button" class="btn btn-primary btn-lg reset" name="">Password Reset</button>
                                        </div>
                                        <div class="text-end">
                                            <a href="{{route('login.view')}}">Back to login</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                         class="img-fluid" alt="Sample image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click', '.reset', function (e) {
                e.preventDefault()
                let form = $(this).closest('form')[0];
                console.log(form)
                let formData = new FormData(form);

                $.ajax({
                    url: "/reset",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.location.href = '{{ route('login.view') }}';
                    },
                    error: function (response) {
                        console.log(response.responseJSON.errors.email);
                        let errors = response.responseJSON.errors;
                        if (errors.email) {
                            $('#email').siblings('span').text(errors.email[0]);
                        }
                        if (errors.oldPassword) {
                            $('#oldPassword').siblings('span').text(errors.oldPassword[0]);
                        }
                        if (errors.newPassword) {
                            $('#newPassword').siblings('span').text(errors.newPassword[0]);
                        }
                        if (errors.confirmPassword) {
                            $('#confirmPassword').siblings('span').text(errors.confirmPassword[0]);
                        }

                    }
                });
            });
        });
    </script>
@endsection
