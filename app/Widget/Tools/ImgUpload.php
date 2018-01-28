<?php
/**
 * 图片上传
 * User: Mike
 * Email: m@9026.com
 * Date: 2016/6/21
 * Time: 11:45
 */


namespace App\Widget\Tools;

use App\Models\CmsLinkModel;

class ImgUpload {

    /**
     * 单个图片上传
     * @param $folder
     * @param string $position
     * @param array $option
     */
    public function single1($folder,$id,$name="data[image]",$img ="",$option=[]) {
        $file_types = 'jpg|jpeg|gif|png|bmp';
        if($img) {
            $style = "display:block;";
        }else{
            $style = "display:none;";
        }
        $option['button_class'] = isset($option['button_class']) ? $option['button_class'] : "";
        $option['input_data'] = isset($option['input_data']) ? $option['input_data'] : "";
        $option['div_class'] = isset($option['div_class']) ? $option['div_class'] : "spiner-example";
        $option['callback'] = isset($option['callback']) ? $option['callback'] : "";
        $option['watermark'] = isset($option['watermark']) ? $option['watermark'] : "";

        $imgHtml = "";
        if(!$option['callback']) {
            $imgHtml = " <div class=\"{$option['div_class']}\" style=\"$style\">
                            <input class=\"upimg_hidden\" {$option['input_data']} type=\"hidden\" value=\"$img\" name=\"$name\"/>
                            <img src=\"$img\" class=\"upimg\" style=\"\"   />
                            <i class=\"fa fa-remove \"></i>
                            <div class=\"sk-spinner sk-spinner-wave\"  style=\"display:none\">
                                <div class=\"sk-rect1\"></div>
                                <div class=\"sk-rect2\"></div>
                                <div class=\"sk-rect3\"></div>
                                <div class=\"sk-rect4\"></div>
                                <div class=\"sk-rect5\"></div>
                                <span>50%</span>
                            </div>
                     </div>";
        }
        $token = csrf_token();
        $html = <<<EOF
                <link href="/base/webuploader/webuploader.css" rel="stylesheet">
                <script src="/base/webuploader/webuploader.min.js"></script>
                <div class="WebUploader">
                   <div class="WebUploader_button">
                             <div id="$id" class="{$option['button_class']}"/>上传图片</div>
                   </div>
                    $imgHtml
                </div>
                 <script type="text/javascript">
                    function webUpload$id() {
                        var uploaderthis="#$id";
                        $(uploaderthis).parent().parent().find(".fa-remove").click(function() {
                            $(this).parent().hide();
                            $(this).parent().find(".upimg_hidden").val('');
                             $(this).parent().find(".upimg").attr('src','');
                        });
                        var uploader = WebUploader.create({
                            auto: true,
                            pick: {
                                id: uploaderthis,
                                multiple: false,
                            },
                            accept: {
                                title: 'Images',
                                extensions: 'gif,jpg,jpeg,bmp,png',
                                mimeTypes: 'image/*'
                            },
                            swf: "/base/webuploader/uploader.swf",
                            server: "/admin/Base/Attachment/webupload",
                            fileNumLimit: 300,
                            fileSizeLimit: 10 * 1024 * 1024,
                            fileSingleSizeLimit: 10 * 1024 * 1024,
                        });
                        uploader.option("formData", {
                            _token : "$token",
                            elementid : "",
                             folder : "$folder",
                             watermark : "{$option['watermark']}",
                            _time: Math.random()
                        });
                        uploader.on("error",function(type){
                            //仅支持JPG、GIF、PNG、JPEG、BMP格式，
                            if(type=='F_EXCEED_SIZE'){
                                layer.msg("上传的图片不大于5MB", {icon: 2});
                                return false;
                            }else if(type=="Q_TYPE_DENIED"){
                                layer.msg("请上传JPG、GIF、PNG、JPEG、BMP格式", {icon: 2});
                                return false;
                            }else {
                                layer.msg("服务器繁忙请稍候再试", {icon: 2});
                                return false;
                            }
                        });
                        uploader.on("uploadProgress",function(file,percentage){
                            var re = /([0-9]+\.[0-9]{2})[0-9]*/;
                            aNew = parseFloat(percentage*100).toFixed(0);
                            $(uploaderthis).parent().parent().find(".spiner-example").show().find(".sk-spinner").show().find("span").html(aNew+"%");
                            if(percentage==1){
                                $(uploaderthis).parent().parent().find(".sk-spinner").find("span").html('上传完成，加载图片...');
//                              $(uploaderthis).parent().parent().find(".sk-spinner").hide();
                            }
                        });
                        uploader.on('uploadSuccess', function( file, response ) {

                            uploader.removeFile( file );
                            if(response.code == 200){
                              $(uploaderthis).parent().parent().find(".upimg").attr("src",response.fileurl + "?t=" +  Math.random()).load(function() {
                                  $(uploaderthis).parent().parent().find(".sk-spinner").hide();
                              });
                              $(uploaderthis).parent().parent().find(".upimg_hidden").val(response.fileurl);
                            }else{
                                layer.msg(response.message, {icon: 2});
                                $(uploaderthis).parent().parent().find(".sk-spinner").hide();
                                $(uploaderthis).parent().parent().find(".spiner-example").hide();
                            }
                        });

                    }
                    webUpload$id();
                </script>
EOF;

        return $html;

    }

