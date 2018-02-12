@extends('web.layout')

@section('header')
<style type="text/css">

</style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="logo col-sm-6 col-sm-offset-3" align="center">
                <img src="/base/img/meizi.jpeg">
            </div>
        </div>
        <div class="row">
            <div class="logo col-sm-6 col-sm-offset-3" align="center">
                <a href="/web/Index/get" class="btn btn-success btn-clock">领取</a>
            </div>
        </div>
        <div class="row">
            <div class="logo col-sm-6 col-sm-offset-3" align="center">
                <a href="/web/Index/buy" class="btn btn-danger btn-clock">购买</a>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $(function() {

        });
    </script>
@endsection