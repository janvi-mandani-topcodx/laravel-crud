@extends('layout')
@section('content')
    <div class="container">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-12 text-center">
                                <h2 class="">Roles</h2>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-sm-4 col-xs-12 p-0">
                                <div class="search-box">
                                    <input type="text" class="form-control" id="search-post" name="searchPost"
                                           placeholder="Search...">
                                </div>
                            </div>
                            <div class="col-xs-8 text-right w-66 p-0">
                                <a href="/roles/create" class="btn btn-sm btn-primary" id="createUser">Create New</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="postDataContainer">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr id="one-role" data-id="{{$role->id}}">
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        @foreach($role->permissions as $permission)
                                            <span class="text-dark">{{ $permission->name}} @if(!$loop->last), @endif</span>
                                        @endforeach
                                    </td>
                                    <td style="height: 176px;" class="edit-delete d-flex justify-content-center align-items-center gap-2" >
                                        <button type="button" id="delete-role" class="btn btn-danger btn-sm my-3" data-id="{{$role->id}}">DELETE</button>
                                        <a href="{{route('roles.edit', $role->id)}}" class="btn btn-warning edit-role d-flex justify-content-center align-items-center col-6" data-id="{{$role->id}}" style="width: 67px; height: 31px;">Edit</a>
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
                        $('#postDataContainer tbody').html(response.html);
                    },
                    error: function (response){
                        $('#postDataContainer tbody').html(response.html);
                    }
                });
            });
                $(document).on('submit', '.edit-role', function () {
                e.preventDefault();
                let $row = $(this).closest('#one-role');
                let roleId = $row.data('id');
                let form = $(this).closest('form')[0];
                let formData = new FormData(form);

                $.ajax({
                    url: `/roles/${roleId}/edit`,
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: {
                        formData,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        window.location.href = `/roles/${roleId}/edit`;
                    }
                });
            });
            $(document).on('click', '#delete-role', function () {
                let $row = $(this).closest('#one-role');
                let roleId = $row.data('id');
                console.log(roleId)
                $.ajax({
                    url: `/roles/${roleId}`,
                    type: "DELETE",
                    data: {
                        delete_id: roleId,
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
