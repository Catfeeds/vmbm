<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Validator, Auth,Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showChangeForm()
    {
        return view('admin.auth.change');
    }

    public function changePassword(\Illuminate\Http\Request $request)
    {

        $validator = Validator::make($data = $request->all(),
            [
                'old_passwprd' => 'required', 'password' => 'required','password_confirmation'=> 'required'
            ],
            [
                'old_passwprd.required'=>'请输入原密码',
                'password.required'=>'请输入密码',
                'password_confirmation.required'=>'请输入确认密码',
            ]
        );
        if ($validator->fails()) {
            $msg = $validator->messages()->first();
            return $this->showWarning($msg);
        }

        $user = Auth::guard('admin')->user();
        $oldpassword = $request->input('old_passwprd');
        $newpassword = $request->input('password');
        $password_confirmation= $request->input('password_confirmation');

        if($newpassword!=$password_confirmation){
            return $this->showWarning("两次密码一直");
        }

        if(!Hash::check($oldpassword, $user->password)){
            return $this->showWarning("原密码不正确");
        }

        $user->password = bcrypt($newpassword);
        $result = $user->save();

        if($result){
            return $this->showMessage("修改成功");
        }else{
            return $this->showWarning("修改密码失败");
        }
    }
}
