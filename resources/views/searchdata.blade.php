
@foreach($users as $user)
    <tr id="oneuser" data-id="{{$user->id}}">
        <td>{{$user->id}}</td>
        <td>{{$user->first_name}}</td>
        <td>{{$user->last_name}}</td>
        <td>{{$user->email}}</td>
        <td>{{ implode(',', json_decode($user->hobbies)) }}</td>
        <td>{{$user->gender}}</td>
        <td>
            <img class="img-fluid img-thumbnail" src="{{ asset('storage/' . $user->image) }}" alt="Uploaded Image" width="200">
        </td>
        <td style="" class="editDelete">
            <form action="{{route('users.destroy', $user->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" id="deleteUsers" class="btn btn-danger btn-sm my-3" data-id="{{$user->id}}">DELETE</button>
            </form>
            <a href="{{route('users.edit', $user->id)}}" class="btn btn-warning editbtn d-flex justify-content-center align-items-center" data-id="{{$user->id}}">Edit</a>
        </td>
    </tr>
@endforeach
