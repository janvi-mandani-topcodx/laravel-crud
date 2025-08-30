@extends('layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-12 text-center">
                                <h2 class="">Posts</h2>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-sm-4 col-xs-12 ">
                                <div class="search-box">
                                    <input type="text" class="form-control" id="searchPost" name="searchPost"
                                           placeholder="Search...">
                                </div>
                            </div>
                            <div class="col-xs-8 text-right w-66">
                                <a href="/posts/create" class="btn btn-sm btn-primary" id="createUser">Create New</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="postDataContainer">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>User id</th>
                                <th>title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr id="onePost" data-id="{{$post->id}}">
                                    <td>{{$post->id}}</td>
                                    <td>{{$post->user_id}}</td>
                                    <td>{{$post->title}}</td>
                                    <td>{{$post->description}}</td>
                                    <td>{{$post->status}}</td>
                                    <td>
                                        <img class="img-fluid img-thumbnail" src="{{$post->postImageUrl}}" alt="Uploaded Image" width="200" height="100" style="height: 126px;">
                                    </td>
                                    <td style="height: 176px;" class="editDelete d-flex justify-content-center align-items-center" >
                                        <form action="{{route('posts.destroy', $post->id)}}" method="POST" class="col-6">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" id="deletePost" class="btn btn-danger btn-sm my-3" data-id="{{$post->id}}">DELETE</button>
                                        </form>
                                        <a href="{{route('posts.edit', $post->id)}}" class="btn btn-warning editpost d-flex justify-content-center align-items-center col-6" data-id="{{$post->id}}">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('keyup', '#searchPost', function () {
                let query = $(this).val();
                $.ajax({
                    url: "{{ route('posts.index') }}",
                    method: "GET",
                    data: {
                        search: query
                    },
                    success: function (response) {
                        $('#postDataContainer tbody').html(response.html);
                    },
                    error: function (response){
                        $('#postDataContainer tbody').html(response.html);
                    }
                });
            });
            $(document).on('submit', '.editpost', function () {
                e.preventDefault();
                let $row = $(this).closest('#onePost');
                let postId = $row.data('id');
                let form = $(this).closest('form')[0];
                let formData = new FormData(form);
                console.log(postId);

                $.ajax({
                    url: `/users/${postId}/edit`,
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: {
                        formData,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        window.location.href = `/posts/${postId}/edit`;
                    }
                });
            });
            $(document).on('click', '#deletePost', function () {

                console.log('asdasdad');
                let $row = $(this).closest('#onePost');
                let postId = $row.data('id');
                console.log(postId)
                $.ajax({
                    url: `/posts/${postId}`,
                    type: "DELETE",
                    data: {
                        delete_id: postId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);
                        $row.remove();
                    }
                });
            });
        });
    </script>
@endsection
