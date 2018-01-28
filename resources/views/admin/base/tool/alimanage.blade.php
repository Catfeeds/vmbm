@extends('admin.layout')

@section('content')

<script type="text/javascript" src="/base/js/zclip/jquery.zclip.min.js?v={{config("sys.version")}}" ></script>
<style type="text/css">
#new-upload-btn { display:none; }
#new-upload-btn .notice{position: relative; left: 8px; top: -9px; color: #1a7bb9;}
#clicklayer {overflow: hidden; height: 35px; position: relative; left: 0; top: 0px;  zoom: 1; z-index: 2; cursor:pointer; }
.opacityupload { width:100%; position: absolute; left: 0px;top: 2px; z-index: 10; height: 35px; opacity: 0; }
.opacityupload  object { width: 100%; cursor:pointer;}
</style>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="file-manager">
                        <h5>当前路径：</h5>
                        <?php echo $folderPath; ?>
                        <div class="hr-line-dashed"></div>
                        <form method="POST" action="" accept-charset="UTF-8">
                        <div class="input-group">
							<input type="text" value=""	placeholder="请输入当前路径下的目录名，不含“/”" name="dirname" class="input-sm form-control"> 
							<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
							<span class="input-group-btn">
								<button type="submit" class="btn btn-sm btn-primary">创建目录</button>
							</span>
						</div>
						</form>
						<div id="new-upload-btn">
                            <div class="hr-line-dashed"></div>
                            <span id="upload_single_file"></span><span class="notice">单一文件上传，同名文件将会被覆盖</span>
                            <div class="hr-line-dashed"></div>
                            <div id="clicklayer">
                                <button class="btn btn-primary btn-block">批量上传文件</button>
                                <div class="opacityupload"><span id="upload_more_file"></span></div>
                            </div>
                        </div>
                        @if(isset($item['dir']))
                        <div class="hr-line-dashed"></div>
                        <h5>文件夹</h5>
                        <ul class="folder-list" style="padding: 0">
                            @foreach($item['dir'] AS $dir)
                            
                            <li><a href="{{ U('Base/Tool/alimanage')}}?folder={{ $dir->getPrefix() }}"><i class="fa fa-folder"></i> {{ $dir->getPrefix() }}</a></li>
                            @endforeach
                        </ul>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9 animated fadeInRight">
            <div class="row">
                <div class="col-sm-12">
                    @if(isset($item['obj']) && is_array($item['obj']))
                    @foreach($item['obj'] AS $file)
                    <?php 
                        if(Request::input('folder') == $file->getKey()) continue;
                        //是否过去日期
                        $pastdate = false;
                        if(strtotime(substr($file->getLastModified(), 0, 10)) < strtotime('2015-11-03')){
                            $pastdate = true;
                        }
                        //是否跟目录
                        $isroot = false;
                        if(strpos($file->getKey(), '/') === false){
                            $isroot = true;
                        }
                        //是否图片类型
                        $isimg = false;
                        if(in_array(fileExt($file->getKey()), array('jpg', 'jpeg', 'gif', 'png', 'bmp'))){
                            $isimg = true;
                        }
                    ?>
                    <div class="file-box">
                        <div class="file">
                            <span class="corner"></span>
                            @if($isimg || ($pastdate && !$isroot))
                            <div class="image">
                                <img alt="image" class="img-responsive" src="{{ $img_path }}{{ $file->getKey() }}@198w">
                            </div>
                            @else
                            <div class="icon">
                                <i class="fa fa-file"></i>
                            </div>
                            @endif
                            <div class="file-name">
                            <input type="hidden" id="<?php echo trim($file->getETag(), '"'); ?>" value="{{ $img_path }}{{ $file->getKey()}}">
                            <button type="button" class="btn btn-primary btn-xs copy-btn" value="<?php echo trim($file->getETag(), '"'); ?>">复制链接</button>
                            @if($isimg || ($pastdate && !$isroot))
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-primary btn-xs" onclick="showImg('<?php echo trim($file->getETag(), '"'); ?>');">查看大图</button>
                            @endif
                            <br><br>
							@if($isroot)
								<div style="width:182px;height:32px;word-break:break-all;">{{ $file->getKey() }}</div>
							@else
								<div style="width:182px;height:32px;word-break:break-all;">{{ substr(strrchr($file->getKey(), '/'), 1) }}</div>
							@endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/base/js/swfupload/swfupload.js?v={{config("sys.version")}}" ></script>
<script type="text/javascript" src="/base/js/swfupload/swfupload.queue.js?v={{config("sys.version")}}" ></script>
<script type="text/javascript" src="/base/js/swfupload/fileprogress.js?v={{config("sys.version")}}" ></script>
<script type="text/javascript" src="/base/js/swfupload/handlers.js?v={{config("sys.version")}}" ></script>
<script type="text/javascript">
var loadlayer;
var swfu = '';
function initUploadControl(id, num, rename) {
	var settings = {
		flash_url : "/base/js/swfupload/swfupload.swf",
		post_params : {"PHPSESSID" : "<?php echo time(); ?>", 'rename' : rename, "elementid" : id, "_token" : "<?php echo csrf_token(); ?>", "position" : "ali", "folder" : "<?php echo trim(Request::input('folder'), '/'); ?>"},
		upload_url : "<?php echo U('Base.attachment.upload'); ?>",
		file_size_limit : "5 MB",
		file_types : "*.*",
        file_upload_limit: num,

		button_image_url : "/base/js/swfupload/select-button.png",
		button_placeholder_id : id,
		button_width : 65,
		button_height : 29,
		button_cursor: SWFUpload.CURSOR.HAND, //鼠标样式
		button_window_mode : SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_action : (num==1 ? SWFUpload.BUTTON_ACTION.SELECT_FILE : SWFUpload.BUTTON_ACTION.SELECT_FILES),
		
		swfupload_preload_handler : preLoad,
		swfupload_load_failed_handler : loadFailed,
		file_dialog_complete_handler : fileDialogComplete,
		file_queue_error_handler: fileQueueError,
		upload_start_handler: uploadStartCo,
		upload_error_handler : uploadErrorCo,
		upload_success_handler : uploadSuccessCo,
		upload_complete_handler : uploadCompleteCo,
		queue_complete_handler : queueuploadCompleteCo,
		file_dialog_complete_handler : fileDialogComplete,
	};
	swfu = new SWFUpload(settings);
}

initUploadControl("upload_more_file", 100, 0);
initUploadControl("upload_single_file", 1, 1);

//选择文件后提示信息
function fileDialogComplete(selectedNum, queuedNum)
{
	//选择并添加到上传队列的文件数大于0
    if (queuedNum > 0 && this.settings.file_upload_limit > 1) {
    	//询问框
    	var swfobj = this;
    	parent.layer.confirm('注意：当前模式上传文件，同名文件将会被重命名！', {
    	    btn: ['确定','取消'], //按钮
    	    shade: false //不显示遮罩
    	}, function(){
    		parent.layer.closeAll();
    		swfobj.startUpload();//开始上传
    	}, function(){
    		//swfobj.setButtonDisabled(true);//禁用上传按钮
    	});
	}else{
		this.startUpload();//开始上传
	}
}

function uploadStartCo(){
	loadlayer = parent.layer.load(0, {
	    shade: [0.5,'#fff'] //0.1透明度的白色背景
	});
}
function uploadErrorCo(data) {
	parent.layer.msg("500, 服务器内部错误", {icon: 2});
}
function fileQueueError(file, errorCode, message) {
	if (errorCode == SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
		parent.layer.msg("上传队列中最多只能有3个文件等待上传", {icon: 2});
		return;
	}
	switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			parent.layer.msg("文件大小超出限制", {icon: 2});
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			parent.layer.msg("文件类型受限", {icon: 2});
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			parent.layer.msg("文件为空文件", {icon: 2});
			break;
		default:
			parent.layer.msg("加载入队列出错", {icon: 2});
			break;
	}
}
function uploadSuccessCo(data, srv) {
	var result = new Array();
	result = eval('('+srv+')');
	if(result.code == 200){
	}
	if(result.exception){
    	parent.layer.msg(result.exception, {icon: 2});
    }
}
function queueuploadCompleteCo(num){
	parent.layer.confirm("本次共 "+num+" 个文件上传成功！", {
	    btn: ['确定'] //按钮
	}, function(){
		parent.layer.closeAll();
		window.location.reload();
	});
}
function uploadCompleteCo(data, srv) {
}

//显示上传按钮
$(function(){
	$('#new-upload-btn').show();
});

//复制链接
$(".copy-btn").zclip({
    path: "/base/js/zclip/ZeroClipboard.swf",
    copy: function(){
        return $("#"+this.value).val();
	}
});

//查看大图
function showImg(id){
	var imgSrc = $("#"+id).val();
	//页面层
	parent.layer.open({
	    type: 1,
	    skin: 'layui-layer-rim', //加上边框
	    area: ['70%', '80%'], //宽高
	    content: '<img style="display:block; margin:0 auto;" src="'+ imgSrc +'">'
	});
}

</script>

@endsection
