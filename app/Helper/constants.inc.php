<?php
/**
 *  全局的常量配置
 */

// ===================== 返回状态 ================== //
define("SUCESS_CODE", 200);
define("FAILURE_CODE", 400);
define("SERVER_ERROR",500);
define("NO_PERMISSION",401);
define("APP_PATH", str_replace('\\', '/', substr(__DIR__, 0, -6)));
define("SYSTEM_TIME", time());
defined("PAGE_NUMS") || define("PAGE_NUMS", 10);
define("PAGE_MAX_NUMS", 50);

//网站登录SESSION
define("LOGIN_OPENID_SESSION_KEY", 'LOGIN_OPENID_SESSION_KEY');
define("AUTH_BACK_REDIRECT", 'AUTH_BACK_REDIRECT');

//网站管理角色
define("WEB_ADMIN_ROLE", 'ROLE_WEB_ADMIN');

defined("LOGIN_MARK_SESSION_KEY") || define("LOGIN_MARK_SESSION_KEY", 'tewelwekrkjk34293423k4jnn');
defined("USER_ROOT_ID") || define("USER_ROOT_ID", '0');
defined("USER_ROOT_EMAIL") || define("USER_ROOT_EMAIL", 'root');

/*
 * 当前现有系统
 */




