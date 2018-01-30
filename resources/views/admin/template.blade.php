@extends('admin.layout')

@section('header')
    <style type="text/css">

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
                        <h5>图片管理</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        {{--表格开始--}}
                        <table class="table table-striped table-bordered table-hover dataTable" id="sg-table">
                            <thead>
                                <tr>
                                    <th>名称</th>
                                    <th>型号</th>
                                    <th>地点</th>
                                    <th>编码(IMEI)</th>
                                    <th>二维码</th>
                                    <th>审核状态</th>
                                    <th>状态</th>
                                    <th>纸巾数</th>
                                    <th>告警信息</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($list) == 0)
                                <tr>
                                    <td colspan="10" class="sg-centered">暂无设备！</td>
                                </tr>
                            @else
                                @foreach($list as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>{{ $item->location }}</td>
                                        <td>{{ $item->IMEI }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->auth_status }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->tissue_num }}</td>
                                        <td>{{ $item->warn_info }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <div class="btn btn-sm btn-danger btn-coupon" data-id="{{ $item->id }}">优惠券</div>
                                                <div class="btn btn-sm btn-info">详情</div>
                                                <div class="btn btn-sm btn-success btn-edit" data-id="{{ $item->id }}">编辑</div>
                                                <div class="btn btn-sm btn-danger">删除</div>
                                                <div class="btn btn-sm btn-primary">订单</div>
                                                <div class="btn btn-sm btn-warning">配送</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="dataTables_info" id="DataTables_Table_0_info"
                                     role="alert" aria-live="polite" aria-relevant="all">每页{{ $list->count() }}条，共{{ $list->lastPage() }}页，总{{ $list->total() }}条。</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    {!! $list->setPath('')->appends(Request::all())->render() !!}
                                </div>
                            </div>
                        </div>
                        {{--表格结束--}}
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