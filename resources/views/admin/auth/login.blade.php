<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>管理后台</title>
    <meta name="keywords" content="管理后台">
    <link href="/base/css/bootstrap.min.css" rel="stylesheet">
    <link href="/base/css/font-awesome.min.css"  rel="stylesheet">
    <link href="/base/css/animate.min.css" rel="stylesheet">
    <link href="/base/css/style.min.css"  rel="stylesheet">
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <div>
                    <h3 class="logo-name">ZMZ</h3>
                </div>
                <h3>纸妹子后台管理</h3>
            </div>
            <form class="m-t" role="form" accept-charset="UTF-8" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <input name="name" class="form-control" placeholder="用户名" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="密码" required="">
                </div>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
            </form>
        </div>
    </div>

<!-- 全局js -->
<script src="/base/js/jquery-2.1.1.min.js" ></script>
<script src="/base/js/bootstrap.min.js?v=3.4.0" ></script>


<!--统计代码，可删除-->

</body>

</html>