    public function single2($folder, $id, $name="data", $file="", $option=[]){
        $folder = urlencode($folder);
        $imgHtml =  "";
        $option['callback'] = isset($option['callback']) ? $option['callback'] : "";
        $option['watermark'] = isset($option['watermark']) ? $option['watermark'] : "";
        $option['sizex'] = isset($option['sizex']) ? $option['sizex'] : "";
        $option['sizey'] = isset($option['sizey']) ? $option['sizey'] : "";
        if(!$option['callback'] && !empty($file)) {  //$img错误！已改$file gq
            if(!is_array($file)){
                $img['url'] = $file;
                $img['alt'] = '';
            }else{
                $img = $file;
            }
            /*$imgHtml .=  " <li><em class=\"close\" onclick='$(this).parent().remove()'>×</em>
                    <img src=\"{$img}\" alt=\"{$img}\">
                    <p class=\"rate\" style=\"display: none;\"><span style=\"width: 100%;\"></span></p>
                    <p class=\"yes\" style=\"display: none;\"></p>
                    <p class=\"no\"></p>
                    <input type=\"hidden\" name=\"{$name}\" value=\"{$img}\">
                </li>";*/

            $iconImage = in_array(fileExt($img['url']), ['jpg', 'png' , 'gif' , 'jpeg' , 'bmp']) ? " <div class='image'><img src=\"{$img['url']}\" alt= /></div>" : "<div class='icon'><i class='fa fa-file'></i></div>";

            $imgHtml .="<li >
                    <div class=\"file\">
                        <span class=\"corner\"></span>
                        {$iconImage}
                        <div class=\"file-name\">
                            <p>{$img['alt']}</p>
                            <small></small>
                        </div>
                    </div>
                    <em class=\"close\" onclick=\"$(this).parent().remove()\" >×</em>
                    <input type=\"hidden\" name=\"data[{$name}]\" value=\"{$img['url']}\">
                    </li>";
        }

        $html = <<<EOF
           <script type="text/javascript" src="/base/plugins/imguploader/uploader.js"></script>
            <div class="layout_upload">
                <ul class="ullit">
                    $imgHtml
                    <li>
                        <a class="layout_upload_but" id="$id">&nbsp;</a>
                    </li>
                    <div class="ov_h"></div>
                </ul>
            </div>
            <script type="text/javascript">
            /*
             UploaderPick:"#",                       //绑定按钮id
             UploaderUrl:"",                         //百度插件地址
             UploaderServer:"",                      //上传api
             UploaderMax:1                           //现在最大上传个数
             UploadHiddenField:""                    //隐藏域name
             */
            new upload({
                UploaderPick:"#$id",
                UploaderMax:0,
                UploadHiddenField:"data[$name]",
                UploaderServer:"/admin/Base/Attachment/webupload?elementid=&watermark={$option['watermark']}&&sizex={$option['sizex']}&&sizey={$option['sizey']}&folder=$folder&_time=" + Math.random(),
                UploaderSingle:true
            });
        </script>
EOF;
        return $html;
    }


