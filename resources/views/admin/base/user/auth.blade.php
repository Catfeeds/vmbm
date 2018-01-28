@extends('admin.layout')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>编辑用户角色</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">

					@if(role('Foundation/User/index'))
				    <div class="row">
    					<div class="col-sm-3 pull-right">
    					   <a href="{{ U('Base/User/index')}}" class="btn btn-sm btn-primary pull-right">返回列表</a>
    					</div>
					</div>
					@endif

					<div class="row">
            			<div class="col-lg-10">
                            <form name="form_product" id="form-validation" action="" class="form-horizontal form-validation" accept-charset="UTF-8" method="post">

                                <div class="form-group">
                                    <label class="control-label col-sm-3">所属角色</label>
                                    <div class="col-sm-9">
                                        @foreach($roles AS $val)
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="info[admin_role_id][]" value="{{ $val['id'] }}" @if(isset($data['admin_role_id']) && in_array($val['id'], explode(',', $data['admin_role_id']))) checked @endif>{{ $val['name'] }}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3">账号</label>
                                    <div class="col-sm-9"><input class="form-control" type="text" placeholder="请输入你要授权的邮箱或手机号" required="" aria-required="true" value="" id="search_email" />
                                    </div>
                                </div>
                                <div id="search_content" style="display:none">
                                     <div class="form-group">
                                        <label class="control-label col-sm-3">编号</label>
                                        <div class="col-sm-9"><input class="form-control user_id" type="text" id="user_id" readonly="readonly" required="没有匹配到用户" aria-required="true" name="info[id]" value="" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">姓名</label>
                                        <div class="col-sm-9 user_name"><input class="form-control user_name"  id="user_name"  readonly="readonly"  name="info[name]" type="text" value="" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">EMAIL</label>
                                        <div class="col-sm-9 user_emial"><input class="form-control user_email" id="user_email" readonly="readonly"  name="info[email]" type="text" value="" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">手机号</label>
                                        <div class="col-sm-9 user_mobile"><input class="form-control user_mobile" id="user_mobile" readonly="readonly"  name="info[mobile]" type="text" value="" /></div>
                                    </div>
                                    <input name="user_type" class="user_type" type="hidden" value="" />
                                </div>
                                 
                                <div class="form-group">
                                    <label class="control-label col-sm-3">&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
										<input type="hidden" name="_referer" value="<?php echo urlencode($_SERVER['HTTP_REFERER']); ?>"/>
                                        <input type="submit" id="submit" class="btn btn-success" style="margin-right:20px;">
                                        <input type="reset" class="btn btn-default" >
                                    </div>
                                </div>
                            </form>
                        </div>
            			<!-- /.col-lg-10 -->
            		</div>
            		<!-- /.row -->
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal inmodal fade" id="add_content" >
  <div class="form-group  text-center">
                                                                        你还没有账号，请先添加账号
  </div>
     
    <div class="form-group">
        <label class="control-label col-sm-3">姓名</label>
        <div class="col-sm-9 user_name"><input class="form-control"  id="add_user_name"  type="text" value="" /></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3">EMAIL</label>
        <div class="col-sm-9 user_emial"><input class="form-control" id="add_user_email" type="text" value="" /></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3">手机号</label>
        <div class="col-sm-9 user_mobile"><input class="form-control" id="add_user_mobile" type="text" value="" /></div>
    </div>
     <div class="form-group">
        <label class="control-label col-sm-3">密码</label>
        <div class="col-sm-9 user_mobile"><input class="form-control" id="add_user_password" type="text" value="" /></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3">验证码</label>
        <div class="col-sm-4 user_mobile"><input class="form-control" id="add_user_captchaCode" type="text" value="" /></div>
        <div class="col-sm-3 user_mobile"><img onclick="this.src='/security/captcha?v=' + Math.random()" style="cursor:pointer" src="/security/captcha?v=<?php time()?>" id="captchaCodeImg"></div>
    </div>
    <div class="form-group  text-center">
    <input type="button" id="add_user" value="点击添加" class="btn btn-success" style="margin-right:50px;">
    </div>
</div>
<script>
	$(function() {
		$("#search_email").blur(function() {
			if($(this).val()=='') {
				return false;
			}
			var _SUCESS_CODE = <?php echo SUCESS_CODE; ?>;
			$.post('/api/user/userinfo', {'loginName':$(this).val()}, function(data){
				if(data.status == _SUCESS_CODE) {
					$(".user_id").val(data.data.id);
					$(".user_name").val(data.data.name);
					$(".user_email").val(data.data.email);
					$(".user_mobile").val(data.data.mobile);
					$(".user_type").val(data.data.type);
					
					$("#search_content").show();
					$("#search_content input").attr("readonly","readonly");
				}else{
					alert(data.msg);
					$("#search_content").hide();
					$("#search_content input").val("");
				}	
			});
		});
	  $("#submit").click(function() {
		 	
	  });
	  $("#add_user").click(function() {
			name = $("#add_user_name").val();
			email = $("#add_user_email").val();
			mobile = $("#add_user_mobile").val();
			password = $("#add_user_password").val();
			captchaCode = $("#add_user_captchaCode").val();
			data = {name:name,email:email,mobile:mobile,password:password,captchaCode};
			if(name && email && mobile && password && captchaCode) {
				$.ajax({
		           type: 'PUT',
		           url: '/services/user/stuff/create',
		           contentType:'application/json;charset=UTF-8',
		           data:JSON.data,
		           dataType: 'json',
		           timeout: 300,
		           context: $('body'),
		           success: function(data){
		              //TODO:弹出预约成功对话框
		               clearFormInput();
		           }, error: function(){
		               //TODO:弹出预约失败对话框
		               alert("非常抱歉，网络出现异常，请稍后再试!");
		           }
		       });
			}else{
				alert("请输入正确数据")
			}
	  });

	  
	});
</script>
@endsection
