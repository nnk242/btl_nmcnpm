<?php $count_name = count(explode(' ', $user->name));
$name = explode(' ', $user->name) ?>
@extends('layouts.app')

@section('css')
    <style>
        input.hidden {
            position: absolute;
            left: -9999px;
        }

        #profile-image1 {
            cursor: pointer;

            width: 100px;
            height: 100px;
            border: 2px solid #03b1ce;
        }

        .tital {
            font-size: 16px;
            font-weight: 500;
        }

        .bot-border {
            border-bottom: 1px #f8f8f8 solid;
            margin: 5px 0 5px 0
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
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="box box-info">

                        <div class="box-body">
                            <div id="alert-notify"></div>
                            <div class="col-sm-6">
                                <div align="center"><img alt="User Pic"
                                                         src="{{$user->image==null?asset('img/default.jpg'):asset('uploads/' . $user->image)}}"
                                                         id="profile-image1" class="img-circle img-responsive">
                                    <div style="color:#999;">Click để thay đổi ảnh đại diện</div>
                                    <form action="{{ route('ajax.editImg') }}" enctype="multipart/form-data"
                                          method="POST">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <input id="profile-image-upload" type="file" name="image" class="hidden"
                                                   class="form-control">
                                        </div>
                                    </form>
                                    <!--Upload Image Js And Css-->
                                </div>
                                <br>
                                <!-- /input-group -->
                            </div>
                            <div class="col-sm-6">
                                <h4 style="color:#00b1b1;">{{isset($info)?$info->ho_ten_dem . ' ' .$info->ten:$user->name}} </h4></span>
                                <span><p>{{$name[$count_name-1]}}</p></span>
                            </div>
                            <div class="clearfix"></div>
                            <hr style="margin:5px 0 5px 0;">


                            <div class="col-sm-5 col-xs-6 tital ">Biệt danh</div>
                            <div class="col-sm-7 col-xs-6 ">{{$user->name==null?'--Trống--':$user->name}}</div>
                            <div class="clearfix"></div>
                            <div class="bot-border"></div>
                            @if (isset($info))
                                <div class="col-sm-5 col-xs-6 tital ">Sinh nhật:</div>
                                <div class="col-sm-7">{{$info->sinh_nhat==null?'--Trống--':$info->sinh_nhat}}</div>
                                <div class="clearfix"></div>
                                <div class="bot-border"></div>


                                <div class="col-sm-5 col-xs-6 tital ">Quê quán:</div>
                                <div class="col-sm-7">{{$info->que_quan==null?'--Trống--':$info->que_quan}}</div>

                                <div class="clearfix"></div>
                                <div class="bot-border"></div>

                                <div class="col-sm-5 col-xs-6 tital ">Số điện thoại:</div>
                                <div class="col-sm-7">{{$info->sdt==null?'--Trống--':0 . $info->sdt}}</div>

                                <div class="clearfix"></div>
                                <div class="bot-border"></div>

                                <div class="col-sm-5 col-xs-6 tital "></div>
                                <div class="col-sm-7">
                                    <button class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                        Chỉnh sửa
                                    </button>
                                </div>
                        @endif
                        <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (isset($info))
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thay đổi thông tin: {{$user->name==null?'--Trống--':$user->name}}</h4>
                </div>
                <div class="modal-body">

                    <form action="{{route('user.edit')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name">Biệt danh:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{$user->name==null?'':$user->name}}" required>
                        </div>

                        <div class="form-group">
                            <label for="birthday">Sinh nhật:</label>
                            <input type="date" class="form-control" name="sinh_nhat" id="birthday"
                                   value="{{$info->sinh_nhat==null?'':$info->sinh_nhat}}" required>
                        </div>

                        <div class="form-group">
                            <label for="que_quan">Quê quán:</label>
                            <input type="text" class="form-control" name="que_quan" id="que_quan"
                                   value="{{$info->que_quan==null?'':$info->que_quan}}" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_sdt">Số điện thoại:</label>
                            <input type="number" class="form-control" name="edit_sdt" id="sdt"
                                   value="{{$info->sdt==null?'':'0'.$info->sdt}}" required>
                        </div>

                        <div class="col-sm-5 col-xs-6 tital"></div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Thay đổi</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('.mes-page').empty();
            }, 1500);

            $('#profile-image1').on('click', function () {
                $('#profile-image-upload').click();
            });

            $('#profile-image-upload').change(function () {
                if ($(this).val() != '') {
                    upload();
                }
            });

            function closeNotify() {
                setTimeout(function () {
                    $("#alert-notify").empty();
                }, 5000);
            }

            function upload() {
                var file_data = $('#profile-image-upload').prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });
                var img_old = $('#profile-image1').attr('src');
                $('#profile-image1').attr('src', '{{url('/img')}}' + '/' + 'loader.svg');
                $.ajax({
                    url: "{{route('ajax.editImg')}}",
                    data: form_data,
                    type: 'POST',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $('#profile-image1').attr('src', '{{url('/uploads')}}' + '/' + data);
                        $('#alert-notify').append('<div class="alert alert-success alert-dismissable fade in">\n' +
                            '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\n' +
                            '    <strong>Thành công!</strong> Ảnh của bạn đã được thay đổi.\n' +
                            '  </div>');
                        closeNotify();
                    },
                    error: function () {
                        $('#profile-image1').attr('src', img_old);
                        $('#alert-notify').append('<div class="alert alert-danger alert-dismissable fade in">\n' +
                            '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\n' +
                            '    <strong>Cảnh báo!</strong> Ảnh của bạn sai.\n' +
                            '  </div>');
                        closeNotify();
                    }
                });
            }
        });
    </script>
@endsection