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
                                    <input type="text" class="form-control" id="searchPost" name="searchPost"
                                           placeholder="Search...">
                                </div>
                                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#permissionCreate">
                                    Create permission
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="postDataContainer">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody id="allPermission">
                                    @foreach($permissions as $permission)
                                        <tr class="onePermission" id="onePermission-{{$permission->id}}" data-id="{{$permission->id}}">
                                            <td>{{$permission->id}}</td>
                                            <td class='permissionName'>{{$permission->name}}</td>

                                            <td  class="editDelete d-flex justify-content-center align-items-center gap-2" >
                                                <button type="button" id="deletePermission" class="btn btn-danger btn-sm my-3" data-id="{{$permission->id}}">DELETE</button>
                                                <span class="btn btn-warning editPermission d-flex justify-content-center align-items-center col-6" data-permission="{{$permission->name}}" data-id="{{$permission->id}}" style="    width: 70px;">Edit</span>
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
                                    <input type="hidden" id="editPermissionId" name="editPermissionId" value="">
                                    <div class="row mb-4">
                                        <div  class="form-group">
                                            <label class=" fw-bold" for="permission">Name</label>
                                            <input type="text" id="permission" class="form-control"  value="{{old('permission')}}"  name="permission" placeholder="Enter your permission"/>
                                            <span style="color: darkred">@error('permission') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary createPermission">Submit</button>
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
            $(document).on('click', '.createPermission', function (e) {
                e.preventDefault()
                let permission = $('#permission').val();
                let PermissionId = $('#editPermissionId').val();
                if (PermissionId) {
                    $.ajax({
                        url: '/permissions/' + PermissionId,
                        type: 'PUT',
                        data: {
                            permission: permission,
                        },
                        success: function (response) {
                            $('#onePermission-' + PermissionId).find('.permissionName').text(response.permission);
                            $('#permissionCreate').modal('hide')
                            $('#permission').val('')
                            $('#onePermission-' + PermissionId).find('.editPermission').data('permission', response.permission);
                            $('#editPermissionId').val('')
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
                                <tr class="onePermission" id="onePermission-${response.id}" data-id="${response.id}">
                                        <td>${response.id}</td>
                                        <td class='permissionName'>${response.name}</td>

                                        <td  class="editDelete d-flex justify-content-center align-items-center gap-2" >
                                            <button type="button" id="deletePermission" class="btn btn-danger btn-sm my-3" data-id="${response.id}">DELETE</button>
                                            <span class="btn btn-warning editPermission d-flex justify-content-center align-items-center col-6" data-permission="${response.name}"  data-id="${response.id}" style="width: 70px;">Edit</span>
                                        </td>
                                    </tr>
                                    `;
                            $('#permissionCreate').modal('hide')
                            $('#allPermission').append(newCommentHTML)
                            $('#permission').val('')

                        }
                    });
                }
            });

            $(document).on('click' , '.editPermission' , function (){
                    const permissionId = $(this).data('id');
                    const permissionName = $(this).data('permission');

                    $('#permission').val(permissionName);
                    $('#editPermissionId').val(permissionId);
                    $('#permissionCreate').modal('show')
                    $('.createPermission').text('Update Permission');
            });

            $(document).on('click', '#deletePermission' ,  function () {
                const permissionId = $(this).data('id');
                const row = $(this).closest('.onePermission');
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
