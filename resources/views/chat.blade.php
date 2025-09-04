@extends('layout')
@section('content')
    <div class="container mt-5">
        <h3 class="text-center">Chat Box</h3>
        <div class="row">
            <div class="col-4">
                <div class="card h-100" style="height: 768px !important;">
                    <div class="card-body">
                        <div class="search-box">
                            <input type="text" class="form-control" id="search" name="search"
                                   placeholder="Search user...">
                        </div>
                        <div class="userSearchData pt-2 ">
                        </div>
                        <div class="messageData">
                            @foreach($messages as $message)
                                @if($message->user)
                                    <div id="User" style="display:flex;" data-user-id="{{$message->user->id}}" data-id="{{$message->id}}" data-image="{{$message->user->imageUrl}}" data-fullname="{{$message->user->fullName}}">
                                        <div class="col-4 p-0" style="width: 100px">
                                            <img style="height: 48px;  width: 46px;" class="img-fluid rounded-circle" src="{{$message->user->imageUrl}}" alt="Uploaded Image" >
                                        </div>
                                        <div class="col-8 d-flex justify-content-end align-items-end px-0" style="padding-top: 20px;">
                                            <p>{{$message->user->fullName}}</p>
                                        </div>
                                    </div>
                                @else
                                    <p>not user found</p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card" style="height: 768px !important;">
                    <div class="card-body" style="position: relative">
                        <div class="userChat">

                        </div>
                        <div style="height:84%; overflow: scroll" id="allMessages" class="overflow-x-hidden">
                        </div>
                        <div class=" d-flex align-items-end p-1" style="position: absolute; bottom: 0; left:0; width: 100%">
                            <div class="search-box w-100">
                                <form action="" id="messageForm" method="post" class="d-flex justify-content-around gap-3" >
                                    @csrf
                                    <input type="hidden" id="editchatId"  value="">
                                    <input type="text" class="form-control" id="message" placeholder="Enter your chat...">
                                    <input type="submit" class="btn btn-primary" value="Send" id="messageSend">
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
            $(document).on('keyup', '#search' ,  function () {
                let query = $(this).val();
                $.ajax({
                    url: "{{route('chat.admin.user')}}",
                    method: "GET",
                    data: {
                        search: query
                    },
                    success: function (response) {
                        $('.userSearchData').html(response.html);
                    },
                    error: function (response){
                        $('.userSearchData').html(response.html);
                    }
                });
            });

            $(document).on('click' , '#oneUser', function (){
                let fullName = $(this).data('fullname');
                let image = $(this).data('image');
                let id = $(this).data('id');
                let userHtml = `
                        <div class="d-flex align-items-center mb-3">
                            <img src="${image}" alt="User Image" style="height: 50px; width: 50px;" class="rounded-circle me-2">
                            <div class="d-flex">
                                <strong class="pe-2">${fullName}</strong>
                            </div>
                        </div>
                        <hr>`;
                    $.ajax({
                        url: "{{route('chat.message')}}",
                        method: "GET",
                        data: {
                            id:id
                        },
                        success: function (response) {

                        }
                    });
                $('.userChat').html(userHtml);
            });

            $(document).on('click' , '#User', function (){
                let fullName = $(this).data('fullname');
                let image = $(this).data('image');
                let messageId = $(this).data('id');
                let userHtml = `
                        <div class="d-flex align-items-center mb-3 messagesName" data-id='${messageId}'>
                            <img src="${image}" alt="User Image" style="height: 50px; width: 50px;" class="rounded-circle me-2">
                            <div class="d-flex">
                                <strong class="pe-2">${fullName}</strong>
                            </div>
                        </div>
                        <hr>`;
                $('.userChat').html(userHtml);
                $.ajax({
                    url: "{{ route('chat.message') }}",
                    method: "GET",
                    data: {
                        id: messageId
                    },
                    success: function (response) {
                        $('#allMessages').html(response.html);
                    }
                });
            });

            $(document).on('click', '.edit_btn', function () {
                const chatId = $(this).data('action');
                console.log(chatId)
                const message = $(this).data('message');
                console.log(message)
                $('#message').val(message);
                $('#editchatId').val(chatId);
                $('#messageSend').text('Update Message');
            });

            $('#messageForm').on('submit', function (e) {
                e.preventDefault();

                const message = $('#message').val();
                const messageId = $('.messagesName').data('id');
                const editChatId = $('#editchatId').val();
                if (editChatId) {
                    $.ajax({
                        url: '/chats/' + editChatId,
                        type: 'PUT',
                        data: {
                            message: message,
                        },
                        success: function (response) {
                            $('.messageData-' + editChatId).find('.messageText').text(response.message);
                            console.log(response.message)
                            $('#message').val('');
                            $('#editchatId').val('');
                            $('#messageSend').text('Send');
                        }
                    });
                }else{
                    $.ajax({
                        url: '{{ route('chats.store') }}',
                        type: 'POST',
                        data: {
                            message_id: messageId,
                            message: message,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            const newMessageHTML = `
                                    <div data-id="${response.id}" data-send="${response.send_by_admin}" class="oneMessage text-right messageData-${response.id}">
                                        <small>${response.created_at}</small>
                                        <p class="messageText">${response.message}</p>
                                        <div class="dropdown">
                                                <button type="button" class="border-0 dropdown-toggle"  data-bs-toggle="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu">
                                                        <li class="mb-2">
                                                            <input type="hidden" name="edit_message" value=" ${response.message}">
                                                            <input type="hidden" name="messageId" value=" ${response.id}">
                                                            <span  class="edit_btn dropdown-item" data-message = " ${response.message}" data-action="${response.id}" > Edit </span>
                                                        </li>
                                                        <li>
                                                            <span class="delete_btn dropdown-item" data-id=" ${response.id}">Delete</span>
                                                        </li>
                                                </ul>
                                            </div>
                                    </div>
                                `;
                            $('#allMessages').append(newMessageHTML);
                            $('#message').val('');
                        }
                    });
                }
            });

            $(document).on('click', '.delete_btn' ,  function () {
                const messageId = $(this).data('id');
                const row = $(this).closest('.oneMessage');
                $.ajax({
                    url: '/chats/' + messageId,
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
