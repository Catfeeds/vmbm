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
                        <h5>{{ $client->name . '的' }}设备列表</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <form method="GET" action="" accept-charset="UTF-8">

                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" value="{{ Request::get('keyword') }}" placeholder="请输入设备名进行搜索" name="keyword"class="input-sm form-control">
                                        <span class="input-group-btn">
									<button type="submit" class="btn btn-sm btn-primary">搜索</button>
								</span>
                                    </div>
                                </div>
                            </form>
                            <div class="col-sm-3 pull-right">
                                <a href="{{ U('Device/create')}}" class="btn btn-sm btn-primary pull-right">添加</a>
                            </div>
                        </div>
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
                                <th>客户名</th>
                                <th>客户手机</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($list) == 0)
                                <tr>
                                    <td colspan="11" class="sg-centered">暂无设备！</td>
                                </tr>
                            @else
                                @foreach($list as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>{{ $item->location }}</td>
                                        <td>{{ $item->IMEI }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>
                                            @if($item->auth_status == 0)
                                                <span class="label label-default">未审核</span>
                                            @elseif($item->auth_status == 1)
                                                <span class="label label-success">审核通过</span>
                                            @else
                                                <span class="label label-danger">审核不过</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == 0)
                                                <span class="label label-default">离线</span>
                                            @elseif($item->status == 1)
                                                <span class="label label-success">在线</span>
                                            @elseif($item->status == 2)
                                                <span class="label label-warning">缺纸</span>
                                            @else
                                                <span class="label label-danger">故障</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->tissue_num }}</td>
                                        <td>{{ $item->client ? $item->client->name : '无' }}</td>
                                        <td>{{ $item->client ? $item->client->phone : '无' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <div class="btn btn-sm btn-success {{ $item->auth_status == 1 ? 'disabled' : '' }} btn-pass" data-id="{{ $item->id }}">审核通过</div>
                                                <div class="btn btn-sm btn-warning {{ $item->auth_status == 2 ? 'disabled' : '' }} btn-not-pass" data-id="{{ $item->id }}">审核不过</div>
                                                <div class="btn btn-sm btn-info btn-detail" data-id="{{ $item->id }}">详情</div>
                                                <div class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}">编辑</div>
                                                <div class="btn btn-sm btn-danger btn-delete" data-id="{{ $item->id }}">删除</div>
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

    <div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="my-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="my-modal-label"></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                        取消
                    </button>
                    <button type="button" class="btn btn-success" id="my-modal-confirm-btn">
                        确认
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="" id="sg-form">
        {{ csrf_field() }}
    </form>
@endsection

@section('footer')
    <script type="text/javascript">
        $(function() {
            $('#sg-table').on('click', '.btn-pass', function () {
                var url = "{{ U('Device/changeAuthStatus') }}" + '?id=' + $(this).attr('data-id') + '&auth_status=1';
                $('#sg-form').attr('action', url);
                $('#my-modal-label').text('确认审核通过？');
                $('#my-modal').modal('show');
            }).on('click', '.btn-not-pass', function () {
                var url = "{{ U('Device/changeAuthStatus') }}" + '?id=' + $(this).attr('data-id') + '&auth_status=2';
                $('#sg-form').attr('action', url);
                $('#my-modal-label').text('确认审核不过？');
                $('#my-modal').modal('show');
            }).on('click', '.btn-delete', function () {
                var url = "{{ U('Device/destroy') }}" + '?id=' + $(this).attr('data-id');
                $('#sg-form').attr('action', url);
                $('#my-modal-label').text('确认删除？');
                $('#my-modal').modal('show');
            }).on('click', '.btn-detail', function () {
                var url = "{{ U('Device/detail') }}" + '?id=' + $(this).attr('data-id');
                window.location = url;
            }).on('click', '.btn-edit', function () {
                var url = "{{ U('Device/edit') }}" + '?id=' + $(this).attr('data-id');
                window.location = url;
            });

            $('#my-modal-confirm-btn').on('click', function () {
                $('#sg-form').submit();
            });
        });
    </script>
@endsection