<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<body>
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
                                        <div  class="form-outline">
                                            <label class="form-label fw-bold " for="firstName">First name</label>
                                            <input type="text" id="firstName" class="form-control"  value="{{old('firstName')}}"  name="firstName" placeholder="Enter First name"/>
                                            <span style="color: darkred">@error('firstName') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div  class="form-outline">
                                            <label class="form-label fw-bold" for="lastName">Last name</label>
                                            <input type="text" id="lastName" class="form-control" value="{{old('lastName')}}" name="lastName" placeholder="Enter Last name"/>
                                            <span style="color: darkred">@error('lastName') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>

                                <div  class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="email">Email address</label>
                                    <input type="email" id="email" class="form-control" value="{{old('email')}}" name="email" placeholder="Enter your email" />
                                    <span style="color: darkred">@error('email') {{$message}} @enderror</span>
                                </div>

                                <div  class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="password">Password</label>
                                    <input type="text" id="password" class="form-control"  value="{{old('password')}}" name="password" placeholder="Enter password"/>
                                    <span style="color: darkred">@error('password') {{$message}} @enderror</span>
                                </div>
                                <div  class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="confirmPassword">Confirm password</label>
                                    <input type="text" id="confirmPassword" class="form-control"  value="{{old('confirmPassword')}}" name="confirmPassword" placeholder="Enter confirm password"/>
                                    <span style="color: darkred">@error('confirmPassword') {{$message}} @enderror</span>
                                </div>

                                <div class="form-outline mb-4 ">
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
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label fw-bold" >Gender</label>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>

                                    <span style="color: darkred">@error('gender') {{ $message }} @enderror</span>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="customFile">Image</label>
                                    <input type="file" class="form-control" id="customFile" name="image"/>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mb-4">Submit</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
