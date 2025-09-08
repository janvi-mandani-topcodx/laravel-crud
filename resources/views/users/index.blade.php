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
                                <h2 class="">Users</h2>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between my-3">
                            <div class="">
                                <div class="search-box">
                                    <input type="text" class="form-control" id="search" name="search"
                                           placeholder="Search...">
                                </div>
                            </div>
                            @php
                                $user = Auth::user();
                                $role = $user->roles->first();
                            @endphp
                            @if ($role->permissions->where('name', 'create user')->isNotEmpty())
                                <div class="col-xs-8 text-right w-66 p-0">
                                    <a href="/users/create" class="btn btn-sm btn-primary" id="create-user">Create New</a>
                                </div>
                            @endif
                            <div class="">
                                    <div class="col-xs-8 text-right w-66 p-0">
                                        <button type="button" class="btn btn-sm btn-primary" id="exports" name="exports">Exports</button>
                                    </div>
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
                                <th>Role</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr id="one-user" data-id="{{$user->id}}">
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->first_name}}</td>
                                    <td>{{$user->last_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{ implode(',', json_decode($user->hobbies)) }}</td>
                                    <td>{{$user->gender}}</td>
                                    <td>{{$user->roles->pluck('name')->first()}}</td>
                                    <td>
                                        <img class="img-fluid img-thumbnail" src="{{ $user->imageUrl }}" alt="Uploaded Image" width="200" style="height: 126px;">
                                    </td>
                                    <td style="" class="edit-delete">
                                        @if ($role->permissions->where('name', 'delete user')->isNotEmpty())
                                            <button type="button" id="delete-users" class="btn btn-danger btn-sm my-3" data-id="{{$user->id}}">DELETE</button>
                                        @endif
                                        @if ($role->permissions->where('name', 'update user')->isNotEmpty())
                                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-warning edit-btn d-flex justify-content-center align-items-center" data-id="{{$user->id}}">Edit</a>
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
            $(document).on('keyup', '#search' ,  function () {
                let query = $(this).val();
                    $.ajax({
                        url: "{{route('users.index')}}",
                        method: "GET",
                        data: {
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
            $(document).on('submit', '#edit-btn', function () {
                e.preventDefault();
                let $row = $(this).closest('#one-user');
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

            $(document).on('click', '#delete-users',function () {
                let $row = $(this).closest('#one-user');
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
            $(document).on('click', '#exports', function () {
                let exports = $(this);
                $.ajax({
                    url: "/usersData",
                    method: "POST",
                    data: exports ,
                    success: function (response) {
                    }
                });
            });
        });
    </script>
@endsection
