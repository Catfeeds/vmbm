@extends('admin.layout')

@section('header')
    <style type="text/css">

    </style>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">在线</span>
                            <h5>设备</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $devices_cnt }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-default pull-right">离线</span>
                            <h5>设备</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $off_device_cnt }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">缺纸</span>
                            <h5>设备</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $lack_device_cnt }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">故障</span>
                            <h5>设备</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $error_device_cnt }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">总数</span>
                            <h5>客户</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $clients_cnt }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">总数</span>
                            <h5>粉丝</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $fans_cnt }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">总数</span>
                            <h5>广告</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $ads_cnt }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">总关注次数</span>
                            <h5>广告</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $ad_get_cnt }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">上架</span>
                            <h5>广告</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $ad_up_cnt }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">下架</span>
                            <h5>广告</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $ad_down_cnt }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">总数</span>
                            <h5>纸巾</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $tissues_cnt }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">领取</span>
                            <h5>纸巾</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $tissue_get_cnt }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">购买</span>
                            <h5>纸巾</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $tissue_buy_cnt }}</h1>
                        </div>
                    </div>
                </div>
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