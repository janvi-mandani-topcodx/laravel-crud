@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout')
@section('content')
    <div class="container">
        @if(session('error'))
            <div class="alert alert-danger my-2">
                {{session('error')}}
            </div>
        @endif
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
                            <div class="col-sm-4 col-xs-12 p-0">
                                <div class="search-box">
                                    <input type="text" class="form-control" id="search-post" name="searchPost"
                                           placeholder="Search...">
                                </div>
                            </div>
                            @if ($role->hasPermissionTo('create post'))
                                <div class="col-xs-8 text-right w-66 p-0">
                                    <a href="/posts/create" class="btn btn-sm btn-primary" id="create-post">Create New</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="post-data-container">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>User Name</th>
                                <th>title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($posts as $post)
                                <tr id="one-post" data-id="{{$post->id}}">
                                    <td>{{$post->id}}</td>
                                    <td>{{$post->fullName}}</td>
                                    <td>{{$post->title}}</td>
                                    <td>{{$post->description}}</td>
                                    <td>{{$post->status}}</td>
                                    <td>
                                            <img class="img-fluid img-thumbnail" src="{{$post->imageUrl}}" alt="Uploaded Image" width="200" height="100" style="height: 126px;">
                                    </td>
                                    <td style="height: 176px;" class="edit-delete d-flex justify-content-center align-items-center gap-2" >
                                        @if ($role->hasPermissionTo('delete post'))
                                            <button type="button" id="delete-post" class="btn btn-danger btn-sm my-3" data-id="{{$post->id}}">DELETE</button>
                                        @endif
                                        @if($role->hasPermissionTo('edit post'))
                                            <a href="{{route('posts.edit', $post->id)}}" class="btn btn-warning edit-post d-flex justify-content-center align-items-center col-6" data-id="{{$post->id}}">Edit</a>
                                        @endif
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
            $(document).on('keyup', '#search-post', function () {
                let query = $(this).val();
                $.ajax({
                    url: "{{ route('posts.index') }}",
                    method: "GET",
                    data: {
                        search: query
                    },
                    success: function (response) {
                        $('#post-data-container tbody').html(response.html);
                    },
                    error: function (response){
                        $('#post-data-container tbody').html(response.html);
                    }
                });
            });
            $(document).on('submit', '.edit-post', function () {
                e.preventDefault();
                let $row = $(this).closest('#one-post');
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
            $(document).on('click', '#delete-post', function () {

                let $row = $(this).closest('#one-post');
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
