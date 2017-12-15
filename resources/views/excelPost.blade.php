@extends('layouts.app')
@section('css')
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="form-group">
                <div id="table-test">
                    {!! $su !!}
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" id="export">Export</button>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('js/FileSaver.js')}}"></script>
    <script src="{{asset('js/Blob.js')}}"></script>
    <script src="{{asset('js/xls.core.min.js')}}"></script>

    <script src="{{asset('js/tableexcel.js')}}"></script>
    <script type="text/javascript">
        $("table").tableExport({formats: ["xlsx","xls", "csv"],});
    </script>
@endsection