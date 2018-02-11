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
                        <h5>粉丝详情</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-8">
                                <a class="btn btn-primary pull-right" href="{{ U('Fan/index') }}">返回列表</a>
                            </div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">公众号ID</div>
                            <div class="col-sm-6 sg-value">{{ $item->wechat_id }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">公众号名称</div>
                            <div class="col-sm-6 sg-value">{{ $item->wechat_name }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">消费金额</div>
                            <div class="col-sm-6 sg-value">{{ $item->money }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">获得纸巾数</div>
                            <div class="col-sm-6 sg-value">{{ $item->num }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">购买纸巾数</div>
                            <div class="col-sm-6 sg-value">{{ $item->buy_num }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">领取纸巾数</div>
                            <div class="col-sm-6 sg-value">{{ $item->num - $item->buy_num }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">注册日期</div>
                            <div class="col-sm-6 sg-value">{{ $item->created_at }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">最近使用日期</div>
                            <div class="col-sm-6 sg-value">{{ $item->updated_at }}</div>
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