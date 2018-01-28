<?php
/**
 *------------------------------------------------------
 * AbstractService.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @date      2016/5/26 11:17
 * @version   V1.0
 *
 */

namespace App\Services\Base;

abstract class AbstractService
{

    protected $_code = FAILURE_CODE;

    /**
     * 错误的信息载体
     */
    protected $_msg;

    /**
     * 取回错误的信息
     */
    public function getMsg()
    {
        return $this->_msg;
    }

    /**
     * 设置错误的信息
     */
    public function setMsg($msg)
    {
        $this->_msg = $msg;
        return false;
    }

    /**
     * 设置状态码
     */
    public function setCode($code)
    {
        $this->_code = $code;
    }

    /**
     * 标记为成功
     */
    public function setSucessCode()
    {
        $this->setCode(SUCESS_CODE);
    }

}
