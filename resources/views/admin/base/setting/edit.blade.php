@extends('layouts.admin-app')

@section('content')

    <section class="content-header">
        <h1>
            配置管理
            <small>编辑配置</small>
        </h1>
        {!! Breadcrumbs::render('admin-setting-edit') !!}
    </section>

    <div class="content">
        <div class="row">

            <div class="col-sm-12 col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-btns">
                            <a href="{{route('admin.setting.index')}}" class="panel-close">×</a>
                        </div>
                        <h4 class="panel-title">编辑配置</h4>
                    </div>

                    <form class="form-horizontal form-bordered" action="{{ route('admin.setting.update', ['id' => $item->id]) }}" method="POST">
                        @include('admin._partials.errors', ['errors' => $errors])
                        {{ method_field('PATCH') }}
                        <div class="panel-body panel-body-nopadding">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">配置类别</label>

                                <div class="col-sm-6">
                                    <select required="true" class="form-control" name="category">
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->code }}"{!! $cat->code == $item->category ? ' selected' : '' !!}>{{ $cat->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">键</label>

                                <div class="col-sm-6">
                                    <input type="text" required="true" class="form-control" name="code" value="{{ $item->code }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">值</label>

                                <div class="col-sm-6">
                                    <input type="text" required="true" class="form-control" name="value" value="{{ $item->value }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">父节点</label>

                                <div class="col-sm-6">

                                    {!!  widget('Tools.Setting')->treeSelect('pid', $item->pid) !!}

                                </div>
                            </div>

                            {{ csrf_field() }}
                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <a class="btn btn-default" href="{{route('admin.setting.index')}}">取消</a>
                                    <button class="btn btn-primary">保存</button>
                                </div>
                            </div>
                        </div><!-- panel-footer -->

                    </form>
                </div>

            </div><!-- col-sm-9 -->

        </div><!-- row -->
    </div><!-- contentpanel -->

@endsection
