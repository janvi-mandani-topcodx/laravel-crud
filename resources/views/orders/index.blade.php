@extends('layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col col-12 text-center">
                        <h2 class="">Order</h2>
                        <div class="row">
                            <div class="panel-body table-responsive">
                                <table class="table table-hover" id="order-container">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>order id</th>
                                        <th>delivery</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                <div id="order-tr">

                                </div>
                            </div>
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

            let table = new DataTable('#order-container', {
                deferRender: true,
                scroller: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('order.index') }}",
                },
                columns: [
                    { data: 'id', name: 'id' },
                    {
                        data: function (row){
                            return '<a href="'+ route('order.show' , row.id) +'" data-id=' + row.id + '>'+ row.id +'</a>';
                        },
                        name: 'order id'
                    },
                    {
                        data: 'delivery',
                        name: 'delivery'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: 'total',
                        name: 'total',
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
        });
    </script>
@endsection
