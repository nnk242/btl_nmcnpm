<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class ExcelController extends Controller
{
    //
    public function index()
    {
        return view('excel');
    }

    public function post(Request $request)
    {
        $file = File::get($request->file);
        $sub1 = substr($file,strpos($file, '<body>') + strlen('<body>'));
        $su = substr($sub1,0,strpos($sub1, '</body>'));
        return view('excelPost', compact('su'));
    }
}
