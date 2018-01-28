@extends('admin.layout')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>菜单管理</h5>
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
									<input type="text" value="{{Request::get('keyword')}}" placeholder="请输入关键词" name="keyword" class="input-sm form-control"> <span class="input-group-btn">
										<button type="submit" class="btn btn-sm btn-primary">搜索</button>
									</span>
								</div>
							</form>
						</div>

						@if(role('Foundation/Menus/create'))
						<div class="col-sm-3 pull-right">
							<a href="{{ U('Base/Menus/create')}}" class="btn btn-sm btn-primary pull-right">添加</a>
						</div>
						@endif
					</div>
					<table class="table table-striped table-bordered table-hover dataTables-example">
						<thead>
							<tr>
							    <th>名称</th>
								<th>URl</th>
								<th>是否显示</th>
								<th>排序</th>
								<th>相关操作</th>
							</tr>
						</thead>
						<tbody>
							@foreach($list as $val)
							<tr>
							    <td>{{ $val['spacer'] }}{{ $val['name'] }}</td>
								<td>{{ $val['path'] }}</td>

								<td>
								@if($val['display'] == 0)
                                <font color="#46b8da">隐藏</font>
                                @else
                                <font color="red">显示</font>
                                @endif
								</td>
								<td>{{ $val['sort'] }}</td>
								<td>
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle" aria-expanded="false">
											操作 <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											@if(role('Foundation/Menus/create'))
										    <li><a href="{{ U('Base/Menus/create',['pid'=>$val['id']])}}" class="font-bold">添加子菜单</a></li>
										    @endif

											@if(role('Foundation/Menus/update'))
											<li class="divider"></li>
											<li><a href="{{ U('Base/Menus/update',['id'=>$val['id']])}}" class="font-bold">修改</a></li>
											@endif

											@if(role('Foundation/Menus/destroy'))
											<li class="divider"></li>
											<li><a href="{{ U('Base/Menus/destroy',['id'=>$val['id']])}}" onclick="return confirm('你确定执行删除操作？');">删除</a></li>
											@endif
										</ul>
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
