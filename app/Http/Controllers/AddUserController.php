<?php

namespace App\Http\Controllers;

use App\ClassS;
use App\Student;
use Illuminate\Http\Request;
use App\Role;
use App\User;
use Auth;
use Validator;

class AddUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::id() == 1) {
            $all_users = User::where('id','<>', 1)->where('role', '<>', 1)->orderby('username', 'ASC')->paginate(10);
            $roles = Role::where('id', '<>', 1)->get();
        } else {
            $roles = Role::where('id', '<>', 1)->where('id', '<>', 4)->get();
            $all_users = User::where('id','<>', 1)->where('role', '<>', 1)->where('role', '<>', 4)->paginate(10);
        }
        $class = ClassS::orderby('id', 'DESC')->get();
        return view('adduser.index', compact('roles', 'class', 'all_users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:30|unique:users',
            'password' => 'required|string|min:5|max:64',
            'role' => 'required'
        ],[
            'name.required' => 'Biệt danh không được để trống',
            'name.string' => 'biệt danh không được có ký tự đặc biệt',
            'name.max' => 'Biệt danh tối đa 255 ký tự',
            'username.required' => 'Tên tài khoản không được để trống',
            'username.min' => 'Tên tài khoản phải có từ 3-30 ký tự',
            'username.max' => 'Tên tài khoản phải có từ 3-30 ký tự',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có từ 5-64 ký tự',
            'password.max' => 'Mật khẩu phải có từ 5-64 ký tự',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();
        return redirect()->back()->with('mes', 'Thêm tài khoản thành công');
    }

    public function studentCreate (Request $request) {
        $validator = Validator::make($request->all(), [
            "ho_ten_dem" => 'required',
            "ho_ten_dem.*" => 'required|min:3|max:30',
            "ten" => 'required',
            "ten.*" => 'required|min:3|max:30',
            'lop' => 'required',
            'lop.*' => 'required',
            'sinh_nhat' => 'required',
            'sinh_nhat.*' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('er', 'Có lỗi khi bạn nhập');;
        } else {
            $count_student = count($request->ho_ten_dem);
            $x = Student::max('id');
            for ($i = 0; $i<$count_student;$i++) {
                $student = new Student();
                $user = new User();

                $strlen_i = strlen($x);
                if ($strlen_i == 0) {
                    $k= '0000';
                } elseif ($strlen_i == 1) {
                    $k = '000' . $x;
                } elseif ($strlen_i == 2) {
                    $k = '00' .$x;
                } elseif ($strlen_i == 3) {
                    $k = '0' . $x;
                } else {
                    $k = $x;
                }

                $mhs = $request->lop[$i] . $k;
                $pass = $mhs . str_replace('-', '', $request->sinh_nhat[$i]);

                $student->mhs = $mhs;
                $student->ho_ten_dem = $request->ho_ten_dem[$i];
                $student->ten = $request->ten[$i];
                $student->id_lop = $request->lop[$i];
                $student->sinh_nhat = $request->sinh_nhat[$i];
                $student->save();

                $user->name = $request->ten[$i];
                $user->username = $mhs;
                $user->password = bcrypt($pass);
                $user->role = 3;
                $user->save();

                $x++;
            }
            return redirect()->back()->with('mes', 'Thêm sinh viên thành công');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if ($id == 1) {
            return redirect()->back()->with('er', 'Bạn không thể thực hiện được xin kiểm tra lại...');
        } else {
            $user = User::find($id);
            $user->delete();
            return redirect()->back()->with('mes', 'Xóa thành công.');
        }
    }
}
