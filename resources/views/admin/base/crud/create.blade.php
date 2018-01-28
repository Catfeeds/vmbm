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
					<h5>CURD</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
		            <div class="row">
                        <div class="col-lg-10">
                            <form name="form_product" id="form-validation" action="" class="form-horizontal form-validation" accept-charset="UTF-8" method="post">
        
        						 <div class="form-group">
                                    <label class="control-label col-sm-3">选择表</label>
                                    <div class="col-sm-9">
                                    	<select id="c_table" name="table" class="form-control">
                                        	<option value="">选择表</option>
                                        	 @foreach($tables as $key => $val)
                                         	    <option value="{{ $val->TABLE_NAME}}" des="{{ $val->TABLE_COMMENT}}">{{ $val->TABLE_NAME}}-{{ $val->TABLE_COMMENT}}</option>
                                             @endforeach
                                         </select>
                                       
                                    </div>
                                </div>
                                <div class="form-group">
                               <label class="control-label col-sm-3">所属菜单</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" required="" aria-required="true" name="menu_pid">
                                            <option value="">请选择所属菜单</option>
                                            @foreach($MenusTrees AS $val)
                                                <option  value={{ $val['id'] }} @if((isset($data['pid']) && $data['pid']==$val['id']) || Request::get('pid')==$val['id']) selected @endif>{{ $val['spacer'] }}{{ $val['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label class="control-label col-sm-3">Description</label>
                                    <div class="col-sm-9">
                                        <input id="c_desc" name="desc" class="form-control" value="" required="" aria-required="true"  placeholder="Model不能为空">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Path</label>
                                    <div class="col-sm-9">
                                        <input id="c_path" name="path" class="form-control" value="" required="" aria-required="true"  placeholder="Path不能为空">
                                        <div id="alert_path" class="alert-danger"></div>

                                    </div>
                                </div>
                               <div class="form-group">
                                    <label class="control-label col-sm-3">Model</label>
                                    <div class="col-sm-9">
                                        <input id="c_model" name="model" class="form-control" value="" required="" aria-required="true"  placeholder="Model不能为空">
                                        <div id="alert_model" class="alert-danger"></div>

                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-sm-3">Repository</label>
                                    <div class="col-sm-9">
                                        <input id="c_repositories" name="repositories" class="form-control" required="" aria-required="true"  value="{{ $data['link'] or ''}}" placeholder="Service不能为空">
                                        <div id="alert_repositories" class="alert-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Control</label>
                                    <div class="col-sm-9">
                                        <input id="c_control" name="control" class="form-control" value="" required="" aria-required="true"  placeholder="控制器不能为空">
                                        <div id="alert_control" class="alert-danger"></div>
                                    </div>
                                </div>
                          
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3">&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="_referer" value="<?php echo urlencode($_SERVER['HTTP_REFERER']);?>"/>
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

@section('footer')
	<script type="text/javascript">
        String.prototype.transform = function(){
            var re=/_(w)/g;
            return this.replace(re,function(){
                var args=arguments;
                return args[1].toUpperCase();
            })
        }
        $(function() {
			$("#c_table").change(function(){
                var table=$(this).val();
                var des = ($(this).find("option[value='"+table+"']").attr("des"));
                $("#c_desc").val(des);
                table = table.replace(/(\w)/,function(v){return v.toUpperCase()})
                PathtableTo = table.replace(/\_(\w)/g, function(all, letter){
                    console.log(all);
                    console.log(letter);
                    return "/" +  letter.toUpperCase();
                });
                Model = table.replace(/\_(\w)/g, function(all, letter){
                    console.log(all);
                    console.log(letter);
                    return  letter.toUpperCase();
                });


                $("#c_model").val(Model + 'Model').trigger("change");
                $("#c_repositories").val(PathtableTo + "Repository").trigger("change");
                $("#c_control").val(PathtableTo + "Controller").trigger("change");
                $("#c_path").val(PathtableTo).trigger("change");

			});
			$("#c_model").change(function() {
                $.getJSON('/Foundation/Crud/checkModelPath?path=' + $(this).val(),function(data) {
                    $("#alert_model").html(data.msg);
                });
            });
            $("#c_repositories").change(function() {
                $.getJSON('/Foundation/Crud/checkServicePath?path=' + $(this).val(),function(data) {
                    if(data.status != 200) {
                        $("#alert_repositories").html(data.msg);
                    }
                });
            });

            $("#c_control").change(function() {
                $.getJSON('/Foundation/Crud/checkControllerPath?path=' + $(this).val(),function(data) {
                    if(data.status != 200) {
                        $("#alert_control").html(data.msg);
                    }
                });
            });
            $("#c_path").change(function() {
                $.getJSON('/Foundation/Crud/checkPath?path=' + $(this).val(),function(data) {
                    if(data.status != 200) {
                        $("#alert_path").html(data.msg);
                    }
                });
            });
         });
	
	
	</script>

@endsection
