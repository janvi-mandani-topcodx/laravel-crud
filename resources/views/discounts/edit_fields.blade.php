@csrf
@method('put')
<div class="container">
    <div class="row">
        <div class="col-6">
            <section class="gradient-custom my-2 ">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px; height: 200px;">
                    <div class="card-body p-4 p-md-5">
                        <div  class="form-group">
                            <label class="form-label fw-bold " for="code">Discount Code</label>
                            <input type="text" id="code" class="form-control"  value="{{$discount->code}}"  name="code" placeholder="Enter your code"/>
                            <span style="color: darkred"></span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-6">
            <section class="gradient-custom my-2">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px; height: 200px;">
                    <div class="card-body p-4 p-md-5">
                        <label class="form-label fw-bold">Types</label>
                        <div  class="form-group ps-3">
                            <div>
                                <input class="form-check-input" type="radio" name="type" value="percentage" id="percentage" {{$discount->type== 'percentage' ? 'checked' : ''}}>
                                <label class="form-check-label" for="percentage">
                                    Percentage
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" name="type" value="fixed" id="fixed" {{$discount->type== 'fixed' ? 'checked' : ''}}>
                                <label class="form-check-label" for="fixed">
                                    Fixed Amount
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row position-relative">
        <div class="col-6">
            <section class="gradient-custom my-2">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px; height: 275px;">
                    <div class="card-body p-4 p-md-5">
                        <div  class="form-group">
                            <label class="form-label fw-bold " for="value">Value</label>
                            <input type="text" id="value" class="form-control"  value="{{$discount->amount}}"  name="value" placeholder="Enter your value"/>
                            <span style="color: darkred"></span>
                        </div>
                        <label>APPLIES TO</label>
                        <div class="ps-3">
                            <div>
                                <input class="form-check-input" type="radio" name="product" value="all products" id="allProducts" {{$discount->product== 'all products' ? 'checked' : ''}}>
                                <label class="form-check-label" for="allProducts">
                                    All Products
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" name="product" value="specific product" id="specificProduct" {{$discount->product== 'specific product' ? 'checked' : ''}}>
                                <label class="form-check-label" for="specificProduct">
                                    Specific Product
                                </label>
                            </div>
                            <input type="text" id="searchProduct" class="form-control" name="" placeholder="search product"/>
                            <input type="hidden" class="hidden-product-id" name="product_id"/>

                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-6">
            <section class="gradient-custom my-2">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px; height: 275px;">
                    <div class="card-body p-4 p-md-5">
                        <label class="form-label fw-bold">Minimum Requirements</label>
                        <div  class="form-group">
                            <div>
                                <input class="form-check-input" type="radio" name="requirement" value="none" id="none" {{$discount->minimum_requirements== 'none' ? 'checked' : ''}}>
                                <label class="form-check-label" for="none">
                                    None
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" name="requirement" value="purchase amount" id="purchaseAmount" {{$discount->minimum_requirements== 'purchase amount' ? 'checked' : ''}}>
                                <label class="form-check-label" for="purchaseAmount">
                                    Minimum Purchase Amount ($)
                                </label>
                            </div>
                            <input type="text" id="minimumPurchase" class="form-control {{$discount->minimum_requirements== 'purchase amount' ? 'd-block' : ''}}" value="{{$discount->minimum_amount}}" name="minimum_purchase" placeholder="Enter minimum purchase amount"/>
                            <div>
                                <input class="form-check-input" type="radio" name="requirement" value="quantity amount" id="quantityAmount" {{$discount->minimum_requirements== 'quantity amount' ? 'checked' : ''}}>
                                <label class="form-check-label" for="quantityAmount">
                                    Minimum Quantity Of Items
                                </label>
                            </div>
                            <input type="text" id="minimumQuantity" class="form-control {{$discount->minimum_requirements== 'quantity amount' ? 'd-block' : ''}}"   value="{{$discount->minimum_amount}}" name="minimum_quantity" placeholder="Enter minimum quantity amount"/>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row position-relative">
        <div class="col-6">
            <section class="gradient-custom my-2">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px; height: 275px;">
                    <div class="card-body p-4 p-md-5">
                        <label class="form-label fw-bold " for="value">Customer Eligibility</label>
                        <div  class="form-group ps-3">
                            <div>
                                <input class="form-check-input" type="radio" name="customer" value="everyone" id="everyone" {{$discount->customer== 'everyone' ? 'checked' : ''}}>
                                <label class="form-check-label" for="everyone">
                                    Everyone
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" name="customer" value="specific customer" id="specificCustomer" {{$discount->customer== 'specific customer' ? 'checked' : ''}}>
                                <label class="form-check-label" for="specificCustomer">
                                    Specific Customer
                                </label>
                            </div>
                            <input type="text" id="searchCustomer" class="form-control  {{$discount->customer== 'specific customer' ? 'd-block' : ''}}" name="" placeholder="search customer" value="{{$discount->user_id}}"/>
                            <input type="hidden" class="hidden-user-id" name="customer_id"/>

                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-6">
            <section class="gradient-custom my-2">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px; height: 275px;">
                    <div class="card-body p-4 p-md-5">
                        <label class="form-label fw-bold">Usage Limit</label>
                        <div  class="form-group">
                            <div>
                                <input class="form-check-input" type="checkbox" name="limit_number" value="how many times use discount" id="limitNumber" {{$discount->discount_apply_type== 'how many times use discount' ? 'checked' : ''}}>
                                <label class="form-check-label" for="limitNumber">
                                    Limit Number of times this discount can be used in total
                                </label>
                            </div>
                            <input type="text" id="limitDiscount" class="form-control {{$discount->discount_apply_type== 'how many times use discount' ? 'd-block' : ''}}" name="limit_discount" placeholder="Enter number of times use discounts "   value="{{$discount->discount_type_number}}"/>
                            <div>
                                <input class="form-check-input" type="checkbox" name="one_use" value="limit one use" id="perCustomer"  {{$discount->discount_apply_type== 'limit one use' ? 'checked' : ''}} />
                                <label class="form-check-label" for="perCustomer">
                                    Limit to one use per customer
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" type="checkbox" name="new_only" value="new customer only" id="newCustomer" {{$discount->discount_apply_type== 'new customer only' ? 'checked' : ''}}>
                                <label class="form-check-label" for="newCustomer">
                                    New customers only
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row position-relative">
        <div class="col">
            <section class="gradient-custom my-2">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <label class="form-label fw-bold " for="value">Active Dates</label>
                        <div  class="row form-group">
                            <div class="col-6">
                                <label class="form-label" for="code">Start Date</label>
                                <input type="date" id="startDate" class="form-control"  value="{{isset($discount->start_date) ? $discount->start_date : ''}}"  name="start_date"/>
                                <span style="color: darkred"></span>
                            </div>
                            <div class="col-6 end-date">
                                <label class="form-label" for="code">End Date</label>
                                <input type="date" id="endDate" class="form-control"  value="{{isset($discount->end_date) && $discount->end_date != null ? $discount->end_date : ''}}"  name="end_date"/>
                                <span style="color: darkred"></span>
                            </div>
                        </div>
                        <div class="ps-3">
                            <input class="form-check-input" type="checkbox" name="end_date" value="end date" id="endDate" {{isset($discount->end_date) && $discount->end_date != null ? 'checked' : ''}}>
                            <label class="form-check-label" for="endDate">
                                Set end date
                            </label>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div id="productSearch" class="position-absolute" style=" bottom: -304px; left: 168px; width: 408px;">

    </div>

    <div id="userSearchData" class="position-absolute" style=" top: -118px; left: 78px; width: 433px;">

    </div>
    <div class="row ps-2">
        <label class="form-label fw-bold" for="custom-file">Status</label>
        <div class="form-check form-switch ">
            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" style="width: 50px; height: 28px;" {{$discount->status== 1 ? 'checked' : ''}}>
        </div>
    </div>
    <div class="row my-3">
        <button type="button" class="btn btn-success w-50 mx-auto" id="updateDiscount">Update</button>
    </div>
</div>
