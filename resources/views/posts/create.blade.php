@extends('layout')

@section('content')

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Create Post</h3>
                            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4 ">
                                    <div class="col">
                                        <div  class="form-group">
                                            <label class="form-label fw-bold " for="title">Title</label>
                                            <input type="text" id="title" class="form-control"  value="{{old('title')}}"  name="title" placeholder="Enter title"/>
                                            <span style="color: darkred">@error('title') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <div  class="form-group">
                                            <label class="form-label fw-bold" for="description">Description</label>
                                            <input type="text" id="description" class="form-control" value="{{old('description')}}" name="description" placeholder="Enter description"/>
                                            <span style="color: darkred">@error('description') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">

                                        <div  class="form-group">
                                            <label class="form-label fw-bold w-100" for="status">Status</label>
                                            <select name="status" id="status" class="px-2 form-control">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            <span style="color: darkred">@error('status') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold" for="customFiles">Image</label>
                                    <input type="file" class="form-control" id="customFiles" name="image"/>
                                    <span style="color: darkred">@error('image') {{ $message }} @enderror</span>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mb-4 submit-post">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click', '.submit-post', function (e) {
                e.preventDefault()
                let form = $(this).closest('form')[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/posts",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.location.href = '{{ route('posts.index') }}';
                    },
                    error: function (response) {
                        console.log(response.responseJSON);
                        let errors = response.responseJSON.errors;
                        if (errors.title) {
                            $('#title').siblings('span').text(errors.title[0]);
                        }
                        if (errors.description) {
                            $('#description').siblings('span').text(errors.description[0]);
                        }
                        if (errors.status) {
                            $('#status').siblings('span').text(errors.status[0]);
                        }
                    }
                });
            });
        });
    </script>
@endsection
