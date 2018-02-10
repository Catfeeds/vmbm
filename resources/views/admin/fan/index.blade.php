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
                        <h5>粉丝列表</h5>
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
                                        <input type="text" value="{{ Request::get('keyword') }}" placeholder="请输入微信ID/号进行搜索" name="keyword"class="input-sm form-control">
                                        <span class="input-group-btn">
									<button type="submit" class="btn btn-sm btn-primary">搜索</button>
								</span>
                                    </div>
                                </div>
                            </form>
                            <div class="col-sm-3 pull-right">
                                <a href="{{ U('Fan/create')}}" class="btn btn-sm btn-primary pull-right">添加</a>
                            </div>
                        </div>
                        {{--表格开始--}}
                        <table class="table table-striped table-bordered table-hover dataTable" id="sg-table">
                            <thead>
                            <tr>
                                <th>微信ID</th>
                                <th>微信名</th>
                                <th>消费金额</th>
                                <th>获得纸巾数</th>
                                <th>购买纸巾数</th>
                                <th>领取纸巾数</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($list) == 0)
                                <tr>
                                    <td colspan="7" class="sg-centered">暂无粉丝！</td>
                                </tr>
                            @else
                                @foreach($list as $item)
                                    <tr>
                                        <td>{{ $item->wechat_id }}</td>
                                        <td>{{ $item->wechat_name }}</td>
                                        <td>{{ $item->money }}</td>
                                        <td>{{ $item->num }}</td>
                                        <td>{{ $item->buy_num }}</td>
                                        <td>{{ $item->num - $item->buy_num }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <div class="btn btn-sm btn-default btn-tissue" data-id="{{ $item->id }}">纸巾</div>
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
            $('#sg-table').on('click', '.btn-delete', function () {
                var url = "{{ U('Fan/destroy') }}" + '?id=' + $(this).attr('data-id');
                $('#sg-form').attr('action', url);
                $('#my-modal-label').text('确认删除？');
                $('#my-modal').modal('show');
            }).on('click', '.btn-detail', function () {
                var url = "{{ U('Fan/detail') }}" + '?id=' + $(this).attr('data-id');
                window.location = url;
            }).on('click', '.btn-edit', function () {
                var url = "{{ U('Fan/edit') }}" + '?id=' + $(this).attr('data-id');
                window.location = url;
            }).on('click', '.btn-tissue', function () {
                var url = "{{ U('Tissue/index') }}" + '?fan_id=' + $(this).attr('data-id');
                window.location = url;
            });

            $('#my-modal-confirm-btn').on('click', function () {
                $('#sg-form').submit();
            });
        });
    </script>
@endsection