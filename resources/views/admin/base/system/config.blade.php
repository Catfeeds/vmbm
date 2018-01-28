@extends('admin.layout')

@section('content')

<?php
    if(!isset($data)) $data = array();
    if(!$data && session("data")){
        $data = session("data");
    }
    if(!$data && session('_old_input')){
        $data = session("_old_input");
    }
    if(!isset($data['target'])) {
        $data['target'] = '_blank';
    }
?>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>系统配置</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
		            <div class="row">
                        <div class="col-lg-10">
                            <form name="form_product" id="form-validation" action="" class="form-horizontal form-validation" accept-charset="UTF-8" method="post">
                                <div>在模板添加即可加入配置</div>
                               <div class="form-group">
                                    <label class="control-label col-sm-3">设置维护模式</label>
                                    <div class="col-sm-9">
                                        <input id="c_page" name="data[app_debug]" class="form-control" value="{{ $data['app_debug'] or ''}}" required="" aria-required="true"  placeholder="待定">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3">&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
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