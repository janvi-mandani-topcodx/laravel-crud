@csrf
<div class="container">
    <div class="row">
        <div class="col-6">
            <section class="gradient-custom my-2 ">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px; height: 200px;">
                    <div class="card-body p-4 p-md-5">
                        <div  class="form-group">
                            <label class="form-label fw-bold " for="code">Discount Code</label>
                            <input type="text" id="code" class="form-control"  value="{{old('code')}}"  name="code" placeholder="Enter your code"/>
                            <span style="color: darkred">@error('code') {{$message}} @enderror</span>
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
                                <input class="form-check-input" type="radio" name="type" value="percentage" id="percentage">
                                <label class="form-check-label" for="percentage">
                                    Percentage
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" name="type" value="fixed" id="fixed">
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
    <div class="row">
        <div class="col-6">
            <section class="gradient-custom my-2">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px; height: 320px;">
                    <div class="card-body p-4 p-md-5">
                        <div  class="form-group">
                            <label class="form-label fw-bold " for="value">Value</label>
                            <input type="text" id="value" class="form-control"  value="{{old('value')}}"  name="value" placeholder="Enter your value" />
                            <span style="color: darkred">@error('value') {{$message}} @enderror</span>
                        </div>
                        <label>APPLIES TO</label>
                        <div class="ps-3">
                            <div>
                                <input class="form-check-input" type="radio" name="product" value="all_products" id="allProducts">
                                <label class="form-check-label" for="allProducts">
                                    All Products
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" name="product" value="specific_product" id="specificProduct">
                                <label class="form-check-label" for="specificProduct">
                                    Specific Product
                                </label>
                            </div>
                            <input type="text" id="searchProduct" class="form-control" name="product_name" placeholder="search product" />
                            <span style="color: darkred" id="product_name_error">@error('product_name') {{$message}} @enderror</span>
                            <input type="hidden" class="hidden-product-id" name="product_id"/>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-6">
            <section class="gradient-custom my-2">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px; height: 320px;">
                    <div class="card-body p-4 p-md-5">
                        <label class="form-label fw-bold">Minimum Requirements</label>
                        <div  class="form-group">
                            <div>
                                <input class="form-check-input" type="radio" name="requirement" value="none" id="none">
                                <label class="form-check-label" for="none">
                                    None
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" name="requirement" value="purchase_amount" id="purchaseAmount" >
                                <label class="form-check-label" for="purchaseAmount">
                                    Minimum Purchase Amount ($)
                                </label>
                            </div>
                            <input type="text" id="minimumPurchase" class="form-control" name="minimum_purchase" placeholder="Enter minimum purchase amount" />
                            <span style="color: darkred">@error('minimum_purchase') {{$message}} @enderror</span>
                            <div>
                                <input class="form-check-input" type="radio" name="requirement" value="quantity_amount" id="quantityAmount">
                                <label class="form-check-label" for="quantityAmount">
                                    Minimum Quantity Of Items
                                </label>
                            </div>
                            <input type="text" id="minimumQuantity" class="form-control" name="minimum_quantity" placeholder="Enter minimum quantity amount"/>
                            <span style="color: darkred">@error('minimum_quantity') {{$message}} @enderror</span>
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
                                <input class="form-check-input" type="radio" name="customer" value="everyone" id="everyone">
                                <label class="form-check-label" for="everyone">
                                    Everyone
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" name="customer" value="specific_customer" id="specificCustomer">
                                <label class="form-check-label" for="specificCustomer">
                                    Specific Customer
                                </label>
                            </div>
                            <input type="text" id="searchCustomer" class="form-control" name="customer_name" placeholder="search customer"/>
                            <span style="color: darkred">@error('customer_name') {{$message}} @enderror</span>
                            <input type="hidden" class="hidden-user-id" name="customer_id">
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
                                <input class="form-check-input" type="checkbox" name="how_many_times" value="how_many_times_use_discount" id="limitNumber">
                                <label class="form-check-label" for="limitNumber">
                                    Limit Number of times this discount can be used in total
                                </label>
                            </div>
                            <input type="text" id="limitDiscount" class="form-control" name="limit_number_discount" placeholder="Enter number of times use discounts "/>
                            <span style="color: darkred">@error('limit_number_discount') {{$message}} @enderror</span>
                            <div>
                                <input class="form-check-input" type="checkbox" name="limit_one_use" value="limit_one_use" id="perCustomer">
                                <label class="form-check-label" for="perCustomer">
                                    Limit to one use per customer
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" type="checkbox" name="limit_new_customer" value="new_customer_only" id="newCustomer">
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
                                <input type="date" id="startDate" class="form-control"  value="{{old('startDate')}}"  name="start_date"/>
                                <span style="color: darkred">@error('start_date') {{$message}} @enderror</span>
                            </div>
                            <div class="col-6 end-date">
                                <label class="form-label" for="code">End Date</label>
                                <input type="date" id="endDate" class="form-control"  value="{{old('endDate')}}"  name="end_date"/>
                                <span style="color: darkred">@error('end_date') {{$message}} @enderror</span>
                            </div>
                        </div>
                        <div class="ps-3">
                            <input class="form-check-input" type="checkbox" name="end_date_checkbox" value="end_date" id="endDateCheckBox">
                            <label class="form-check-label" for="endDateCheckBox">
                                Set end date
                            </label>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div id="productSearch" class="position-absolute" style=" bottom: 34px; left: 78px; width: 433px;">

        </div>
        <div id="userSearchData" class="position-absolute" style=" top: -118px; left: 78px; width: 433px;">

        </div>
    </div>
    <div class="row ps-2 position-relative">
        <label class="form-label fw-bold" for="custom-file">Status</label>
        <div class="form-check form-switch ">
            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" style="width: 50px; height: 28px;">
        </div>
    </div>
    <div class="row my-3 position-relative">
        <button type="submit" class="btn btn-success w-50 mx-auto" id="createDiscount">Create</button>
    </div>
</div>
