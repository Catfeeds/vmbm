<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountLog extends Model
{
    public $table = 'account_logs';

    //交易行为定义
    const OP_CHARGE         = 'CHARGE';
    const OP_REMOVE_M       = 'REMOVE_M';
    const OP_CHARGE_M       = 'CHARGE_M';
    const OP_CHARGE_M_GIFT  = 'CHARGE_M_GIFT';
    const OP_CC             = 'CC';
    const OP_CC_BONUS       = 'CC_BONUS';
    const OP_CONSUME        = 'CONSUME';
    const OP_WITHDRAW       = 'WITHDRAW';
    const OP_CHANGE         = 'CHANGE';

    //货币类型定义
    const TYPE_BALANCE      = 1;
    const TYPE_COIN       = 2;
    const TYPE_CASH         = 3;

    //交易渠道定义
    const CHANNEL_PLATFORM  = 'platform';
    const CHANNEL_ALIPAY    = 'alipay';
    const CHANNEL_WECHATPAY = 'wechatpay';

    //交易方向
    const DIRECTION_INC     = 1; //增加
    const DIRECTION_DEC     = 2; //减少

    //交易行为枚举
    private static $_op = [
        self::OP_CHARGE         => '充值',
        self::OP_REMOVE_M       => '商户给会员扣除',
        self::OP_CHARGE_M       => '商户给会员充值',
        self::OP_CHARGE_M_GIFT  => '商户充值赠送',
        self::OP_CC             => '续消',
        self::OP_CC_BONUS       => '续消分成',
        self::OP_CONSUME        => '消耗',
        self::OP_WITHDRAW       => '提现',
        self::OP_CHANGE         => '卡金换余额',
    ];

    //货币类型枚举
    private static $_type = [
        self::TYPE_BALANCE      => '余额',
        self::TYPE_CREDIT       => '卡金',
        self::TYPE_CASH         => '现金',
        self::TYPE_BALANCE_M    => '商户余额',
    ];

    //交易渠道枚举
    private static $_channels = [
        self::CHANNEL_PLATFORM  => '平台内交易',
        self::CHANNEL_ALIPAY    => '支付宝',
        self::CHANNEL_WECHATPAY => '微信支付',
    ];

    // 交易流向
    private static $_direction = [
        self::DIRECTION_INC => '收入',
        self::DIRECTION_DEC => '支出'
    ];

    // 获取所有操作
    public static function getAllop() {
        return self::$_op;
    }

    // 获取所有类型
    public static function getAllType() {
        return self::$_type;
    }

    //获取所有渠道
    public static function getAllChannels() {
        return self::$_channels;
    }

    // 获取交易流向
    public static function getAllDirections() {
        return self::$_direction;
    }
}
