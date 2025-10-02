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
{{--                            @if ($role->hasPermissionTo('create user'))--}}
                                <div class="col-xs-8 text-right w-66 p-0">
                                    <a href="/users/create" class="btn btn-sm btn-primary" id="create-user">Create New</a>
                                </div>
{{--                            @endif--}}
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
{{--                            @foreach($users as $user)--}}
{{--                                <tr id="one-user" data-id="{{$user->id}}">--}}
{{--                                    <td>{{$user->id}}</td>--}}
{{--                                    <td>{{$user->first_name}}</td>--}}
{{--                                    <td>{{$user->last_name}}</td>--}}
{{--                                    <td>{{$user->email}}</td>--}}
{{--                                    <td>{{ implode(',', json_decode($user->hobbies)) }}</td>--}}
{{--                                    <td>{{$user->gender}}</td>--}}
{{--                                    <td>{{$user->roles->pluck('name')->first()}}</td>--}}
{{--                                    <td>--}}
{{--                                        <img class="img-fluid img-thumbnail" src="{{ $user->imageUrl }}" alt="Uploaded Image" width="200" style="height: 126px;">--}}
{{--                                    </td>--}}
{{--                                    <td style="" class="edit-delete">--}}
{{--                                        @if ($role->hasPermissionTo('delete user'))--}}
{{--                                            <button type="button" id="delete-users" class="btn btn-danger btn-sm my-3" data-id="{{$user->id}}">DELETE</button>--}}
{{--                                        @endif--}}
{{--                                        @if ($role->hasPermissionTo('edit user'))--}}
{{--                                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-warning edit-btn d-flex justify-content-center align-items-center" data-id="{{$user->id}}">Edit</a>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
                            </tbody>
                        </table>
                        <div id="outputContainer">

                        </div>
                        <div>
                            <button class="btn btn-danger sweet-alert-button">SweetAlert</button>
                        </div>
                        <div id="summernote"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @include('users.templates');

    <script>
        $(document).ready(function () {
            //
            // var userData  = {
            //     name:"aaaa",
            //     email:"aaa@gmail.com"
            // };
            // console.log($('#editDeleteScript'));
            //
            // var templete = $.templates("#editDeleteScript");
            // var htmlOutput = templete.render(userData);
            // console.log(htmlOutput)
            // $("#outputContainer").html(htmlOutput);

            $('#summernote').summernote({
                placeholder: 'Hello',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
                }
            )
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const usersIndexUrl = "{{ route('users.index') }}";
            let table = new DataTable('#userDataContainer', {
                deferRender: true,
                scroller: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: usersIndexUrl,
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('id', 'one-user');
                    $(row).attr('data-id' , data.id)
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'email', name: 'email' },
                    {
                        data: function(row) {
                            return  row.hobbies;

                        },
                        name: 'hobbies'
                    },
                    { data: 'gender', name: 'gender'},
                    {
                        data: function(row) {
                            return row.roles[0].name;

                        },
                        name: 'roles'
                    },
                    {
                        data: function(row) {
                            return `<img src="${row.image}" alt="user image" width="80" height="80" class="img-thumbnail"/>`;
                        },
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: function(row) {
                            let url = `/users/${row.id}/edit`;
                            let data = [
                                {
                                    'id': row.id,
                                    'url': url,
                                    'edit': 'Edit',
                                    'delete': 'Delete'
                                }];
                            var templete = $.templates("#editDeleteScript");
                            return templete.render(data);
                        },
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
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
            $(document).on('click', '.sweet-alert-button', function () {
                Swal.fire({
                    title: 'Error!',
                    text: 'Do you want to continue',
                    icon: 'error',
                    confirmButtonText: 'Cool'
                })
            })
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
