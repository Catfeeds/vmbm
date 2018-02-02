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
                        <h5>创建设备</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" role="form" method="POST" action="{{ U('device/store') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">名称</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="name" value="{{ Request::get('name') }}" placeholder="请输入设备名称" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">型号</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="type" value="{{ Request::get('type') }}" placeholder="请输入设备型号" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">地点</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="location" value="{{ Request::get('location') }}" placeholder="请输入设备地点" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">IMEI</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="IMEI" value="{{ Request::get('IMEI') }}" placeholder="请输入设备编码（IMEI地址）" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">审核状态</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="radio" name="auth_status" value="0" checked>未审核
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="auth_status" value="1">审核通过
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="auth_status" value="2">审核不过
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">状态</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="0" checked>离线
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="1">在线
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="2">缺纸
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="3">故障
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">客户</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="client_id">
                                        @foreach($clients as $item)
                                            <option value="{{ $item->id }}"><b>{{ $item->id . ' ' . $item->name }}</b></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-2 control-label">纸巾数</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="tissue_num" value="{{ Request::get('tissue_num') }}" placeholder="请输入设备纸巾数" required>
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