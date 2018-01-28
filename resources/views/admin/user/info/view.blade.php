@extends('admin.layout')

@section('content')
<div class="row">
    <div class="ibox-content">
        <div class="list-group">
                                 
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">用户ID</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['id'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">登录名</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['username'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">姓名</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['real_name'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">密码</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['password'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">EMAIL</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['email'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">手机号</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['mobile'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">用户头像</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['avatar'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">性别,1:男,2:女,参照数据字典</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['gender'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">居住地址省</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['province'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">居住地址市</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['city'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">居住地址区县</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['county'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">工作类型：上班，自由职业者</h3>
                                                   
                   <p class="list-group-item-text">{{ dict()->get('user_info','work_type',$data['work_type']) }}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">详细地址</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['address'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">居住时长</h3>
                                                   
                   <p class="list-group-item-text">{{ dict()->get('user_info','address_time',$data['address_time']) }}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">身份证号</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['idcard'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">身份证正面</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['idcard_positive'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">身份证背面</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['idcard_back'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">学历</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['educational'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">婚姻状况</h3>
                                                   
                   <p class="list-group-item-text">{{ dict()->get('user_info','marital',$data['marital']) }}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">最后一次登录时间</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['last_login_time'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">直系亲属联系人关系</h3>
                                                   
                   <p class="list-group-item-text">{{ dict()->get('user_info','contact_bind',$data['contact_bind']) }}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">直系亲属联系人姓名</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['contact_name'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">直系亲属联系人手机</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['contact_mobile'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">其他联系人关系</h3>
                                                   
                   <p class="list-group-item-text">{{ dict()->get('user_info','other_contact_bind',$data['other_contact_bind']) }}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">直系亲属联系人姓名</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['other_contact_name'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">直系亲属联系人手机</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['other_contact_mobile'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">创建时间</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['created_at'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">更新时间</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['updated_at'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">删除时间</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['deleted_at'] or ''}}</p>
                                                 
               </div>
        </div>
    </div>
</div>
@endsection