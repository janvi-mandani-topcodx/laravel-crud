@extends('layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col col-12 text-center">
                        <h2 class="">Orders</h2>
                        <div class="row">
                            <div class="panel-body table-responsive">
                                <table class="table table-hover" id="order-container">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Delivery</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center" id="totalAmountOrder">Total</th>
                                        <th class="text-center">Actions</th>
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
    @include('orders.templates');

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
                    { data : 'name',name: 'name'},
                    { data: 'delivery', name: 'delivery'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'total', name: 'total' , type : 'string'},
                    {
                        data: function (row) {
                            let url = route('order.edit' , row.id);
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
            $(document).on('click', '#delete-order', function () {
                let orderId = $(this).data('id');

                $.ajax({
                    url: route('order.destroy' , orderId),
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
