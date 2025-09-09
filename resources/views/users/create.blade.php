@extends('layout')


@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Create User</h3>
                            <form method="POST" enctype="multipart/form-data" action="{{ route('users.store') }}">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col">
                                        <div  class="form-group">
                                            <label class="form-label fw-bold " for="first-name">First name</label>
                                            <input type="text" id="first-name" class="form-control"  value="{{old('firstName')}}"  name="firstName" placeholder="Enter First name"/>
                                            <span style="color: darkred">@error('firstName') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div  class="form-group">
                                            <label class="form-label fw-bold" for="last-name">Last name</label>
                                            <input type="text" id="last-name" class="form-control" value="{{old('lastName')}}" name="lastName" placeholder="Enter Last name"/>
                                            <span style="color: darkred">@error('lastName') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>

                                <div  class="form-group mb-4">
                                    <label class="form-label fw-bold" for="email">Email address</label>
                                    <input type="email" id="email" class="form-control" value="{{old('email')}}" name="email" placeholder="Enter your email" />
                                    <span style="color: darkred">@error('email') {{$message}} @enderror</span>
                                </div>

                                <div  class="form-group mb-4">
                                    <label class="form-label fw-bold" for="password">Password</label>
                                    <input type="password" id="password" class="form-control"  value="{{old('password')}}" name="password" placeholder="Enter password"/>
                                    <span style="color: darkred">@error('password') {{$message}} @enderror</span>
                                </div>
                                <div  class="form-group mb-4">
                                    <label class="form-label fw-bold" for="confirm-password">Confirm password</label>
                                    <input type="password" id="confirm-password" class="form-control"  value="{{old('confirmPassword')}}" name="confirmPassword" placeholder="Enter confirm password"/>
                                    <span style="color: darkred">@error('confirmPassword') {{$message}} @enderror</span>
                                </div>

                                <div class="form-group mb-4 ">
                                    <label class="form-label fw-bold">Hobbies</label>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" name="hobbie[]" value="singing" id="singing" {{ in_array('singing', old('hobbie', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="singing">
                                            singing
                                        </label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" value="dancing" name="hobbie[]" id="dancing" {{ in_array('dancing', old('hobbie', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="dancing">
                                            dancing
                                        </label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" value="acting" name="hobbie[]" id="acting" {{ in_array('acting', old('hobbie', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="acting">
                                            acting
                                        </label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" value="cooking" name="hobbie[]" id="cooking" {{ in_array('cooking', old('hobbie', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cooking">
                                            cooking
                                        </label>
                                    </div>
                                    <span style="color: darkred" class="hobbies-error">@error('hobbie') {{ $message }} @enderror</span>

                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold" >Gender</label>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                    <span style="color: darkred" class="gender-error">@error('gender') {{ $message }} @enderror</span>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold" >Role</label>
                                        <select class="form-select" name="role" id="mySelect">
                                            <option selected disabled>Select Role</option>
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                </div>



                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold" for="custom-file">Image</label>
                                    <input type="file" class="form-control" id="custom-file" name="image"/>
                                    <span style="color: darkred">@error('image') {{ $message }} @enderror</span>
                                </div>
                                <button type="button" class="btn btn-primary btn-block mb-4 submit-btn">Submit</button>
                            </form>
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
            $(document).on('click', '.submit-btn', function (e) {
                e.preventDefault()
                let form = $(this).closest('form')[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/users",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.location.href = '{{ route('users.index') }}';
                    },
                    error: function (response) {
                        console.log(response.responseJSON);
                            let errors = response.responseJSON.errors;
                            if (errors.firstName) {
                                $('#first-name').siblings('span').text(errors.firstName[0]);
                            }
                            if (errors.lastName) {
                                $('#last-name').siblings('span').text(errors.lastName[0]);
                            }
                            if (errors.email) {
                                $('#email').siblings('span').text(errors.email[0]);
                            }
                            if (errors.password) {
                                $('#password').siblings('span').text(errors.password[0]);
                            }
                            if (errors.confirmPassword) {
                                $('#confirm-password').siblings('span').text(errors.confirmPassword[0]);
                            }
                            if (errors.hobbie) {
                                $('.hobbies-error').text(errors.hobbie[0]);
                            }
                            if (errors.gender) {
                                $('.gender-error').text(errors.gender[0]);
                            }
                            if (errors.image) {
                                $('#custom-file').siblings('span').text(errors.image[0]);
                            }
                    }
                });
            });
        });
    </script>
@endsection

