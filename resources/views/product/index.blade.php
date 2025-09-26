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
                                <h2 class="">Products</h2>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end my-3">
                            <div class="col-xs-8 text-right w-66 p-0">
                                <a href="{{route('product.create')}}" class="btn btn-sm btn-primary" id="create-user-demo">Create New</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="product-container">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div id="product-tr">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @include('product.templates');

    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let table = new DataTable('#product-container', {
                deferRender: true,
                scroller: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('product.index') }}",
                },
                columns: [
                    { data: 'id', name: 'id' },
                    {
                        data: function (row){
                            return '<a href="'+ route('product.show' , row.id) +'" data-id=' + row.id + '>'+ row.title +'</a>';
                        },
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: function (row){
                            return row.status == true ? 'Active' : 'Inactive';
                        },
                        name : 'status'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: function (row) {
                            let url = route('product.edit' , row.id);
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
                let productId = $row.data('id');
                let formData = $(this).serialize();
                console.log(productId);

                $.ajax({
                    url: route('product.edit' , productId),
                    method: "POST",
                    data: {
                        formData,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        window.location.href = route('product.edit' , productId);
                    }
                });
            });

            $(document).on('click', '#delete-users', function () {
                let productId = $(this).data('id');

                $.ajax({
                    url: route('product.destroy' , productId),
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
