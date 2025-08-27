@extends('layout')

@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Edit User</h3>
                            <form method="POST" enctype="multipart/form-data" id="editUserForm" action="{{ route('users.update', $users->id) }}">

                            @csrf
                                @method('PUT')
                                <input type="hidden" id="editUserId" data-id="{{$users->id}}">
                                <div class="row mb-4">
                                    <div class="col">
                                        <div  class="form-outline">
                                            <label class="form-label fw-bold" for="firstName">First name</label>
                                            <input type="text" id="firstName" class="form-control"  value="{{$users->first_name}}"  name="firstName" placeholder="Enter First name"/>
                                            <span style="color: darkred">@error('firstName') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div  class="form-outline">
                                            <label class="form-label fw-bold" for="lastName">Last name</label>
                                            <input type="text" id="lastName" class="form-control" value="{{$users->last_name}}" name="lastName" placeholder="Enter Last name"/>
                                            <span style="color: darkred">@error('lastName') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>

                                <div  class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="email">Email address</label>
                                    <input type="email" id="email" class="form-control" value="{{$users->email}}" name="email" placeholder="Enter your email" />
                                    <span style="color: darkred">@error('email') {{$message}} @enderror</span>
                                </div>

                                <div  class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="password">Password</label>
                                    <input type="text" id="password" class="form-control"  value="" name="password" placeholder="Enter password"/>
                                    <span style="color: darkred">@error('password') {{$message}} @enderror</span>
                                </div>
                                <div  class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="confirmPassword">Confirm Password</label>
                                    <input type="text" id="confirmPassword" class="form-control"  value="" name="confirmPassword" placeholder="Enter confirm password"/>
                                    <span style="color: darkred">@error('confirmPassword') {{$message}} @enderror</span>
                                </div>
                                @php
                                    $userHobbies = old('hobbie', json_decode($users->hobbies));
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
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label fw-bold" >Gender</label>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ $users->gender == 'male' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ $users->gender == 'female' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>

                                    <span style="color: darkred">@error('gender') {{ $message }} @enderror</span>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="customFile">Image</label>
                                    <input type="file" class="form-control" id="customFile" name="image"/>
                                    @if ($users->image)
                                        <img src="{{$users->imageUrl}}" alt="User Image" class="img-thumbnail mt-2" style="max-width: 150px;">
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
            $(document).on('click', '#editbutton', function (e) {
                e.preventDefault();
                let form = $(this).closest('form')[0];
                let formData = new FormData(form);
                console.log("heloo")
                $.ajax({
                    url: "{{route('users.update', $users->id)}}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                    {{--    form.reset();--}}
                    {{--    let newRow = `--}}
                    {{--    <tr id="oneuser" data-id='${response.id}>--}}
                    {{--        <td>${response.id}</td>--}}
                    {{--        <td>${response.first_name}</td>--}}
                    {{--        <td>${response.last_name}</td>--}}
                    {{--        <td>${response.email}</td>--}}
                    {{--        <td>${response.gender}</td>--}}
                    {{--        <td>${Array.isArray(response.hobbies) ? response.hobbies.join(', ') : ''}</td>--}}
                    {{--        <td><img src="${response.image_url}" width="50"/></td>--}}
                    {{--        <td style="" class="editDelete">--}}
                    {{--                    <form action="" method="POST">--}}
                    {{--                        @csrf--}}
                    {{--    @method('DELETE')--}}
                    {{--    <button type="button" id="deleteUsers" class="btn btn-danger btn-sm my-3" data-id="${response.id}">DELETE</button>--}}
                    {{--                    </form>--}}
                    {{--                        <a href="" class="btn btn-warning editbtn d-flex justify-content-center align-items-center" data-id="${response.id}">Edit</a>--}}
                    {{--                    </td>--}}
                    {{--    </tr>--}}
                    {{--`;--}}
                    //     $('#userDataContainer tbody').append(newRow);
                        console.log("hsdgrtyty");
                        history.pushState(null,'' , '{{route('users.index')}}')
                        {{--window.location.href = "{{route('users.index')}}";--}}
                    },
                });
            });
        });
    </script>
@endsection
