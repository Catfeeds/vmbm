@extends('admin.layout')

@section('content')
 <SCRIPT type="text/javascript">
	<!--
	var setting = {
		check: {
			enable: true
		},
		data: {
			simpleData: {
				enable: true
			}
		}
	};

	var zNodes =<?php echo json_encode($zTree) ?>;;
	
	var code;
	
	function setCheck() {
		var zTree = $.fn.zTree.getZTreeObj("zTree-container"),
		py = $("#check_py").is(':checked') ? "p":"",
		sy = $("#check_sy").is(':checked') ? "s":"",
		pn = $("#check_pn").is(':checked') ? "p":"",
		sn = $("#check_sn").is(':checked') ? "s":"",
		type = { "Y":py + sy, "N":pn + sn};
		console.log($("#check_py"));
		console.log(type);
		zTree.setting.check.chkboxType = type;
	}
	 //获取所有选中节点的值
    function getCheckedAll() {
        var treeObj = $.fn.zTree.getZTreeObj("zTree-container");
        var nodes = treeObj.getCheckedNodes(true);
        var checkNodes = new Array();
        for (var i = 0; i < nodes.length; i++) {
            checkNodes.push(nodes[i].id);
        }
        return checkNodes;
    }
	$(document).ready(function(){
		$.fn.zTree.init($("#zTree-container"), setting, zNodes);
		setCheck();
		$("#check_py").bind("change", setCheck);
		$("#check_sy").bind("change", setCheck);
		$("#check_pn").bind("change", setCheck);
		$("#check_sn").bind("change", setCheck);
		$("#sys-ajax-btn-submit").click(function () {
			data = getCheckedAll();
			var params = {menu_ids:data,_token:'<?php echo csrf_token(); ?>'};
			console.log(params);
			var _oldstr = $(this).html();
			$.ajax({
		        type: 'POST', 
		        url: '<?php echo U('Base/Role/auth',array('id'=>$data['id']))?>',
		        data: params,
		        dataType: 'json',
		        headers: {
		        	'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
		       	},
		        success:  function(data) {
			        if(data.status == 200) {
				        alert('操作成功');
			        }else{
				        alert("操作失败");
			        }
		        },
		        beforeSend: function() {
		            var loading = $(this).attr('data-loading') || 'loading...';
		            $(this).html(loading);
		            $(this).attr('disabled', 'disabled');
		        },
		        complete: function() {
		        	$(this).removeAttr('disabled');
		        	$(this).find('.sys-btn-submit-str').html(_oldstr);
		        }
		    });
		});
		
	});
	
	//-->
</SCRIPT>
 
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>设置权限 :"{{$data['name']}}"</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
				    <div class="row"> 被勾选时:           
				        <label class="checkbox-inline">
                       <input type="checkbox" id="check_py" class="checkbox first" checked /> 关联父</label>
                       <label class="checkbox-inline"><input type="checkbox" id="check_sy" class="checkbox first" checked />关联子</label>
                   </div>
                   <div class="row">    
                                                                    取消勾选时：
                        <label class="checkbox-inline"><input type="checkbox" id="check_pn" class="checkbox first" checked />关联父</label>
						<label class="checkbox-inline"><input type="checkbox" id="check_sn" class="checkbox first" checked />关联子</label>
				    </div>
                    <div class="row">
                                                                        
                        <ul id="zTree-container" class="ztree"></ul>
                       
                    </div>				
				<div></div>
				  <div class="btn-toolbar list-toolbar">
                    <a class="btn btn-primary btn-sm" id="sys-ajax-btn-submit" data-loading="保存中..." ><i class="fa fa-save"></i> <span class="sys-btn-submit-str">保存</span></a>
                    <button class="btn btn-default btn-sm" onclick="javascript:history.go(-1);" type="button">返回</button>
                  </div>

					@if(role('Foundation/Role/index'))
				    <div class="row">
    					<div class="col-sm-3 pull-right">
    					   <a href="{{ U('Base/Role/index')}}" class="btn btn-sm btn-primary pull-right">返回列表</a>
    					</div>
					</div>
					@endif

					<div class="row">
            			<div class="col-lg-10">
                            
                        </div>
            			<!-- /.col-lg-10 -->
            		</div>
            		<!-- /.row -->
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('footer')
	 <!-- ztree -->
    <link rel="stylesheet" href="/base/js/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <script type="text/javascript" src="/base/js/zTree_v3/js/jquery.ztree.core-3.5.js?v={{config("sys.version")}}" ></script>
    <script type="text/javascript" src="/base/js/zTree_v3/js/jquery.ztree.excheck-3.5.js?v={{config("sys.version")}}" ></script>
@endsection