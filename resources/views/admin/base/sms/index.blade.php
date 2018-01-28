@extends('admin.layout')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>短信列表</h5>
					<div class="ibox-tools">
						<a class="collapse-link"><i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
				    <div class="row">
    					<div class="col-sm-4">
    						<form method="GET" action="" accept-charset="UTF-8">
        						<div class="input-group">
                                    <input type="text" value="{{Request::get('keyword')}}"	placeholder="请输入关键词" name="keyword" class="input-sm form-control">
                                    <span class="input-group-btn">
                                    	<button type="submit" class="btn btn-sm btn-primary">搜索</button>
                                    </span>
        						</div>
    						</form>
    					</div>
					</div>
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
						<thead>
							<tr>
								<th class="sorting" data-sort="id">ID</th>
								<th>内容</th>
								<th class="sorting" data-sort="mobile">手机</th>
								<th class="sorting" data-sort="status">状态</th>
								<th>消息</th>
								<th class="sorting" data-sort="created_at">发送时间</th>
							</tr>
						</thead>
						<tbody>
						@if(isset($list))
							@foreach($list as $item)
							<tr>
								<td>{{ $item->id }}</td>
								<td>{{ $item->content }}</td>
								<td>{{ $item->mobile }}</td>
								<td>{{ $item->status }}</td>
								<td>{{ $item->return_msg }}</td>
								<td>{{ $item->created_at }}</td>
							</tr>
							@endforeach
					    @endif
						</tbody>
					</table>
					@if(isset($list))
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
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
