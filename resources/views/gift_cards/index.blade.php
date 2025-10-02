@extends('layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col col-12 text-center">
                        <h2 class="">Gift Cards</h2>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success"><a href="{{route('gift-card.create')}}" class="text-decoration-none text-white">Create</a></button>
                        </div>
                        <div class="row">
                            <div class="panel-body table-responsive">
                                <table class="table table-hover" id="gift-card-container">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th class="text-center">User</th>
                                        <th class="text-center">Balance</th>
                                        <th class="text-center">Code</th>
                                        <th class="text-center">Notes</th>
                                        <th class="text-center">Expiry At</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                <div id="gift-card-tr">

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
    @include('gift_cards.templates');

    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let table = new DataTable('#gift-card-container', {
                deferRender: true,
                scroller: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('gift-card.index') }}",
                },
                columns: [
                    {
                        data: function(row) {
                            let url = route('gift-card.show' , row.id);
                            return `<a href="${url}" data-id="${row.id}">${row.id}</a>`;
                        },
                        name: 'id'
                    },
                    { data: 'customer_id' , name:'user'},
                    { data: 'balance', name: 'balance' , type: 'string'},
                    { data : 'code',name: 'code'},
                    { data: 'notes', name: 'notes'},
                    { data: 'expiry_at', name: 'expiry at' , type:'string'},
                    { data: 'enabled', name: 'status' },
                    {
                        data: function (row) {
                            let url = route('gift-card.edit' , row.id);
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
                    url: route('gift-card.destroy' , discountId),
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
