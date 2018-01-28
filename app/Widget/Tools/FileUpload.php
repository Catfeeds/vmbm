<?php
/**
 * 文件上传
 * User: Mike
 * Email: m@9026.com
 * Date: 2016/6/21
 * Time: 11:45
 */

namespace App\Widget\Tools;

class FileUpload {

    /**
     * 单个文件上传
     * @param $folder
     * @param string $position
     * @param array $option
     */
    public function single($folder, $id, $name = "data[file]", $file = "", $option = [], $param = [])
    {
        $file_types = 'jpg|jpeg|gif|png|bmp|doc|docx|xls|xlsx|ppt|htm|html|php|txt|zip|rar|gz|bz2';
        $option['position'] = isset($option['position']) ? $option['position'] : "alioss";
        $option['placeholder'] = isset($option['placeholder']) ? $option['placeholder'] : "";
        $option['button_class'] = isset($option['button_class']) ? $option['button_class'] : "";

        //扩展参数
        $extParam = '';
        if($param){
            foreach($param AS $key => $val){
                $extParam .= $key . ":" . $val . ',';
            }
        }

        $token = csrf_token();
        $html = <<<EOF
         <link href="/base/webuploader/webuploader.css" rel="stylesheet">
                        <script src="/base/webuploader/webuploader.min.js"></script>
            <div class="WebUploader">
                <div class="WebUploader_button">
                    <div class="input-group">
                        <input type="text" class="form-control input-uploadfile" value="{$file}" name="{$name}" placeholder="{$option['placeholder']}" readonly>
                        <div class="input-group-btn">
                            <div id="{$id}" class="btn-xs {$option['button_class']}">上传文件</div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                function webUpload{$id}() {
                    var uploaderthis="#{$id}";
                    var uploader = WebUploader.create({
                        auto: true,
                        pick: {
                            id: uploaderthis,
                            multiple: false,
                        },
                        accept: {
                            title: 'Files',
                            extensions: "{$file_types}",
                        },
                        swf: "/base/webuploader/uploader.swf",
                        server: "/api/attachment/webupload",
                        fileNumLimit: 300,
                        fileSizeLimit: 20 * 1024 * 1024,
                        fileSingleSizeLimit: 10 * 1024 * 1024,
                    });
                    uploader.option("formData", {
                        $extParam
                        _time: Math.random(),
                        _token : "{$token}",
                        _position : "{$option['position']}",
                        elementid : "",
                        file_type : "file",
                        folder : "{$folder}"
                    });
                    uploader.on("error",function(type){
                        if(type=='F_EXCEED_SIZE'){
                            layer.msg("上传的文件不大于10MB", {icon: 2});
                            return false;
                        }else if(type=="Q_TYPE_DENIED"){
                            layer.msg("请上传格式正确的文件", {icon: 2});
                            return false;
                        }else {
                            layer.msg("服务器繁忙请稍候再试", {icon: 2});
                            return false;
                        }
                    });
                    uploader.on("uploadProgress",function(file,percentage){
                        var re = /([0-9]+\.[0-9]{2})[0-9]*/;
                        aNew = parseFloat(percentage*100).toFixed(0);
                        $(uploaderthis).parent().parent().find(".webuploader-pick").html(aNew+"%");
                        if(percentage==1){
                            $(uploaderthis).parent().parent().find(".webuploader-pick").html('保存中...');
                        }
                    });
                    uploader.on('uploadSuccess', function( file, response ) {
                        uploader.removeFile( file );
                        if(response.code == 200){
                            $(uploaderthis).parent().parent().find(".input-uploadfile").val(response.fileurl);
                            $(uploaderthis).parent().parent().find(".webuploader-pick").html('上传完成');
                        }else{
                            layer.msg(response.message, {icon: 2});
                            $(uploaderthis).parent().parent().find(".webuploader-pick").html('上传失败');
                        }
                    });

                }
                webUpload{$id}();
            </script>
EOF;
        return $html;
    }


    public function single2($folder, $id, $name="data", $file="", $option=[]){
        $folder = urlencode($folder);

        $imgHtml =  "";
        $option['callback'] = isset($option['callback']) ? $option['callback'] : "";
        if(!$option['callback'] && !empty($file)) {
            // $imgHtml .=  " <li><em class=\"close\" onclick='$(this).parent().remove()'>×</em>
            //         <a href='{$file}' class='cc_file' target='_blank'> <img src=\"/base/plugins/imguploader/img/file.jpg\" alt=\"{$file}\"></a>
            //         <p class=\"rate\" style=\"display: none;\"><span style=\"width: 100%;\"></span></p>
            //         <p class=\"yes\" style=\"display: none;\"></p>
            //         <p class=\"no\"></p>
            //         <input type=\"hidden\" name=\"{$name}\" value=\"{$file}\">
            //     </li>";
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
            new uploadFile({
                UploaderPick:"#$id",
                UploaderMax:0,
                UploadHiddenField:"$name",
                UploaderServer:"/api/attachment/webupload?elementid=&folder=$folder&_time=" + Math.random(),
                UploaderSingle:true
            });
        </script>
EOF;
        return $html;
    }

    public function multi2($folder, $id, $name="data[image]", $files=[], $option=[]){
        $folder = urlencode($folder);
        $imgHtml =  "";
        $option['callback'] = isset($option['callback']) ? $option['callback'] : "";
        $option['max'] = isset($option['max']) ? $option['max'] : 200;
        $option['max'] = $option['max']-count($files);

        if(!$option['callback'] && !empty($files)) {
            foreach($files as $key=>$val) {
                if(is_string($val)) {
                    $file['url'] = $val;
                    $file['alt'] = '';
                }else{
                    $file = $val;
                }
                /*$imgHtml .=  " <li><em class=\"close\" onclick='$(this).parent().remove()'>×</em>
                        <a href='{$file['url']}' title='{$file['alt']}' target='_blank'> <img src=\"/base/plugins/imguploader/img/file.jpg\" alt=\"{$file['alt']}\"></a>
                        <p class=\"rate\" style=\"display: none;\"><span style=\"width: 100%;\"></span></p>
                        <p class=\"yes\" style=\"display: none;\"></p>
                        <p class=\"no\"></p>
                        <input type=\"hidden\" name=\"{$name}[alt][]\" value=\"{$file['alt']}\">
                        <input type=\"hidden\" name=\"{$name}[url][]\" value=\"{$file['url']}\">
                    </li>";*/
                $iconImage = in_array(fileExt($file['url']), ['jpg', 'png' , 'gif' , 'jpeg' , 'bmp']) ? " <div class='image'><img src=\"{$file['url']}\" alt= /></div>" : "<div class='icon'><i class='fa fa-file'></i></div>";

                $imgHtml .="<li >
                        <div class=\"file\">
                            <span class=\"corner\"></span>
                            {$iconImage}
                            <div class=\"file-name\">
                                <p>{$file['alt']}</p>
                                <small></small>
                            </div>
                        </div>
                        <em class=\"close\" onclick=\"$(this).parent().remove()\" >×</em>
                        <input type=\"hidden\" name=\"{$name}[alt][]\" value=\"{$file['alt']}\">
                        <input type=\"hidden\" name=\"{$name}[url][]\" value=\"{$file['url']}\">
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
            new uploadFile({
                UploaderPick:"#$id",
                UploaderMax:{$option['max']},
                UploaderServer:"/api/attachment/webupload?elementid=&folder=$folder&_time=" + Math.random(),
                UploadHiddenField:"$name"
            });
        </script>
EOF;
        return $html;
    }

}