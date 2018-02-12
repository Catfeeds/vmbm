<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>管理后台</title>

    <!--[if lt IE 8]>
    <script>
        alert('H+已不支持IE6-8，请使用谷歌、火狐等浏览器\n或360、QQ等国产浏览器的极速模式浏览本页面！');
    </script>
    <![endif]-->

    <link href="/base/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="/base/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">
    <link href="/base/css/animate.min.css" rel="stylesheet">
    <link href="/base/css/style.min.css?v={{config("sys.version")}}" rel="stylesheet">
</head>

<body class="fixed-sidebar full-height-layout gray-bg">
    <div id="wrapper">
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                <span class="block m-t-xs"><strong class="font-bold">{{$_user['name']}}</strong></span>
                                <span class="text-muted text-xs block">{{$_user['admin_role_name']}}<b class="caret"></b></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a target="_blank" href="/">网站首页</a></li>
                                <li><a href="/admin/changePassword" class="J_menuItem">修改密码</a></li>
                                <li class="divider"></li>
                                <li><a href="/admin/logout">安全退出</a>
                                </li>
                            </ul>
                        </div>
                        <div class="logo-element">
                        </div>
                    </li>
                    @if(isset($menus))
                     @foreach($menus as $key => $val)  
                        <li> 
                            <a href="<?php if($val['path']=='#'){echo"#";}else{echo U("{$val['path']}");}?>">
                                <i class="fa {{$val['ico']}}"></i>
                                <span class="nav-label">{{$val['name']}}</span> </a>
                                @if(isset($val['_child']))
                                <span class="fa arrow"></span>
                                <ul class="nav nav-second-level">
                                     @foreach($val['_child'] as $key2 => $val2)  
                                        <li>
                                            <a @if($val2['path']=='order_export')target="_blank" @else class="J_menuItem"@endif href="<?php if($val2['path']=='#'){echo"#";}else{echo U("{$val2['path']}");}?>" data-index="0">{{$val2['name']}}</a>
                                        </li>
                                     @endforeach
                                </ul>
                                @endif
                           
                        </li>
                     @endforeach
                    @endif   
                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->
        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">
            {{--<div class="row border-bottom">--}}
                {{--<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">--}}
                    {{--<div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>--}}
                        {{--<form role="search" class="navbar-form-custom" method="post" action="search_results.html">--}}
                            {{--<div class="form-group">--}}
                                {{--<input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search">--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                    {{--<ul class="nav navbar-top-links navbar-right">--}}
                        {{----}}
                        {{--<li class="dropdown hidden-xs">--}}
                            {{--<a class="right-sidebar-toggle" aria-expanded="false">--}}
                                {{--<i class="fa fa-tasks"></i>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</nav>--}}
            {{--</div>--}}
            {{--<div class="row content-tabs">--}}
                {{--<button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>--}}
                {{--</button>--}}
                {{--<nav class="page-tabs J_menuTabs">--}}
                    {{--<div class="page-tabs-content">--}}
                        {{--<a href="javascript:;" class="active J_menuTab" data-id="index_v1.html">首页</a>--}}
                    {{--</div>--}}
                {{--</nav>--}}
                {{--<button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>--}}
                {{--</button>--}}
                {{--<div class="btn-group roll-nav roll-right">--}}
                    {{--<button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>--}}

                    {{--</button>--}}
                    {{--<ul role="menu" class="dropdown-menu dropdown-menu-right">--}}
                        {{--<li class="J_tabShowActive"><a>定位当前选项卡</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li class="J_tabCloseAll"><a>关闭全部选项卡</a>--}}
                        {{--</li>--}}
                        {{--<li class="J_tabCloseOther"><a>关闭其他选项卡</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                {{--<a href="/admin/logout" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>--}}
            {{--</div>--}}
            <div class="row J_mainContent" id="content-main" style="height:calc(100% - 80px)">
                <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="{{ U('Base/Index/welcome')}}" frameborder="0" data-id="index_v1.html" seamless></iframe>
            </div>
            <div class="footer" style="position: fixed;bottom:0;right: 0;left: 0">
                <div class="pull-right">&copy; 2014-2019 <a href="/" target="_blank">纸妹子</a>
                </div>
            </div>
        </div>
        <!--右侧部分结束-->
        <!--右侧边栏开始-->
        <div id="right-sidebar">
           
        </div>
        <!--右侧边栏结束-->
    <!-- 全局js -->
    <script src="/base/js/jquery-2.1.1.min.js?v={{config("sys.version")}}" ></script>
    <script src="/base/js/bootstrap.min.js?v=3.4.0"></script>
    <script src="/base/js/plugins/metisMenu/jquery.metisMenu.js?v={{config("sys.version")}}" ></script>
    <script src="/base/js/plugins/slimscroll/jquery.slimscroll.min.js?v={{config("sys.version")}}" ></script>
    <script src="/base/js/plugins/layer/layer.min.js?v={{config("sys.version")}}" ></script>

    <!-- 自定义js -->
    <script src="/base/js/hplus.min.js?v=3.2.0"></script>
    <script type="text/javascript" src="/base/js/contabs.min.js?v={{config("sys.version")}}" ></script>

    <!-- 第三方插件 -->
    <script src="/base/js/plugins/pace/pace.min.js?v={{config("sys.version")}}" ></script>
    
    
    
</body>

</html>