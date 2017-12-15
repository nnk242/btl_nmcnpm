@extends('layouts.app')

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
                            <h2>Sinh Viên</h2>
                            <div class="form-group">
                                <small>Bạn muốn xem danh sách sinh viên???</small>
                            </div>
                            <form class="form-inline" action="/action_page.php">
                                <div class="form-group">
                                    <label for="sel1">Select list (select one):</label>
                                    <select class="form-control" id="sel1">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sel1">Select list (select one):</label>
                                    <select class="form-control" id="sel1">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-default">Submit</button>
                            </form>

                            {{--<table class="table table-hover">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>STT</th>--}}
                                    {{--<th>Họ</th>--}}
                                    {{--<th>Điểm 1</th>--}}
                                    {{--<th>Điểm 2</th>--}}
                                    {{--<th>Điểm giữa kỳ</th>--}}
                                    {{--<th>Điểm trung bình</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--@foreach($students as $key=>$student)--}}
                                    {{--<tr>--}}
                                        {{--<td>{{$key+1}}</td>--}}
                                        {{--<td>Toán</td>--}}
                                        {{--<td>10</td>--}}
                                        {{--<td>9</td>--}}
                                        {{--<td>8</td>--}}
                                        {{--<td>8.75</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        </div>
                        <!-- /.box -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
