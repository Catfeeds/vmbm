@extends('admin.layout')

@section('content')

<link href="/base/js/swfupload/swfupload.css?v={{config("sys.version")}}" rel="stylesheet">
<script type="text/javascript" src="/base/js/zclip/jquery.zclip.min.js?v={{config("sys.version")}}" ></script>
<style type="text/css">
i,em{font-style:normal;}
.upload_object {width:80px;}
.upload_object, .checkoption_btn {float:left;}
.checkoption_btn{text-align:center; width:260px;}
.checkoption_btn .checkbox_item{position:relative;display:inline-block;margin-right:10px;height:16px;}
.checkbox_item input{position:absolute;top:-9999px;left:-9999px;}
.checkbox_item .check_label{display:inline-block;cursor:default;}
.checkbox_icon{display:block;float:left;margin-right:5px;width:16px;height:16px;background:url('/base/img/checkbox_icon.png') 0 0;}
.check_label { width:230px; padding-top: 6px;}
.check_label.on .checkbox_icon{background-position:-16px 0;}
.checkbox_text{float:left;height:16px;line-height:16px; font-weight: normal;}
</style>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="file-manager">
                        <h5>当前路径：</h5>
                        <?php echo $folderPath; ?>

						@if(role('foundation.resources.manage'))
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
						@endif

						@if(role('Foundation/Attachment/upload'))
						<div id="new-upload-btn">
                            <div class="hr-line-dashed"></div>
							<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#uploadbox" data-backdrop="static" data-keyboard="false">上传文件</button>
                        </div>
						@endif

                        @if(isset($item['dir']))
                        <div class="hr-line-dashed"></div>
                        <h5>文件夹</h5>
                        <ul class="folder-list" style="padding: 0">
                            @foreach($item['dir'] AS $dir)
                            <li><a href="{{ U('Base.resources.manage')}}?folder={{ $dir->getPrefix() }}"><i class="fa fa-folder"></i> {{ $dir->getPrefix() }}</a></li>
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
                            <div class="icon">
								<i class="fa fa-picture-o"></i>
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


<div class="modal inmodal fade" id="uploadbox" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="padding:15px 15px;">
				<div class="row">
					<div class="form-group">
						<div class="col-sm-8">
							<div class="upload_object">
								<span id="upload_more_files"></span>
							</div>
							<div class="checkoption_btn">
								<span class="checkbox_item">
									<input type="checkbox" name="iscover" />
									<label class="check_label" onclick="selectMode();">
										<i class="checkbox_icon "></i>
										<em class="checkbox_text">选择后，上传同名文件将会被覆盖。</em>
									</label>
								</span>
							</div>
						</div>
						<div class="col-sm-4">
							<button type="button" class="close" data-dismiss="modal" style="padding-top:8px;">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="fieldset flash" id="fsUploadProgress"></div>
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
			flash9_url : "/base/js/swfupload/swfupload_fp9.swf",
			post_params : {
				"PHPSESSID" : "<?php echo session()->getId(); ?>",
				'rename' : rename,
				'bucket' : "resource-manager",
				"elementid" : id,
				"_token" : "<?php echo csrf_token(); ?>",
				"position" : "ali",
				"file_type" : "all",
				"folder" : "<?php echo Request::input('folder', 'lwj/designer/'); ?>"
			},
			upload_url : "<?php echo U('Base.attachment.upload'); ?>",
			file_size_limit : "5 MB",
			file_types : "*.*",
			file_upload_limit: num,
			custom_settings : {
				progressTarget : "fsUploadProgress"
			},

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
			upload_error_handler : uploadErrorCo,
			upload_success_handler : uploadSuccessCo,
			upload_complete_handler : uploadCompleteCo,
			upload_progress_handler : uploadProgressCo,

		};
		swfu = new SWFUpload(settings);
	}
	initUploadControl("upload_more_files", 100, 0);

	//上传模式切换
	function selectMode() {
		$(".upload_object object").remove();
		$(".upload_object").append('<span id="upload_more_files"></span>');
		if ($(".checkoption_btn input[type='checkbox']").is(":checked")) {
			initUploadControl("upload_more_files", 100, 0);
		} else {
			initUploadControl("upload_more_files", 100, 1);
		}
	}

	//选择文件后提示信息
	function fileDialogComplete(selectedNum, queuedNum) {
		this.startUpload();//开始上传
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

	function uploadProgressCo(file, bytesLoaded, bytesTotal) {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setProgress(percent);
		if(percent == 100){
			progress.setStatus("文件保存中...");
		}else{
			progress.setStatus("文件上传中...");
		}
	}

	function uploadSuccessCo(file, serverData) {
		var result = new Array();
		result = eval('('+serverData+')');
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setComplete();
		if(result.message){
			progress.setStatus(result.message);
		}else{
			progress.setStatus('<font color="#449d44">上传完成.</font>');
		}
		if(result.exception){
			parent.layer.msg(result.exception, {icon: 2});
		}
	}

	function uploadCompleteCo(data, srv) {

	}

	//关闭模态窗口时触发
	$('#uploadbox').on('hide.bs.modal', function () {
		$('#fsUploadProgress').html('');
		window.location.reload();
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

<script type="text/javascript">
	(function($){
		$.fn.extend({
			checkbox : function(){
				return this.each(function(){
					var $this = $(this);
					if($this.hasClass("on")){
						$this.siblings("input").prop("checked","checked");
					}else{
						$this.siblings("input").removeAttr("checked");
					}
					$this.on("click",function(){
						if($this.hasClass("on")){
							$this.siblings("input").removeAttr("checked");
							$this.removeClass("on");
						}else{
							$this.siblings("input").prop("checked","checked");
							$this.addClass("on");
						}
					});
				});
			}
		});
	})(jQuery);
	$(".check_label").checkbox();
</script>


@endsection
