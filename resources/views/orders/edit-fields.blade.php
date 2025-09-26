@csrf
<div class="row mb-4">
    <div class="col">
        <div  class="form-group">
            <label class="form-label fw-bold " for="firstName">First Name</label>
            <input type="text" id="firstName" class="form-control"  value="{{$shippingDetails->first_name}}"  name="first_name" placeholder="Enter your first name"/>
            <span style="color: darkred" class="first-name-error">@error('first_name') {{$message}} @enderror</span>
        </div>
    </div>
</div>

<div  class="form-group mb-4">
    <label class="form-label fw-bold" for="lastName">Last Name</label>
    <input type="text" id="lastName" class="form-control"  value="{{$shippingDetails->last_name}}"  name="last_name" placeholder="Enter your last name"/>
    <span style="color: darkred" class="last-name-error">@error('last_name') {{$message}} @enderror</span>
</div>

<div class="form-group mb-4">
    <label class="form-label fw-bold" for="address">Address</label>
    <input type="text" id="address" class="form-control"  value="{{$shippingDetails->address}}"  name="address" placeholder="Enter your address"/>
    <span style="color: darkred" class="address-error">@error('address') {{$message}} @enderror</span>
</div>

<div class="form-group mb-4">
    <label class="form-label fw-bold" for="state">State</label>
    <input type="text" id="state" class="form-control"  value="{{$shippingDetails->state}}"  name="state" placeholder="Enter your state"/>
    <span style="color: darkred" class="state-error">@error('state') {{$message}} @enderror</span>
</div>

<div class="form-group mb-4">
    <label class="form-label fw-bold" for="country">Country</label>
    <input type="text" id="country" class="form-control"  value="{{$shippingDetails->country}}"  name="country" placeholder="Enter your country"/>
    <span style="color: darkred" class="country-error">@error('country') {{$message}} @enderror</span>
</div>

<div class="form-group mb-4">
    <label class="form-label fw-bold" for="delivery">Delivery</label>
    <textarea id="delivery" class="form-control"  name="delivery">{{$order->delivery}}</textarea>
    <span style="color: darkred" class="delivery-error">@error('delivery') {{$message}} @enderror</span>
</div>

<div>
    <button class="btn btn-success w-100 updateCheckoutAction">Update</button>
</div>