    public function single3($text, $folder, $id, $option = [])
    {
        $folder = urlencode($folder);
        $trigger = $id . '-trigger';
        $modal = $id . '-modal';
        $select_btn = $id . '-select-btn';
        $upload_btn = $id . '-upload-btn';
        $uploader = $id . '_uploader';
        $url = isset($option['url']) ? $option['url'] : 'empty';
        $upload_url = "/admin/Base/Attachment/webupload?folder=" . $folder;
        foreach($option as $key => $val) {
            $upload_url = $upload_url . '&' . $key . '=' . $val;
        }

        $html = <<<EOF
<link rel="stylesheet" type="text/css" href="/base/plugins/webuploader/webuploader.css">
<script type="text/javascript" src="/base/plugins/webuploader/webuploader.js"></script>
<style type="text/css">
    .webuploader-pick {
        height: 34px
    }
    .webupload-item {
        width: 100%;
        padding: 15px 20px;
        border: 1px solid transparent;
        background-color: #E8E8E8;
        display: inline-block;
    }
    .webupload-item.success-status {
        background-color: #00FF66
    }
    .webupload-item.error-status {
        background-color: #FF9966
    }
    .webupload-item .info,
    .webupload-item .status {
        display: inline-block;
    }
    .webupload-item .webupload-cancel,
    .webupload-item .webupload-retry {
        float: right;
    }
    .webupload-item .status {
        margin-left: 15px;
    }
    .uploader-list {
        margin: 20px 15px;
    }
</style>
    <div id="$trigger" class="btn btn-sm btn-primary">$text</div>

    <div class="modal fade" id="$modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="btns">
                                <div id="$select_btn" style="position: absolute; left: 10px; height: 34px">选择图片</div>
                                <div id="$upload_btn" class="btn btn-info" style="position: absolute; left: 110px;">上传图片</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control img-compress-ratio" name="class" placeholder="压缩比，1-50">
                        </div>
                    </div>
                    <div class="row">
                        <div class="uploader-list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    var $uploader = WebUploader.create({
        pick: {
            id: "#$select_btn",
            multiple: false,
        },
        server: "$upload_url",
        swf: "/base/plugins/webuploader/Uploader.swf",
        fileNumLimit: 1,
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });

    $('#$trigger').on('click', function() {
        $uploader.reset();
        $('.uploader-list', '#$modal').empty();
        $('#$modal').modal('show');
    });

    $('#$upload_btn').on('click', function() {
        ratio = parseInt($('.img-compress-ratio', '#$modal').val());
        if(ratio >= 1 && ratio <= 50) {
            $uploader.options.server = $uploader.options.server + "&compress_ratio=" + ratio;
        } else {
            $uploader.options.server = $uploader.options.server;
        }
        $uploader.upload();
    });

    $uploader.on('fileQueued', function(file) {
        $('.uploader-list', '#$modal').append( '<div id="' + file.id + '" class="webupload-item" data-id="' + file.id + '">' + '<div class="info">' + file.name + '</div>' + '<span class="status">等待上传...</span>' + '<button type="button" class="btn btn-sm btn-default webupload-cancel" data-id="' + file.id + '">取消</button></div>' );
    }).on('beforeFileQueued', function() {
        $uploader.reset();
        $('.uploader-list', '#$modal').empty();
    }).on('uploadProgress', function(file, percentage) {
        $('#' + file.id).removeClass().addClass('webupload-item');
        $('#' + file.id + ' .status').text('正在上传：' + percentage);
    }).on('uploadSuccess', function(file, response) {
        $('#' + file.id).removeClass().addClass('webupload-item success-status');
        $('#' + file.id + ' .status').text('上传完毕');
    }).on('uploadError', function(file, reason) {
        $('.webupload-retry', '#' + file.id).remove();
        $('#' + file.id).removeClass().addClass('webupload-item error-status').append('<button type="button" class="btn btn-sm btn-warning webupload-retry" data-id="' + file.id + '">重试</button>');
        $('#' + file.id + ' .status').text(reason.data.message);
    }).on('uploadAccept', function(object, ret) {
        if(ret.data.code == 200) {
            return true;
        } else {
            return false;
        }
    }).on('uploadFinished', function() {
        var url = "$url";
        var status = $uploader.getStats();
        if(url != 'empty' && status.uploadFailNum != 0) {
            window.location = url;
        }
    });

    $('#$modal').on('click', '.webupload-cancel', function() {
        $uploader.reset();
        $('.uploader-list', '#$modal').empty();
    }).on('click', '.webupload-retry', function() {
        $uploader.retry($(this).attr('data-id'));
    });

