@extends('admin.layout') 

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>用户管理</h5>
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
								<input type="text" value="{{Request::get('keyword')}}"	placeholder="请输入关键词" name="keyword"class="input-sm form-control"> 
								<span class="input-group-btn">
									<button type="submit" class="btn btn-sm btn-primary">搜索</button>
								</span>
    						</div>
				        </div>
				        </form>
						@if(role('User/Info/create'))
    					<div class="col-sm-3 pull-right">
    					   <a href="{{ U('User/Info/create')}}" class="btn btn-sm btn-primary pull-right">添加</a>
    					</div>
						@endif
					</div>
					
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
						<thead>
    						<tr>
								
            <th class="sorting" data-sort="id"> 用户ID </th>
            <th class="sorting" data-sort="real_name"> 姓名 </th>
            <th class="sorting" data-sort="email"> EMAIL </th>
            <th class="sorting" data-sort="mobile"> 手机号 </th>
            <th class="sorting" data-sort="idcard_back"> 工作类型 </th>
            <th class="sorting" data-sort="educational"> 学历 </th>
								<th class="sorting" data-sort="last_login_time"> 最后登陆时间 </th>

        						<th width="22%">相关操作</th>
        					</tr>
						</thead>
						<tbody>

						@if(isset($list))
							@foreach($list as $key => $item)
								<tr>
									<td>{{ $item->id }}</td>
									<td>{{ $item->real_name }}</td>
									<td>{{ $item->email }}</td>
									<td>{{ $item->mobile }}</td>
									<td>{{ dict()->get('user_info','work_type',$item->work_type) }}</td>
									<td>{{ $item->educational }}</td>
									<td>{{ $item->last_login_time }}</td>
									<td>{{ $item->created_at->format('Y-m-d H:i:s') }}</td>


								<td>
									<div class="btn-group">
										<button data-toggle="dropdown"
											class="btn btn-warning btn-sm dropdown-toggle"
											aria-expanded="false">
											操作 <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">


											@if(role('User/Info/update'))
											<li><a href="{{ U('User/Info/update',['id'=>$item->id])}}" class="font-bold">修改</a></li>
											@endif

											@if(role('User/Info/destroy'))
											<li class="divider"></li>
											<li><a href="{{ U('User/Info/destroy',['id'=>$item->id])}}" onclick="return confirm('你确定执行删除操作？');">删除</a></li>
											@endif

										</ul>
									</div>
								@if(role('User/Info/view'))
										<button onclick="layer.open({type: 2,area: ['80%', '90%'],content: '{{ U('User/Info/view',['id'=>$item->id])}}'});"  class="btn btn-primary ">查看</button>
									@endif
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
				</div>
			</div>
		</div>
	</div>
</div>
@endsection