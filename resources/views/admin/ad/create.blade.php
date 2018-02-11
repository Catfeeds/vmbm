@extends('admin.layout')

@section('header')
    <style type="text/css">
        .sg-centered {
            text-align: center;
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
                        <h5>创建广告</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" role="form" method="POST" action="{{ U('AD/store') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">公众号ID</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="wechat_id" value="{{ Request::get('wechat_id') }}" placeholder="请输入公众号ID" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">公众号名</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="wechat_name" value="{{ Request::get('wechat_name') }}" placeholder="请输入公众号名" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">二维码</label>
                                <div class="col-sm-6">
                                    {!!  widget('Tools.ImgUpload')->single2('/upload/qrcode','img','img', isset($data['img'])? $data['img'] : "", ['class' => '广告二维码']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">商家名称</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="name" value="{{ Request::get('name') }}" placeholder="请输入商家名称" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">商家电话</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="tel" value="{{ Request::get('tel') }}" placeholder="请输入商家电话" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">充值金额</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="money" value="{{ Request::get('money') }}" placeholder="请输入充值金额" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">吸粉数上限</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="limit" value="{{ Request::get('limit') }}" placeholder="请输入吸粉数上限（整数）" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">日吸粉数上限</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="day_limit" value="{{ Request::get('day_limit') }}" placeholder="请输入日吸粉数上限（整数）" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">开始日期</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="date" name="begin_date" value="{{ Request::get('begin_date') }}" placeholder="请输入开始日期" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">截止日期</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="date" name="end_date" value="{{ Request::get('end_date') }}" placeholder="请输入截止日期" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">状态</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="1" checked>上架
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="0">下架
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6 col-sm-offset-4">
                                    <button class="btn btn-primary" type="submit">提交</button>
                                </div>
                            </div>
                        </form>
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