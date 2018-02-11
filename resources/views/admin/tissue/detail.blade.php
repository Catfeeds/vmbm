@extends('admin.layout')

@section('header')
<style type="text/css">
    .sg-item {
        font-size: 1.3em;
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .sg-value {
        font-weight: bold;
    }
</style>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                @if(isset($errors) && !$errors->isEmpty())
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">
                            &times;
                        </button>
                        @foreach($errors->keys() as $key)
                            {{ $errors->first($key) }}
                        @endforeach
                    </div>
                @endif

                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>纸巾详情</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-8">
                                <a class="btn btn-primary pull-right" href="{{ U('Tissue/index') }}">返回列表</a>
                            </div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">粉丝微信</div>
                            <div class="col-sm-6 sg-value">{{ $item->fan ? $item->fan->wechat_name : '' }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">设备IMEI</div>
                            <div class="col-sm-6 sg-value">{{ $item->device ? $item->device->IMEI : '' }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">状态</div>
                            <div class="col-sm-6 sg-value">
                                @if($item->status == 0)
                                    <span class="label label-success">领取</span>
                                @else
                                    <span class="label label-danger">购买</span>
                                @endif
                            </div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">时间</div>
                            <div class="col-sm-6 sg-value">{{ $item->created_at }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">备注</div>
                            <div class="col-sm-6 sg-value">{{ $item->info }}</div>
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