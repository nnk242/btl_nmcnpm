@extends('layouts.app')

@section('css')
    <link href="{{asset('selectize/css/bootstrap2.css')}}" rel="stylesheet"/>
    <link href="{{asset('selectize/css/bootstrap3.css')}}" rel="stylesheet"/>
    <link href="{{asset('selectize/css/selectize.css')}}" rel="stylesheet"/>
    <link href="{{asset('selectize/css/default.css')}}" rel="stylesheet"/>
    <link href="{{asset('selectize/css/legacy.css')}}" rel="stylesheet"/>
@endsection

@section('content')

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
                            <h2>Danh sách lớp</h2>
                            <hr>
                            <div class="col-md-6">
                                <form class="form-inline" method="Get">
                                    <div class="form-group">
                                        <label for="sel1">Chọn lớp:</label>
                                        <select class="form-control" id="sel1" name="class">
                                            @foreach($class as $val)
                                                <option value="{{$val->id}}" @if(isset($students))@if(isset($_GET['class'])){{$_GET['class'] == $val->id?'selected':''}}@endif @endif>{{'Khóa '.$val->khoa . ' - Lớp ' . $val->lop}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-success">Xem danh sách lớp</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div id="search-form-story" class="form-inline" style="float: right">
                                    <select style="width: 290px;" id="story-search" type="text"
                                            placeholder="Tìm kiếm..." aria-label="Search"></select>
                                    <button class="btn btn-outline-success story-cursor" id="search-story" type="submit"
                                            style="float: right"><i
                                                class="fa fa-search"></i>&nbsp;&nbsp;Tìm...
                                    </button>
                                </div>
                            </div>
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
                                        <th>Quê quán</th>
                                        <th>Sinh nhật</th>
                                        <th>Số điện thoại</th>
                                        <th>Xem chi tiết điểm</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($students as $key=>$student)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$student->ho_ten_dem}}</td>
                                            <td>{{$student->ten}}</td>
                                            <td>{{$student->que_quan?$student->que_quan: '--Trống--'}}</td>
                                            <td>{{$student->sinh_nhat?$student->sinh_nhat: '--Trống--'}}</td>
                                            <td>{{$student->sdt?$student->sdt: '--Trống--'}}</td>
                                            <td><a href="{{url('result/show') . '/' . $student->id}}"
                                                   title="Xem điểm của {{$student->ho_ten_dem. ' ' . $student->ten}}"><span
                                                            class="fa fa-street-view"></span></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {!! $students->appends(request()->except('page'))->links() !!}
                            </div>
                    @endif
                    <!-- /.box -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{--selectize--}}
    <script src="{{asset('selectize/js/standalone/selectize.js')}}"></script>

    <script src="{{asset('selectize/js/selectize.js')}}"></script>

    <script type="text/javascript">
        $('#story-search').selectize({
            valueField: 'ten',
            labelField: 'ten',
            searchField: ['ho_ten_dem', 'ten'],
            create: true,
            maxItems: 1,
            maxOptions: 10,
            render: {
                option: function (item, escape) {
                    return '<div>' +
                        '<span class="title">' +
                        '<span class="name">' + escape(item.ho_ten_dem) + ' ' + escape(item.ten) + '</span>' +
                        '</span>' +
                        '</div>';
                }
            },
            load: function (query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '/result/search?type=student&keyword=' + encodeURIComponent(query),
                    type: 'GET',
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res);
                    }
                });
            },
        });
        $(document).on('click', '#search-story', function () {
            var val = $('#story-search').val();
            console.log(val)
            $(location).attr('href', '{{url('result/search?q=')}}' + val);
        });
    </script>
@endsection
