@extends('layout')
@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="d-flex justify-content-end">
                        <div class="py-2">
                            <a href="{{route('gift-card.index')}}" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Gift Card</h3>
                            <div class="row my-2">
                                <div class="col">
                                    <label class="text-muted fw-bold">Code</label>
                                    <p>{{$giftCard->code}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Balance</label>
                                    <p>{{$giftCard->balance}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Notes</label>
                                    <p>{{$giftCard->notes}}</p>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <label class="text-muted fw-bold">User</label>
                                    <p>{{$giftCard->user->full_name}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Expiry At</label>
                                    <p>{{$giftCard->expiry_at}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Enabled</label>
                                    <p>{{$giftCard->Enabled == 1 ? 'Active'  : 'InActive'}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
