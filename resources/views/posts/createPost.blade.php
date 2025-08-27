@extends('layout')

@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Create Post</h3>
                            <form method="POST" enctype="multipart/form-data" action="{{route('posts.store')}}">
                                @csrf
                                <div class="row mb-4 ">
                                    <div class="col">
                                        <div  class="form-outline">
                                            <label class="form-label fw-bold " for="title">Title</label>
                                            <input type="text" id="title" class="form-control"  value="{{old('title')}}"  name="title" placeholder="Enter First name"/>
                                            <span style="color: darkred">@error('title') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <div  class="form-outline">
                                            <label class="form-label fw-bold" for="description">Description</label>
                                            <input type="text" id="description" class="form-control" value="{{old('description')}}" name="description" placeholder="Enter Last name"/>
                                            <span style="color: darkred">@error('description') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <div  class="form-outline">
                                            <label class="form-label fw-bold" for="status">Status</label>
                                            <input type="text" id="status" class="form-control" value="{{old('status')}}" name="status" placeholder="Enter Last name"/>
                                            <span style="color: darkred">@error('status') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label fw-bold" for="customFiles">Image</label>
                                    <input type="file" class="form-control" id="customFiles" name="imagePost"/>
                                    <span style="color: darkred">@error('image') {{ $message }} @enderror</span>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mb-4 submitbtn">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
