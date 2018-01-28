@extends('admin.layout')

@section('header')
<style type="text/css">
.side-class-bar ul li a {
	padding: 5px 10px !important;
}
.side-class-bar .a_selected {
	background-color: #eeeeee;
}
#file-upload-modal .modal-dialog {
	width: 80%;
}
#crop-file-modal .modal-dialog {
	width: 80%;
}
.img-check {
	position: absolute;
	right: 5px;
	bottom: 5px;
    margin: 0;
    padding: 0;
    width: 22px;
    height: 22px;
    background: url(/base/img/check_blue_1.png) no-repeat;
    border: none;
    background-position: -144px 0;
}
.img-check.checked {
    background-position: -168px 0;
}
.img-card .content {
	text-align: center;
	word-wrap: break-word;
}
.img-card .image {
	position: relative;
}
.sg-divider {
	margin: 1rem 0rem;
	line-height: 1;
	height: 0em;
	font-weight: bold;
	text-transform: uppercase;
	letter-spacing: 0.05em;
	color: rgba(0, 0, 0, 0.85);
}
</style>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			@if(isset($errors) && !$errors->isEmpty())
	        <div class="alert alert-danger alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert"
	                    aria-hidden="true">
	                &times;
	            </button>
	            @foreach($errors->keys() as $key)
	            	{{ $errors->first($key) }}
	            @endforeach
	        </div>
			@endif
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>图片管理</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="row">
						<div class="col-sm-2">
							<div class="side-class-bar">
								<div class="btn btn-sm btn-primary btn-block" id="add-class-btn">添加分类</div>
								<ul class="nav">
									@foreach($classes as $class)
										@if($class->class == $a_class->class && $status != 'search')
										<li class="a_selected">
											<a href="{{ U('Base/Photos/index', ['class' => $class->id]) }}">
												<i class="fa fa-folder-open" aria-hidden="true"></i>
												<span class="nav-label">
													{{ $class->class }}
												</span>
											</a>
										</li>
										@else
										<li>
											<a href="{{ U('Base/Photos/index', ['class' => $class->id]) }}">
												<i class="fa fa-folder" aria-hidden="true"></i>
												<span class="nav-label">
													{{ $class->class }}
												</span>
											</a>
										</li>
										@endif
									@endforeach
								</ul>
							</div>
						</div>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-sm-4">
									<form method="GET" accept-charset="UTF-8">
										<div class="input-group">
											<input type="text" value="" placeholder="请输入关键词" name="keyword" class="input-sm form-control" id="search-file-input">
											<span class="input-group-btn">
												<button type="submit" class="btn btn-sm btn-primary" id="search-file">搜索</button>
											</span>
										</div>
									</form>
								</div>
								<div class="col-sm-8">
									<div class="btn-group pull-right">
										<div id="select-toogle" class="btn btn-sm btn-default">全选图片</div>
										@if($status != 'search')
											{!!  widget('Tools.ImgUpload')->multi3('上传', '/upload/user','upload_files', ['class' => $a_class->class, 'url' => U('Base/Photos/index', ['class' => $class->id])]) !!}
										@endif
										<div id="edit-file" class="btn btn-sm btn-success">编辑</div>
										@if($status != 'search')
											<div id="move-file" class="btn btn-sm btn-info">移动</div>
										@endif
										<div id="crop-file" class="btn btn-sm btn-warning">裁剪</div>
										<div id="download-file" class="btn btn-sm btn-primary">下载</div>
										<div id="delete-file" class="btn btn-sm btn-danger">删除图片</div>
										@if($a_class->class != '未分类' && $status != 'search')
											<div id="delete-class" class="btn btn-sm btn-danger">删除分类</div>
										@endif
									</div>
								</div>
							</div>
							<div class="photos">
								@foreach($photos as $photo)
									@if($loop->index % 6 == 0)
									<div class="row">
									@endif
									<div class="img-card col-sm-2">
										<div class="image">
											<img src="{{ $photo->url }}" class="img-thumbnail">
											<span class="img-check" data-id="{{ $photo->id }}" data-name="{{ $photo->name }}" data-src="{{ $photo->url }}" data-class="{{ $photo->class }}" data-md5="{{ $photo->md5 }}"></span>
										</div>
										<div class="content">
											{{ $photo->name }}
										</div>
									</div>
									@if($loop->index % 6 == 5)
									</div>
									@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="add-class-modal" tabindex="-1" role="dialog" aria-labelledby="add-class-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="add-class-modal-label">添加分类</h4>
            </div>
            <div class="modal-body">
            	<form class="form-horizontal" role="form" method="POST" id="add-class-form" action="{{ U('Base/Class/add') }}">
            		{{ csrf_field() }}

	                <div class="form-group">
	                    <label for="class" class="col-md-2 col-md-offset-2 control-label">分类</label>
	                    <div class="col-md-6">
	                        <input id="class" type="text" class="form-control" name="class" required autofocus>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <div class="col-md-6 col-md-offset-4">
	                        <button type="submit" class="btn btn-primary" id="edit-project-confirm">
	                            添加
	                        </button>
	                    </div>
	                </div>
            	</form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit-file-modal" tabindex="-1" role="dialog" aria-labelledby="edit-file-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="edit-file-modal-label">编辑图片</h4>
            </div>
            <div class="modal-body">
            	<form class="form-horizontal" role="form" method="POST" id="edit-file-form" action="{{ U('Base/Photos/edit') }}">
            		{{ csrf_field() }}

	                <div class="form-group">
	                    <label for="img-name" class="col-md-2 col-md-offset-2 control-label">图片名</label>
	                    <div class="col-md-6">
	                        <input type="text" class="img-name form-control" name="img-name" required autofocus>
	                    </div>
	                </div>
	                <input class="img-id" type="text" name="img-id" style="display: none">
	                <div class="form-group">
	                    <div class="col-md-6 col-md-offset-4">
	                        <button type="submit" class="btn btn-primary">
	                            确认
	                        </button>
	                    </div>
	                </div>
            	</form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="move-file-modal" tabindex="-1" role="dialog" aria-labelledby="move-file-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="move-file-modal-label">移动图片</h4>
            </div>
            <div class="modal-body">
            	<form class="form-horizontal" role="form" method="POST" id="move-file-form" action="{{ U('Base/Photos/move') }}">
            		{{ csrf_field() }}

	                <div class="form-group">
	                    <label for="class" class="col-md-2 col-md-offset-2 control-label">移动到</label>
	                    <div class="col-md-6">
	                        <select class="form-control" name="class">
	                        	@foreach($classes as $class)
	                        		<option value="{{ $class->id }}">
	                        			{{ $class->class }}
	                        		</option>
	                        	@endforeach
	                        </select>
	                    </div>
	                </div>
	                <input class="ids" type="text" name="ids" style="display: none">
	                <div class="form-group">
	                    <div class="col-md-6 col-md-offset-4">
	                        <button type="submit" class="btn btn-primary">
	                            确认
	                        </button>
	                    </div>
	                </div>
            	</form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete-file-modal" tabindex="-1" role="dialog" aria-labelledby="delete-file-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="delete-file-modal-label">确定要删除以下图片吗？</h4>
            </div>
            <div class="modal-body">
            	<div id="delete-files"></div>
            	<form class="form-horizontal" role="form" method="POST" id="delete-file-form" action="{{ U('Base/Photos/delete') }}">
            		{{ csrf_field() }}
	                <input class="ids" type="text" name="ids" style="display: none">
	                <div class="form-group">
	                    <div class="col-md-6 col-md-offset-4">
	                        <button type="submit" class="btn btn-primary">
	                            确认
	                        </button>
	                    </div>
	                </div>
            	</form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete-class-modal" tabindex="-1" role="dialog" aria-labelledby="delete-class-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="delete-class-modal-label">
                	{{ '确定要删除分类《' . $a_class->class . '》及其分类下所有的图片吗？' }}
                </h4>
            </div>
            <div class="modal-body">
            	<form class="form-horizontal" role="form" method="POST" id="delete-class-form" action="{{ U('Base/Class/delete', ['class' => $a_class->id]) }}">
            		{{ csrf_field() }}
	                <div class="form-group">
	                    <div class="col-md-6 col-md-offset-4">
	                        <button type="submit" class="btn btn-primary">
	                            确认
	                        </button>
	                    </div>
	                </div>
            	</form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="crop-file-modal" tabindex="-1" role="dialog" aria-labelledby="crop-file-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="crop-file-modal-label">
                	裁剪图片
                </h4>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<div class="col-sm-6">
        				<img id="crop-img">
        			</div>
        			<div class="col-sm-6">
        				<div class="row">
	        				<div class="btn-group ratio-group">
	        					<div class="btn btn-sm btn-success ratio-16-9">16:9</div>
	        					<div class="btn btn-sm btn-success ratio-4-3">4:3</div>
	        					<div class="btn btn-sm btn-success ratio-1-1">1:1</div>
	        					<div class="btn btn-sm btn-success ratio-free">自定义</div>
	        				</div>
        				</div>
        				<div class="sg-divider"></div>
        				<div class="row">
			                <div class="form-group">
			                    <div class="col-md-6">
			                        <input id="crop-img-name" type="text" class="form-control" name="img-name" placeholder="文件名，扩展名为png">
			                    </div>
			                </div>
        				</div>
        				<div class="sg-divider"></div>
        				<div class="row">
        					<div class="btn btn-sm btn-success" id="crop-confirm">确认裁剪</div>
        				</div>
        			</div>
            	</div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-margin-top" id="file-upload-modal" tabindex="-1" role="dialog" aria-labelledby="file-upload-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div id="fine-uploader-manual-trigger"></div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer')
