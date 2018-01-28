@extends('admin.layout')

@section('header')
<style>
.footable-row-detail-value{width:93%;}
.footable-row-detail-value div.wrap{width:92%;word-break:break-all;}
.footable-row-detail-inner{width: 100%;}
</style>

<link href="/base/css/plugins/footable/footable.core.css" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>操作列表</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
				    <div class="row">
                    	<div class="col-sm-1 m-b-xs">
                        	<label class="font-noraml">类型</label>
                            <select class="input-sm form-control input-s-sm inline" name="topic" id="topic">
                            	<option value="0">请选择</option>
                            	@foreach($aTopIc as $key => $item)
                                <option value="{{ $key }}" @if($key==$topic) selected="selected" @endif>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                       <div class="col-sm-1 m-b-xs">
                        	<label class="font-noraml">行数</label>
                            <select class="input-sm form-control input-s-sm inline" name="region_id" id="sel_region_id">
                            	<option value="0">请选择</option>
                            	@foreach($aLine as $key => $item)
                                <option value="{{ $key }}" @if($key==$line) selected="selected" @endif>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1 m-b-xs">
                        	<label class="font-noraml">来源</label>
                            <input type="text" value="{{Request::get('from')}}"	placeholder="请输入关键词 " name="from" class="input-sm form-control">
                        </div>
                       
                        <div class="col-sm-3 m-b-xs">
                        	<label class="font-noraml">时间范围</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input class="form-control layer-date" placeholder="YYYY-MM-DD hh:mm:ss" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="{{$start_time}}" name="start_time">
                                <span class="input-group-addon">到</span>
                                <input class="form-control layer-date" placeholder="YYYY-MM-DD hh:mm:ss" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="{{$end_time}}" name="end_time">
                            </div>
                        </div>
					</div>
				    <div class="row">
    					<div class="col-sm-5">
    						<form method="GET" action="" accept-charset="UTF-8">
        						<div class="input-group">
                                    <input type="text" value="{{Request::get('keyword')}}"	placeholder="请输入关键词 " name="keyword" class="input-sm form-control"> 
                                    <span class="input-group-btn">
                                    	<button type="submit" class="btn btn-sm btn-primary">搜索</button>
                                    </span>
        						</div>
    						</form>
    					</div>
					</div>
                    <div class="row">
                        <div class="col-sm-1 pull-left">
                            <div class="input-group">
                            </div>
    					</div>
                    </div>
					<table class="footable table table-stripped toggle-arrow-tiny table-bordered table-hover dataTable breakpoint">
						<thead>
							<tr>
								<th>时间</th>
								<th>IP</th>
								<th>METHOD</th>
								<th>功能</th>
								<th>URL</th>
								
							</tr>
						</thead>
						<tbody>
						@if($data)
						    <?php $list = $data->getLogs()?>
							@foreach($list as $key=>$item)
							<?php $contents = $item->getContents();?>
							<tr class="@if($key+1 & 1) footable-even @else footable-odd @endif" style="display: table-row;">
								<td>{{$item->getTime()}}</td>
								<td>{{$item->getSource()}}</td>
								<td>{{$contents['method'] or ''}}</td>
								<td >{{$contents['module'] or ''}}.{{$contents['class'] or ''}}.{{$contents['action'] or ''}}</td>
								<td>{{$contents['url'] or ''}}</td>
							</tr>
							@endforeach
					    @endif
						</tbody>
					</table>
					<div class="row">
					  @if($data)
						<div class="col-sm-6">
							<div class="dataTables_info" role="alert" aria-live="polite" aria-relevant="all">总 {{$data->getCount()}}条。</div>
						</div>
					@endif
						<div class="col-sm-6">
						<div class="dataTables_paginate paging_simple_numbers">
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection



@section('footer')
<script>

function zankaiAndshouqi(statu,$target){
	var $detail = $target.next();
	var display = $detail.css('display');
	
	if(statu){
		//存在则由总的控制
		display = statu=='zankai'?'none':'';
	}
	
	if(display != 'none'){
		$target.removeClass('footable-detail-show');
		$detail.css('display', 'none');
	}else{
		$target.addClass('footable-detail-show');
		$detail.css('display', 'table-row');
	}
}
</script>
@endsection