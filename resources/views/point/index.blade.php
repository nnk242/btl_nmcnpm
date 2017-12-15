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
                            <h2>Danh sách lớp nhập điểm</h2>
                            <hr>
                            <form class="form-inline" method="Get">
                                <div class="form-group">
                                    <img id="profile-image1" src="{{url('/img/loader.svg')}}">
                                    <div id="notify">
                                    </div>
                                    <label for="ky">Chọn kỳ học:</label>
                                    <select class="form-control" id="ky" name="ky">
                                        <option value="1" @if(isset($_GET['ky'])){{$_GET['ky'] == 1? 'selected':''}}@endif>
                                            Kỳ học 1
                                        </option>
                                        <option value="2" @if(isset($_GET['ky'])){{$_GET['ky'] == 2? 'selected':''}}@endif>
                                            Kỳ học 2
                                        </option>
                                    </select>
                                    <label for="sel1">Chọn lớp:</label>
                                    <select class="form-control" id="sel1" name="class">
                                        <option id="add">---Lựa chọn---</option>
                                        @foreach($class as $val)
                                            <option class="element-class"
                                                    value="{{$val->id}}" @if(isset($students))@if(isset($_GET['class'])){{$_GET['class'] == $val->id?'selected':''}}@endif @endif>{{'Khóa '.$val->khoa . ' - Lớp ' . $val->lop}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Xem danh sách lớp</button>
                                <button type="button" class="btn btn-default" data-toggle="modal"
                                        data-target="#myModal">Nhập điểm
                                </button>
                            </form>
                        </div>
                        @if(isset($students))
                            <hr>
                            <div class="box-body">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Họ và tên đệm</th>
                                        <th>Tên</th>
                                        <th>Điểm 1</th>
                                        <th>Điểm 2</th>
                                        <th>Điểm 3</th>
                                        <th>Điểm giữa kỳ</th>
                                        <th>Điểm cuối kỳ</th>
                                        <th>Điểm trung bình</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (isset($_GET['ky']))
                                        @if (in_array($_GET['ky'], array(1,2)))
                                            @if(isset($all_student))
                                                @foreach($all_student as $key=>$val)
                                                    @if ($_GET['ky']==1)
                                                        @if ( count($val->resultone)==0)
                                                            <tr data-id="{{$val->id}}">
                                                                <td>{{$key+1}}</td>
                                                                <td>{{$val->ho_ten_dem}}</td>
                                                                <td>{{$val->ten}}</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @else
                                                            @foreach($val->resultone as $a)
                                                                {{--@if($a->id_lop == $id_max_lop && $a->id_gv == $id_gv)--}}
                                                                <tr data-id="{{$val->id}}">
                                                                    <td>{{$key+1}}</td>
                                                                    <td>{{$val->ho_ten_dem}}</td>
                                                                    <td>{{$val->ten}}</td>
                                                                    <td>{{$a->diem_1}}</td>
                                                                    <td>{{$a->diem_2}}</td>
                                                                    <td>{{$a->diem_3}}</td>
                                                                    <td>{{$a->diem_giua_ky}}</td>
                                                                    <td>{{$a->diem_cuoi_ky}}</td>
                                                                    <td>{{$a->diem_trung_binh}}</td>
                                                                </tr>
                                                                {{--@endif--}}
                                                            @endforeach
                                                        @endif
                                                    @else
                                                        @if ( count($val->resulttwo)==0)
                                                            <tr data-id="{{$val->id}}">
                                                                <td>{{$key+1}}</td>
                                                                <td>{{$val->ho_ten_dem}}</td>
                                                                <td>{{$val->ten}}</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @else
                                                            @foreach($val->resulttwo as $a)
                                                                {{--@if($a->id_lop == $id_max_lop && $a->id_gv == $id_gv)--}}
                                                                <tr data-id="{{$val->id}}">
                                                                    <td>{{$key+1}}</td>
                                                                    <td>{{$val->ho_ten_dem}}</td>
                                                                    <td>{{$val->ten}}</td>
                                                                    <td>{{$a->diem_1}}</td>
                                                                    <td>{{$a->diem_2}}</td>
                                                                    <td>{{$a->diem_3}}</td>
                                                                    <td>{{$a->diem_giua_ky}}</td>
                                                                    <td>{{$a->diem_cuoi_ky}}</td>
                                                                    <td>{{$a->diem_trung_binh}}</td>
                                                                </tr>
                                                                {{--@endif--}}
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                    @endif
                    <!-- /.box -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{route('point.edit')}}">
                {{ csrf_field() }}
                <input type="text" value="{{isset($_GET['ky'])?$_GET['ky']:''}}" name="ky" hidden>
                <input type="text" value="{{isset($_GET['class'])?$_GET['class']:''}}" name="class" hidden>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Nhập điểm</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Họ và tên đệm</th>
                                <th>Tên</th>
                                <th>Điểm 1</th>
                                <th>Điểm 2</th>
                                <th>Điểm 3</th>
                                <th>Điểm giữa kỳ</th>
                                <th>Điểm cuối kỳ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (isset($_GET['ky']))
                                @if (in_array($_GET['ky'], array(1,2)))
                                    @if(isset($all_student))
                                        @foreach($all_student as $key=>$val)
                                            @if ($_GET['ky'] == 1)
                                                @if ( count($val->resultone)==0)
                                                    <input value="{{$val->id}}" type="text" name="id[]" hidden>
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$val->ho_ten_dem}}</td>
                                                        <td>{{$val->ten}}</td>
                                                        <td><input class="form-control" value=""
                                                                   type="number"
                                                                   min="0" max="10" name="diem_1[]"
                                                                   placeholder="Nhập điểm 1"></td>
                                                        <td><input class="form-control" value=""
                                                                   type="number" placeholder="Nhập điểm 2"
                                                                   min="0" max="10" name="diem_2[]"></td>
                                                        <td><input class="form-control" value=""
                                                                   type="number" placeholder="Nhập điểm 3"
                                                                   min="0" max="10" name="diem_3[]"></td>
                                                        <td><input class="form-control"
                                                                   value=""
                                                                   type="number" min="0" max="10"
                                                                   name="diem_giua_ky[]"
                                                                   placeholder="Nhập điểm giữa kỳ">
                                                        </td>
                                                        <td><input class="form-control"
                                                                   value=""
                                                                   type="number" min="0" max="10"
                                                                   name="diem_cuoi_ky[]"
                                                                   placeholder="Nhập điểm cuối kỳ">
                                                        </td>
                                                    </tr>
                                                @else
                                                    @foreach($val->resultone as $a)
                                                        <input value="{{$val->id}}" type="text" name="id[]" hidden>
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{$val->ho_ten_dem}}</td>
                                                            <td>{{$val->ten}}</td>
                                                            <td><input class="form-control" value="{{$a->diem_1}}"
                                                                       type="number" placeholder="Nhập điểm 1"
                                                                       min="0" max="10" name="diem_1[]"></td>
                                                            <td><input class="form-control" value="{{$a->diem_2}}"
                                                                       type="number" placeholder="Nhập điểm 2"
                                                                       min="0" max="10" name="diem_2[]"></td>
                                                            <td><input class="form-control" value="{{$a->diem_3}}"
                                                                       type="number" placeholder="Nhập điểm 3"
                                                                       min="0" max="10" name="diem_3[]"></td>
                                                            <td><input class="form-control" value="{{$a->diem_giua_ky}}"
                                                                       type="number" min="0" max="10"
                                                                       name="diem_giua_ky[]"
                                                                       placeholder="Nhập điểm giữa kỳ">
                                                            </td>
                                                            <td><input class="form-control" value="{{$a->diem_cuoi_ky}}"
                                                                       type="number" min="0" max="10"
                                                                       name="diem_cuoi_ky[]"
                                                                       placeholder="Nhập điểm cuối kỳ">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @else

                                                @if ( count($val->resulttwo)==0)
                                                    <input value="{{$val->id}}" type="text" name="id[]" hidden>
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$val->ho_ten_dem}}</td>
                                                        <td>{{$val->ten}}</td>
                                                        <td><input class="form-control" value=""
                                                                   type="number"
                                                                   min="0" max="10" name="diem_1[]"
                                                                   placeholder="Nhập điểm 1"></td>
                                                        <td><input class="form-control" value=""
                                                                   type="number" placeholder="Nhập điểm 2"
                                                                   min="0" max="10" name="diem_2[]"></td>
                                                        <td><input class="form-control" value=""
                                                                   type="number" placeholder="Nhập điểm 3"
                                                                   min="0" max="10" name="diem_3[]"></td>
                                                        <td><input class="form-control"
                                                                   value=""
                                                                   type="number" min="0" max="10"
                                                                   name="diem_giua_ky[]"
                                                                   placeholder="Nhập điểm giữa kỳ">
                                                        </td>
                                                        <td><input class="form-control"
                                                                   value=""
                                                                   type="number" min="0" max="10"
                                                                   name="diem_cuoi_ky[]"
                                                                   placeholder="Nhập điểm cuối kỳ">
                                                        </td>
                                                    </tr>
                                                @else
                                                    @foreach($val->resulttwo as $a)
                                                        <input value="{{$val->id}}" type="text" name="id[]" hidden>
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{$val->ho_ten_dem}}</td>
                                                            <td>{{$val->ten}}</td>
                                                            <td><input class="form-control" value="{{$a->diem_1}}"
                                                                       type="number" placeholder="Nhập điểm 1"
                                                                       min="0" max="10" name="diem_1[]"></td>
                                                            <td><input class="form-control" value="{{$a->diem_2}}"
                                                                       type="number" placeholder="Nhập điểm 2"
                                                                       min="0" max="10" name="diem_2[]"></td>
                                                            <td><input class="form-control" value="{{$a->diem_3}}"
                                                                       type="number" placeholder="Nhập điểm 3"
                                                                       min="0" max="10" name="diem_3[]"></td>
                                                            <td><input class="form-control" value="{{$a->diem_giua_ky}}"
                                                                       type="number" min="0" max="10"
                                                                       name="diem_giua_ky[]"
                                                                       placeholder="Nhập điểm giữa kỳ">
                                                            </td>
                                                            <td><input class="form-control" value="{{$a->diem_cuoi_ky}}"
                                                                       type="number" min="0" max="10"
                                                                       name="diem_cuoi_ky[]"
                                                                       placeholder="Nhập điểm cuối kỳ">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Thay đổi</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#ky').on('change', function () {
                var id = $(this).val();
                $('#profile-image1').css({'display': 'block'});
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.ky') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': id
                    },
                    dataType: 'JSON',
                    success: function (rsp) {
                        var length = rsp.length;
                        $('.element-class').remove();
                        for (var i = 0; i < length; i++) {
                            $('#add').parent().append('<option class="element-class" value="' + rsp[i]['id'] + '">Khóa ' + rsp[i]['khoa'] + ' - Lớp ' + rsp[i]['lop'] + '</option>\n')
                        }
                        $('#profile-image1').css({'display': 'none'});
                    },
                    error: function () {
                        $('#profile-image1').css({'display': 'none'});
                        $('#notify').append('<div class="alert alert-danger">\n' +
                            '<strong>Lỗi!</strong> Tải Kỳ học thất bại.\n' +
                            '</div>');
                        setTimeout(function () {
                            $("#notify").empty();
                        }, 5000);
                    }
                });
            });
            setTimeout(function () {
                $('.mes-page').empty();
            }, 1500);
        });
    </script>
@endsection