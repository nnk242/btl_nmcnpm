@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <form method="POST" action="{{route('excel.post')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    {{--<label class="btn btn-default" for="file">--}}
                        {{--Chọn file--}}
                    {{--</label>--}}
                    <input id="file" type="file" required name="file">
                </div>
                <button type="submit" class="btn btn-danger">Submit</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('js/tableexcel.js')}}"></script>
@endsection