
@extends('layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-12 text-center">
                                <h2 class="">User Data</h2>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-sm-4 col-xs-12 ">
                                <div class="search-box">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search...">
                                </div>
                            </div>
                            <div class="col-xs-8 text-right w-66">
                                <a href="/" class="btn btn-sm btn-primary" id="createUser"> Create New</a>
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
                            @include('searchdata')
{{--                            @foreach($users as $user)--}}
{{--                                <tr id="oneuser" data-id="{{$user->id}}">--}}
{{--                                    <td>{{$user->id}}</td>--}}
{{--                                    <td>{{$user->first_name}}</td>--}}
{{--                                    <td>{{$user->last_name}}</td>--}}
{{--                                    <td>{{$user->email}}</td>--}}
{{--                                    <td>{{ implode(',', json_decode($user->hobbies)) }}</td>--}}
{{--                                    <td>{{$user->gender}}</td>--}}
{{--                                    <td>--}}
{{--                                        <img class="img-fluid img-thumbnail" src="{{ asset('storage/' . $user->image) }}" alt="Uploaded Image" width="200">--}}
{{--                                    </td>--}}
{{--                                    <td style="" class="editDelete">--}}
{{--                                        <form action="" method="POST">--}}
{{--                                            @csrf--}}
{{--                                            @method('DELETE')--}}
{{--                                            <button type="button" id="deleteUsers" class="btn btn-danger btn-sm my-3" data-id="{{$user->id}}">DELETE</button>--}}
{{--                                        </form>--}}
{{--                                           <a href="{{route('users.edit', $user->id)}}" class="btn btn-warning editbtn d-flex justify-content-center align-items-center">Edit</a>--}}
{{--                                        <a href="{{route('users.edit', $user->id)}}" class="btn btn-warning editbtn d-flex justify-content-center align-items-center" data-id="{{$user->id}}">Edit</a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
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
            $('#search').on('keyup', function () {
                let query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: "{{route('users.search')}}",
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            search: query
                        },
                        success: function(response) {
                            $('#userDataContainer tbody').html(response.html);
                        },
                    });
                } else {
                    $('tbody').html('');
                }
            });
            // $(document).on('submit', '#editbtn', function () {
            //     e.preventDefault();
            //     let $row = $(this).closest('#oneuser');
            //     let userId = $row.data('id');
            //     let formData = $(this).serialize();
            //     console.log(userId);
            //
            //         $.ajax({
            //             url: `/users/${userId}/edit`,
            //             method: "POST",
            //             data: {
            //                 formData,
            //                 _token: $('meta[name="csrf-token"]').attr('content'),
            //             },
            //             success: function (data) {
            //                 window.location.href = `/users/${userId}/edit`;
            //             }
            //         });
            // });

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
