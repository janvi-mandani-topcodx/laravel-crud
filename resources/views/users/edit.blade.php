@extends('layout')

@section('content')
    <section class="gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Edit User</h3>
                            <form method="POST" enctype="multipart/form-data" id="edit-user-form" action="{{ route('users.update', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit-user-id" data-id="{{$user->id}}">
                                <div class="row mb-4">
                                    <div class="col">
                                        <div  class="form-group">
                                            <label class="form-label fw-bold" for="first-name">First name</label>
                                            <input type="text" id="first-name" class="form-control"  value="{{$user->first_name}}"  name="firstName" placeholder="Enter First name"/>
                                            <span style="color: darkred">@error('firstName') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div  class="form-group">
                                            <label class="form-label fw-bold" for="last-name">Last name</label>
                                            <input type="text" id="last-name" class="form-control" value="{{$user->last_name}}" name="lastName" placeholder="Enter Last name"/>
                                            <span style="color: darkred">@error('lastName') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>

                                <div  class="form-group mb-4">
                                    <label class="form-label fw-bold" for="email">Email address</label>
                                    <input type="email" id="email" class="form-control" value="{{$user->email}}" name="email" placeholder="Enter your email" />
                                    <span style="color: darkred">@error('email') {{$message}} @enderror</span>
                                </div>

                                <div  class="form-group mb-4">
                                    <label class="form-label fw-bold" for="password">Password</label>
                                    <input type="password" id="password" class="form-control"  value="" name="password" placeholder="Enter password"/>
                                    <span style="color: darkred">@error('password') {{$message}} @enderror</span>
                                </div>
                                <div  class="form-group mb-4">
                                    <label class="form-label fw-bold" for="confirm-password">Confirm password</label>
                                    <input type="password" id="confirm-password" class="form-control"  value="" name="confirmPassword" placeholder="Enter confirm password"/>
                                    <span style="color: darkred">@error('confirmPassword') {{$message}} @enderror</span>
                                </div>
                                @php
                                    $userHobbies = old('hobbie', json_decode($user->hobbies));
                                @endphp
                                <div class="form-group mb-4 ">
                                    <label class="form-label fw-bold">Hobbies</label>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" name="hobbie[]" value="singing" id="singing"  {{ in_array('singing', $userHobbies) ? 'checked' : '' }} >
                                        <label class="form-check-label" for="singing">
                                            singing
                                        </label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" value="dancing" name="hobbie[]" id="dancing" {{ in_array('dancing', $userHobbies) ? 'checked' : '' }}  >
                                        <label class="form-check-label" for="dancing">
                                            dancing
                                        </label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" value="acting" name="hobbie[]" id="acting"{{ in_array('acting', $userHobbies) ? 'checked' : '' }}  >
                                        <label class="form-check-label" for="acting">
                                            acting
                                        </label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" value="cooking" name="hobbie[]" id="cooking"  {{ in_array('cooking', $userHobbies) ? 'checked' : '' }} >
                                        <label class="form-check-label" for="cooking">
                                            cooking
                                        </label>
                                    </div>
                                    <span style="color: darkred" class="hobbies-error">@error('hobbies') {{ $message }} @enderror</span>

                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold" >Gender</label>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ $user->gender == 'male' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ $user->gender == 'female' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>

                                    <span style="color: darkred" class="gender-error">@error('gender') {{ $message }} @enderror</span>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold" >Role</label>
                                    <select class="form-select" name="role" id="mySelect">
                                        <option >Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}" {{ $user->roles->contains('id', $role->id) ? 'selected' : '' }}>{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold" for="custom-file">Image</label>
                                    <input type="file" class="form-control" id="custom-file" name="image"/>
                                    @if ($user->imageUrl)
                                        <img src="{{$user->imageUrl}}" alt="User Image" class="img-thumbnail mt-2" style="max-width: 150px;">
                                    @else
                                        <p class="text-muted">No image uploaded.</p>
                                    @endif
                                    <span style="color: darkred">@error('image') {{ $message }} @enderror</span>
                                </div>

                                <div class="form-group">

                                    <div class="d-flex justify-content-end">
                                        <div class="btn btn-primary" id="add-tags">Add</div>
                                    </div>
                                    <div id="one-tag">
                                       @foreach($user->tags as $tags)
                                            <div class="row p-2">
                                                <div class="col-10">
                                                    <input type="text" id="tag" class="form-control" value="{{$tags->tag}}" name="tag[]" placeholder="Enter tag"/>
                                                </div>
                                                <div class="col-2 d-flex justify-content-end p-0">
                                                    <span class="btn btn-danger delete-tag">Delete</span>
                                                </div>
                                            </div>
                                       @endforeach
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary btn-block mb-4" id="edit-button">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Credit</h3>
                            <form method="POST" enctype="multipart/form-data" id="creditForm" action="">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div  class="form-group">
                                            <label class="form-label fw-bold" for="creditAmount">Credit Amount</label>
                                            <input type="text" id="creditAmount" class="form-control" value="" name="credit_amount" placeholder="Enter credit amount"/>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div  class="form-group">
                                            <label class="form-label fw-bold" for="description">Description</label>
                                            <input type="text" id="description" class="form-control" value="" name="description" placeholder="Enter description"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="btn btn-success" id="CreateCredit">Create</div>
                                </div>
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

            $(document).on('click' , '#add-tags' , function (){
                const newTag = `
                <div class="row p-2">
                                   <div class="col-10">
                                        <input type="text" id="tag" class="form-control"   name="tag[]" placeholder="Enter tag"/>
                                   </div>
                                   <div class="col-2 d-flex justify-content-end p-0">
                                       <span class="btn btn-danger delete-tag">Delete</span>
                                   </div>
                               </div>
                               `;
                $('#one-tag').append(newTag)
            });

            $(document).on('click' , '.delete-tag' , function (){
                $(this).closest('.row').remove()
            })

            $(document).on('click', '#edit-button', function (e) {
                e.preventDefault();

                let form = $(this).closest('form')[0];
                let formData = new FormData(form);
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

            $(document).on('click' , '#CreateCredit' , function (){
                let form = $(this).closest('form')[0];
                let formData = new FormData(form);
                let userId = $('#edit-user-id').data('id')
                formData.append('user_id' , userId);
                $.ajax({
                    url: "{{route('credit.store')}}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.location.href = "{{route('users.index')}}";
                    },
                });
            })

        });
    </script>
@endsection
