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
                        <h5>创建粉丝</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" role="form" method="POST" action="{{ U('Fan/store') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">微信ID</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="wechat_id" value="{{ isset($item) ? $item->wechat_id : '' }}" placeholder="请输入微信ID" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">微信名</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="wechat_name" value="{{ isset($item) ? $item->wechat_id : '' }}" placeholder="请输入微信名" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">消费金额</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="money" value="{{ isset($item) ? $item->money : 0 }}" placeholder="请输入消费金额" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">获得纸巾数</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="num" value="{{ isset($item) ? $item->num : '' }}" placeholder="此为获得的总纸巾数（整数）" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">购买纸巾数</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="buy_num" value="{{ isset($item) ? $item->buy_num : '' }}" placeholder="此为购买的纸巾数（整数）" required>
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