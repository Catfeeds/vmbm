<?php

namespace App\Http\Controllers\Web;


use App\Models\UserInfoModel;
use Auth;

class AuthController extends Controller
{


    public function test(){
        $user = UserInfoModel::find(1);
        Auth::login($user);
        dd(Auth::user());

//        return $this->error(ErrorCode::SAVE_USER_FAILED);
        return $this->api(['test' => 'test']);
    }


}
