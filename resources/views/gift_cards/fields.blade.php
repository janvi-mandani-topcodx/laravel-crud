@csrf
<div class="container">
    <div class="row">
        <div class="col">
            <section class="gradient-custom my-2 ">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <div  class="form-group">
                            <div>
                                <label class="form-check-label" for="specificCustomer">
                                    Customer
                                </label>
                            </div>
                            <input type="text" id="searchCustomer" class="form-control w-50" name="customer_name" placeholder="search customer"/>
                            <span style="color: darkred"></span>
                            <input type="hidden" class="hidden-user-id" name="customer_id">
                        </div>
                        <div id="userSearchData" class="w-50"></div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <section class="gradient-custom my-2">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <div  class="form-group">
                            <label class="form-label fw-bold " for="code">Code</label>
                            <input type="text" id="code" class="form-control"  value="{{old('code')}}"  name="code" placeholder="Enter your code"/>
                            <span style="color: darkred" class="gift-card-code-error"></span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-6">
            <section class="gradient-custom my-2">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <div  class="form-group">
                            <label class="form-label fw-bold " for="balance">Balance</label>
                            <input type="text" id="balance" class="form-control"  value="{{old('balance')}}"  name="balance" placeholder="Enter your balance"/>
                            <span style="color: darkred" class="gift-card-balance-error"></span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row position-relative">
        <div class="col-6">
            <section class="gradient-custom my-2">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <div  class="form-group ps-3">
                            <label class="form-label fw-bold " for="expiry">Expiry</label>
                            <input type="date" id="expiry" class="form-control"  value="{{old('expiry')}}"  name="expiry"/>
                            <span style="color: darkred"></span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-6">
            <section class="gradient-custom my-2">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <div  class="form-group">
                            <label class="form-label fw-bold " for="notes">Notes</label>
                            <input type="text" id="notes" class="form-control"  value="{{old('notes')}}"  name="notes" placeholder="Enter your notes"/>
                            <span style="color: darkred"></span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row ps-2 position-relative">
        <label class="form-label fw-bold" for="custom-file">Status</label>
        <div class="form-check form-switch ">
            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" style="width: 50px; height: 28px;">
        </div>
    </div>
    <div class="row my-3 position-relative">
        <button type="button" class="btn btn-success w-50 mx-auto" id="createGiftCard">Create</button>
    </div>
</div>
