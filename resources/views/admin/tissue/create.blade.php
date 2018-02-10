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
                        <h5>创建纸巾</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" role="form" method="POST" action="{{ U('Tissue/store') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">选择粉丝</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="fan_id" required>
                                        @foreach($fans as $item)
                                            <option value="{{ $item->id }}">{{ $item->wechat_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">选择设备</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="device_id" required>
                                        @foreach($devices as $item)
                                            <option value="{{ $item->id }}">{{ $item->IMEI }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">选择广告</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="ad_id">
                                        @foreach($ads as $item)
                                            <option value="{{ $item->id }}">{{ $item->wechat_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">状态</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="0" checked>领取
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="1">购买
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">备注</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="info" value="" placeholder="请输入备注">
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