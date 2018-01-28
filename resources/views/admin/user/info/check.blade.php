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

						<table class="table table-striped table-bordered table-hover dataTables-example dataTable dataCheckTable">
							<thead>
							<tr>
								<th><input class="btSelectAll" name="btSelectAll" type="checkbox"></th>
								
            <th class="sorting" data-sort="id"> 用户ID </th>
            <th class="sorting" data-sort="username"> 登录名 </th>
            <th class="sorting" data-sort="real_name"> 姓名 </th>
            <th class="sorting" data-sort="password"> 密码 </th>
            <th class="sorting" data-sort="email"> EMAIL </th>
            <th class="sorting" data-sort="mobile"> 手机号 </th>
            <th class="sorting" data-sort="avatar"> 用户头像 </th>
            <th class="sorting" data-sort="gender"> 性别,1:男,2:女,参照数据字典 </th>
            <th class="sorting" data-sort="province"> 居住地址省 </th>
            <th class="sorting" data-sort="city"> 居住地址市 </th>
            <th class="sorting" data-sort="county"> 居住地址区县 </th>
            <th class="sorting" data-sort="work_type"> 工作类型：上班，自由职业者 </th>
            <th class="sorting" data-sort="address"> 详细地址 </th>
            <th class="sorting" data-sort="address_time"> 居住时长 </th>
            <th class="sorting" data-sort="idcard"> 身份证号 </th>
            <th class="sorting" data-sort="idcard_positive"> 身份证正面 </th>
            <th class="sorting" data-sort="idcard_back"> 身份证背面 </th>
            <th class="sorting" data-sort="educational"> 学历 </th>
            <th class="sorting" data-sort="marital"> 婚姻状况 </th>
            <th class="sorting" data-sort="last_login_time"> 最后一次登录时间 </th>
            <th class="sorting" data-sort="contact_bind"> 直系亲属联系人关系 </th>
            <th class="sorting" data-sort="contact_name"> 直系亲属联系人姓名 </th>
            <th class="sorting" data-sort="contact_mobile"> 直系亲属联系人手机 </th>
            <th class="sorting" data-sort="other_contact_bind"> 其他联系人关系 </th>
            <th class="sorting" data-sort="other_contact_name"> 直系亲属联系人姓名 </th>
            <th class="sorting" data-sort="other_contact_mobile"> 直系亲属联系人手机 </th>
            <th class="sorting" data-sort="created_at"> 创建时间 </th>
            <th class="sorting" data-sort="updated_at"> 更新时间 </th>
								<th width="22%">相关操作</th>
							</tr>
							</thead>
							<tbody>
							@if(isset($list))
								@foreach($list as $key => $item)
									<tr>
									<td><input data-json='{!! json_encode($item) !!}'  name="btSelectItem" class="data_key" type="checkbox" value="{{ $item->id or 0 }}" /></td>
									
            <td>{{ $item->id }}</td>
            <td>{{ $item->username }}</td>
            <td>{{ $item->real_name }}</td>
            <td>{{ $item->password }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->mobile }}</td>
            <td>{{ $item->avatar }}</td>
            <td>{{ $item->gender }}</td>
            <td>{{ $item->province }}</td>
            <td>{{ $item->city }}</td>
            <td>{{ $item->county }}</td>
            <td>{{ dict()->get('user_info','work_type',$item->work_type) }}</td>
            <td>{{ $item->address }}</td>
            <td>{{ dict()->get('user_info','address_time',$item->address_time) }}</td>
            <td>{{ $item->idcard }}</td>
            <td>{{ $item->idcard_positive }}</td>
            <td>{{ $item->idcard_back }}</td>
            <td>{{ $item->educational }}</td>
            <td>{{ dict()->get('user_info','marital',$item->marital) }}</td>
            <td>{{ $item->last_login_time }}</td>
            <td>{{ dict()->get('user_info','contact_bind',$item->contact_bind) }}</td>
            <td>{{ $item->contact_name }}</td>
            <td>{{ $item->contact_mobile }}</td>
            <td>{{ dict()->get('user_info','other_contact_bind',$item->other_contact_bind) }}</td>
            <td>{{ $item->other_contact_name }}</td>
            <td>{{ $item->other_contact_mobile }}</td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->updated_at }}</td>
									<td>
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
	@include('admin.tools.check_script');

@endsection