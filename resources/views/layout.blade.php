<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>

    {{--    <link rel="stylesheet" href="{{ mix('css/app.css') }}">--}}
    {{--    <link rel="stylesheet" href="{{ mix('css/dataTables.css') }}">--}}
    {{--    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />--}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

</head>
<body>
<div class="bg-light">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light d-flex justify-content-between ">
            <div class="" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        @if(Auth::check())
                            {{--                            <a class="nav-link"  href="{{route('logout.view')}}">Logout</a>--}}
                        @else
                            {{--                            <a href="{{route('login.view')}}" class="nav-link">Login</a>--}}
                        @endif
                    </li>
                    @if(Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('users.index')}}">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('posts.index')}}">Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('roles.index')}}">Roles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('permissions.index')}}">Permissions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('chats.index')}}">Chats</a>
                        </li>
                    @endif
                </ul>
            </div>
            @if(Auth::check())
                <div class="d-flex align-items-center py-1">
                    <div class="px-2">Name : <span class="text-muted">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</span></div>
                    <div class="px-2">Email : <span class="text-muted">{{auth()->user()->email}} </span></div>
                    <div class="px-2">Role : <span class="text-muted">{{auth()->user()->roles->pluck('name')->first()}} </span>  </div>
                </div>
            @endif
        </nav>
    </div>
</div>
@yield('content')
@yield('scripts')
</body>
</html>
