<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Result;
use App\Student;
use App\ClassS;
use App\ResultOne;
use App\ResultTwo;

class ResultController extends Controller
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
    public function index(Request $request)
    {
        $user = User::find(Auth::id());
        $mhs = $user->username;
        $student = Student::wheremhs($mhs)->first();

        if ($user->role == 1 || $user->role == 2) {
            $class = ClassS::Orderby('id', 'DESC')->get();
            if ($request->class) {
                $students = Student::where('id_lop', $request->class)->orderby('ten', 'ASC')->paginate(10);
            }
            return view('result.index', compact('class', 'students'));
        } else {
            $test = json_decode(ResultOne::whereId_sv($student->id)->groupby('id_lop')->pluck('id_lop'));
            $class = ClassS::whereIn('id', $test)->Orderby('id', 'DESC')->get();
            $lop = ResultOne::whereId_sv($student->id)->max('id_lop');
            if ($request->class && $request->ky) {
                if (in_array($request->class, $test)) {
                    if ($request->ky == 2) {
                        $result = ResultTwo::whereId_sv($student->id)->whereId_lop($request->class)->with('Subject')->get();
                        $dtb_ky = round((ResultTwo::whereId_sv($student->id)->whereId_lop($request->class)->sum('diem_trung_binh')) / 120, 2) * 10;
                    } else {
                        $result = ResultOne::whereId_sv($student->id)->whereId_lop($request->class)->with('Subject')->get();
                        $dtb_ky = round((ResultOne::whereId_sv($student->id)->whereId_lop($request->class)->sum('diem_trung_binh')) / 120, 2) * 10;
                    }
                } else {
                    if ($request->ky == 2) {
                        $result = ResultTwo::whereId_sv($student->id)->whereId_lop($lop)->with('Subject')->get();
                        $dtb_ky = round((ResultTwo::whereId_sv($student->id)->whereId_lop($lop)->sum('diem_trung_binh')) / 120, 2) * 10;
                    } else {
                        $result = ResultOne::whereId_sv($student->id)->whereId_lop($lop)->with('Subject')->get();
                        $dtb_ky = round((ResultOne::whereId_sv($student->id)->whereId_lop($lop)->sum('diem_trung_binh')) / 120, 2) * 10;
                    }
                }
            } else {
                if ($request->ky == 2) {
                    $result = ResultTwo::whereId_sv($student->id)->whereId_lop($lop)->with('Subject')->get();
                    $dtb_ky = round((ResultTwo::whereId_sv($student->id)->whereId_lop($lop)->sum('diem_trung_binh')) / 120, 2) * 10;
                } else {
                    $result = ResultOne::whereId_sv($student->id)->whereId_lop($lop)->with('Subject')->get();
                    $dtb_ky = round((ResultOne::whereId_sv($student->id)->whereId_lop($lop)->sum('diem_trung_binh')) / 120, 2) * 10;
                }
            }

            if ($dtb_ky < 5) {
                $a = 'Kém';
            } elseif ($dtb_ky >= 5 && $dtb_ky <= 6.5) {
                $a = 'Trung bình';
            } elseif ($dtb_ky >= 6.5 && $dtb_ky <= 8) {
                $a = 'Khá';
            } elseif ($dtb_ky > 8) {
                $a = 'Giỏi';
            } else {
                $a = 'Chưa xác định';
            }
            return view('result.show', compact('result', 'dtb_ky', 'a', 'student', 'class'));
        }
}

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public
function create()
{
    //
}

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request $request
 * @return \Illuminate\Http\Response
 */
public
function store(Request $request)
{
    //
    $students = Student::orderby('ten', 'ASC')->get();
    $result = Result::with('User')->paginate(10);
    return view('result.store', compact('result', 'students'));
}

/**
 * Display the specified resource.
 *
 * @param  int $id
 * @return \Illuminate\Http\Response
 */
public
function show($id, Request $request)
{
    $student = Student::find($id);
    $test = json_decode(ResultOne::whereId_sv($student->id)->groupby('id_lop')->pluck('id_lop'));
    $class = ClassS::whereIn('id', $test)->Orderby('id', 'DESC')->get();
    $lop = ResultOne::whereId_sv($id)->max('id_lop');
    if ($request->ky == 2) {
        $result = ResultTwo::whereId_sv($id)->whereId_lop($lop)->with('Subject')->get();
        $dtb_ky = round((ResultTwo::whereId_sv($id)->whereId_lop($lop)->sum('diem_trung_binh')) / 120, 2) * 10;
    } else {
        $result = ResultOne::whereId_sv($id)->whereId_lop($lop)->with('Subject')->get();
        $dtb_ky = round((ResultOne::whereId_sv($id)->whereId_lop($lop)->sum('diem_trung_binh')) / 120, 2) * 10;
    }
    if ($dtb_ky < 5) {
        $a = 'Kém';
    } elseif ($dtb_ky >= 5 && $dtb_ky <= 6.5) {
        $a = 'Trung bình';
    } elseif ($dtb_ky >= 6.5 && $dtb_ky <= 8) {
        $a = 'Khá';
    } elseif ($dtb_ky > 8) {
        $a = 'Giỏi';
    } else {
        $a = 'Chưa xác định';
    }
    return view('result.show', compact('result', 'dtb_ky', 'a', 'student', 'class'));
}

/**
 * Show the form for editing the specified resource.
 *
 * @param  int $id
 * @return \Illuminate\Http\Response
 */
public
function edit($id)
{
    //
}

/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request $request
 * @param  int $id
 * @return \Illuminate\Http\Response
 */
public
function update(Request $request, $id)
{
    //
}

/**
 * Remove the specified resource from storage.
 *
 * @param  int $id
 * @return \Illuminate\Http\Response
 */
public
function destroy($id)
{
    //
}

public
function search(Request $request)
{
    $keyword = $request->keyword;
    if ($request->type == 'student') {
        $responses = Student::select('ho_ten_dem', 'ten')
            ->where('ten', 'like', '%' . $keyword . '%')
            ->orwhere('ho_ten_dem', '%' . $keyword . '%')
            ->with('Lop')
            ->limit(10)
            ->get();
        return response()->json($responses);

    } else {
        $keyword = $request->q;
        $class = ClassS::Orderby('id', 'DESC')->get();
        $students = Student::where('ten', 'like', '%' . $keyword . '%')
            ->orwhere('ho_ten_dem', '%' . $keyword . '%')
            ->orderby('ten', 'ASC')
            ->paginate(10);
        return view('result.search', compact('class', 'students'));
    }
}
}
