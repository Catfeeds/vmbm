@extends('admin.layout')

@section('content')


    {!!  widget('Tools.ImgUpload')->single2('/upload/user','idcard_positive',"idcard_positive", isset($data['idcard_positive'])? $data['idcard_positive'] : "",array("sizex"=>100)) !!}
{{--{!!  widget('Tools.ImgUpload')->single3('单文件上传', '/upload/user', 'single_file') !!}--}}
{{--{!!  widget('Tools.ImgUpload')->multi3('多文件上传', '/upload/user', 'multi_file') !!}--}}
{{--{!!  widget('Tools.ImgUpload')->multi3('按钮文字', '上传文件夹', 'id', '附加选项') !!}--}}

！！！注意：需要提前引入jQuery + Bootstrap

@endsection

@section('footer')
<script type="text/javascript">
$(function() {

});
</script>
@endsection