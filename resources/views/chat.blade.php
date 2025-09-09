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
                        <div class="user-search-data pt-2 ">
                        </div>

                        <div class="message-data">
                        @foreach($messages as $message)
                                @php
                                        $authId = auth()->user()->id;
                                        $otherUser = $message->admin_id == $authId ? $message->user : $message->admin;
                                @endphp
                                    <div id="user" style="display:flex;" data-user-id="{{$otherUser->id}}" data-id="{{$message->id}}" data-image="{{$otherUser->imageUrl}}" data-fullname="{{$otherUser->fullName}}">
                                        <div class="col-4 p-0" style="width: 100px">
                                            <img style="height: 48px;  width: 46px;" class="img-fluid rounded-circle" src="{{$otherUser->imageUrl}}" alt="Uploaded Image" >
                                        </div>
                                        <div class="col-8 d-flex justify-content-end align-items-end px-0" style="padding-top: 20px;">
                                            <p>{{$otherUser->fullName}}</p>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card" style="height: 768px !important;">
                    <div class="card-body" style="position: relative">
                            <div class="user-chat" >

                            </div>
                        <div style="height:84%; overflow: scroll" id="all-messages" class="overflow-x-hidden">
                        </div>
                        <div class=" d-flex align-items-end p-1" style="position: absolute; bottom: 0; left:0; width: 100%">
                            <div class="search-box w-100">
                                @if($messages)
                                    <div id="message-input">
                                        <form action="" id="message-form" method="post" enctype="multipart/form-data" class="d-flex justify-content-around gap-3" >
                                            @csrf
                                            <input type="hidden" id="edit-chat-id"  value="">
                                            <input type="text" class="form-control" id="message" name="message" placeholder="Enter your chat...">
                                            <label for="file-upload-input">
                                                <i class="fa fa-paper-plane-o"></i>
                                                <input type="file" id="file-upload-input" style="display: none;" name="image">
                                            </label>
                                            <input type="submit" class="btn btn-primary" value="Send" id="message-send">
                                        </form>
                                    </div>
                                @endif
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
            let refreshInterval;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if($('.messages-name') == ''){
                $('#message-input').show();
            } else {
                $('#message-input').hide();
            }
            $(document).on('keyup', '#search' ,  function () {
                let query = $(this).val();
                $.ajax({
                    url: "{{route('chat.admin.user')}}",
                    method: "GET",
                    data: {
                        search: query
                    },
                    success: function (response) {
                        $('.user-search-data').html(response.html);
                    },
                    error: function (response){
                        $('.user-search-data').html(response.html);
                    }

                });
                $('.message-data').hide();
            });

            $(document).on('click' , '#one-user', function (){
                let fullName = $(this).data('fullname');
                let image = $(this).data('image');
                let id = $(this).data('id');

                $('.message-data').show();
                let userHtml = `
                        <div class="d-flex align-items-center mb-3 messages-name" data-id="">
                            <img src="${image}" alt="User Image" style="height: 50px; width: 50px;" class="rounded-circle me-2">
                            <div class="d-flex">
                                <strong class="pe-2">${fullName}</strong>
                            </div>
                        </div>
                        <hr>`;
                 $('#message-input').show();
                     $.ajax({
                         url: "{{route('chat.messages')}}",
                         method: "GET",
                         data: {
                             id:id
                         },
                         success: function (response) {
                             $('.message-data').append(response.html);
                             $('.messages-name').attr('data-id' , response.message_id)
                         }
                     });
                $('.user-chat').html(userHtml);
                $('.user-search-data').text('');
                $('#search').val('');
                $('#all-messages').text('');
            });

            $(document).on('click' , '#user', function (){

                    let fullName = $(this).data('fullname');
                    let image = $(this).data('image');
                    let messageId = $(this).data('id');
                    console.log(messageId);
                    let userHtml = `
                            <div class="d-flex align-items-center mb-3 messages-name" data-id=''>
                                <img src="${image}" alt="User Image" style="height: 50px; width: 50px;" class="rounded-circle me-2">
                                <div class="d-flex">
                                    <strong class="pe-2">${fullName}</strong>
                                </div>
                            </div>
                            <hr>`;
                    $('.user-chat').html(userHtml);
                    $('#message-input').show();
                    $('.all-messages').text('');

                function ajaxFunction(){
                    $.ajax({
                        url: "{{ route('chat.message') }}",
                        method: "GET",
                        data: {
                            id: messageId
                        },
                        success: function (response) {
                            $('#all-messages').html(response.html);
                            $('.messages-name').attr('data-id' , response.message_id)
                        }
                    });
                }
                ajaxFunction();
                if(refreshInterval){
                    console.log("clear")
                    clearInterval(refreshInterval);
                }
                refreshInterval = setInterval(ajaxFunction, 5000);
            });

            $(document).on('click', '.edit-btn', function () {
                const chatId = $(this).data('action');
                const message = $(this).data('message');
                console.log(message)
                $('#message').val(message);
                $('#edit-chat-id').val(chatId);
                $('#message-send').val('Update');
            });

            $('#message-form').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                const messageId = $('.messages-name').data('id');
                formData.append('message_id', messageId);
                const editChatId = $('#edit-chat-id').val();
                if (editChatId) {
                    formData.append('_method', 'PUT');
                    $.ajax({
                        url: '/chats/' + editChatId,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log(response)
                            $('.message-data-' + editChatId).find('.message-text').text(response.message);
                            $('.message-data-' + editChatId).find('.message-image').attr('src' , response.message);
                            $('.message-data-' + editChatId).find('.edit-btn').attr('data-message', response.message);
                        }
                    });
                    $('#message').val('');
                    $('#edit-chat-id').val('');
                    $('#message-send').val('Send');

                }else{
                      $.ajax({
                          url: '{{ route('chats.store') }}',
                          type: 'POST',
                          data:formData,
                          contentType: false,
                          processData: false,
                          success: function (response) {
                              console.log(response)
                              const sendByAdmin = response.send_by_admin == 1 ? 'text-end' : 'text-start';
                              const sendMessage = sendByAdmin == 'text-end' ? 'justify-content-end' : 'justify-content-start';
                              const display = response.image == "http://127.0.0.1:8000/storage" ? 'd-none' : '';
                              const newMessage = `
                                    <div data-id="${response.id}" data-send="${response.send_by_admin}" class="one-message ${sendByAdmin} message-data-${response.id}">
                                        <small>${response.created_at}</small>
                                        <div class="d-flex ${sendMessage} ">
                                            <div class="message-text">${response.message}</div>
                                                <img class="message-image img-fluid img-thumbnail ${display}" src="${response.image}" alt="Uploaded Image" width="200" style="height: 126px;">
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
                                                                    <span  class="edit-btn dropdown-item m-0" data-message = " ${response.message}" data-action="${response.id}" data-image = "${response.image}" > Edit </span>
                                                                </li>
                                                                <li>
                                                                    <span class="delete-btn dropdown-item" data-id=" ${response.id}">Delete</span>
                                                                </li>
                                                        </ul>
                                                    </div>
                                            </div>
                                        </div>
                                `;
                              $('#all-messages').append(newMessage);
                              $('#message').val('');
                          }
                      });
                  }
            });

            $(document).on('click', '.delete-btn' ,  function () {
                const messageId = $(this).data('id');
                const row = $(this).closest('.one-message');
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
