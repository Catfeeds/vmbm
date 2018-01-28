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

						<table class="table table-striped table-bordered table-hover dataTables-example dataTable dataCheckTable">
							<thead>
							<tr>
								<th><input class="btSelectAll" name="btSelectAll" type="checkbox"></th>
								
            <th class="sorting" data-sort="id">  </th>
            <th class="sorting" data-sort="key"> 配置代码 </th>
            <th class="sorting" data-sort="value"> 配置名称 </th>
            <th class="sorting" data-sort="sort"> 排序 </th>
            <th class="sorting" data-sort="category"> 配置类型 </th>
            <th class="sorting" data-sort="pid"> 父id </th>
            <th class="sorting" data-sort="status"> 图片状态 </th>
								<th width="22%">相关操作</th>
							</tr>
							</thead>
							<tbody>
							@if(isset($list))
								@foreach($list as $key => $item)
									<tr>
									<td><input data-json='{!! json_encode($item) !!}'  name="btSelectItem" class="data_key" type="checkbox" value="{{ $item->id or 0 }}" /></td>
									
            <td>{{ $item->id }}</td>
            <td>{{ $item->key }}</td>
            <td>{{ $item->value }}</td>
            <td>{{ $item->sort }}</td>
            <td>{{ $item->category }}</td>
            <td>{{ $item->pid }}</td>
            <td>{{ $item->status }}</td>
									<td>
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
	@include('admin.tools.check_script');

@endsection