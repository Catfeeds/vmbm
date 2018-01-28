<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\Base\ErrorCode;
use Request, Response, Auth,Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

//    protected $_data = null;
    protected $_user = null;

    public function __construct() {

        $this->middleware('auth:api', [
            'except' => [
                'upload', 'getCode', 'reset', 'login', 'get', 'register', 'alipayNotify', 'wechatpayNotify',
                'get', 'area', 'get_province', 'get_city', 'get_county', 'test',

            ]
        ]);

//        \DB::connection()->enableQueryLog();
//        $queries = \DB::getQueryLog();
//        dd($queries);

//        $this->_user = Auth::user();
//        if ($this->_user !== null) {
//            $this->_user->last_ip = Request::ip();
//        }
//        $data = $this->rawPostData();
//        if (!$this->checkSignature($data, env('APP_SECRET'))) {
//            $this->rawError(ErrorCode::CLIENT_APP_CHECKSUM_ERROR);
//        }
//        unset($data['nonce_str'], $data['timestamp'], $data['sig']);

//        $this->_data = $data;
    }

//    public function saveLastIp() {
//        if ($this->_user !== null) {
//            $this->_user->save();
//        }
//    }

    public function rawPostData() {
        $request = Request::instance();
        $data = $request->getContent();
        return json_decode($data, true);
    }

    public function rawApi($data, $code = 0, $message = '') {
        $ret = $this->genApiData($data, $code, $message);
        return json_encode($ret);
    }

    public function api($data, $code = 0, $message = '') {
        $ret = $this->genApiData($data, $code, $message);
        $status = $code === 0 ? 200 : 400;
        return Response::json($ret, $status);
    }

    public function validatorError($arr, $code = 0, $message = '') {
        Log::info($arr);
        foreach ($arr as $val){
            if($val&&$message==''){
                $message = $val;
            }
        }
        $ret = $this->genApiData(null, $code, $message);
        $status = $code === 0 ? 200 : 400;
        return Response::json($ret, $status);
    }

    public function error($code, $message = '', $data = null) {
        return $this->api($data, $code, $message);
    }

    public function rawError($code, $message = '') {
        echo $this->rawApi(null, $code, $message);
        exit;
    }

    private function genApiData($data, $code = 0, $message = '') {
        if ($code !== 0 && ErrorCode::CLIENT_WRONG_PARAMS && empty($message)) {
            $message = ErrorCode::message($code);
        }
        $ret = [
            'status'     => $code == 0,
            'status_code'      => $code,
            'message'   => $message,
            'data'      => $data
        ];
        return $ret;
    }
}
