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
  <div class="row">
    <div class="col-sm-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>用户管理</h5>
          <div class="ibox-tools">
            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">
                    @if(role('User/Info/index'))
            <div class="row">
              <div class="col-sm-3 pull-right">
                 <a href="{{ U('User/Info/index')}}" class="btn btn-sm btn-primary pull-right">返回列表</a>
              </div>
          </div>
                    @endif

                <div class="row">
                        <div class="col-lg-10">
                            <form name="form_product" id="form-validation" action="" class="form-horizontal form-validation" accept-charset="UTF-8" method="post">

                                    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">登录名</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_username" name="data[username]" class="form-control" value="{{ $data['username'] or ''}}" required="" aria-required="true"  placeholder="">
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">姓名</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_real_name" name="data[real_name]" isChinese class="form-control" value="{{ $data['real_name'] or ''}}" required="" aria-required="true"  placeholder="">
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">密码</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_password" name="data[password]" class="form-control" value="{{ $data['password'] or ''}}" required="" aria-required="true"  placeholder=""> 
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">EMAIL</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_email" name="data[email]" email="true" class="form-control" value="{{ $data['email'] or ''}}" required="" aria-required="true"  placeholder="">
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">手机号</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_mobile" name="data[mobile]" isMobile="true" class="form-control" value="{{ $data['mobile'] or ''}}" required="" aria-required="true"  placeholder="">
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">用户头像</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_avatar" name="data[avatar]" class="form-control" value="{{ $data['avatar'] or ''}}" required="" aria-required="true"  placeholder=""> 
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">性别</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_gender" name="data[gender]" class="form-control" value="{{ $data['gender'] or ''}}" required="" aria-required="true"  placeholder=""> 
                    </div>
                                
                    </div>    

                <div class="form-group">
                 <label class="control-label col-sm-3">工作类型</label>
                                    
                   <div class="col-sm-9">
                   @if(dict()->get('user_info','work_type') != null)
                       @foreach(dict()->get('user_info','work_type') as $key=>$val)
                           <label class="radio-inline">
                               <input type="radio" name="data[work_type]" value="{{$key}}" @if(isset($data['work_type']) && $data['work_type'] == $key)checked="checked" @endif/>{{$val}}
                           </label>
                        @endforeach
                    @else
                           <label class="radio-inline">
                               <input type="radio" name="data[work_type]">
                           </label>
                    @endif
                    </div>
                                
                    </div>
                    <div class="form-group">

                        <label class="control-label col-sm-3">居住地址省</label>

                        <div class="col-sm-9">
                            <div class="col-sm-2">
                                <select class="form-control" id="cmbProvince" name="place_province_id"></select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" id="cmbCity" name="place_city_id"></select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" id="cmbArea" name=""></select>
                            </div>
                            <script type="text/javascript" src="/base/js/areadata.min.js"></script>
                            <script type="text/javascript">
                                areadata({_cmbProvince:'cmbProvince',//省
                                    _cmbCity:'cmbCity',//市
                                    _cmbArea:'cmbArea',//县
                                    _infoname:'place_area_id',
                                    _default:"{{ $data['place_area_id'] or '' }}"//默认县
                                });
                            </script>
                        </div>

                    </div>

                                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">简介</label>

                    <div class="col-sm-9">
                        <textarea name="data[address]" id="editoraddress" required="" aria-required="true" class="form-control" rows="10">{{ $data['address'] or ''}}</textarea>

                        {!! editor('editoraddress', ['position' => 'local', 'folder' => '/upload/common'], ['themeType' => 'simple', 'height' => '280px']) !!}

                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">居住时长</label>
                                    
                   <div class="col-sm-9">
                   @if(dict()->get('user_info','address_time') != null)
                       @foreach(dict()->get('user_info','address_time') as $key=>$val)
                               <label class="radio-inline">
                                   <input type="radio" name="data[address_time]" value="{{$key}}" @if(isset($data['address_time']) && $data['address_time'] == $key)checked="checked" @endif/>{{$val}}
                               </label>
                        @endforeach
                      @else
                               <label class="radio-inline">
                                   <input type="radio" name="data[address_time]">
                               </label>
                    @endif
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">身份证号</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_idcard" name="data[idcard]" isIdCardNo="true" class="form-control" value="{{ $data['idcard'] or ''}}" required="" aria-required="true"  placeholder="">
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">身份证正面</label>
                                    
                   <div class="col-sm-9">
                       {!!  widget('Tools.ImgUpload')->single2('/upload/user','idcard_positive',"idcard_positive", isset($data['idcard_positive'])? $data['idcard_positive'] : "") !!}
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">身份证背面</label>
                                    
                   <div class="col-sm-9">
                       {!!  widget('Tools.ImgUpload')->single2('/upload/user','idcard_back',"idcard_back", isset($data['idcard_back'])? $data['idcard_back'] : "") !!}
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">学历</label>
                                    
                   <div class="col-sm-9">
                   @if(dict()->get('user_info','educational') != null)
                       @foreach(dict()->get('user_info','educational') as $key=>$val)
                           <label class="radio-inline">
                               <input type="radio" name="data[educational]" value="{{$key}}" @if(isset($data['educational']) && $data['educational'] == $key)checked="checked" @endif/>{{$val}}
                           </label>
                       @endforeach
                    @else
                           <label class="radio-inline">
                               <input type="radio" name="data[educational]">
                           </label>
                          @endif     
                    </div>
                </div>
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">婚姻状况</label>
                                    
                   <div class="col-sm-9"> 
                   @if(dict()->get('user_info','marital') != null)
                   @foreach(dict()->get('user_info','marital') as $key=>$val)
                                                   <label class="radio-inline">
                                                       <input type="radio" name="data[marital]" value="{{$key}}" @if(isset($data['marital']) && $data['marital'] == $key)checked="checked" @endif/>{{$val}}
                                                   </label>
                                            @endforeach 
                                            @else
                                                   <label class="radio-inline">
                                                       <input type="radio" name="data[marital]">
                                                   </label>
                                            @endif
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">直系亲属联系人关系</label>

                   <div class="col-sm-9"> 
                   @if(dict()->get('user_info','contact_bind') != null)
                   @foreach(dict()->get('user_info','contact_bind') as $key=>$val)
                                                   <label class="radio-inline">
                                                       <input type="radio" name="data[contact_bind]" value="{{$key}}" @if(isset($data['contact_bind']) && $data['contact_bind'] == $key)checked="checked" @endif/>{{$val}}
                                                   </label>
                                            @endforeach
                                            @else
                                                   <label class="radio-inline">
                                                       <input type="radio" name="data[contact_bind]">
                                                   </label>
                                            @endif
                    </div>

                    </div>
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">直系亲属联系人姓名</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_contact_name" name="data[contact_name]" isChinese="true" class="form-control" value="{{ $data['contact_name'] or ''}}" required="" aria-required="true"  placeholder="">
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">直系亲属联系人手机</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_contact_mobile" isMobile="true"  name="data[contact_mobile]" class="form-control" value="{{ $data['contact_mobile'] or ''}}" required="" aria-required="true"  placeholder="">
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">其他联系人关系</label>
                                    
                   <div class="col-sm-9"> 
                   @if(dict()->get('user_info','other_contact_bind') != null)
                   @foreach(dict()->get('user_info','other_contact_bind') as $key=>$val)
                                                   <label class="radio-inline">
                                                       <input type="radio" name="data[other_contact_bind]" value="{{$key}}" @if(isset($data['other_contact_bind']) && $data['other_contact_bind'] == $key)checked="checked" @endif/>{{$val}}
                                                   </label>
                                            @endforeach 
                                            @else
                                                   <label class="radio-inline">
                                                       <input type="radio" name="data[other_contact_bind]">
                                                   </label>
                                            @endif
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">直系亲属联系人姓名</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_other_contact_name" isChinese="true" name="data[other_contact_name]" class="form-control" value="{{ $data['other_contact_name'] or ''}}" required="" aria-required="true"  placeholder="">
                    </div>
                                
                    </div>    
                <div class="form-group">
                                    
                 <label class="control-label col-sm-3">直系亲属联系人手机</label>
                                    
                   <div class="col-sm-9">
                     <input id="data_other_contact_mobile" isMobile="true"  name="data[other_contact_mobile]" class="form-control" value="{{ $data['other_contact_mobile'] or ''}}" required="" aria-required="true"  placeholder="">
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

@endsection