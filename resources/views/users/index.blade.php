@extends('layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-12 text-center">
                                <h2 class="">Users</h2>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-sm-4 col-xs-12 ">
                                <div class="search-box">
                                    <input type="text" class="form-control" id="search" name="search"
                                           placeholder="Search...">
                                </div>
                            </div>
                            <div class="col-xs-8 text-right w-66">
                                <a href="/users/create" class="btn btn-sm btn-primary" id="createUser">Create New</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="userDataContainer">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Email</th>
                                <th>Hobbies</th>
                                <th>Gender</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @include('users.search')
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
            $('#search').on('keyup', function () {
                let query = $(this).val();
                    $.ajax({
                        url: "{{route('users.search')}}",
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            search: query
                        },
                        success: function (response) {
                            $('#userDataContainer tbody').html(response.html);
                        },
                        error: function (response){
                            $('#userDataContainer tbody').html(response.html);
                        }
                    });
            });
            $(document).on('submit', '#editbtn', function () {
                e.preventDefault();
                let $row = $(this).closest('#oneuser');
                let userId = $row.data('id');
                let formData = $(this).serialize();
                console.log(userId);

                $.ajax({
                    url: `/users/${userId}/edit`,
                    method: "POST",
                    data: {
                        formData,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        window.location.href = `/users/${userId}/edit`;
                    }
                });
            });

            $(document).on('click', '#deleteUsers', function () {

                console.log('asdasdad');
                let $row = $(this).closest('#oneuser');
                let userId = $row.data('id');
                console.log(userId)
                $.ajax({
                    url: `/users/${userId}`,
                    type: "DELETE",
                    data: {
                        delete_id: userId,
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
