@csrf
@method('PUT')
<div class="container">
    <section class="gradient-custom my-2">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
            <div class="card-body p-4 p-md-5">
                <div class="row my-2">
                    <div class="col-6">
                        <div  class="form-group">
                            <label class="form-label fw-bold " for="code">Discount Code</label>
                            <input type="text" id="code" class="form-control"  value="{{$giftCard->code}}"  name="code" placeholder="Enter your code" readonly/>
                            <span style="color: darkred"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div  class="form-group">
                            <label class="form-label fw-bold " for="balance">Initial Balance</label>
                            <input type="text" id="initialBalance" class="form-control"  value="{{$giftCard->balance}}"  name="initial_balance" placeholder="Enter your balance" readonly/>
                            <span style="color: darkred"></span>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-6">
                        <div  class="form-group">
                            <label class="form-label fw-bold " for="balance">Balance</label>
                            <input type="text" id="balance" class="form-control"  value="{{$giftCard->balance}}"  name="balance" placeholder="Enter your balance"/>
                            <span style="color: darkred" class="gift-card-balance-error"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div  class="form-group">
                            <label class="form-label fw-bold " for="notes">Notes</label>
                            <input type="text" id="notes" class="form-control"  value="{{$giftCard->notes}}"  name="notes" placeholder="Enter your notes"/>
                            <span style="color: darkred"></span>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-6">
                        <div  class="form-group">
                            <label class="form-label fw-bold " for="expiry">Expiry</label>
                            <input type="date" id="expiry" class="form-control"  value="{{$giftCard->expiry_at}}"  name="expiry"/>
                            <span style="color: darkred"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold" for="custom-file">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" style="width: 50px; height: 28px;" {{$giftCard->enabled == 1 ? 'checked' : ''}}>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row my-3 position-relative">
        <button type="button" class="btn btn-success w-50 mx-auto" id="updateGiftCard">Update</button>
    </div>
</div>
