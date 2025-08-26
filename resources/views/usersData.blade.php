<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-12 text-center">
                                <h2 class="">User Data</h2>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-sm-4 col-xs-12 ">
                            <div class="search-box">
                                <input type="text" class="form-control" placeholder="Search...">
                            </div>
                        </div>
                        <div class="col-xs-8 text-right w-66">
                            <a href="/" class="btn btn-sm btn-primary"> Create New</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Email</th>
                                    <th>Hobbies</th>
                                    <th>Gender</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
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
                                            <form action="{{route('users.destroy',$user->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm my-3">DELETE</button>
                                            </form>
                                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-warning editbtn d-flex justify-content-center align-items-center">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

