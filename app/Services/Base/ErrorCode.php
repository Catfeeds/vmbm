<?php
/**
 *------------------------------------------------------
 * BaseProcess.php
 *------------------------------------------------------
 *
 * @author    Mike
 * @date      2016/5/26 11:17
 * @version   V1.0
 *
 */

namespace App\Services\Base;

final class ErrorCode {
    //错误常量定义
    const ATTACHMENT_DELETE_FAILED = 605;
    const ATTACHMENT_MOVE_FAILED = 604;
    const ATTACHMENT_RECORD_DELETE_FAILED = 606;
    const ATTACHMENT_MKDIR_FAILED = 601;
    const SAVE_USER_FAILED = 600;
    const ATTACHMENT_SAVE_FAILED = 603;
    const ATTACHMENT_UPLOAD_INVALID = 602;
    const ATTACHMENT_SIZE_EXCEEDED = 1201;
    const ILLEGAL_REQUEST = 701;
    const ATTACHMENT_NOT_EXIST = 1203;
    const ATTACHMENT_MIME_NOT_ALLOWED = 1202;
    const MERCHANT_CREDIT_NOT_ENOUGH = 1304;
    const MEMBER_CREDIT_NOT_ENOUGH = 1305;
    const MERCHANT_NOT_EXIST = 1300;
    const FAVORITE_NOT_EXIST = 1900;
    const MERCHANT_ADD_MEMBER_FAILED = 1301;
    const MERCHANT_STATUS_NOT_OK = 1302;
    const MERCHANT_BALANCE_NOT_ENOUGH = 1303;
    const PAY_TYPE_UNSUPPORTED = 2000;
    const MEMBER_NOT_EXIST = 1500;
    const MEMBER_BALANCE_NOT_ENOUGH = 1501;
    const MERCHANT_SERVICE_NOT_EXIST = 1400;
    const MERCHANT_SERVICE_ADD_FAILED = 1401;
    const CONTENT_GET_DETAIL_FAILED = 1402;
    const MERCHANT_SERVICE_STATUS_INVALID = 1403;
    const MERCHANT_SERVICE_EXPIRED = 1404;
    const CANT_ADD_SERVICE_SAME_MERCHANT = 1405;
    const SERVICE_STATUS_INVALID_CHANGE = 1406;
    const SERVICE_COST_OVERFLOW_BALANCE = 1407;
    const CREATE_SERVICE_OVER_MAX = 1408;
    const SAVE_MODEL_FAILED = 700;
    const REMOVE_MODEL_FAILED = 701;
    const MODEL_NOT_EXIST = 702;
    const ATTACHMENT_UPLOAD_FAILED = 1200;
    const PROTO_PATH_NOT_EXIST = 100;
    const PROTO_TRY_TO_SET_VALUE_ON_NULL = 101;
    const ACTIVITY_NOT_EXIST = 1700;
    const ORDER_GENERATE_FAILED = 1800;
    const CONSUME_LOG_NOT_EXIST = 1600;
    const SERVICE_CODE_FAILED= 1610;
    const PHONE_NUMBER_ALREADY_REGISTERED = 1100;
    const INCORRECT_VERIFY_CODE = 1101;
    const INCORRECT_USER_OR_PASS = 1102;
    const VERIFY_CODE_TOO_MUCH = 1103;
    const LOGOUT_FAILED = 1104;
    const USER_DOES_NOT_EXIST = 1105;
    const USER_DOES_EXIST = 1106;
    const DELETE_OP_FAILED = 1001;
    const CLIENT_WRONG_PARAMS = 1000;

