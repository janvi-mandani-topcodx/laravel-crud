@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout')

@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Edit Post</h3>
                            <form method="POST" enctype="multipart/form-data"  action="{{ route('posts.update', $post->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit-user-id" data-id="{{$post->id}}">
                                <div class="row mb-4 ">
                                    <div class="col">
                                        <div  class="form-group">
                                            <label class="form-label fw-bold " for="title">Title</label>
                                            <input type="text" id="title" class="form-control"  value="{{$post->title}}" name="title" placeholder="Enter title"/>
                                            <span style="color: darkred">@error('title') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <div  class="form-group">
                                            <label class="form-label fw-bold" for="description">Description</label>
                                            <input type="text" id="description" class="form-control"  value="{{$post->description}}" name="description" placeholder="Enter description"/>
                                            <span style="color: darkred">@error('description') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <div  class="form-group">
                                            <label class="form-label fw-bold w-100" for="status">Status</label>
                                            <select name="status" id="status" class="px-2 form-control">
                                                <option value="active" {{ $post->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive"  {{ $post->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold" for="custom-file-post">Image</label>
                                    <input type="file" class="form-control" id="custom-file-post" name="image"/>
                                    @if ($post->image)
                                        <img src="{{$post->postImageUrl}}" alt="User Image" class="img-thumbnail mt-2" style="max-width: 150px;">
                                    @else
                                        <p class="text-muted">No image uploaded.</p>
                                    @endif
                                    <span style="color: darkred">@error('image') {{ $message }} @enderror</span>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mb-4 update-post">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="vh-100 gradient-custom">
        <div class="container  h-100">
            <div class="row justify-content-center align-items-center ">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center">Comments</h3>
                                <form method="POST" enctype="multipart/form-data" action="{{ route('comments.store') }}" id="comment-form">
                                    @csrf
                                    <input type="hidden" id="post-id" name="post_id" data-id="{{$post->id}}" value="{{$post->id}}">
                                    <input type="hidden" id="edit-comment-id" name="editCommentId" value="">
                                    @php
                                        $user = Auth::user();
                                        $role = $user->roles->first();
                                    @endphp
                                    <div class="row mb-4 update-comment-input">
                                        @if ($role->permissions->where('name', 'create comment')->isNotEmpty())
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <input type="text" id="comment" class="form-control"  value="" name="comment" placeholder="Enter Comment"/>
                                                    <span style="color: darkred">@error('comment') {{$message}} @enderror</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($role->permissions->where('name', 'create comment')->isNotEmpty())
                                            <div class="col-4">
                                                <button type="submit" class="btn btn-primary btn-block mb-4 create-comment" id="comment-submit-btn">Add Comment</button>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            <div class="comment-data">
                                @foreach($post->comments as $comment)
                                <div class='my-5 dots rounded p-2 one-comment' id="comment-data-{{$comment->id}}">
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <div class='d-flex align-items-center'>
                                            <div class='full_name d-flex justify-content-center align-items-center'>
                                                <b class="bg-black text-light rounded rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                                    {{substr($comment->user->first_name , 0 ,1)}}{{substr($comment->user->last_name , 0 ,1)}}
                                                </b>
                                                <div class="mx-2 fw-bold">{{$comment->fullName}}</div>

                                            </div>
                                        </div>
                                        @if(Auth::user()->id == $comment->user->id)
                                            <div class='dropdown'>
                                                <button type='button' class='border-0 dropdown-toggle'  data-bs-toggle='dropdown'>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                                    </svg>
                                                </button>
                                                <ul class='dropdown-menu'>
                                                    @if ($role->permissions->where('name', 'update comment')->isNotEmpty())
                                                        <li class='mb-2'>
                                                            <input type='hidden' name='edit_comment' value="{{$comment->id}}">
                                                            <input type='hidden' name='postId' value="{{$comment->post->id}}">
                                                            <span  class='edit-btn dropdown-item' data-comment = "{{$comment->comment}}" data-action="{{$comment->id}}" > Edit </span>
                                                        </li>
                                                    @endif
                                                    @if ($role->permissions->where('name', 'delete comment')->isNotEmpty())
                                                        <li>
                                                            <span class='delete-btn dropdown-item' data-comment="{{$comment->id}}">Delete</span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class='d-flex justify-content-between'>
                                        <span class='mx-5 comment-text' id="comment">{{$comment->comment}}</span>
                                        <span>{{$comment->created_at}}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.delete-btn' ,  function () {
                const commentId = $(this).data('comment');
                const row = $(this).closest('.one-comment');
                $.ajax({
                    url: '/comments/' + commentId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        row.remove();
                    }
                });
            });
            $(document).on('click', '.update-post', function (e) {
                e.preventDefault()
                let form = $(this).closest('form')[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "{{route('posts.update' , $post->id)}}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.location.href = '{{ route('posts.index') }}';
                    },
                    error: function (response) {
                        console.log(response.responseJSON);
                        let errors = response.responseJSON.errors;
                        if (errors.title) {
                            $('#title').siblings('span').text(errors.title[0]);
                        }
                        if (errors.description) {
                            $('#description').siblings('span').text(errors.description[0]);
                        }
                        if (errors.status) {
                            $('#status').siblings('span').text(errors.status[0]);
                        }
                    }
                });
            });
            $(document).on('click', '.edit-btn', function () {
                const commentId = $(this).data('action');
                const commentText = $(`#comment-data-${commentId}`).find('.comment-text').text();

                const editComment = `
                    <div class='row update-comment-input'>
                        <div class="col-8">
                            <div  class="form-group">
                                <input type="text" id="comment" class="form-control"  value="${commentText}" name="comment" placeholder="Enter Comment"/>
                                <span style="color: darkred">@error('comment') {{$message}} @enderror</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block mb-4 create-comment" id="comment-submit-btn">Update Comment</button>
                        </div>
                    </div>`;
                $('.update-comment-input').replaceWith(editComment);
                $('#comment').val(commentText);
                $('#edit-comment-id').val(commentId);
            });
            $('#comment-form').on('submit', function (e) {
                e.preventDefault();

                const commentText = $('#comment').val();
                const postId = $('#post-id').val();
                const commentId = $('#edit-comment-id').val();

                if (commentId) {
                    $.ajax({
                        url: '/comments/' + commentId,
                        type: 'PUT',
                        data: {
                            comment: commentText,
                        },
                        success: function (response) {
                            $('#comment-data-' + commentId).find('.comment-text').text(response.comment);
                            if(response.addComment === true){
                                $('#comment').val('');
                                $('#edit-comment-id').val('');
                                $('#comment-submit-btn').text('Add Comment');
                            }
                            else{
                                $('#comment').val('');
                                $('#edit-comment-id').val('');
                                $('.update-comment-input').hide();
                            }
                        }
                    });
                } else {
                    $.ajax({
                        url: '{{ route('comments.store') }}',
                        type: 'POST',
                        data: {
                            post_id: postId,
                            comment: commentText,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            const newCommentHTML = `
                            <div class='my-5 dots rounded p-2 one-comment' id="comment-data-${response.id}">
                                <div class='d-flex align-items-center justify-content-between'>
                                    <div class='d-flex align-items-center'>
                                        <div class='full_name d-flex justify-content-center align-items-center'>
                                            <b class="bg-black text-light rounded rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                                ${response.shortname}
                                            </b>
                                            <div class="mx-2 fw-bold">${response.full_name}</div>
                                        </div>
                                    </div>
                                    <div class='dropdown'>
                                        <button type='button' class='border-0 dropdown-toggle' data-bs-toggle='dropdown'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                            </svg>
                                        </button>
                                        <ul class='dropdown-menu'>
                                            <li class='mb-2'>
                                                <input type='hidden' name='edit_comment' value="${response.id}">
                                                <input type='hidden' name='postId' value="${response.post-id}">
                                                <span class='edit-btn dropdown-item' data-comment="${response.comment}" data-action="${response.id}">Edit</span>
                                            </li>
                                            <li>
                                                <span class='delete-btn dropdown-item' data-comment="${response.id}">Delete</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span class='mx-5 comment-text' id="comment">${response.comment}</span>
                                    <span>${response.created_at}</span>
                                </div>
                            </div>`;
                            $('.comment-data').append(newCommentHTML);
                            $('#comment').val('');
                            $('#edit-comment-id').val('');
                            $('#comment-submit-btn').text('Add Comment');
                        }
                    });
                }
            });
        });
    </script>
@endsection
