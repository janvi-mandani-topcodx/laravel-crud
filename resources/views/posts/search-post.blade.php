
@foreach($posts as $post)
    <tr id="onepost" data-id="{{$post->id}}">
        <td>{{$post->id}}</td>
        <td>{{$post->user_id}}</td>
        <td>{{$post->title}}</td>
        <td>{{$post->description}}</td>
        <td>{{$post->status}}</td>
        <td>
            <img class="img-fluid img-thumbnail" src="{{ asset('storage/' . $post->image) }}" alt="Uploaded Image" width="200" height="100" style="height: 126px;">
        </td>
        <td style="height: 176px;" class="editDelete d-flex justify-content-center align-items-center" >
            <form action="{{route('posts.destroy', $post->id)}}" method="POST" class="col-6">
                @csrf
                @method('DELETE')
                <button type="button" id="deletePost" class="btn btn-danger btn-sm my-3" data-id="{{$post->id}}">DELETE</button>
            </form>
            <a href="{{route('posts.edit', $post->id)}}" class="btn btn-warning editpost d-flex justify-content-center align-items-center col-6" data-id="{{$post->id}}">Edit</a>
        </td>
    </tr>
@endforeach
