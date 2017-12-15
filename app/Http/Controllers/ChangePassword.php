<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use Hash;
use App\User;

class ChangePassword extends Controller
{
    //

    private function adminCredentialRules(array $data)
    {
        $messages = [
            'current-password.required' => 'Please enter current password',
            'password.required' => 'Please enter password',
        ];

        $validator = Validator::make($data, [
            'current-password' => 'required',
            'password' => 'required|same:password',
            'password_confirmation' => 'required|same:password',
        ], $messages);

        return $validator;
    }

    public function postCredentials(Request $request)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        if(Auth::Check())
        {
            $request_data = $request->All();
            $validator = $this->adminCredentialRules($request_data);
            if($validator->fails())
            {
                return redirect()->back()->with('er', 'Bạn hãy xem lại!');
            }
            else
            {
                $current_password = Auth::User()->password;
                if(Hash::check($request_data['current-password'], $current_password))
                {
                    $obj_user = User::find(Auth::id());
                    $obj_user->password = Hash::make($request_data['password']);;
                    $obj_user->save();
                    return redirect()->back()->with('mes', 'Đã thay đổi thành công!');
                }
                else
                {
                    return redirect()->back()->with('er', 'Bạn hãy xem lại!');
                }
            }
        }
        else
        {
            return redirect()->back();
        }
    }
}
