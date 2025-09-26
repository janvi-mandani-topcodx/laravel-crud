@csrf
<div class="row mb-4">
    <div class="col">
        <div  class="form-group">
            <label class="form-label fw-bold " for="firstName">First Name</label>
            <input type="text" id="firstName" class="form-control"  value="{{old('first_name')}}"  name="first_name" placeholder="Enter your first name"/>
            <span style="color: darkred" class="first_name-error"></span>
        </div>
    </div>
</div>

<div  class="form-group mb-4">
    <label class="form-label fw-bold" for="lastName">Last Name</label>
    <input type="text" id="lastName" class="form-control"  value="{{old('last_name')}}"  name="last_name" placeholder="Enter your last name"/>
    <span style="color: darkred" class="last-name-error"></span>
</div>

<div class="form-group mb-4">
    <label class="form-label fw-bold" for="address">Address</label>
    <input type="text" id="address" class="form-control"  value="{{old('address')}}"  name="address" placeholder="Enter your address"/>
    <span style="color: darkred" class="address-error"></span>
</div>

<div class="form-group mb-4">
    <label class="form-label fw-bold" for="state">State</label>
    <input type="text" id="state" class="form-control"  value="{{old('state')}}"  name="state" placeholder="Enter your state"/>
    <span style="color: darkred" class="state-error"></span>
</div>

<div class="form-group mb-4">
    <label class="form-label fw-bold" for="country">Country</label>
    <input type="text" id="country" class="form-control"  value="{{old('country')}}"  name="country" placeholder="Enter your country"/>
    <span style="color: darkred" class="country-error"></span>
</div>

<div class="form-group mb-4">
    <label class="form-label fw-bold" for="delivery">Delivery</label>
    <textarea id="delivery" class="form-control"  name="delivery" placeholder="Enter delivery">{{old('delivery')}}</textarea>
    <span style="color: darkred" class="delivery-error"></span>
</div>

<div>
    <button class="btn btn-success w-100 checkoutAction">Checkout</button>
</div>
