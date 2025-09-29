@extends('layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col col-12 text-center">
                        <h2 class="">Discounts</h2>
                        <div class="row">
                            <div class="panel-body table-responsive">
                                <table class="table table-hover" id="discount-container">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th class="text-center">Code</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Type</th>
{{--                                        <th class="text-center">Minimum Requirements</th>--}}
{{--                                        <th class="text-center">Minimum Amount</th>--}}
                                        <th class="text-center">Customer</th>
                                        <th class="text-center">User Id</th>
                                        <th class="text-center">Product</th>
                                        <th class="text-center">Product Id</th>
{{--                                        <th class="text-center">Discount Apply Type</th>--}}
{{--                                        <th class="text-center">Discount Type Number</th>--}}
                                        <th class="text-center">Start Date</th>
                                        <th class="text-center">End Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                <div id="discount-tr">

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
    @include('discounts.templates');

    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let table = new DataTable('#discount-container', {
                deferRender: true,
                scroller: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('discounts.index') }}",
                },
                columns: [
                    {
                        data: function(row) {
                            let url = route('discounts.show' , row.id);
                            return `<a href="${url}" data-id="${row.id}">${row.id}</a>`;
                        },
                        name: 'id'
                    },
                    { data : 'code',name: 'code'},
                    { data: 'amount', name: 'amount' , type: 'string'},
                    { data: 'type', name: 'type'},
                    // { data: 'minimum_requirements', name: 'Minimum Requirements'},
                    // { data: 'minimum_amount', name: 'Minimum Amount'},
                    { data: 'customer', name: 'customer'},
                    { data: 'user_id', name: 'user Id'},
                    { data: 'product', name: 'product'},
                    { data: 'product_id', name: 'product Id'},
                    { data: 'start_date', name: 'start date' , type: 'string'},
                    { data: 'end_date', name: 'end_date'},
                    { data: 'status', name: 'status' , type: 'string'},
                    // { data: 'discount_apply_type', name: 'Discount Apply Type'},
                    // { data: 'discount_type_number', name: 'Discount Type Number'},


                    {
                        data: function (row) {
                            let url = route('discounts.edit' , row.id);
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
            $(document).on('click', '#delete-discount', function () {
                let discountId = $(this).data('id');

                $.ajax({
                    url: route('discounts.destroy' , discountId),
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