<script type="text/javascript">
$(function() {
    // var uploader = new qq.FineUploader({
    // 	element: document.getElementById("fine-uploader-manual-trigger"),
    //     request: {
    //         endpoint: "/admin/Base/Attachment/webupload?folder={{ urlencode('/upload/user') }}&class={{ $a_class->class }}",
    //         customHeaders: {
    //         	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         inputName: 'file'
    //     },
    //     template: 'qq-template-manual-trigger',
    //     thumbnails: {
    //         placeholders: {
    //             waitingPath: "/base/plugins/fine-uploader/placeholders/waiting-generic.png",
    //             notAvailablePath: "/base/plugins/fine-uploader/placeholders/not_available-generic.png"
    //         }
    //     },
    //     autoUpload: false,
    //     callbacks: {
    //     	onComplete: function(id, name, response) {
        		
    //     	},
    //     	onAllComplete: function(succeeded, failed)
    //     	{
    //             if(failed.length == 0) {
    //                 window.location = "{{ U('Base/Photos/index', ['class' => $a_class->id]) }}";
    //             }
    //     	}
    //     },
    //     validation: {
    //     	allowedExtensions: ['jpg', 'jpeg', 'png', 'bmp', 'gif'],
    //     	allowEmpty: true,
    //     },
    //     messages: {
    //     	noFilesError: '没有需要上传的文件',
    //     	sizeError: '{file}过大',
    //     	typeError: '{file}上传错误！支持的文件类型：{extensions}',
    //     }
    // });

    // $('#trigger-upload').click(function() {
    // 	ratio = parseInt($('#compress_ratio').val());
    // 	if(ratio >= 1 && ratio <= 50) {
    // 		uploader.setEndpoint("/admin/Base/Attachment/webupload?folder={{ urlencode('/upload/user') }}&class={{ $a_class->class }}&compress_ratio=" + ratio);
    // 	}
    //     uploader.uploadStoredFiles();
    // });

    // $('#upload-file').on('click', function() {
    //     $('#file-upload-modal').modal('show');
    // });

	$('#add-class-btn').on('click', function() {
		$('#add-class-modal').modal('show');
	});

	$('#add-class-confirm-btn').on('click', function() {
		$('#add-class-form').submit();
	});

	$('.img-card', '.photos').on('click', function() {
		$(this).find('.img-check').toggleClass('checked');
	});

	$('#edit-file').on('click', function() {
		edit = $('.photos').find('.checked')[0];
		if(edit != undefined) {
			$edit = $(edit);

			$('.img-name', '#edit-file-modal').val($edit.attr('data-name'));
			$('.img-id', '#edit-file-modal').val($edit.attr('data-id'));
			$('#edit-file-modal').modal('show');
		}
	});

	$('#download-file').on('click', function() {
		edit = $('.photos').find('.checked')[0];
		if(edit != undefined) {
			window.location = "{{ url('/') }}" + "/attachment/" + $(edit).attr('data-md5');
		}
	});

	$('#select-toogle').on('click', function() {
		if($(this).hasClass('selected')) {
			$('.photos .img-check').removeClass('checked');
			$(this).removeClass('selected').text('全选图片');
		} else {
			$('.photos .img-check').removeClass('checked').addClass('checked');
			$(this).addClass('selected').text('取消全选');
		}
	});

	$('#move-file').on('click', function() {
		photos = $('.photos').find('.checked');
		if(photos.length != 0) {
			ids = $(photos[0]).attr('data-id');
			for(i = 1; i < photos.length; ++i) {
				ids += ',' + $(photos[i]).attr('data-id');
			}
			$('.ids', '#move-file-modal').val(ids);
			$('#move-file-modal').modal('show');
		}
	});

	$('#delete-file').on('click', function() {
		photos = $('.photos').find('.checked');
		info = '';
		if(photos.length != 0) {
			ids = $(photos[0]).attr('data-id');
			info += $(photos[0]).attr('data-name');
			for(i = 1; i < photos.length; ++i) {
				ids += ',' + $(photos[i]).attr('data-id');
				info += '<br>' + $(photos[i]).attr('data-name');
			}
			$('.ids', '#delete-file-modal').val(ids);
			$('#delete-files').html(info);
			$('#delete-file-modal').modal('show');
		}
	});

	$('#delete-class').on('click', function() {
		$('#delete-class-modal').modal('show');
	});

	$('#search-file').on('click', function(e) {
		e.preventDefault();
		$input = $('#search-file-input');
		if($input.val().trim() != '') {
			window.location = "{{ U('Base/Photos/index') }}" + '?search=' + $input.val().trim();
		}
	});

	var crop_image = document.getElementById('crop-img');
	var cropper = new Cropper(crop_image, {
		minContainerWidth: 400,
		minContainerHeight: 300,
	});

	$('#crop-file').on('click', function() {
		edit = $('.photos').find('.checked')[0];
		if(edit != undefined) {
			src = $(edit).attr('data-src');
			cropper.replace(src);
			cropper.reset();
			$('#crop-img').attr('src', src);
			$('#crop-file-modal').attr('data-class', $(edit).attr('data-class'));
			$('#crop-file-modal').modal('show');
		}
	});

	$('#crop-confirm').on('click', function() {
		cropper.getCroppedCanvas().toBlob(function(blob) {
			var formData = new FormData();
			a_class = $('#crop-file-modal').attr('data-class').trim();
			name = $('#crop-img-name').val().trim();
			if(name == '') {
				name = '裁剪.png';
			} else if(name.lastIndexOf('.png') == -1) {
				name = name + '.png';
			}
			formData.append('file', blob);
			formData.append('folder', '/upload/user');
			formData.append('class', a_class);
			formData.append('from', 'crop');
			formData.append('name', name);

			$.ajax({
				url: "{{ U('Base/Photos/crop') }}",
				method: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				header: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				success: function(data) {
					window.location = "{{ U('Base/Photos/index', ['class' => $a_class->class]) }}";
				}
			});
		});
	});

	$('.ratio-group').on('click', '.ratio-16-9', function() {
		cropper.setAspectRatio(16 / 9);
	}).on('click', '.ratio-4-3', function() {
		cropper.setAspectRatio(4 / 3);
	}).on('click', '.ratio-1-1', function() {
		cropper.setAspectRatio(1);
	}).on('click', '.ratio-free', function() {
		cropper.setAspectRatio(NaN);
	});
});
</script>
@endsection