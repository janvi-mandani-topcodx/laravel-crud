
@extends('layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-12 text-center">
                                <h2 class="">Post Data</h2>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-sm-4 col-xs-12 ">
                                <div class="search-box">
                                    <input type="text" class="form-control" id="searchPost" name="searchpost" placeholder="Search...">
                                </div>
                            </div>
                            <div class="col-xs-8 text-right w-66">
                                <a href="/create/posts" class="btn btn-sm btn-primary" id="createUser"> Create New</a>
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
                            @include('posts.search-post')
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('keyup', '#searchPost' , function () {
                let query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: "{{route('posts.search')}}",
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            searchpost: query
                        },
                        success: function(response) {
                            $('#postDataContainer tbody').html(response.html);
                        },
                    });
                } else {
                    $('tbody').html('');
                }
            });
            // $(document).on('submit', '.editpost', function () {
            //     e.preventDefault();
            //     let $row = $(this).closest('#onepost');
            //     let postId = $row.data('id');
            //     let form = $(this).closest('form')[0];
            //     let formData = new FormData(form);
            //     console.log(postId);
            //
            //         $.ajax({
            //             url: `/users/${postId}/edit`,
            //             method: "POST",
            //             contentType: false,
            //             processData: false,
            //             data: {
            //                 formData,
            //                 _token: $('meta[name="csrf-token"]').attr('content'),
            //             },
            //             success: function (data) {
            //                 window.location.href = `/posts/${postId}/edit`;
            //             }
            //         });
            // });
            $(document).on('click', '#deletePost', function () {

                console.log('asdasdad');
                let $row = $(this).closest('#onepost');
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
