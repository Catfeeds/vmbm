<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Request,Auth;
/**
 * 父控制类类
 *
 * @author wangzhoudong <m@9026.com>
 */
abstract class Controller extends BaseController
{
    protected $_user;
    protected $_serviceAdminRole;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->_user = Auth::guard('admin')->user();
            view()->share('_user',$this->_user);
            return $next($request);
        });
    }

    /**
     * 检测表单篡改
     *
     * @return true|exception
     */
    protected function checkFormHash()
    {
        return (new Formhash())->checkFormHash();
    }

    /**
     * 启用操作日志记录
     */
    protected function setActionLog($extDatas = [])
    {
        return app()->make(Mark::BIND_NAME)->setMarkYes()->setExtDatas($extDatas);
    }

    /**
     * 显示提示消息
     */
    public function showMessage($msg, $links = NULL, $data = NULL, $redirect = true)
    {
        $this->_showMessage($msg, $links, $data, SUCESS_CODE, $redirect);
    }

    /**
     * 显示错误消息
     */
    public function showWarning($msg, $links = NULL, $data = NULL, $redirect = true)
    {
        $this->_showMessage($msg, $links, $data, FAILURE_CODE, $redirect);
    }

    /**
     *    显示消息
     */
    public function _showMessage($msgs, $links, $data, $code, $redirect)
    {
        header("Content-type:text/html;charset=utf-8");
        if(!is_array($msgs)) {
            $msgs = array($msgs);
        }
        $urls = $links;
        if(!is_array($links)) {
            $urls = array();
            if($links) {
                $urls[0]['url']    =  $links;
            }elseif(isset($_SERVER['HTTP_REFERER'])) {
                $urls[0]['url'] = $_SERVER['HTTP_REFERER'];
            }else{
                $urls[0]['url']    =  'javascript:history.back();';

            }
            $urls[0]['title']  = '点击立即跳转';
        }

        if($redirect) {
            $redirect = $urls[0]['url'];
            $redirect = (strstr($redirect, 'javascript:') !== false) ? $redirect : "location.href='{$redirect}'";
        } else {
            $redirect = '';
        }

        if(Request::ajax()){
            $retval['msg'] = $msgs;
            $retval['redirect'] = $redirect;
            $retval['data'] = $data;
            $retval['status'] = $code;
            echo json_encode($retval);exit;
            return ;
        }
        if($links=="refresh") {
            echo "<script>alert('{$msgs[0]}');</script>";
            echo "<script>window.close();</script>";
            echo "<script>opener.location.reload();</script>";
            exit;
        }
        if($code==SUCESS_CODE) {
            $ico = '<i class="fa fa-check"></i>';
            $titleHtml = '信息提示';
        }else{
            $ico = '<i class="fa fa-warning"></i>';
            $titleHtml = '错误警告';
        }
        $msgHtml = '';
        foreach ($msgs as $msg) {
            $msgHtml .= "<li>$msg</li>";
        }
        $urlHtml = '';
        foreach ($urls as $url) {
            if($url['url'] == 'history_back'){
                $u = "javascript:history.back();";
            }else{
                $u = $url['url'];
            }
            $urlHtml .= '&nbsp;<a  class="btn btn-primary"  href="' . $u . '" >' . $url['title'] . '</a>';
        }

        $html ='<!DOCTYPE html>
                <html>
                <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta name="renderer" content="webkit">
                    <title>' . $titleHtml .'</title>
                    <link href="/base/css/bootstrap.min.css?v=3.4.0.css"  rel="stylesheet">
                    <link href="/base/css/font-awesome.min.css?v=4.3.0.css"  rel="stylesheet">
                    <link href="/base/css/style.min.css?v=3.0.0.css"  rel="stylesheet">
                    <script type="text/javascript">
                            setTimeout(function(){
                                var url = "' . $urls[0]['url'] . '";
                                if(url == "history_back"){
                                    window.location.href = history.back();
                                }else{
	                               window.location.href = url;
	                            }
	                        }, 3000);
                    </script>
                </head>
                
                <body class="gray-bg">
                    <div class="ibox-content middle-box" style="width:600px; margin-top: 150px;">
                        <h2 class="text-center">' . $ico . ' ' . $titleHtml . '</h2>
                        <ul class="todo-list m-t ui-sortable">
                           ' . $msgHtml . '
                        </ul>
                        <div class="text-center">
                                                                             该页面将在 3 秒钟后自动转向
                        </div>
                        <div class="text-center" style="margin-top: 10px;">
                           ' . $urlHtml . '
                          
                            <a href="javascript:history.back();" class="btn  btn-success">
                                                                                 返回
                            </a>
                        </div>
                    </div>
                </body>
                </html>';
        exit($html);
    }

}
