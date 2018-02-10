<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Services\Admin\AdminUser;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator, Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/Index/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_service = new AdminUser();
        $this->middleware('guest', ['except' => 'logout']);
    }
    /**
     * 重写登录视图页面
     * @author 晚黎
     * @date   2016-09-05T23:06:16+0800
     * @return [type]                   [description]
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
    /**
     * 自定义认证驱动
     * @author 晚黎
     * @date   2016-09-05T23:53:07+0800
     * @return [type]                   [description]
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }

    public function username()
    {
        return 'name';
    }

    public function login(\Illuminate\Http\Request $request)
    {

        $validator = Validator::make($data = $request->all(),
            [
                'name' => 'required', 'password' => 'required',
            ],
            [
                'name.required'=>'请输入用户名',
                'password.required'=>'请输入密码'
            ]
        );

        if ($validator->fails()) {
            $msg = $validator->messages()->first();
            return $this->showWarning($msg);
        }
        $res = $this->_service->login($request->name, $request->password);
        if($res) {
            redirect('/admin/login');
        }else{
            $msg = $this->_service->getMsg();
            $this->showWarning($msg);
        }

        return redirect('/admin');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');

    }
}
