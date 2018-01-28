<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Merchant;
use App\Models\MemberMerchant;
use App\Models\UserBanks;
use App\Models\Setting;

use Illuminate\Http\Request;
//use App\Http\HelperTraits\AttachmentHelper;
use App\Services\Base\ErrorCode;
use App\User;
use Illuminate\Support\Facades\Hash;
use Validator, Auth, Cache;

class AuthController extends Controller
{

    private $expireTime     = 1;
    private $keySmsCode     = 'auth:sms:';
    private $keySmsCodeExist     = 'auth:sms:exist';
    private $expireTimeExist     = 24*60;

    public function test(){
//        return $this->error(ErrorCode::SAVE_USER_FAILED);
        return $this->api(['test' => 'test']);
    }
//    /**
//     * @api {post} /api/auth/login 登陆（login）
//     * @apiDescription 登陆(login)
//     * @apiGroup Auth
//     * @apiPermission none
//     * @apiVersion 0.1.0
//     * @apiParam {string}  phone   手机号码
//     * @apiParam {int} type 类型－1.用户，2.商户
//     * @apiParam {string} password   password
//     * @apiSuccessExample {json} Success-Response:
//     * HTTP/1.1 200 OK
//     * {
//     *     "state": true,
//     *     "code": 0,
//     *     "message": "",
//     *     "data": {
//     *         "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjdjYWUyYzFmYTUwMTIyZDI0ZTRiYTZhZGZhNmQxYmZlOWNiMzIxMTBmYWJlZjNjYzIyNmViZjRmNGExNWM3NjllNmU2ZTNiYWE5OGNhOWUzIn0.eyJhdWQiOiIxIiwianRpIjoiN2NhZTJjMWZhNTAxMjJkMjRlNGJhNmFkZmE2ZDFiZmU5Y2IzMjExMGZhYmVmM2NjMjI2ZWJmNGY0YTE1Yzc2OWU2ZTZlM2JhYTk4Y2E5ZTMiLCJpYXQiOjE0NzU0MTE1NTgsIm5iZiI6MTQ3NTQxMTU1OCwiZXhwIjo0NjMxMDg1MTU4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.E9YGEzuRUOk02aV1EiWLJ_pD0hKoCyW0k_sGy63hM3u5X8K_HI1kVhaU6JNLqLZeszIAroTEDB8XMgZKAqTLlwtL8PLCJcuDoxfk1BRHbfjhDheTsahBysKGalvNEpzRCrGlao0mS0Cg9qDpEsndtypPFS8sfaflToOzbJjiSK2DvQiHSH8xZI3zHJTezgZMz-pB_hPTxp8ajdv0ve1gWtWjs3vERr0Y91X4hngO8X7LuXtAYtfxGZRIye12YE7TuLBMYzj8CCfiRt7Smhyf4palNW5mzKlZpa2l87n6NQ14Iy4oMzQ2PON1j_swrosuE2yZohGOn6fDdSCBRdJ6dLD_emjBdQCQOoB63R7BbhFZgvFX25TjzFJ7r9AdVMiGmebuRKEVSZV_JCGu1C71OIbQk-UK35s00gSr2fmJGBbN2cZTXBRTJpfuMZ_ihFYEZrvVq_Ih2X0xkd36JUuxaUld1BXRgPZvH-9jBuhe0YW2OOlgwpdm6ZB8BMcuS4ftLoi6FipgzFqfIuy-0ZqPMDnJaG7Gycrdpxza00mgOFxYxJtqwZNsUWFRZEVU881l6VC_cy294YXSPQxUwEoyKg-G5Pm8AEB9bqv5z4EU4B8-XTd3zKNqtNba_snHbc711i4EytCiZfYSjNB1hwenq45YYOAhPTwOpFI0kxyRazc",
//     *         "user": {
//     *             "id": 1,
//     *             "name": "15888888888",
//     *             "email": "abcdefg@gmail.com",
//     *             "type": 2,
//     *             "phone": "15888888888",
//     *             "avatar": null,
//     *             "last_ip": null,
//     *             "created_at": "2016-09-30 00:45:13",
//     *             "updated_at": "2016-09-29 16:43:36"
//     *         }
//     *     }
//     * }
//     * @apiErrorExample {json} Error-Response:
//     * HTTP/1.1 400 Bad Request
//     * {
//     *     "state": false,
//     *     "code": 1000,
//     *     "message": "传入参数不正确",
//     *     "data": null or []
//     * }
//     * 可能出现的错误代码：
//     *    1000    CLIENT_WRONG_PARAMS             传入参数不正确
//     *    1102    INCORRECT_USER_OR_PASS          用户名或密码不正确
//     */
//    public function login(Request $request) {
//        $validator = Validator::make($request->all(),
//            [
//                'phone'         => 'required|regex:/^1[34578]\d{9}$/',
//                'password'      => 'required|between:6,16',
//            ],
//            [
//                'phone.required'        => '手机号码必填',
//                'phone.regex'           => '手机号码格式不正确',
//                'type.required'         => '用户类型必填',
//                'password.between'      => '密码长度6~16位',
//            ]
//        );
//
//        if ($validator->fails()) {
//            return $this->validatorError($validator->messages()->all(),ErrorCode::CLIENT_WRONG_PARAMS);
//        }
//
//        $credentials = $request->only('phone', 'type', 'password');
//
//        if (Auth::attempt($credentials)) {
//            $user = Auth::user();
//            if($request->type == 2){
//                $merchant = Merchant::where('user_id',$user->id)->first();
//                $data = MemberMerchant::where('merchant_id',$merchant->id);
//                $user['member_count'] = count($data->get());
//                $user['ref_count'] = count($data->where('ref_merchant_id','<>','')->get());
//                if($merchant->status!=1){
//                    return $this->error(ErrorCode::MERCHANT_STATUS_NOT_OK);
//                }
//            }
//            $token = $user->createToken($user->phone . '-' . $user->type)->accessToken;
//            $banners = Setting::where('category', '=', 'banner')->select('value')->get()->toArray();
//            return $this->api(compact('token', 'user', 'banners'));
//        } else {
//            return $this->error(ErrorCode::INCORRECT_USER_OR_PASS);
//        }
//    }
//
//    /**
//     * @api {get} /api/auth/logout 退出(logout)
//     * @apiDescription 退出(logout)
//     * @apiGroup Auth
//     * @apiPermission Passport
//     * @apiVersion 0.1.0
//     * @apiSuccessExample {json} Success-Response:
//     * HTTP/1.1 200 OK
//     * {
//     *     "state": true,
//     *     "code": 0,
//     *     "message": "",
//     *     "data": {
//     *         "result": true/false
//     *     }
//     * }
//     * @apiErrorExample {json} Error-Response:
//     * HTTP/1.1 400 Bad Request
//     * {
//     *     "state": false,
//     *     "code": 1104,
//     *     "message": "退出失败",
//     *     "data": null
//     * }
//     * 可能出现的错误代码：
//     *    1104    LOGOUT_FAILED                   退出失败
//     */
//    public function logout() {
//        if (Auth::user()->token()->delete()) {
//            return $this->api(['result' => true]);
//        }
//        return $this->error(ErrorCode::LOGOUT_FAILED);
//    }
//
//    /**
//     * @api {post} /api/auth/code 获取验证码(get code)
//     * @apiDescription 获取验证码(get code)，验证码有效期暂定为15分钟
//     * @apiGroup Auth
//     * @apiPermission none
//     * @apiVersion 0.1.0
//     * @apiParam {string} phone   手机
//     * @apiParam {int}    type    用户类型：1.个人，2.商户，3.注册
//     * @apiSuccessExample {json} Success-Response:
//     * HTTP/1.1 200 OK
//     * {
//     *     "state": true,
//     *     "code": 0,
//     *     "message": "",
//     *     "data": {
//     *         "verify_code": "1234"//该值调试时使用，sms调通后取消
//     *     }
//     * }
//     * @apiErrorExample {json} Error-Response:
//     * HTTP/1.1 400 Bad Request
//     * {
//     *     "state": false,
//     *     "code": 1000,
//     *     "message": "传入参数不正确",
//     *     "data": null or []
//     * }
//     * 可能出现的错误代码：
//     *    1000    CLIENT_WRONG_PARAMS             传入参数不正确
//     *    1100    PHONE_NUMBER_ALREADY_REGISTERED 该手机号已注册
//     */
//    public function getCode(Request $request)
//    {
//
//
//        $validator = Validator::make($request->all(),
//            [
//                'phone'             => 'required|regex:/^1[34578]\d{9}$/',
////                'type'              => 'required|in:' . User::TYPE_CONSUMER . ',' . User::TYPE_MERCHANT,'3'
//            ],
//            [
//                'phone.required'    => '手机号码必填',
//                'phone.regex'       => '手机号码格式不正确',
////                'type.required'     => '用户类型必填',
////                'type.in'           => '用户类型不正确',
//            ]
//        );
//
//        if($request->type == 3){
//            $user = User::where('phone',$request->phone)->first();
//            if($user){
//                $merchant = Merchant::where('user_id', '=', $user->id)->first();//模型支持单用户多商户，业务只设计单商户
//                if($user&&$merchant) return $this->error(ErrorCode::USER_DOES_EXIST);
//            }
//        }else{
//            if(!User::where('phone',$request->phone)->first()) return $this->error(ErrorCode::USER_DOES_NOT_EXIST);
//        }
//
//        if ($validator->fails()) {
//            return $this->validatorError($validator->messages()->all(),ErrorCode::CLIENT_WRONG_PARAMS);
//        }
//
//        $phone = $request->get('phone');
////        $type = $request->get('type');
//
//        $keyexist = $this->keySmsCodeExist . $phone;
//        $times = Cache::store('file')->get($keyexist);
//        if($times>5) {
//            return $this->error(ErrorCode::VERIFY_CODE_TOO_MUCH);
//        }else{
//            $times++;
//            Cache::store('file')->put($keyexist, $times, $this->expireTimeExist);
//        }
//
//        $verify_code = (string) mt_rand(1000, 9999);
//        \Log::info('verify_code:'.$verify_code);
//        $key = $this->keySmsCode . $phone;
//
//        Cache::store('file')->put($key, $verify_code, $this->expireTime);
////        Redis::set($key, $verify_code);
////        Redis::expire($key, $this->expireTime);
//
//        $msg = '您好，您的验证码是：' . $verify_code;
//        $result = $this->sendSms($msg, $phone);
//        if (!$result) {
//            $this->logger->Error("Send sms failed.");
//        }
//
//        return $this->api(['verify_code' => $verify_code]);
//    }
//
//    /**
//     * @api {post} /api/auth/register 注册(register)
//     * @apiDescription 注册(register)
//     * @apiGroup Auth
//     * @apiPermission none
//     * @apiVersion 0.1.0
//     * @apiParam {String}   phone               手机号码
//     * @apiParam {String}   verify_code          手机验证码
//     * @apiParam {int}      type                帐户类型：1.个人，2.商户
//     * @apiParam {String}   [name=手机号码]      用户帐号名称
//     * @apiParam {String}   [email]             邮件地址
//     * @apiParam {String}   [password=123456]   密码
//     * @apiParam {File}     [avatar]            用户头像
//     * @apiSuccessExample {json} Success-Response:
//     * HTTP/1.1 200 OK
//     * {
//     *     "state": true,
//     *     "code": 0,
//     *     "message": "",
//     *     "data": {
//     *         "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjdjYWUyYzFmYTUwMTIyZDI0ZTRiYTZhZGZhNmQxYmZlOWNiMzIxMTBmYWJlZjNjYzIyNmViZjRmNGExNWM3NjllNmU2ZTNiYWE5OGNhOWUzIn0.eyJhdWQiOiIxIiwianRpIjoiN2NhZTJjMWZhNTAxMjJkMjRlNGJhNmFkZmE2ZDFiZmU5Y2IzMjExMGZhYmVmM2NjMjI2ZWJmNGY0YTE1Yzc2OWU2ZTZlM2JhYTk4Y2E5ZTMiLCJpYXQiOjE0NzU0MTE1NTgsIm5iZiI6MTQ3NTQxMTU1OCwiZXhwIjo0NjMxMDg1MTU4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.E9YGEzuRUOk02aV1EiWLJ_pD0hKoCyW0k_sGy63hM3u5X8K_HI1kVhaU6JNLqLZeszIAroTEDB8XMgZKAqTLlwtL8PLCJcuDoxfk1BRHbfjhDheTsahBysKGalvNEpzRCrGlao0mS0Cg9qDpEsndtypPFS8sfaflToOzbJjiSK2DvQiHSH8xZI3zHJTezgZMz-pB_hPTxp8ajdv0ve1gWtWjs3vERr0Y91X4hngO8X7LuXtAYtfxGZRIye12YE7TuLBMYzj8CCfiRt7Smhyf4palNW5mzKlZpa2l87n6NQ14Iy4oMzQ2PON1j_swrosuE2yZohGOn6fDdSCBRdJ6dLD_emjBdQCQOoB63R7BbhFZgvFX25TjzFJ7r9AdVMiGmebuRKEVSZV_JCGu1C71OIbQk-UK35s00gSr2fmJGBbN2cZTXBRTJpfuMZ_ihFYEZrvVq_Ih2X0xkd36JUuxaUld1BXRgPZvH-9jBuhe0YW2OOlgwpdm6ZB8BMcuS4ftLoi6FipgzFqfIuy-0ZqPMDnJaG7Gycrdpxza00mgOFxYxJtqwZNsUWFRZEVU881l6VC_cy294YXSPQxUwEoyKg-G5Pm8AEB9bqv5z4EU4B8-XTd3zKNqtNba_snHbc711i4EytCiZfYSjNB1hwenq45YYOAhPTwOpFI0kxyRazc",
//     *         "user": {
//     *             "type": "2",
//     *             "phone": "15881082737",
//     *             "name": "15881082737",
//     *             "updated_at": "2016-10-03 20:52:21",
//     *             "created_at": "2016-10-03 20:52:21",
//     *             "id": 6
//     *         }
//     *     }
//     * }
//     * @apiErrorExample {json} Error-Response:
//     * HTTP/1.1 400 Bad Request
//     * {
//     *     "state": false,
//     *     "code": 1000,
//     *     "message": "传入参数不正确",
//     *     "data": null or []
//     * }
//     * 可能出现的错误代码：
//     *    200     SAVE_USER_FAILED                保存用户数据失败
//     *    1000    CLIENT_WRONG_PARAMS             传入参数不正确
//     *    1101    INCORRECT_VERIFY_CODE           输入验证码错误
//     */
//    public function register(Request $request) {
//        $validator = Validator::make($request->input(),
//            [
//                'phone'         => 'required|regex:/^1[34578]\d{9}$/',
//                'verify_code'    => 'required',
//                'name'          => 'alpha_dash|between:2,50',
//                'email'         => 'email',
//                'password'      => 'between:6,16',
//                'avatar'        => 'image',
//            ],
//            [
//                'phone.required'        => '手机号码必填',
//                'phone.regex'           => '手机号码格式不正确',
//                'verify_code.required'   => '请输入校验码',
//                'name.alpha_dash'       => '用户名称只能字母数字中下划线',
//                'name.between'          => '用户名称只能为2~50字符',
//                'email.email'           => '邮件格式不正确',
//                'password.between'      => '密码必须在6~16字符之内',
//                'avatar.image'          => '用户头像必须为有效的图片',
//            ]
//        );
//
//        if ($validator->fails()) {
//            return $this->error($validator->messages()->all(),ErrorCode::CLIENT_WRONG_PARAMS, '');
//        }
//
//        $phone = $request->get('phone');
//        $type = $request->get('type');
//        $verify_code = $request->get('verify_code');
//        $name = $request->get('name');
//
//        //先绑定会员 ，后绑定商户
////        if (User::where('phone', '=', $phone)->where('type', '=', $type)->exists()) {
////            return $this->error(ErrorCode::PHONE_NUMBER_ALREADY_REGISTERED);
////        }
//
//        $email = $request->get('email');
//        $password = $request->get('password');
//        //如果有头像，上传
//        if ($request->hasFile('avatar')) {
//            $md5 = $this->uploadAttachment($request, 'avatar', 'avatar');
//        }
//
//        $key = $this->keySmsCode . $phone;
////        if (Redis::exists($key)) {
//        if (Cache::store('file')->has($key)) {
////            $code = Redis::get($key);
//            $code = Cache::store('file')->get($key);
//            if ($code == $verify_code) {
//                if(!$user = User::where('phone', '=', $phone)->first()){
//                    $user = new User();
//                }
//                $user->type = $type;
//                $user->phone = $phone;
//                $user->name = $name;
//                $user->email = $email;
//                if (!empty($password)) {
//                    $user->password = bcrypt($password);
//                }
//                if (isset($md5) && is_string($md5) && !empty($md5)) {
//                    $user->avatar = $md5;
//                }
//                if ($user->save()) {
////                    Redis::del($key);
//                    Cache::store('file')->forget($key);
//
//                    //发token
//                    $token = $user->createToken($phone . '-' . $type);
//                    return $this->api([
//                        'token'     => $token->accessToken,
//                        'user'      => $user->toArray(),
//                    ]);
//                } else {
//                    return $this->error(ErrorCode::SAVE_USER_FAILED);
//                }
//            }
//        }
//        return $this->error(ErrorCode::INCORRECT_VERIFY_CODE);
//    }
//
//    public function refreshToken() {
//        $token = '';//TODO
//
//        return $this->api([
//            'token'     => $token,
//        ]);
//    }
//
//    /**
//     * @api {post} /api/auth/password 设置密码(password)
//     * @apiDescription 上传头像(password)
//     * @apiGroup Auth
//     * @apiPermission Passport
//     * @apiVersion 0.1.0
//     * @apiParam {String} password 密码
//     * @apiSuccessExample {json} Success-Response:
//     * HTTP/1.1 200 OK
//     * {
//     *     "state": true,
//     *     "code": 0,
//     *     "message": "",
//     *     "data": {
//     *         "result": true,
//     *     }
//     * }
//     * @apiErrorExample {json} Error-Response:
//     * HTTP/1.1 400 Bad Request
//     * {
//     *     "state": false,
//     *     "code": 1000,
//     *     "message": "传入参数不正确",
//     *     "data": null or []
//     * }
//     * 可能出现的错误代码：
//     *    200     SAVE_USER_FAILED                保存用户数据失败
//     *    1000    CLIENT_WRONG_PARAMS             传入参数不正确
//     */
//    public function setPassword(Request $request) {
//        $validator = Validator::make($request->input(),
//            [
//                'password'      => 'required|between:6,16',
//            ],
//            [
//                'password.required'     => '请输入密码',
//                'password.between'      => '密码长度6~16位',
//            ]
//        );
//
//        if ($validator->fails()) {
//            return $this->validatorError($validator->messages()->all(),ErrorCode::CLIENT_WRONG_PARAMS);
//        }
//
//        $pass = $request->get('password');
//
//        $user = Auth::user();
//        $user->password = bcrypt($pass);
//        if (!$user->save()) {
//            return $this->error(ErrorCode::SAVE_USER_FAILED);
//        }
//
//        return $this->api([
//            'result'    => true,
//        ]);
//    }
//
//    public function isLogin()
//    {
//        $user = Auth::user();
//        $res = true;
//        if(!$user) $res = false;
//        return $this->api([
//            'result'    => $res,
//        ]);
//    }
//
//    public function check_password(Request $request)
//    {
//        $password = Auth::user()->password;
//
//        if(!Hash::check($request->oldpassword,$password)) return $this->error(ErrorCode::CHECK_OLDPASSWORD_FAILED);
//
//        return $this->api(null,0,'验证通过');
//    }
//
//    /**
//     * @api {post} /api/auth/reset 找回密码(reset)
//     * @apiDescription 找回密码(reset)
//     * @apiGroup Auth
//     * @apiPermission none
//     * @apiVersion 0.1.0
//     * @apiParam {Phone}  phone   手机
//     * @apiParam {int} type 帐户类型：1.个人，2.商户
//     * @apiParam {String} verify_code 手机验证码
//     * @apiParam {String} password   password
//     * @apiSuccessExample {json} Success-Response:
//     * HTTP/1.1 200 OK
//     * {
//     *     "state": true,
//     *     "code": 0,
//     *     "message": "",
//     *     "data": {
//     *         "result": true,
//     *     }
//     * }
//     * @apiErrorExample {json} Error-Response:
//     * HTTP/1.1 400 Bad Request
//     * {
//     *     "state": false,
//     *     "code": 1000,
//     *     "message": "传入参数不正确",
//     *     "data": null or []
//     * }
//     * 可能出现的错误代码：
//     *    200     SAVE_USER_FAILED                保存用户数据失败
//     *    1000    CLIENT_WRONG_PARAMS             传入参数不正确
//     *    1101    INCORRECT_VERIFY_CODE           输入验证码错误
//     *    1105    USER_DOES_NOT_EXIST             用户不存在
//     */
//    public function reset(Request $request) {
//        $validator = Validator::make($request->all(),
//            [
//                'phone'         => 'required|regex:/^1[34578]\d{9}$/',
//                'verify_code'    => 'required',
//                'password'      => 'required|between:6,16',
//            ],
//            [
//                'phone.required'        => '手机号码必填',
//                'phone.regex'           => '手机号码格式不正确',
//                'verify_code.required'   => '请输入校验码',
//                'password.required'     => '请输入密码',
//                'password.between'      => '密码长度6~16位',
//            ]
//        );
//
//        if ($validator->fails()) {
//            return $this->error(ErrorCode::CLIENT_WRONG_PARAMS, '', $validator->messages());
//        }
//
//        $phone = $request->get('phone');
//        $verify_code = $request->get('verify_code');
//        $pass = $request->get('password');
//
//        $key = $this->keySmsCode . $phone;
////        if (Redis::exists($key)) {
//        if (Cache::store('file')->has($key)) {
////            $code = Redis::get($key);
//            $code = Cache::store('file')->get($key);
//            if ($code == $verify_code) {
//                $user = User::where([
//                    'phone'     => $phone,
//                ])->first();
//
//                if (!$user) {
//                    return $this->error(ErrorCode::USER_DOES_NOT_EXIST);
//                }
//
//                //$password = app('hash')->make($request->get('password'));
//                $user->password = bcrypt($pass);
//                if (!$user->save()) {
//                    return $this->error(ErrorCode::SAVE_USER_FAILED);
//                }
//                Cache::store('file')->forget($key);
//
//                return $this->api(['result' => true]);
//            }
//        }
//        return $this->error(ErrorCode::INCORRECT_VERIFY_CODE);
//    }
//
//    /**
//     * @api {post} /api/auth/avatar 上传头像(avatar)
//     * @apiDescription 上传头像(reset)
//     * @apiGroup Auth
//     * @apiPermission Passport
//     * @apiVersion 0.1.0
//     * @apiParam {File} avatar 头像图片
//     * @apiSuccessExample {json} Success-Response:
//     * HTTP/1.1 200 OK
//     * {
//     *     "state": true,
//     *     "code": 0,
//     *     "message": "",
//     *     "data": {
//     *         "md5": "fdf8dd78eb383b8acf6d94d4752c1424",
//     *     }
//     * }
//     * @apiErrorExample {json} Error-Response:
//     * HTTP/1.1 400 Bad Request
//     * {
//     *     "state": false,
//     *     "code": 1000,
//     *     "message": "传入参数不正确",
//     *     "data": null or []
//     * }
//     * 可能出现的错误代码：
//     *    200     SAVE_USER_FAILED                保存用户数据失败
//     *    201     ATTACHMENT_MKDIR_FAILED         创建附件目录失败
//     *    202     ATTACHMENT_UPLOAD_INVALID       上传附件文件无效
//     *    203     ATTACHMENT_SAVE_FAILED          保存附件失败
//     *    204     ATTACHMENT_MOVE_FAILED          移动附件失败
//     *    205     ATTACHMENT_DELETE_FAILED        删除附件文件失败
//     *    206     ATTACHMENT_RECORD_DELETE_FAILED 删除附件记录失败
//     *    1000    CLIENT_WRONG_PARAMS             传入参数不正确
//     *    1101    INCORRECT_VERIFY_CODE           输入验证码错误
//     *    1105    USER_DOES_NOT_EXIST             用户不存在
//     *    1200    ATTACHMENT_UPLOAD_FAILED        附件上传失败
//     *    1201    ATTACHMENT_SIZE_EXCEEDED        附件大小超过限制
//     *    1202    ATTACHMENT_MIME_NOT_ALLOWED     附件类型不允许
//     *    1203    ATTACHMENT_NOT_EXIST            附件不存在
//     */
//    public function avatar(Request $request) {
//        $user = Auth::user();
//        $old_avatar = $user->avatar;
//        $result = $this->uploadAttachment($request, 'avatar', 'avatar', 4 * 1024 * 1024, [
//            'image/jpeg',
//            'image/png',
//            'image/gif',
//        ]);
//        if (is_array($result)) {
//            $result = array_shift($result);
//        }
//        if (is_string($result)) {
//            $user->avatar = $result;
//            if (!$user->save()) {
//                return $this->error(ErrorCode::SAVE_USER_FAILED);
//            }
//            $this->deleteAttachment($old_avatar);
//            return $this->api(['md5' => $result]);
//        }
//        return $this->error($result);
//    }
//
//
//    /**
//     * @api {post} /api/auth/bank_card/create 添加银行卡
//     * @apiDescription 添加银行卡
//     * @apiGroup Auth
//     * @apiPermission Passport
//     * @apiVersion 0.1.0
//     * @apiParam {string} bank_name 银行名称
//     * @apiParam {string} bank_number 银行卡号
//     * @apiParam {string} bank_phone 银行预留手机号
//     * @apiParam {string} bank_user 银行卡用户姓名
//     * @apiSuccessExample {json} Success-Response:
//     * HTTP/1.1 200 OK
//     * {
//     *     "state": true,
//     *     "code": 0,
//     *     "message": "",
//     *     "data": {
//     *         ....
//     *     }
//     * }
//     * @apiErrorExample {json} Error-Response:
//     * HTTP/1.1 400 Bad Request
//     * {
//     *     "state": false,
//     *     "code": 1000,
//     *     "message": "传入参数不正确",
//     *     "data": null or []
//     * }
//     *  可能出现的错误代码：
//     *    2003     BANK_CARD_ADD_FAILED        添加银行卡失败
//     */
//    public function create_bank_card(Request $request)
//    {
//        $validator = Validator::make($request->all(),
//            [
//                'bank_name'          => 'required',
////                'bank_number'    => 'required',
////                'bank_phone'      => 'required',
////                'bank_user'      => 'required',
//            ],
//            [
//                'bank_name.required'         => '银行名称必填',
////                'bank_number.required'   => '银行卡号必填',
////                'bank_phone.required'     => '联系电话必填',
////                'bank_user.required'     => '持卡人姓名必填',
//            ]
//        );
//
//        if($validator->fails()) return $this->validatorError($validator->messages()->all(),ErrorCode::CLIENT_WRONG_PARAMS);
//
//        $data = $request->all();
//        $data['user_id'] = Auth::id();
//
//        if(!UserBanks::create($data)) return $this->error(ErrorCode::BANK_CARD_ADD_FAILED,'');
//
//    }
//
//    /**
//     * @api {post} /api/auth/bank_card/index 获取银行卡列表
//     * @apiDescription 获取银行卡信息
//     * @apiGroup Auth
//     * @apiPermission Passport
//     * @apiVersion 0.1.0
//     * @apiSuccessExample {json} Success-Response:
//     * HTTP/1.1 200 OK
//     * {
//     *     "state": true,
//     *     "code": 0,
//     *     "message": "",
//     *     "data": [
//     *        {
//     *          "id": 1,
//     *          "user_id": 27,
//     *          "bank_name": "测试银行",
//     *          "bank_number": "12345678987654321",
//     *          "bank_phone": "12345678987"
//     *         }
//     *       ]
//     * }
//     * @apiErrorExample {json} Error-Response:
//     * HTTP/1.1 500
//     * {
//     *     "state": false,
//     *     "code": 2002,
//     *     "message": "获取银行卡列表失败",
//     *     "data": null or []
//     * }
//     */
//    public function index_bank_card()
//    {
//
//        $user_id = Auth::id();
//        if(!$user_id)return $this->error(ErrorCode::USER_DOES_NOT_EXIST,'');
//        if(!$data = UserBanks::where('user_id', $user_id)->get()) return $this->error(ErrorCode::BANK_CARD_INDEX_FAILED,'');
//
//        return $this->api($data->toArray());
//
//    }
//
//    /**
//     * @api {post} /api/auth/bank_card/edit 修改银行卡
//     * @apiDescription 修改银行卡
//     * @apiGroup Auth
//     * @apiPermission Passport
//     * @apiVersion 0.1.0
//     * @apiParam {string} bank_number 银行卡号
//     * @apiSuccessExample {json} Success-Response:
//     * HTTP/1.1 200 OK
//     * {
//     *     "state": true,
//     *     "code": 0,
//     *     "message": "",
//     *     "data": {
//     *         ....
//     *     }
//     * }
//     * @apiErrorExample {json} Error-Response:
//     * HTTP/1.1 500
//     * {
//     *     "state": false,
//     *     "code": 2004,
//     *     "message": "修改银行卡失败",
//     *     "data": null or []
//     * }
//     *    可能出现的错误代码：
//     *    2001     BANK_CARD_NOT_EXIST        银行卡不存在
//     */
//
//    public function edit_bank_card(Request $request)
//    {
//
//        if(!$request->all()) return $this->error(ErrorCode::BANK_CARD_NOT_EXIST,'');
//
//        if(!$data = UserBanks::where('bank_number',$request->bank_number)->get()) return $this->error(ErrorCode::BANK_CARD_NOT_EXIST,'');
//
//        return $this->api($data->toArray());
//
//    }
//
//    /**
//     * @api {post} /api/auth/bank_card/update 更新银行卡
//     * @apiDescription 更新银行卡
//     * @apiGroup Auth
//     * @apiPermission Passport
//     * @apiVersion 0.1.0
//     * @apiParam {int} id 银行卡id
//     * @apiParam {string} bank_name 银行名称
//     * @apiParam {string} bank_number 银行卡号
//     * @apiParam {string} bank_phone 银行预留手机号
//     * @apiSuccessExample {json} Success-Response:
//     * HTTP/1.1 200 OK
//     * {
//     *     "state": true,
//     *     "code": 0,
//     *     "message": "success",
//     *     "data": {
//     *         ....
//     *     }
//     * }
//     * @apiErrorExample {json} Error-Response:
//     *HTTP/1.1 400 Bad Request
//     * {
//     *     "state": false,
//     *     "code": 1000,
//     *     "message": "传入参数不正确",
//     *     "data": null or []
//     * }
//     *    可能出现的错误代码：
//     *    2001     BANK_CARD_NOT_EXIST        银行卡不存在
//     *    2005     BANK_CARD_UPDATE_FAILED        更新银行卡失败
//     */
//    public function update_bank_card(Request $request)
//    {
//        $validator = Validator::make($request->all(),
//            [
//                'id'        => 'required',
//                'bank_name'  => 'required',
//                'bank_number' => 'required',
//                'bank_phone'   => 'required',
//                'bank_user'   => 'required',
//            ],
//            [
//                'id.required'        => '未能获取当前卡ID',
//                'bank_name.required'  => '银行名称必填',
//                'bank_number.required' => '银行卡号必填',
//                'bank_phone.required'   => '联系电话必填',
//                'bank_user.required'   => '持卡人姓名必填',
//            ]
//        );
//        if($validator->fails()) return $this->validatorError($validator->messages()->all(),ErrorCode::CLIENT_WRONG_PARAMS);
//
//        if(!$data = UserBanks::find($request->id)) return $this->error(ErrorCode::BANK_CARD_NOT_EXIST,'');
//
//        if(! $data->update($request->except('id'))) return $this->error(ErrorCode::BANK_CARD_UPDATE_FAILED,'');
//
//        return $this->api('',0,'success');
//
//    }
//
//    /**
//     * @api {post} /api/auth/bank_card/delete/{id} 删除银行卡
//     * @apiDescription 删除银行卡
//     * @apiGroup Auth
//     * @apiPermission Passport
//     * @apiVersion 0.1.0
//     * @apiSuccessExample {json} Success-Response:
//     * HTTP/1.1 200 OK
//     * {
//     *     "state": true,
//     *     "code": 0,
//     *     "message": "success",
//     *     "data": {
//     *         ....
//     *     }
//     * }
//     * @apiErrorExample {json} Error-Response:
//     *HTTP/1.1 400 Bad Request
//     * {
//     *     "state": false,
//     *     "code": 2008,
//     *     "message": "删除银行卡失败",
//     *     "data": null or []
//     * }
//     * 2001  没有此银行卡
//     */
//    public function delete_bank_card($id)
//    {
//
//        if(!$bank = UserBanks::find($id)) return $this->api(ErrorCode::BANK_CARD_NOT_EXIST.'');
//
//        if(!$bank->delete()) return $this->api(ErrorCode::BANK_CARD_DELETE_FAILED,'');
//
//        return $this->api('',0,'success');
//
//    }

}
