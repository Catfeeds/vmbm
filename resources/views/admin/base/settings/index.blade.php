@extends('admin.layout') 

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>配置列表</h5>
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
						@if(role('Base/Settings/create'))
    					<div class="col-sm-3 pull-right">
    					   <a href="{{ U('Base/Settings/create')}}" class="btn btn-sm btn-primary pull-right">添加</a>
    					</div>
						@endif
					</div>
					
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
						<thead>
    						<tr>
								
            <th class="sorting" data-sort="id">  </th>
            <th class="sorting" data-sort="key"> 键 </th>
            <th class="sorting" data-sort="value"> 值 </th>
            <th class="sorting" data-sort="sort"> 排序 </th>
            <th class="sorting" data-sort="category"> 配置类别 </th>
            <th class="sorting" data-sort="pid"> 父id </th>
            <th class="sorting" data-sort="status"> 状态 </th>
        						<th width="22%">相关操作</th>
        					</tr>
						</thead>
						<tbody>
						@if(isset($list))
							@foreach($list as $key => $item)							<tr>
								
            <td>{{ $item->id }}</td>
            <td>{{ $item->key }}</td>
            <td>{{ $item->value }}</td>
            <td>{{ $item->sort }}</td>
            <td>{{ $item->category }}</td>
            <td>{{ $item->pid }}</td>
			<td>{{ $item->status == '0' ? '禁用':'启用' }}</td>
								<td>
									@if($item->id>=1000)
									<div class="btn-group">
										<button data-toggle="dropdown"
											class="btn btn-warning btn-sm dropdown-toggle"
											aria-expanded="false">
											操作 <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">


											@if(role('Base/Settings/update'))
											<li><a href="{{ U('Base/Settings/update',['id'=>$item->id])}}" class="font-bold">修改</a></li>
											@endif

											@if(role('Base/Settings/destroy'))
											<li class="divider"></li>
											<li><a href="{{ U('Base/Settings/destroy',['id'=>$item->id])}}" onclick="return confirm('你确定执行删除操作？');">删除</a></li>
											@endif

										</ul>
									</div>
									@endif
								@if(role('Base/Settings/view'))
										<button onclick="layer.open({type: 2,area: ['80%', '90%'],content: '{{ U('Base/Settings/view',['id'=>$item->id])}}'});"  class="btn btn-primary ">查看</button>
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