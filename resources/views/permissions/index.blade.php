@extends('layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-12 text-center">
                                <h2 class="">Permissions</h2>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="d-flex justify-content-between p-0">
                                <div class="search-box">
                                    <input type="text" class="form-control" id="search-post" name="searchPost"
                                           placeholder="Search...">
                                </div>
                                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#permissionCreate">
                                    Create permission
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="post-data-container">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody id="all-permission">
                                    @foreach($permissions as $permission)
                                        <tr class="one-permission" id="one-permission-{{$permission->id}}" data-id="{{$permission->id}}">
                                            <td>{{$permission->id}}</td>
                                            <td class='permission-name'>{{$permission->name}}</td>

                                            <td  class="edit-delete d-flex justify-content-center align-items-center gap-2" >
                                                <button type="button" id="delete-permission" class="btn btn-danger btn-sm my-3" data-id="{{$permission->id}}">DELETE</button>
                                                <span class="btn btn-warning edit-permission d-flex justify-content-center align-items-center col-6" data-permission="{{$permission->name}}" data-id="{{$permission->id}}" style="    width: 70px;">Edit</span>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal fade" id="permissionCreate" tabindex="-1" role="dialog" aria-labelledby="permissionCreateLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="permissionCreateLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <input type="hidden" id="edit-permission-id" name="editPermissionId" value="">
                                    <div class="row mb-4">
                                        <div  class="form-group">
                                            <label class=" fw-bold" for="permission">Name</label>
                                            <input type="text" id="permission" class="form-control"  value="{{old('permission')}}"  name="permission" placeholder="Enter your permission"/>
                                            <span style="color: darkred">@error('permission') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary create-permission">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
            $(document).on('click', '.create-permission', function (e) {
                e.preventDefault()
                let permission = $('#permission').val();
                let PermissionId = $('#edit-permission-id').val();
                if (PermissionId) {
                    $.ajax({
                        url: '/permissions/' + PermissionId,
                        type: 'PUT',
                        data: {
                            permission: permission,
                        },
                        success: function (response) {
                            $('#one-permission-' + PermissionId).find('.permissionName').text(response.permission);
                            $('#permission-create').modal('hide')
                            $('#permission').val('')
                            $('#one-permission-' + PermissionId).find('.edit-permission').data('permission', response.permission);
                            $('#edit-permission-id').val('')
                        }
                    });
                }
                else {
                    $.ajax({
                        url: "/permissions",
                        method: "POST",
                        data: {
                            permission: permission,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            console.log(response.name)
                            const newCommentHTML = `
                                <tr class="one-permission" id="one-permission-${response.id}" data-id="${response.id}">
                                        <td>${response.id}</td>
                                        <td class='permission-name'>${response.name}</td>

                                        <td  class="edit-delete d-flex justify-content-center align-items-center gap-2" >
                                            <button type="button" id="delete-permission" class="btn btn-danger btn-sm my-3" data-id="${response.id}">DELETE</button>
                                            <span class="btn btn-warning edit-permission d-flex justify-content-center align-items-center col-6" data-permission="${response.name}"  data-id="${response.id}" style="width: 70px;">Edit</span>
                                        </td>
                                    </tr>
                                    `;
                            $('#permission-create').modal('hide')
                            $('#all-permission').append(newCommentHTML)
                            $('#permission').val('')

                        }
                    });
                }
            });

            $(document).on('click' , '.edit-permission' , function (){
                    const permissionId = $(this).data('id');
                    const permissionName = $(this).data('permission');

                    $('#permission').val(permissionName);
                    $('#edit-permission-id').val(permissionId);
                    $('#permission-create').modal('show')
                    $('.create-permission').text('Update Permission');
            });

            $(document).on('click', '#delete-permission' ,  function () {
                const permissionId = $(this).data('id');
                const row = $(this).closest('.one-permission');
                $.ajax({
                    url: '/permissions/' + permissionId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        row.remove();
                    }
                });
            });

        });
    </script>
@endsection
