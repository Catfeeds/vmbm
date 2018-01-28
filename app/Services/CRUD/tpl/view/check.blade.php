@extends('admin.layout')

@section('content')
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>{{desc}}</h5>
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
							@if(role('{{path}}/create'))
								<div class="col-sm-3 pull-right">
									<a href="{{ U('{{path}}/create')}}" class="btn btn-sm btn-primary pull-right">添加</a>
								</div>
							@endif
						</div>

						<table class="table table-striped table-bordered table-hover dataTables-example dataTable dataCheckTable">
							<thead>
							<tr>
								<th><input class="btSelectAll" name="btSelectAll" type="checkbox"></th>
								{{listThStr}}
								<th width="22%">相关操作</th>
							</tr>
							</thead>
							<tbody>
							@if(isset($list))
								@foreach($list as $key => $item)
									<tr>
									<td><input data-json='{!! json_encode($item) !!}'  name="btSelectItem" class="data_key" type="checkbox" value="{{ $item->{{primaryKey}} or 0 }}" /></td>
									{{listTdStr}}
									<td>
										@if(role('{{path}}/view'))
											<button onclick="layer.open({type: 2,area: ['80%', '90%'],content: '{{ U('{{path}}/view',['{{primaryKey}}'=>$item->{{primaryKey}}])}}'});"  class="btn btn-primary ">查看</button>
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
	@include('admin.tools.check_script');

@endsection