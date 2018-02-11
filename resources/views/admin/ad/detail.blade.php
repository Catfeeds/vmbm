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
                        <h5>广告详情</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-8">
                                <a class="btn btn-primary pull-right" href="{{ U('AD/index') }}">返回列表</a>
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
                            <div class="col-sm-2 col-sm-offset-2 sg-label">商家名称</div>
                            <div class="col-sm-6 sg-value">{{ $item->name }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">商家电话</div>
                            <div class="col-sm-6 sg-value">{{ $item->tel }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">充值金额</div>
                            <div class="col-sm-6 sg-value">{{ $item->money }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">吸粉数上限</div>
                            <div class="col-sm-6 sg-value">{{ $item->limit }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">已吸粉数上限</div>
                            <div class="col-sm-6 sg-value">{{ $item->num }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">日吸粉数上限</div>
                            <div class="col-sm-6 sg-value">{{ $item->day_limit }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">开始日期</div>
                            <div class="col-sm-6 sg-value">{{ $item->begin_date }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">截止日期</div>
                            <div class="col-sm-6 sg-value">{{ $item->end_date }}</div>
                        </div>
                        <div class="row sg-item">
                            <div class="col-sm-2 col-sm-offset-2 sg-label">状态</div>
                            <div class="col-sm-6 sg-value">
                                @if($item->auth_status == 0)
                                    <span class="label label-default">下架</span>
                                @else
                                    <span class="label label-success">上架</span>
                                @endif
                            </div>
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