<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{--my style--}}
    <link href="{{ asset('css/myStyle.css') }}" rel="stylesheet">

    {{--font awesome--}}
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <div class="navbar-brand">
                    Mini
                    <small>Quản lý học sinh</small>
                </div>
                @guest
                    @else
                        <a class="navbar-brand {{in_array('home',explode('/',url()->current()))?'selected_menu': ''}}"
                           href="{{ url('/') }}">
                            <span class="fa fa-user-circle"></span>&nbsp;Thông tin cá nhân
                        </a>
                        <a class="navbar-brand {{in_array('result',explode('/',url()->current()))?'selected_menu': ''}}"
                           href="{{ url('/result') }}">
                            <span class="fa fa-bar-chart-o"></span>&nbsp;Kết quả học tập
                        </a>

                        @if (Auth::id())
                            @if(\App\User::find(Auth::id())->role == 2)
                                <a class="navbar-brand {{in_array('input-point',explode('/',url()->current()))?'selected_menu': ''}}"
                                   href="{{ url('/input-point') }}">
                                    <span class="fa fa-pencil-square-o"></span>&nbsp;Nhập điểm
                                </a>
                            @endif
                            @if(\App\User::find(Auth::id())->role == 1)
                                <a class="navbar-brand {{in_array('add-user',explode('/',url()->current()))?'selected_menu': ''}}"
                                   href="{{ url('/add-user') }}">
                                    <span class="fa fa-user-plus"></span>&nbsp;Quản lý
                                </a>
                            @endif
                        @endif
                        @endguest
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">

                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false" aria-haspopup="true">
                                    <span class="fa fa-user-o"></span>&nbsp;{{ Auth::user()->name }} <span
                                            class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li data-toggle="modal" data-target="#change-password">
                                        <a href="#">
                                            <span class="fa fa-gear"></span>&nbsp;&nbsp;Thay đổi mật khẩu
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <span class="fa fa-sign-out"></span>&nbsp;&nbsp;Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endguest
                </ul>
                {{--@guest--}}
                    {{--@else--}}
                        {{--@include('layouts.notify')--}}
                {{--@endguest--}}
            </div>
        </div>
    </nav>

    <!-- Modal change password-->
    <div class="modal fade" id="change-password" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content aj-form-page">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thay đổi mật khẩu</h4>
                </div>
                <div class="modal-body">
                    <form id="form-change-password" role="form" method="POST" action="{{ route('changePassword') }}"
                          novalidate class="form-horizontal">
                        <div class="col-md-9">
                            <label for="current-password" class="col-sm-4 control-label">Mật khẩu hiện tại</label>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="password" class="form-control" id="current-password"
                                           name="current-password" placeholder="Password">
                                </div>
                            </div>
                            <label for="password" class="col-sm-4 control-label">Mật khẩu mới</label>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="Password">
                                </div>
                            </div>
                            <label for="password_confirmation" class="col-sm-4 control-label">Nhập lại mật khẩu</label>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password_confirmation"
                                           name="password_confirmation" placeholder="Re-enter Password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-6">
                                <button type="submit" class="btn btn-danger">Thay đổi</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">Quay lại</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
</body>
</html>
