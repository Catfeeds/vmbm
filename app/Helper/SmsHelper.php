<?php
namespace App\Helper;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

trait SmsHelper
{
    public function sendSms($msg, $mobile) {
        $url = "http://api.106txt.com/smsGBK.aspx?";
        $account = "swufecredit2017";
        $password = "mask751002";
        $password = strtoupper(md5($password));
        $gwid = 53;
        $message = iconv("UTF-8", "GB2312", $msg);

        try {
            $client = new GuzzleHttpClient();
            $data = [
                'action'      => 'Send',
                'username'        => $account,
                'password'       => $password,
                'gwid'      => $gwid,
                'mobile'    => $mobile,
                'message'       => $message,
            ];
            $apiRequest = $client->post($url, [
                'form_params'      => $data,
            ]);
            $resp = $apiRequest->getBody()->getContents();
            $res = iconv("GB2312", "UTF-8", $resp);
            $re = json_decode($res, true);
            \Log::info("发送短信 到手机:$mobile 内容:$msg RESULT:".$re['RESULT']);
            if (trim($re['CODE']) == '1') {
                return true;
            }
        } catch (RequestException $re) {
            \Log::info("发送短信错误:".$re->getMessage());
            return false;
        }
        return false;
    }

}