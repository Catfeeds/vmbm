@extends('admin.layout')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>角色列表</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
				    <div class="row">
    					<div class="col-sm-4">
    						<form method="GET" action="" accept-charset="UTF-8">
        						<div class="input-group">
                                    <input type="text" value="{{Request::get('keyword')}}"	placeholder="请输入关键词 （角色名，描述）" name="keyword" class="input-sm form-control"> 
                                    <span class="input-group-btn">
                                    	<button type="submit" class="btn btn-sm btn-primary">搜索</button>
                                    </span>
        						</div>
    						</form>
    					</div>

						@if(role('Foundation/Role/create'))
    					<div class="col-sm-3 pull-right">
    					   <a href="{{ U('Base/Role/create')}}" class="btn btn-sm btn-primary pull-right">添加</a>
    					</div>
						@endif

					</div>
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
						<thead>
							<tr>
								<th class="sorting" data-sort="id">ID</th>
								<th class="sorting" data-sort="name">角色名</th>
								<th>描述</th>
								<th class="sorting" data-sort="level">角色等级</th>
								<th class="sorting" data-sort="status">状态</th>
								<th>相关操作</th>
							</tr>
						</thead>
						<tbody>
						@if(isset($list))
							@foreach($list as $item)
							<tr>
								<td>{{ $item->id }}</td>
								<td>{{ $item->name }}</td>
								<td>{{ $item->mark }}</td>
								<td>{{ $item->level }}</td>
								<td>
								@if($item->status == 0)
                                <font color="red">禁用</font>
                                @else
                                <font color="#46b8da">启用</font>
                                @endif
								</td>
								<td>
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle" aria-expanded="false">
											操作 <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											@if(role('Foundation/Role/update'))
										    <li><a href="{{ U('Base/Role/update')}}?id={{ $item->id }}" class="font-bold">修改</a></li>
											@endif

											@if(role('Foundation/Role/auth'))
											<li><a href="{{ U('Base/Role/auth')}}?id={{ $item->id }}" class="font-bold">授权</a></li>
											@endif

											@if(role('Foundation/Role/status'))
												<li class="divider"></li>
												@if($item->status == 1)
												<li><a href="{{ U('Base/Role/status')}}?id={{ $item->id }}&status=0" >禁用</a></li>
												@else
												<li><a href="{{ U('Base/Role/status')}}?id={{ $item->id }}&status=1" >启用</a></li>
												@endif
											@endif

											@if(role('Foundation/Role/destroy'))
											<li class="divider"></li>
											<li><a href="{{ U('Base/Role/destroy')}}?id={{ $item->id }}" onclick="return confirm('你确定执行删除操作？');">删除</a></li>
											@endif
										</ul>
									</div>
								</td>
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
