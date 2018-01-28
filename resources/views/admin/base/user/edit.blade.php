@extends('admin.layout')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo isset($data['id']) ? '编辑' : '添加'; ?>用户</h5>
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
                                    <div class="col-sm-9"><input id="txt_name" name="info[name]" class="form-control" value="{{ $data['name'] or ''}}" placeholder="账号名"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">姓名</label>
                                    <div class="col-sm-9"><input id="txt_real_name" name="info[real_name]" class="form-control" value="{{ $data['real_name'] or ''}}" placeholder="昵称"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">E-mail</label>
                                    <div class="col-sm-9"><input id="txt_email" name="info[email]" class="form-control" value="{{ $data['email'] or ''}}" placeholder="邮箱"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">电话</label>
                                    <div class="col-sm-9"><input id="txt_mobile" name="info[mobile]" class="form-control" value="{{ $data['mobile'] or ''}}" placeholder="手机"></div>

                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3">密码</label>
                                    <div class="col-sm-9">
                                        <input id="c_page" name="info[password]" class="form-control" value="" @if(isset($data['id']) ) placeholder="不修改请留空" @else placeholder="请输入密码" @endif>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3">&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
										<input type="hidden" name="_referer" value="<?php echo urlencode($_SERVER['HTTP_REFERER']); ?>"/>
                                        <input type="submit" class="btn btn-success" style="margin-right:20px;">
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

@endsection
