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
    @routes
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
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user-demo.index')}}">Users Demo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('product.index')}}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('cart.product')}}">Products Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('order.index')}}">Orders</a>
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
                <div class=""  data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg>
                    <div class="count rounded-circle position-absolute d-flex justify-content-center align-items-center text-light" style="background-color: red; width: 20px; height: 20px; top: 9px; right: -13px;">0</div>
                </div>
            @endif
        </nav>
    </div>
    @extends('cart')
</div>
@yield('content')
@yield('scripts')
</body>
</html>
