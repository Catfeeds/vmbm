@extends('admin.layout')

@section('content')
<div class="row">
    <div class="ibox-content">
        <div class="list-group">
                                 
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading"></h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['id'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">配置代码</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['key'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">配置名称</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['value'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">排序</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['sort'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">配置类型</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['category'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">父id</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['pid'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading">图片状态</h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['status'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading"></h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['created_at'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading"></h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['updated_at'] or ''}}</p>
                                                 
               </div>                     
               <div class="list-group-item">
                                                  
                   <h3 class="list-group-item-heading"></h3>
                                                   
                   <p class="list-group-item-text"> {{ $data['deleted_at'] or ''}}</p>
                                                 
               </div>
        </div>
    </div>
</div>
@endsection