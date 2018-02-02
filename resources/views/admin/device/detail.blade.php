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
                        <h5>设备详情</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-8">
                                <a class="btn btn-primary pull-right" href="{{ U('device/index') }}">返回列表</a>
                            </div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">ID</div>
                            <div class="col-sm-6 sg-value">{{ $item->id }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">名称</div>
                            <div class="col-sm-6 sg-value">{{ $item->name }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">型号</div>
                            <div class="col-sm-6 sg-value">{{ $item->type }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">地点</div>
                            <div class="col-sm-6 sg-value">{{ $item->location }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">编码(IMEI)</div>
                            <div class="col-sm-6 sg-value">{{ $item->IMEI }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">二维码</div>
                            <div class="col-sm-6 sg-value">{{ $item->code }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">审核状态</div>
                            <div class="col-sm-6 sg-value">
                                @if($item->auth_status == 0)
                                    <span class="label label-default">未审核</span>
                                @elseif($item->auth_status == 1)
                                    <span class="label label-success">审核通过</span>
                                @else
                                    <span class="label label-danger">审核不过</span>
                                @endif
                            </div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">状态</div>
                            <div class="col-sm-6 sg-value">
                                @if($item->status == 0)
                                    <span class="label label-default">离线</span>
                                @elseif($item->status == 1)
                                    <span class="label label-sucesss">在线</span>
                                @elseif($item->status == 2)
                                    <span class="label label-warning">缺纸</span>
                                @else
                                    <span class="label label-danger">故障</span>
                                @endif
                            </div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">纸巾数</div>
                            <div class="col-sm-6 sg-value">{{ $item->tissue_num }}</div>
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