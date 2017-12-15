<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifyController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $user = User::find(Auth::id());
        $student = Student::where('mhs',$user->username)->first();

        if ($student != null) {
            $id_student = $student->id;

            $resultone = ResultOne::where('id_sv', $id_student)->get();
            $resulttwo = ResultTwo::where('id_sv', $id_student)->get();

            $day_one = array();
            $day_two = array();

            foreach ($resultone as $val) {
                $day_one[] = $val->created_at;
            }

            foreach ($resulttwo as $val) {
                $day_two[] = $val->created_at;
            }
//
            foreach ($day_one as $val) {
                $notify_one = ResultOne::where('updated_at', $val)->get();
            }

            foreach ($day_two as $val) {
                $notyfy_two = ResultOne::where('updated_at', $val)->get();
            }
        }

        return view('layouts.notify', compact('notify_one', 'notyfy_two'));

    }
}
