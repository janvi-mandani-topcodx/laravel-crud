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
                                <h2 class="">Users Demo</h2>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end my-3">
                                <div class="col-xs-8 text-right w-66 p-0">
                                    <a href="/user-demo/create" class="btn btn-sm btn-primary" id="create-user-demo">Create New</a>
                                </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="user-demo-container">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Email</th>
                                <th>Hobbies</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div id="user-demo-tr">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @include('user_demo.templates');

    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const usersDemoUrl = "{{ route('user-demo.index') }}";
            let table = new DataTable('#user-demo-container', {
                deferRender: true,
                scroller: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user-demo.index') }}",
                },
                columns: [
                    { data: 'id', name: 'id' },
                    {
                        data: function (row){
                            return  `<a href="/user-demo/${row.id}" data-id='${row.id}'>${row.first_name}</a>`;
                        },
                        name: 'first_name'
                    },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'email', name: 'email' },
                    { data: 'hobbies', name: 'hobbies' },
                    {
                        data: function (row){
                            return row.status == true ? 'Active' : 'Inactive';
                        },
                        name : 'status'
                    },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    {
                        data: function (row) {
                            let url = `/user-demo/${row.id}/edit`;
                            let data = [{
                                'id': row.id,
                                'url': url,
                                'edit': 'Edit',
                                'delete': 'Delete'
                            }];
                            let template = $.templates("#editDeleteScript");
                            return template.render(data);
                        },
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });


            $(document).on('submit', '#edit-btn', function () {
                e.preventDefault();
                let $row = $(this).closest('#one-user');
                let userId = $row.data('id');
                let formData = $(this).serialize();
                console.log(userId);

                $.ajax({
                    url: `/user-demo/${userId}/edit`,
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

            $(document).on('click', '#delete-users', function () {
                let userId = $(this).data('id');

                $.ajax({
                    url: `/user-demo/${userId}`,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        table.ajax.reload(null, false);
                    },
                });
            });
        });
    </script>
@endsection
