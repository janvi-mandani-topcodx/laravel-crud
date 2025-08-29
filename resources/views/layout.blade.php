<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    @if(Auth::check())
        <a href="{{route('logout.view')}}">Logout</a>
    @else
        <a href="{{route('login.view')}}">Login</a>
    @endif
    <a href="{{route('posts.index')}}">Posts</a>
    <a href="{{route('users.index')}}">Users</a>
    @yield('content')
    @yield('scripts')
</body>
</html>
