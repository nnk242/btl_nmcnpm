@extends('layouts.app')
@section('css')
    <style>
        #profile-image1 {
            position: absolute;
            left: 45%;
            top: 0px;
            display: none;
        }
    </style>
@endsection
@section('content')
    @if(session('mes'))
        <div class="mes-page" style="position: absolute;z-index: 1;opacity: 0.9;left: 30%">
            <div class="alert alert-success" role="alert">
                <strong>Thành công!</strong> {{session('mes')}}.
            </div>
        </div>
    @endif
    @if(session('er'))
        <div class="mes-page" style="position: absolute;z-index: 1;opacity: 0.9;left: 30%">
            <div class="alert alert-danger" role="alert">
                <strong>Lỗi!</strong> {{session('er')}}.
            </div>
        </div>
    @endif
    @if ($errors->any())
        <div class="mes-page" style="position: absolute;z-index: 1;opacity: 0.9;left: 30%">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="box box-info">
                        <div class="box-body">
                            <h2>Tài khoản</h2>
                            <hr>
                        </div>
                        <div class="box-body">
                            <ul class="nav nav-pills">
                                <li class="active"><a data-toggle="pill" href="#all-user"><span
                                                class="fa fa-child"></span>&nbsp;Tất cả tài khoản</a></li>
                                <li><a data-toggle="pill" href="#home"><span class="fa fa-address-card-o"></span>&nbsp;Thêm
                                        sinh viên</a></li>
                                <li><a data-toggle="pill" href="#menu1"><span class="fa fa-users"></span>&nbsp;Thêm tài
                                        khoản</a></li>
                                <li><a data-toggle="pill" href="#menu2"><span class="fa fa-shopping-basket"></span>&nbsp;Lớp học</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="all-user" class="tab-pane fade in active">
                                    <hr>
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Biệt danh</th>
                                            <th>Tên tài khoản</th>
                                            <th>Email</th>
                                            <th>Ngày lập</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_users as $key=>$all_user)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$all_user->name}}</td>
                                                <td class="username">{{$all_user->username}}</td>
                                                <td>{{$all_user->email}}</td>
                                                <td>{{$all_user->created_at}}</td>
                                                <td><a class="delete-user" data-toggle="modal" data-target=".delete_user" href="{{url('/add-user/delete/') . '/' . $all_user->id}}" title="Xóa tài khoản"><span class="fa fa-trash-o"></span></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <hr>
                                    {{ $all_users->links() }}
                                </div>
                                <div id="home" class="tab-pane fade">
                                    <hr>
                                    <form method="POST" action="{{route('create.student')}}">
                                        {{csrf_field()}}
                                        <button type="button" class="btn btn-info" id="add_student"
                                                style="float: right"><span
                                                    class="fa fa-plus-square-o"></span>&nbsp;Thêm tài khoản
                                        </button>
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Họ tên đệm</th>
                                                <th>Tên</th>
                                                <th>Lớp</th>
                                                <th>sinh nhật</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody id="add">
                                            <tr>
                                                <td><input type="text" class="form-control" id="ho_ten_dem"
                                                           name="ho_ten_dem[]" placeholder="Họ tên đệm" required></td>
                                                <td><input type="text" class="form-control" id="ten" name="ten[]"
                                                           placeholder="Tên" required>
                                                </td>
                                                <td><select class="form-control" id="lop" name="lop[]">
                                                        @foreach($class as $val)
                                                            <option value="{{$val->id}}">{{'Khóa ' . $val->khoa . ' - Lớp ' . $val->lop}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="date" class="form-control" id="sinh_nhat"
                                                           name="sinh_nhat[]"
                                                           placeholder="Sinh nhật"></td>
                                                <td><a href="#" class="remove-element" title="Xóa phần tử"><span
                                                                class="fa fa-remove"></span></a></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-success">Xác nhận</button>
                                    </form>
                                </div>
                                <div id="menu1" class="tab-pane fade">
                                    <hr>
                                    <form method="post" action="{{route('create.user')}}">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label for="name">Biệt danh:</label>
                                            <input type="text" class="form-control" id="username" name="name" required
                                                   placeholder="Biệt danh">
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Tên tài khoản:</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                   required placeholder="Tên tài khoản">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Mật khẩu:</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                   required placeholder="mật khẩu">
                                        </div>
                                        <div class="form-group">
                                            <label for="role">Cấp quyền:</label>
                                            <select class="form-control" id="role" name="role">
                                                @foreach($roles as $role)
                                                    <option value="{{$role->id}}">{{$role->name_role}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success">Xác nhận</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade delete_user" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" action="" id="delete_user">
                    {{csrf_field()}}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Xác nhận ý kiến.</h4>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có muốn xóa tài khoản:</p>
                        <h3 id="delete_username">abc</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Xác nhận</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('.mes-page').empty();
            }, 1500);
        });
        $(document).ready(function () {
            $('#add_student').click(function () {
                $('#add').append('<tr>\n' +
                    '<td><input type="text" class="form-control" id="ho_ten_dem"\n' +
                    '           name="ho_ten_dem[]" placeholder="Họ tên đệm" required></td>\n' +
                    '<td><input type="text" class="form-control" id="ten" name="ten[]"\n' +
                    '           placeholder="Tên" required>\n' +
                    '</td>\n' +
                    '<td><select class="form-control" id="lop" name="lop[]">\n' +
                        @foreach($class as $val)
                            '<option value="' + '{{$val->id}}' + '">' + '{{'Khóa ' . $val->khoa . ' - Lớp ' . $val->lop}}' + '</option>\n' +
                        @endforeach
                            '        </select>\n' +
                    '    </td>\n' +
                    '    <td><input type="date" class="form-control" id="sinh_nhat" name="sinh_nhat[]"\n' +
                    '               placeholder="Sinh nhật"></td>\n' +
                    '    <td><a href="#" class="remove-element" title="Xóa phần tử"><span\n' +
                    '                    class="fa fa-remove"></span></a></td>\n' +
                    '</tr>');
            });
            $(document).on('click', '.remove-element', function () {
                if ($('#add').find('tr').length != 1) {
                    $(this).closest('tr').remove();
                }
            });

            $(document).on('click', '.delete-user', function () {
                var href = $(this).attr('href');
                $('#delete_user').attr('action', href);
                $('#delete_username').empty();
                $('#delete_username').append($(this).closest('tr').find('.username').text());
            });
        });
    </script>
@endsection