</script>
EOF;
        return $html;
    }

    /**
     * 统一上传
     * @param $folder
     * @param $id
     * @param string $name
     * @param array $imgs
     * @param null $callBackFun
     * @return string
     */
    public function multi($folder, $id, $name="data[image]", $imgs=[], $option=[]){
        $file_types = 'jpg|jpeg|gif|png|bmp';
        $option['watermark'] = isset($option['watermark']) ? $option['watermark'] : "";

        $url = U("tools/uploadImg",['fooder'=>$folder,'watermark'=>$option['watermark'],'time'=>SYSTEM_TIME,'token'=>md5($folder. LOGIN_MARK_SESSION_KEY . SYSTEM_TIME)]);

        $imgHtml =  "";
        $option['callback'] = isset($option['callback']) ? $option['callback'] : "";
        if(!$option['callback'] && !empty($imgs)) {
//            dd($imgs);
            foreach($imgs as $key=>$val) {
                if(is_string($val)) {
                    $img['url'] = $val;
                    $img['alt'] = '';
                }else{
                    $img = $val;
                }
                $imgHtml .=  "<a class=\"fancybox\"title=\"图片\">
                    <input type=\"hidden\" name=\"{$name}[url][]\" value=\"{$img['url']}\" />
                   <em class=\"fa fa-remove\" onclick='removeUploadImg{$id}(this)'></em>
                   <img alt=\"image\" src=\"{$img['url']}\" />
                   <textarea class='form-control' name='{$name}[alt][]'>{$img['alt']}</textarea>
               </a>";
            }
        }
        $herfUrl = request()->fullUrl();
        $html = <<<EOF
                        <link href="/base/webuploader/webuploader.css" rel="stylesheet">
                        <script src="/base/webuploader/webuploader.min.js"></script>
                            <div style="clear:both">
                            <div>
                               <button class="btn btn-white"  id="$id" type="button">开始上传</button>
                            </div>


                            <div id="{$id}list" class="upload-ibox-content ibox-content sortable-list ui-sortable">
                                    $imgHtml
                             </div>
                             <script>
                                $(document).ready(function(){
                                   $("#{$id}list").sortable({connectWith:"#{$id}list",tag:"a",constraint:"horizontal",scroll:false}).disableSelection()});
                            </script>

                             </div>
                            <script type="text/javascript">
                                $("#$id").click(function() {
                                    layer.open({
                                        type: 2,
                                        title: '图片上传',
                                        shadeClose: true,
                                        shade: 0.8,
                                        area: ['80%', '90%'],
                                        content: '$url',
                                        btn: ['完成上传'],
                                        yes:function(index, layero){
                                            var iframeWin = window[layero.find('iframe')[0]['name']];
                                            var data = iframeWin.\$filePaths;
                                            for(i=0;i<data.length;i++) {
                                                console.log(data[i]);
                                                 $("#{$id}list").append('<a class="fancybox"  title="图片1">'+
                                                 '<input type="hidden" name="{$name}[url][]" value="' + data[i].fileurl +  '"/>' +
                                                '<em class="fa fa-remove" onclick="removeUploadImg{$id}(this)" ></em>' +
                                                '<img alt="image" src="' + data[i].fileurl +  '" />' +
                                                '<textarea class="form-control" name="{$name}[alt][]">' + data[i].filename +  '</textarea>' +
                                             '</a>');
                                            }
                                            layer.close(index);
                                        },
                                        end:function(index,msg){ }
                                    });
                                });
                                function callbackUploadImg$id(data){
                                    for(i=0;i<data.length;i++) {
                                        console.log(data[i]);
                                         $("#{$id}list").append('<a class="fancybox"  title="图片1">'+
                                         '<input type="hidden" name="{$name}[url][]" value="' + data[i].fileurl +  '"/>' +
                                        '<em class="fa fa-remove" onclick="removeUploadImg{$id}(this)" ></em>' +
                                        '<img alt="image" src="' + data[i].fileurl +  '" />' +
                                                '<textarea class="form-control" name="{$name}[alt][]">' + data[i].filename +  '</textarea>' +
                                     '</a>');
                                    }
                                }
                                function removeUploadImg$id(obj){
                                    $(obj).parent().remove();
                                }

                            </script>

EOF;
        return $html;

    }

    public function multi2($folder, $id, $name="data[image]", $imgs=[], $option=[]){
        $folder = urlencode($folder);

        $imgHtml =  "";
        $option['callback'] = isset($option['callback']) ? $option['callback'] : "";
        $option['max'] = isset($option['max']) ? $option['max'] : 200;
        $option['max'] = $option['max']-count($imgs);
        $option['watermark'] = isset($option['watermark']) ? $option['watermark'] : "";
        $class = isset($option['class']) ? $option['class'] : "";
        if(!$option['callback'] && !empty($imgs)) {
//                       dd($imgs);
            foreach($imgs as $key=>$val) {
                if(is_string($val)) {
                    $img['url'] = $val;
                    $img['alt'] = '';
                }else{
                    $img = $val;
                }
                /*$imgHtml .=  " <li><em class=\"close\" onclick='$(this).parent().remove()'>×</em>
                        <img src=\"{$img['url']}\" alt=\"{$img['alt']}\">
                        <p class=\"rate\" style=\"display: none;\"><span style=\"width: 100%;\"></span></p>
                        <p class=\"yes\" style=\"display: none;\"></p>
                        <p class=\"no\"></p>
                        <input type=\"hidden\" name=\"{$name}[alt][]\" value=\"{$img['alt']}\">
                        <input type=\"hidden\" name=\"{$name}[url][]\" value=\"{$img['url']}\">
                    </li>";*/
                //echo  in_array(fileExt($img['url']), ['jpg', 'png']) ? "<div class='icon'><i class='fa fa-file'></i></div>" :" <div class='image'><img src= alt= /></div>";
                $iconImage = in_array(fileExt($img['url']), ['jpg', 'png' , 'gif' , 'jpeg' , 'bmp']) ? " <div class='image'><img src=\"{$img['url']}\" alt= /></div>" : "<div class='icon'><i class='fa fa-file'></i></div>";

                $imgHtml .="<li >
                        <div class=\"file\">
                            <span class=\"corner\"></span>
                            {$iconImage}
                            <div class=\"file-name\">
                                <p>{$img['alt']}</p>
                                <small></small>
                            </div>
                        </div>
                        <em class=\"close\" onclick=\"$(this).parent().remove()\" >×</em>
                        <input type=\"hidden\" name=\"{$name}[alt][]\" value=\"{$img['alt']}\">
                        <input type=\"hidden\" name=\"{$name}[url][]\" value=\"{$img['url']}\">
                        </li>";
            }
        }

        $html = <<<EOF
           <script type="text/javascript" src="/base/plugins/imguploader/uploader.js"></script>
            <div class="layout_upload">
                <ul class="ullit">
                                    $imgHtml

                    <li>
                        <a class="layout_upload_but" id="$id">&nbsp;</a>
                    </li>
                    <div class="ov_h"></div>
                </ul>
            </div>
            <script type="text/javascript">
            /*
             UploaderPick:"#",                       //绑定按钮id
             UploaderUrl:"",                         //百度插件地址
             UploaderServer:"",                      //上传api
             UploaderMax:5                           //现在最大上传个数
             UploadHiddenField:""                    //隐藏域name
             */
            new upload({
                UploaderPick:"#$id",
                UploaderMax:{$option['max']},
                UploaderServer:"/admin/Base/Attachment/webupload?elementid=&watermark={$option['watermark']}&folder=$folder&class=$class&_time=" + Math.random(),
                UploadHiddenField:"$name"
            });
        </script>
EOF;
        return $html;
    }

    /**
     * 统一上传
     * @param $text         按钮文字
     * @param $folder       上传文件夹
     * @param $id           id
     * @param $option       附加选项
     */
    public function multi3($text, $folder, $id, $option = [])
    {
        $folder = urlencode($folder);
        $trigger = $id . '-trigger';
        $modal = $id . '-modal';
        $select_btn = $id . '-select-btn';
        $upload_btn = $id . '-upload-btn';
        $uploader = $id . '_uploader';
        $url = isset($option['url']) ? $option['url'] : 'empty';
        $upload_url = "/admin/Base/Attachment/webupload?folder=" . $folder;
        foreach($option as $key => $val) {
            $upload_url = $upload_url . '&' . $key . '=' . $val;
        }

        $html = <<<EOF
<link rel="stylesheet" type="text/css" href="/base/plugins/webuploader/webuploader.css">
<script type="text/javascript" src="/base/plugins/webuploader/webuploader.js"></script>
<style type="text/css">
    .webuploader-pick {
        height: 34px
    }
    .webupload-item {
        width: 100%;
        padding: 15px 20px;
        margin-top: 5px;
        border: 1px solid transparent;
        background-color: #E8E8E8;
        display: inline-block;
    }
    .webupload-item.success-status {
        background-color: #00FF66
    }
    .webupload-item.error-status {
        background-color: #FF9966
    }
    .webupload-item .info,
    .webupload-item .status {
        display: inline-block;
    }
    .webupload-item .webupload-cancel,
    .webupload-item .webupload-retry {
        float: right;
    }
    .webupload-item .status {
        margin-left: 15px;
    }
    .uploader-list {
        margin: 20px 15px;
    }
</style>
    <div id="$trigger" class="btn btn-sm btn-primary">$text</div>

    <div class="modal fade" id="$modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="btns">
                                <div id="$select_btn" style="position: absolute; left: 10px; height: 34px">选择图片</div>
                                <div id="$upload_btn" class="btn btn-info" style="position: absolute; left: 110px;">上传图片</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control img-compress-ratio" name="class" placeholder="压缩比，1-50">
                        </div>
                    </div>
                    <div class="row">
                        <div class="uploader-list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    var $uploader = WebUploader.create({
        pick: {
            id: "#$select_btn",
        },
        server: "$upload_url",
        swf: "/base/plugins/webuploader/Uploader.swf",
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });

    $('#$trigger').on('click', function() {
        $uploader.reset();
        $('.uploader-list', '#$modal').empty();
        $('#$modal').modal('show');
    });

    $('#$upload_btn').on('click', function() {
        ratio = parseInt($('.img-compress-ratio', '#$modal').val());
        if(ratio >= 1 && ratio <= 50) {
            $uploader.options.server = $uploader.options.server + "&compress_ratio=" + ratio;
        } else {
            $uploader.options.server = $uploader.options.server;
        }
        $uploader.upload();
    });

    $uploader.on('fileQueued', function(file) {
        $('.uploader-list', '#$modal').append( '<div id="' + file.id + '" class="webupload-item" data-id="' + file.id + '">' + '<div class="info">' + file.name + '</div>' + '<span class="status">等待上传...</span>' + '<button type="button" class="btn btn-sm btn-default webupload-cancel" data-id="' + file.id + '">取消</button></div>' );
    }).on('uploadProgress', function(file, percentage) {
        $('#' + file.id).removeClass().addClass('webupload-item');
        $('#' + file.id + ' .status').text('正在上传：' + percentage);
    }).on('uploadSuccess', function(file, response) {
        $('#' + file.id).removeClass().addClass('webupload-item success-status');
        $('#' + file.id + ' .status').text('上传完毕');
    }).on('uploadError', function(file, reason) {
        $('.webupload-retry', '#' + file.id).remove();
        $('#' + file.id).removeClass().addClass('webupload-item error-status').append('<button type="button" class="btn btn-sm btn-warning webupload-retry" data-id="' + file.id + '">重试</button>');
        $('#' + file.id + ' .status').text(reason.data.message);
    }).on('uploadAccept', function(object, ret) {
        if(ret.data.code == 200) {
            return true;
        } else {
            return false;
        }
    }).on('uploadFinished', function() {
        var url = "$url";
        console.log($uploader.getStats());
        if(url != 'empty') {
            window.location = url;
        }
    });

    $('#$modal').on('click', '.webupload-cancel', function() {
        $uploader.removeFile($(this).attr('data-id'), true);
        $(this).closest('.webupload-item').remove();
    }).on('click', '.webupload-retry', function() {
        $uploader.retry($(this).attr('data-id'));
    });

</script>
EOF;
        return $html;
    }
}