@csrf
<input type="hidden" id="edit-user-id" data-id="{{$userData->id}}">
<div class="row mb-4">
    <div class="col">
        <div  class="form-group">
            <label class="form-label fw-bold " for="first-name">First name</label>
            <input type="text" id="first-name" class="form-control"  value="{{$userData->first_name}}"  name="first_name" placeholder="Enter First name"/>
            <span style="color: darkred">@error('firstName') {{$message}} @enderror</span>
        </div>
    </div>
    <div class="col">
        <div  class="form-group">
            <label class="form-label fw-bold" for="last-name">Last name</label>
            <input type="text" id="last-name" class="form-control" value="{{$userData->last_name}}" name="last_name" placeholder="Enter Last name"/>
            <span style="color: darkred">@error('lastName') {{$message}} @enderror</span>
        </div>
    </div>
</div>

<div  class="form-group mb-4">
    <label class="form-label fw-bold" for="email">Email address</label>
    <input type="email" id="email" class="form-control" value="{{$userData->email}}" name="email" placeholder="Enter your email" />
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
@php
    $userHobbies = old('hobbie', json_decode($userData->hobbies));
@endphp
<div class="form-group mb-4 ">
    <label class="form-label fw-bold">Hobbies</label>
    <div class="form-check ms-4">
        <input class="form-check-input" type="checkbox" name="hobbie[]" value="singing" id="singing"  {{ in_array('singing', $userHobbies) ? 'checked' : '' }}>
        <label class="form-check-label" for="singing">
            singing
        </label>
    </div>
    <div class="form-check ms-4">
        <input class="form-check-input" type="checkbox" value="dancing" name="hobbie[]" id="dancing"  {{ in_array('dancing', $userHobbies) ? 'checked' : '' }}>
        <label class="form-check-label" for="dancing">
            dancing
        </label>
    </div>
    <div class="form-check ms-4">
        <input class="form-check-input" type="checkbox" value="acting" name="hobbie[]" id="acting"  {{ in_array('acting', $userHobbies) ? 'checked' : '' }}>
        <label class="form-check-label" for="acting">
            acting
        </label>
    </div>
    <div class="form-check ms-4">
        <input class="form-check-input" type="checkbox" value="cooking" name="hobbie[]" id="cooking"  {{ in_array('cooking', $userHobbies) ? 'checked' : '' }}>
        <label class="form-check-label" for="cooking">
            cooking
        </label>
    </div>
    <span style="color: darkred">@error('hobbie') {{ $message }} @enderror</span>
</div>

<div class="form-group mb-4">
    <label class="form-label fw-bold" for="custom-file">Status</label>
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" style="width: 50px; height: 28px;" {{$userData->status == 1 ? 'checked' : ''}}>
    </div>
</div>


<div class="form-group mb-4">
    <label class="form-label fw-bold" for="custom-file">Image</label>
    <input type="file" class="form-control" id="custom-file" name="image[]" multiple/>

    <div id="image-preview">
        @if ($userData->image_url)
            @foreach($userData->image_url as $image)
                <img src="{{$image}}" alt="User Image" class="img-thumbnail mt-2" style="max-width: 100px;">
            @endforeach
        @endif
    </div>
</div>
<button type="button" class="btn btn-primary btn-block mb-4 submit-btn">Update</button>
