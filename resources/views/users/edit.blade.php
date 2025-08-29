@extends('layout')

@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Edit User</h3>
                            <form method="POST" enctype="multipart/form-data" id="editUserForm" action="{{ route('users.update', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="editUserId" data-id="{{$user->id}}">
                                <div class="row mb-4">
                                    <div class="col">
                                        <div  class="form-outline">
                                            <label class="form-label fw-bold" for="firstName">First name</label>
                                            <input type="text" id="firstName" class="form-control"  value="{{$user->first_name}}"  name="firstName" placeholder="Enter First name"/>
                                            <span style="color: darkred">@error('firstName') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div  class="form-outline">
                                            <label class="form-label fw-bold" for="lastName">Last name</label>
                                            <input type="text" id="lastName" class="form-control" value="{{$user->last_name}}" name="lastName" placeholder="Enter Last name"/>
                                            <span style="color: darkred">@error('lastName') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>

                                <div  class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="email">Email address</label>
                                    <input type="email" id="email" class="form-control" value="{{$user->email}}" name="email" placeholder="Enter your email" />
                                    <span style="color: darkred">@error('email') {{$message}} @enderror</span>
                                </div>

                                <div  class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="password">Password</label>
                                    <input type="password" id="password" class="form-control"  value="" name="password" placeholder="Enter password"/>
                                    <span style="color: darkred">@error('password') {{$message}} @enderror</span>
                                </div>
                                <div  class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="confirmPassword">Confirm password</label>
                                    <input type="password" id="confirmPassword" class="form-control"  value="" name="confirmPassword" placeholder="Enter confirm password"/>
                                    <span style="color: darkred">@error('confirmPassword') {{$message}} @enderror</span>
                                </div>
                                @php
                                    $userHobbies = old('hobbie', json_decode($user->hobbies));
                                @endphp
                                <div class="form-outline mb-4 ">
                                    <label class="form-label fw-bold">Hobbies</label>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" name="hobbie[]" value="singing" id="singing" {{ in_array('singing', $userHobbies) ? 'checked' : '' }} >
                                        <label class="form-check-label" for="singing">
                                            singing
                                        </label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" value="dancing" name="hobbie[]" id="dancing" {{ in_array('dancing', $userHobbies) ? 'checked' : '' }} >
                                        <label class="form-check-label" for="dancing">
                                            dancing
                                        </label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" value="acting" name="hobbie[]" id="acting" {{ in_array('acting', $userHobbies) ? 'checked' : '' }} >
                                        <label class="form-check-label" for="acting">
                                            acting
                                        </label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" value="cooking" name="hobbie[]" id="cooking" {{ in_array('cooking', $userHobbies) ? 'checked' : '' }} >
                                        <label class="form-check-label" for="cooking">
                                            cooking
                                        </label>
                                    </div>
                                    <span style="color: darkred" class="hobbieError">@error('gender') {{ $message }} @enderror</span>

                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label fw-bold" >Gender</label>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ $user->gender == 'male' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ $user->gender == 'female' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>

                                    <span style="color: darkred" class="genderError">@error('gender') {{ $message }} @enderror</span>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="customFile">Image</label>
                                    <input type="file" class="form-control" id="customFile" name="image"/>
                                    @if ($user->image)
                                        <img src="{{$user->imageUrl}}" alt="User Image" class="img-thumbnail mt-2" style="max-width: 150px;">
                                    @else
                                        <p class="text-muted">No image uploaded.</p>
                                    @endif
                                    <span style="color: darkred">@error('image') {{ $message }} @enderror</span>
                                </div>
                                <button type="button" class="btn btn-primary btn-block mb-4" id="editbutton">Update</button>
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
            $(document).on('click', '#editbutton', function (e) {
                e.preventDefault();
                let form = $(this).closest('form')[0];
                let formData = new FormData(form);
                console.log("heloo")
                $.ajax({
                    url: "{{route('users.update', $user->id)}}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.location.href = "{{route('users.index')}}";
                    },
                    error:function (response){
                        console.log(response.responseJSON);
                        let errors = response.responseJSON.errors;
                        if (errors.firstName) {
                            $('#firstName').siblings('span').text(errors.firstName[0]);
                        }
                        if (errors.lastName) {
                            $('#lastName').siblings('span').text(errors.lastName[0]);
                        }
                        if (errors.email) {
                            $('#email').siblings('span').text(errors.email[0]);
                        }
                        if (errors.password) {
                            $('#password').siblings('span').text(errors.password[0]);
                        }
                        if (errors.confirmPassword) {
                            $('#confirmPassword').siblings('span').text(errors.confirmPassword[0]);
                        }
                        if (errors.hobbie) {
                            $('.hobbieError').text(errors.hobbie[0]);
                        }
                        if (errors.gender) {
                            $('.genderError').text(errors.gender[0]);
                        }
                        if (errors.image) {
                            $('#customFile').siblings('span').text(errors.image[0]);
                        }
                    }
                });
            });
        });
    </script>
@endsection
