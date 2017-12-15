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
                            <div class="col-md-12">
                                <h2>Học sinh: {{$student->ho_ten_dem . ' ' . $student->ten}}</h2>
                                <div class="form-group">
                                    <small>Bạn đang xem điểm kỳ {{isset($_GET['ky'])?(in_array($_GET['ky'], array(1,2))?$_GET['ky']:1):1}}</small>
                                </div>
                            </div>

                                <div id="search-form-story" class="form-inline" style="float: right">
                                    <select style="width: 290px;" id="story-search" type="text"
                                            placeholder="Tìm kiếm..." aria-label="Search"></select>
                                    <button class="btn btn-outline-success story-cursor" id="search-story" type="submit" style="float: right"><i
                                                class="fa fa-search"></i>&nbsp;&nbsp;Tìm...
                                    </button>
                                </div>
                            <hr>
                            <form class="form-inline">
                                <div class="form-group">
                                    <label for="sel1">Chọn lớp:</label>
                                    <select class="form-control" id="sel1" name="class">
                                        @foreach($class as $val)
                                            <option value="{{$val->id}}" @if(isset($student))@if(isset($_GET['class'])){{$_GET['class'] == $val->id?'selected':''}}@endif @endif>{{'Khóa '.$val->khoa . ' - Lớp ' . $val->lop}}</option>
                                        @endforeach
                                    </select>

                                    <label for="sel1">Chọn kỳ học:</label>
                                    <select class="form-control" id="sel1" name="ky">
                                        <option value="1" @if(isset($_GET['ky'])){{$_GET['ky'] == 1? 'selected':''}}@endif>Kỳ học 1</option>
                                        <option value="2" @if(isset($_GET['ky'])){{$_GET['ky'] == 2? 'selected':''}}@endif>Kỳ học 2</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Thực hiện</button>
                            </form>

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Môn</th>
                                    <th>Điểm 1</th>
                                    <th>Điểm 2</th>
                                    <th>Điểm 3</th>
                                    <th>Điểm giữa kỳ</th>
                                    <th>Điểm cuối kỳ</th>
                                    <th>Điểm trung bình</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($result as $key=>$val)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$val->Subject->mon}}</td>
                                        <td>{{isset($val->diem_1)?$val->diem_1:'--Chưa có--'}}</td>
                                        <td>{{isset($val->diem_2)?$val->diem_2:'--Chưa có--'}}</td>
                                        <td>{{isset($val->diem_3)?$val->diem_3:'--Chưa có--'}}</td>
                                        <td>{{isset($val->diem_giua_ky)?$val->diem_giua_ky:'--Chưa có--'}}</td>
                                        <td>{{isset($val->diem_cuoi_ky)?$val->diem_cuoi_ky:'--Chưa có--'}}</td>
                                        <td>{{isset($val->diem_trung_binh)?$val->diem_trung_binh:'--Chưa có--'}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <h4>Điểm trung bình kỳ này là: {{$dtb_ky}}</h4><small>Xếp loại: {{$a}}</small>
                        </div>
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
                option: function(item, escape) {
                    return '<div>' +
                        '<span class="title">' +
                        '<span class="name">' + escape(item.ho_ten_dem) + ' ' + escape(item.ten) + '</span>' +
                        '</span>' +
                        '</div>';
                }
            },
            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '/result/search?type=student&keyword=' + encodeURIComponent(query),
                    type: 'GET',
                    error: function() {
                        callback();
                    },
                    success: function(res) {
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

