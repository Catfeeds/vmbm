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
?>
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
                    @if(role('Base/Settings/index'))
				    <div class="row">
    					<div class="col-sm-3 pull-right">
    					   <a href="{{ U('Base/Settings/index')}}" class="btn btn-sm btn-primary pull-right">返回列表</a>
    					</div>
					</div>
                    @endif

		            <div class="row">
                        <div class="col-lg-10">
                            <form name="form_product" id="form-validation" action="" class="form-horizontal form-validation" accept-charset="UTF-8" method="post">

                                    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">键</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_key" name="data[key]" class="form-control" value="{{ $data['key'] or ''}}" required="" aria-required="true"  placeholder=""> 
                    </div>
                                
                </div>
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">值</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_value" name="data[value]" class="form-control" value="{{ $data['value'] or ''}}" required="" aria-required="true"  placeholder=""> 
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">排序</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_sort" name="data[sort]" class="form-control" value="{{ $data['sort'] or ''}}" required="" aria-required="true"  placeholder=""> 
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">配置类别</label>
                                    
                   <div class="col-sm-9">
                       <select  aria-required="true" class="form-control" name="category">
                       @foreach($categories as $cat)
                           <option value="{{ $cat->key }}" @if(isset($data['category']))  {!! $cat->key == $data['category'] ? ' selected' : '' !!}  @endif>{{ $cat->value }}</option>
                       @endforeach
                       </select>
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">父节点</label>
                                    
                   <div class="col-sm-9">
                       @if(isset($data['pid']))
                           {!!  widget('Tools.Setting')->treeSelect('pid', $data['pid']) !!}
                       @else
                           {!!  widget('Tools.Setting')->treeSelect('pid', 0) !!}
                       @endif
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">状态</label>
                                    
                   <div class="col-sm-9">
                           <input type="radio" name="data[status]" value="1" @if(!isset($data['status']) || $data['status'] == "1")checked="checked" @endif>启用
                           &nbsp; &nbsp; &nbsp;
                           <input type="radio" name="data[status]" value="0" @if(isset($data['status']) && $data['status'] == "0")checked="checked" @endif>禁用
                    </div>
                                
                    </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3">&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="_referer" value="<?php echo urlencode(request()->server('HTTP_REFERER'));?>"/>
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