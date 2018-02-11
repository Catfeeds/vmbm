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
                        <h5>编辑广告</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" role="form" method="POST" action="{{ U('AD/update') }}">
                            {{ csrf_field() }}

                            <input class="form-control" type="hidden" name="id" value="{{ $item->id }}">
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">公众号ID</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="wechat_id" value="{{ $item->wechat_id }}" placeholder="请输入公众号ID" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">公众号名</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="wechat_name" value="{{ $item->wechat_name }}" placeholder="请输入公众号名" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">商家名称</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="name" value="{{ $item->name }}" placeholder="请输入商家名称" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">商家电话</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="tel" value="{{ $item->tel }}" placeholder="请输入商家电话" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">充值金额</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="money" value="{{ $item->money }}" placeholder="请输入充值金额" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">吸粉数上限</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="limit" value="{{ $item->limit }}" placeholder="请输入吸粉数上限（整数）" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">已吸粉数</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="num" value="{{ $item->num }}" placeholder="请输入已吸粉数（整数）" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">日吸粉数上限</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="day_limit" value="{{ $item->day_limit }}" placeholder="请输入日吸粉数上限（整数）" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">开始日期</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="date" name="begin_date" value="{{ $item->begin_date }}" placeholder="请输入开始日期" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">截止日期</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="date" name="end_date" value="{{ $item->end_date }}" placeholder="请输入截止日期" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">状态</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="1" {{ $item->status == 1 ? 'checked' : '' }}>上架
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="0" {{ $item->status == 0 ? 'checked' : '' }}>下架
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