    //错误常量枚举
    private static $_msg = [
        self::ATTACHMENT_DELETE_FAILED => '删除附件文件失败',
        self::ATTACHMENT_MOVE_FAILED => '移动附件失败',
        self::ATTACHMENT_RECORD_DELETE_FAILED => '删除附件记录失败',
        self::ATTACHMENT_MKDIR_FAILED => '创建附件目录失败',
        self::SAVE_USER_FAILED => '保存用户数据失败',
        self::ATTACHMENT_SAVE_FAILED => '保存附件失败',
        self::ATTACHMENT_UPLOAD_INVALID => '上传附件文件无效',
        self::ATTACHMENT_SIZE_EXCEEDED => '附件大小超过限制',
        self::ILLEGAL_REQUEST => '非法请求',
        self::ATTACHMENT_NOT_EXIST => '附件不存在',
        self::ATTACHMENT_MIME_NOT_ALLOWED => '附件类型不允许',
        self::MEMBER_CREDIT_NOT_ENOUGH => '会员卡金不足',
        self::MERCHANT_CREDIT_NOT_ENOUGH => '商户卡金不足',
        self::MERCHANT_NOT_EXIST => '商户不存在',
        self::FAVORITE_NOT_EXIST => '收藏不存在',
        self::MERCHANT_ADD_MEMBER_FAILED => '添加会员失败',
        self::MERCHANT_STATUS_NOT_OK => '申请成功,客服会在3个工作日内与您取得联系！',
        self::MERCHANT_BALANCE_NOT_ENOUGH => '商户余额不足',
        self::PAY_TYPE_UNSUPPORTED => '不支持的支付方式',
        self::MEMBER_NOT_EXIST => '会员不存在',
        self::MEMBER_BALANCE_NOT_ENOUGH => '会员余额不足',
        self::SERVICE_COST_OVERFLOW_BALANCE => '余额不足，请充值',
        self::CREATE_SERVICE_OVER_MAX => '服务数量达到系统上限',
        self::MERCHANT_SERVICE_STATUS_INVALID => '服务状态不正确',
        self::CONTENT_GET_DETAIL_FAILED => '获取内容详情失败',
        self::MERCHANT_SERVICE_ADD_FAILED => '发出服务失败',
        self::MERCHANT_SERVICE_NOT_EXIST => '服务不存在',
        self::SERVICE_STATUS_INVALID_CHANGE => '服务状态转换无效',
        self::CANT_ADD_SERVICE_SAME_MERCHANT => '服务发出方与创建方一致',
        self::MERCHANT_SERVICE_EXPIRED => '服务已过期',
        self::SAVE_MODEL_FAILED => '保存模型失败',
        self::REMOVE_MODEL_FAILED => '删除模型失败',
        self::MODEL_NOT_EXIST => '模型不存在',
        self::ATTACHMENT_UPLOAD_FAILED => '附件上传失败',
        self::PROTO_PATH_NOT_EXIST => '指定API路径不存在',
        self::PROTO_TRY_TO_SET_VALUE_ON_NULL => '企图操作NULL对象并赋值',
        self::ACTIVITY_NOT_EXIST => '活动不存在',
        self::ORDER_GENERATE_FAILED => '生成订单失败',
        self::CONSUME_LOG_NOT_EXIST => '消费记录不存在',
        self::LOGOUT_FAILED => '退出失败',
        self::SERVICE_CODE_FAILED=>'验证码错误',
        self::USER_DOES_EXIST => '手机已经注册',
        self::USER_DOES_NOT_EXIST => '用户不存在',
        self::INCORRECT_USER_OR_PASS => '用户名或密码不正确',
        self::PHONE_NUMBER_ALREADY_REGISTERED => '该手机号已注册',
        self::INCORRECT_VERIFY_CODE => '输入验证码错误',
        self::VERIFY_CODE_TOO_MUCH => '24小时内验证码发送过多',
        self::DELETE_OP_FAILED => '删除操作失败',
        self::CLIENT_WRONG_PARAMS => '输入不正确',
    ];

    public static function message($code) {
        if (isset(self::$_msg[$code])) {
            return self::$_msg[$code];
        } else {
            return null;
        }
    }

}
