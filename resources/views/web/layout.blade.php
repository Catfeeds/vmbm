<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
	<meta name="crm" content="http://{{env('CRM_DOMAIN','kefu.liweijia.com')}}/"/>
    <title>纸妹子</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="/base/css/bootstrap.min.css?v=3.4.0.css" rel="stylesheet">
    <link href="/base/css/font-awesome.min.css?v=4.3.0.css" rel="stylesheet">

    <script src="/base/js/jquery-2.1.1.min.js?v={{config("sys.version")}}" ></script>
    <script src="/base/js/bootstrap.min.js?v=3.4.0" ></script>

    @yield('header')
</head>

<body class="gray-bg">
    @yield('content')

	
    @yield('footer')
</body>

</html>