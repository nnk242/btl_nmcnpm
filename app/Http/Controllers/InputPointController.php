<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use App\ResultOne;
use App\Teacher;
use App\User;
use App\ClassS;
use App\ResultTwo;
use Auth;
use DB;

class InputPointController extends Controller
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
        //
        $user = User::find(Auth::id());
        if ($user->role == 2) {
            $teacher = Teacher::whereid_gv($user->username)->first();
            $test = json_decode(ResultOne::whereid_gv($teacher->id_mon)->groupby('id_sv')->pluck('id_sv'));
            $id_sv = json_decode(Student::whereIn('id', $test)->groupby('id_lop')->pluck('id_lop'));
            $class = ClassS::whereIn('id', $id_sv)->Orderby('id', 'DESC')->get();

            $id_max_lop = ResultOne::whereId_sv($id_sv)->max('id_lop');

            if ($request->ky && $request->class) {
                $id_student = json_decode(Student::whereid_lop($request->class)->pluck('id'));//id học sinh

//                $all_student = Student::whereid_lop($request->class)->whereIn('id', $id_student)->orderby('ten', 'ASC')->get();
                $id_mon = $teacher->id_mon;
                if (in_array($request->ky, array(1, 2))) {
                    if ($request->ky == 1) {
                        $all_student = Student::whereid_lop($request->class)->whereIn('id', $id_student)->orderby('ten', 'ASC')->with(['resultone' => function ($query) {
                            $query->where('id_gv',
                                (Teacher::whereid_gv((User::find(Auth::id()))->username)->first())->id
                            )->where('id_lop',
                                ResultOne::whereId_sv((
                                json_decode(Student::whereIn('id',
                                    json_decode(ResultOne::whereid_gv((Teacher::whereid_gv(
                                        (User::find(Auth::id()))->username
                                    )->first())->id_mon)->groupby('id_sv')->pluck('id_sv')))->groupby('id_lop')->pluck('id_lop'))
                                ))->max('id_lop')
                            );
                        }])->get();
                        $students = ResultOne::whereIn('id_sv', $id_student)
                            ->wheremon($id_mon)
                            ->whereid_lop($id_max_lop)->get();
                    } else {
                        $all_student = Student::whereid_lop($request->class)->whereIn('id', $id_student)->orderby('ten', 'ASC')->with(['resulttwo' => function ($query) {
                            $query->where('id_gv',
                                (Teacher::whereid_gv((User::find(Auth::id()))->username)->first())->id
                            )->where('id_lop',
                                ResultTwo::whereId_sv((
                                json_decode(Student::whereIn('id',
                                    json_decode(ResultTwo::whereid_gv((Teacher::whereid_gv(
                                        (User::find(Auth::id()))->username
                                    )->first())->id_mon)->groupby('id_sv')->pluck('id_sv')))->groupby('id_lop')->pluck('id_lop'))
                                ))->max('id_lop')
                            );
                        }])->get();
                        $students = ResultTwo::whereIn('id_sv', $id_student)
                            ->wheremon($id_mon)
                            ->whereid_lop($id_max_lop)->get();
                    }
                }
            }
            return view('point.index', compact('class', 'students', 'all_student', 'arr_id', 'id_max_lop', 'id_gv'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $user = User::find(Auth::id());
        $teacher = Teacher::whereid_gv($user->username)->first();
        $id_gv = $teacher->id;
        $mon = $teacher->id_mon;
        if ($user->role == 2) {
            if (in_array($request->ky, array(1, 2))) {
                $kq1 = json_decode(ResultOne::whereid_gv($teacher->id)->pluck('id_sv'));
                $class = ClassS::find($request->class);
                if ($class->lop ==10) {
                    $x = 1;
                } elseif ($class->lop ==11) {
                    $x = 2;
                } elseif ($class->lop ==12) {
                    $x= 3;
                } else {
                    return redirect()->back()->with('er', 'Sai.');
                }
                $id = $request->id;
                $diem_1 = $request->diem_1;
                $diem_2 = $request->diem_2;
                $diem_3 = $request->diem_3;
                $diem_giua_ky = $request->diem_giua_ky;
                $diem_cuoi_ky = $request->diem_cuoi_ky;

                $count_sv = count($id);

                if ($request->ky == 1) {
                     for ($i =0; $i<$count_sv;$i++) {
                         $b = ResultOne::where(
                             [
                                 'id_sv' => $id[$i],
                                 'id_lop' => $x,
                                 'id_gv' => $id_gv
                             ])->first();
                         if (count($b)>0) {
                             $result = ResultOne::find($b->id);
                             $result->diem_1 = $diem_1[$i];
                             $result->diem_2 = $diem_2[$i];
                             $result->diem_3 = $diem_3[$i];
                             $result->diem_giua_ky = $diem_giua_ky[$i];
                             $result->diem_cuoi_ky = $diem_cuoi_ky[$i];
                             if ($result->diem_1 != null && $result->diem_2 != null && $result->diem_3 != null && $result->diem_giua_ky != null && $result->diem_cuoi_ky != null) {
                                 $result->diem_trung_binh = ( $result->diem_1 + $result->diem_2 + $result->diem_3 + ($result->diem_giua_ky*2) + ($result->diem_cuoi_ky)*3 )/8;
                             }
                             $result->save();
                         } else {
                             $result = new ResultOne();
                             $result->mon = $mon;
                             $result->id_gv = $id_gv;
                             $result->id_sv = $id[$i];
                             $result->id_lop = $x;

                             $result->diem_1 = $diem_1[$i];
                             $result->diem_2 = $diem_2[$i];
                             $result->diem_3 = $diem_3[$i];
                             $result->diem_giua_ky = $diem_giua_ky[$i];
                             $result->diem_cuoi_ky = $diem_cuoi_ky[$i];
                             if ($result->diem_1 != null && $result->diem_2 != null && $result->diem_3 != null && $result->diem_giua_ky != null && $result->diem_cuoi_ky != null) {
                                 $result->diem_trung_binh = ( $result->diem_1 + $result->diem_2 + $result->diem_3 + ($result->diem_giua_ky*2) + ($result->diem_cuoi_ky)*3 )/8;
                             }
                             $result->save();
                         }
                     }
                } else {
                    for ($i =0; $i<$count_sv;$i++) {
                        $b = ResultTwo::where(
                            [
                                'id_sv' => $id[$i],
                                'id_lop' => $x,
                                'id_gv' => $id_gv
                            ])->first();
                        if (count($b)>0) {
                            $result = ResultTwo::find($b->id);
                            $result->diem_1 = $diem_1[$i];
                            $result->diem_2 = $diem_2[$i];
                            $result->diem_3 = $diem_3[$i];
                            $result->diem_giua_ky = $diem_giua_ky[$i];
                            $result->diem_cuoi_ky = $diem_cuoi_ky[$i];
                            if ($result->diem_1 != null && $result->diem_2 != null && $result->diem_3 != null && $result->diem_giua_ky != null && $result->diem_cuoi_ky != null) {
                                $result->diem_trung_binh = ( $result->diem_1 + $result->diem_2 + $result->diem_3 + ($result->diem_giua_ky*2) + ($result->diem_cuoi_ky)*3 )/8;
                            }
                            $result->save();
                        } else {
                            $result = new ResultTwo();
                            $result->mon = $mon;
                            $result->id_gv = $id_gv;
                            $result->id_sv = $id[$i];
                            $result->id_lop = $x;

                            $result->diem_1 = $diem_1[$i];
                            $result->diem_2 = $diem_2[$i];
                            $result->diem_3 = $diem_3[$i];
                            $result->diem_giua_ky = $diem_giua_ky[$i];
                            $result->diem_cuoi_ky = $diem_cuoi_ky[$i];
                            if ($result->diem_1 != null && $result->diem_2 != null && $result->diem_3 != null && $result->diem_giua_ky != null && $result->diem_cuoi_ky != null) {
                                $result->diem_trung_binh = ( $result->diem_1 + $result->diem_2 + $result->diem_3 + ($result->diem_giua_ky*2) + ($result->diem_cuoi_ky)*3 )/8;
                            }
                            $result->save();
                        }
                    }
                }
                return redirect()->back()->with('mes', 'Đã thay đổi thành công...');
            } else {
                return redirect()->back()->with('er', 'Kỳ học sai...');
            }
        } else return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajaxKy(Request $request)
    {
        $ky = $request->id;
        if (in_array($ky, array(1, 2))) {
            $user = User::find(Auth::id());
            $teacher = Teacher::whereid_gv($user->username)->first();

            if ($ky == 1) {
                $test = json_decode(ResultOne::whereid_gv($teacher->id_mon)->groupby('id_sv')->pluck('id_sv'));
                $id_sv = json_decode(Student::whereIn('id', $test)->groupby('id_lop')->pluck('id_lop'));
                $class = ClassS::whereIn('id', $id_sv)->Orderby('id', 'DESC')->get();
            } else {
                $test = json_decode(ResultTwo::whereid_gv($teacher->id_mon)->groupby('id_sv')->pluck('id_sv'));
                $id_sv = json_decode(Student::whereIn('id', $test)->groupby('id_lop')->pluck('id_lop'));
                $class = ClassS::whereIn('id', $id_sv)->Orderby('id', 'DESC')->get();
            }
            return $class;
        } else return false;
    }
}
