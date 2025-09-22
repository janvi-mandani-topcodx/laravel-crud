@extends('layout')
@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="d-flex justify-content-end">
                        <div class="py-2">
                            <a href="{{route('user-demo.index')}}" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">User Details</h3>
                            <div class="row">
                                <div class="col">
                                    <label class="text-muted fw-bold">First Name</label>
                                    <p>{{$userData->first_name}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Last Name</label>
                                    <p>{{$userData->last_name}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Email</label>
                                    <p>{{$userData->email}}</p>
                                </div>
                            </div>
                            <div class="row py-4">
                                <div class="col">
                                    <label class="text-muted fw-bold">Hobbies</label>
                                    <p>{{implode(',', json_decode($userData->hobbies))}}</p>
                                </div>
                                <div class="col">
                                    <label class="text-muted fw-bold">Status</label>
                                    <p>{{$userData->status==1 ? 'Active' : 'Inactive'}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label class="text-muted fw-bold">Image</label>
                                    <div class="d-flex">
                                        @if ($userData->image_url)
                                            @foreach($userData->image_url as $image)
                                                <img src="{{$image}}" alt="User Image" class="img-thumbnail mt-2 mx-2" style="max-width: 100px;">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
