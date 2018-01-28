@extends('admin.layout')

@section('content')
   <section class="content-header">
       <h1>
           配置管理
           <small>配置列表</small>
       </h1>

   </section>

    <div class="content">
        <div class="row">

            <div class="col-sm-12 col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="pull-right">
                            <div class="btn-group mr10">
                                <a href="" class="btn btn-white tooltips"
                                   data-toggle="tooltip" data-original-title="新增" style="margin-right:20px;"><i
                                            class="fa fa-plus" ></i></a>
                            </div>
                        </div><!-- pull-right -->

                        <h5 class="subtitle mb5">配置列表</h5>

                        {{--@include('admin._partials.show-page-status',['result' => $items])--}}

                        <div class="table-responsive col-md-12">
                            <table class="table mb30">
                                <thead>
                                <tr>
                                    <th>类别</th>
                                    <th>键</th>
                                    <th>值</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>类别定义</td>
                                        <td>{{$category->code}}</td>
                                        <td>{{$category->value}}</td>
                                        <td>
{{--                                            <a href="{{ route('admin.setting.edit', ['id' => $category->id]) }}" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑</a>--}}
                                            <a class="btn btn-danger btn-sm application-delete"
                                               href="javascript:if (confirm('确定要删除？')) { $('#form-destroy-{{ $category->id }}').submit(); }"><i class="fa fa-trash-o"></i> 删除</a>
                                            <form id="form-destroy-{{ $category->id }}" class="hidden" action="{{ route('admin.setting.destroy', ['id'=>$category->id]) }}" method="POST">
                                                <input name="_method" type="hidden" value="DELETE">
                                                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                            </form>
                                        </td>
                                    </tr>

                                    @foreach($items as $item)
                                        @if($item->category == $category->code)
                                        <tr>
                                            <td>-&nbsp;&nbsp;{{$category->value}}</td>
                                            <td>{{$item->code}}</td>
                                            <td>{{$item->value}}</td>
                                            <td>
                                                <a href="{{ route('admin.setting.edit', ['id' => $item->id]) }}" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑</a>
                                                <a class="btn btn-danger btn-sm application-delete"
                                                   href="javascript:if (confirm('确定要删除？')) { $('#form-destroy-{{ $item->id }}').submit(); }"><i class="fa fa-trash-o"></i> 删除</a>
                                                <form id="form-destroy-{{ $item->id }}" class="hidden" action="{{ route('admin.setting.destroy', ['id'=>$item->id]) }}" method="POST">
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                                </form>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach

                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{--{{ $items->links() }}--}}

                    </div><!-- panel-body -->
                </div><!-- panel -->

            </div><!-- col-sm-12 -->

        </div><!-- row -->
    </div><!-- contentpanel -->

    <script type="text/javascript">
        $(document).ready(function() {
            $(".user-delete").click(function () {
                return confirm("确认删除该条目？");
            });
            $(".deleteall").click(function () {
                return confirm("确认删除选定条目？");
            });
            $("#selectall").click(function () {
                var v = this.checked;
                $("tbody input:checkbox").attr("checked", v);
            });
        });
    </script>
@endsection