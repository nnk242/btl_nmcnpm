<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Auth;
use File;
use App\Http\Requests;
use App\Teacher;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());
        if ($user->role == 2) {
            $info = Teacher::whereid_gv($user->username)->first();
        } elseif($user->role == 3) {
            $info = Student::wheremhs($user->username)->first();
        }
        return view('home', compact('user', 'info'));
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'sinh_nhat' => 'required|date',
            'que_quan' => 'required|min:3|max:50',
            'edit_sdt' => 'required|min:9|max:11',
        ], [
            'name.required' => 'Trường tên hoặc biệt danh không được bỏ trống',
            'sinh_nhat.date' => 'Trường sinh nhật phải là ngày',
            'que_quan.required'=> 'Trường quê quán không được bỏ trống',
            'que_quan.min' => 'Trường quê quán phải có từ 3-50 ký tự',
            'que_quan.max' => 'Trường quê quán phải có từ 3-50 ký tự',
            'edit_sdt.required' => 'Trường số điện thoại không được bỏ trống',
            'edit_sdt.min' => 'Trường số điện thoại phải có từ 9-11 số ký tự',
            'edit_sdt.max' => 'Trường số điện thoại phải có từ 9-11 số ký tự'
        ]);
        $user = User::find(Auth::id());
        if ($user->role == 2) {
            $info = Teacher::whereid_gv($user->username)->first();
            if ($info==null) {
                return redirect()->route('home')->with('er', 'Không thể thay đổi...');
            }
        } elseif($user->role == 3) {
            $info = Student::where('mhs',$user->username)->first();
            if ($info==null) {
                return redirect()->route('home')->with('er', 'Không thể thay đổi...');
            }
        }
        $info->que_quan = $request->que_quan;
        $info->sinh_nhat = $request->sinh_nhat;
        $info->sdt = $request->edit_sdt;
        $info->save();

        $user->name = $request->name;
        $user->save();
        return redirect()->route('home')->with('mes', 'Đã thay đổi thành công...');
    }

    public function ajaxEditImg(Request $request)
    {
//        return $request->all(); 'image' => 'image|mimes:jpg,png|max:5000',
        $validator = Validator::make($request->all(),
            [
                'file' => 'image',
            ],
            [
                'file.image' => 'Ảnh phải có đuôi (jpeg, png, bmp, gif, hoặc svg)'
            ]);
        if ($validator->fails()) {
            return Response::json(['error' => 'Error msg'], 404);
        } else {
            $extension = $request->file('file')->getClientOriginalExtension();
            $dir = 'uploads/';
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $request->file('file')->move($dir, $filename);
            $user_img = User::find(Auth::id());
            File::delete('uploads/' . $user_img->image);
            $user_img->image = $filename;
            $user_img->save();
            return $filename;
        }
    }

}
