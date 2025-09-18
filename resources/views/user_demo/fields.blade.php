@csrf
<div class="row mb-4">
    <div class="col">
        <div  class="form-group">
            <label class="form-label fw-bold " for="first-name">First name</label>
            <input type="text" id="first-name" class="form-control"  value="{{old('firstName')}}"  name="firstName" placeholder="Enter First name"/>
        </div>
    </div>
    <div class="col">
        <div  class="form-group">
            <label class="form-label fw-bold" for="last-name">Last name</label>
            <input type="text" id="last-name" class="form-control" value="{{old('lastName')}}" name="lastName" placeholder="Enter Last name"/>
        </div>
    </div>
</div>

<div  class="form-group mb-4">
    <label class="form-label fw-bold" for="email">Email address</label>
    <input type="email" id="email" class="form-control" value="{{old('email')}}" name="email" placeholder="Enter your email" />
</div>

<div  class="form-group mb-4">
    <label class="form-label fw-bold" for="password">Password</label>
    <input type="password" id="password" class="form-control"  value="{{old('password')}}" name="password" placeholder="Enter password"/>

</div>
<div  class="form-group mb-4">
    <label class="form-label fw-bold" for="confirm-password">Confirm password</label>
    <input type="password" id="confirm-password" class="form-control"  value="{{old('confirmPassword')}}" name="confirmPassword" placeholder="Enter confirm password"/>
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
</div>

<div class="form-group mb-4">
    <label class="form-label fw-bold" for="custom-file">Status</label>
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="status" style="width: 50px; height: 28px;">
    </div>
</div>


<div class="form-group mb-4">
    <label class="form-label fw-bold" for="custom-file">Image</label>
    <input type="file" class="form-control" id="custom-file" name="image" multiple/>
</div>
<button type="button" class="btn btn-primary btn-block mb-4 submit-btn">Submit</button>
