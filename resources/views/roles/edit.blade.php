@extends('layout')


@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Edit Role</h3>
                            <form method="POST" enctype="multipart/form-data"  action="{{ route('roles.update', $role->id) }}">
                                @csrf
                                @method('PUT')
                                <div  class="form-group">
                                    <label class="form-label fw-bold " for="role">Name</label>
                                    <input type="text" id="role" class="form-control"  value="{{$role->name}}"  name="role" placeholder="Enter First name"/>
                                    <span style="color: darkred">@error('role') {{$message}} @enderror</span>
                                </div>

                                <div class="form-group mb-4 ">
                                    <label class="form-label fw-bold">Permissions</label>
                                    @foreach($permissions as $permission)

                                        <div class="form-check ms-4 one-permission" data-id="{{$permission->id}}">
                                                <input class="form-check-input" type="checkbox" name="permission[]" value="{{$permission->id}}" id="{{$permission->name}}"  {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{$permission->name}}">
                                                {{$permission->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                    <span style="color: darkred" class="Permission-error">@error('permission') {{ $message }} @enderror</span>
                                </div>
                                <button type="button" class="btn btn-primary btn-block mb-4 editRole">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click', '.edit-role', function (e) {
                e.preventDefault();
                let form = $(this).closest('form')[0];
                let formData = new FormData(form);
                console.log(formData)
                $.ajax({
                    url: "{{route('roles.update', $role->id)}}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.location.href = "{{route('roles.index')}}";
                    },
                });
            });
        });
    </script>
@endsection
