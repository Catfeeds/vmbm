<?php
/**
 * User: Mike
 * Email: m@9026.com
 * Date: 2016/7/28
 * Time: 15:09
 */

namespace App\Services\CRUD;

use App\Models\AdminMenusModel;
use App\Models\ModuleTagModel;
use App\Services\Base\BaseProcess;

class CRUD extends BaseProcess
{

    private $_data;

    private $_date;
    private $_modelTpl;
    private $_repositoriesTpl;
    private $_CriteriaMultiWhereTpl;
    private $_controlTpl;
    private $_viewTpl;

    private $_fieldData;

    private $_fieldContentData;

    private $_fieldPrimary;

    public $notFillable = ['created_at','updated_at',"deleted_at"];

    private $_coverage = true; //强制覆盖
    /**
     * 创建CRUD
     * @param $data
     *
     */
    public function create($data) {

        $this->_dealData($data);
        \DB::beginTransaction();

        if(!$this->_addMenu()) {
            dd(1);
            $this->setMsg("添加菜单失败");
            \DB::rollback();
            return false;
        }

        if(!$this->_addModel()) {
            dd(2);
            $this->setMsg("添加模型失败");
            \DB::rollback();
            return false;
        }

        if(!$this->_addService()) {
            dd(3);
            $this->setMsg("添加Service失败");
            \DB::rollback();
            return false;
        }
        if(!$this->_addCriteriaMultiWhere()) {
            dd(4);
            $this->setMsg("添加Service失败");
            \DB::rollback();
            return false;
        }

        if(!$this->_addControl()) {
            dd(5);
            $this->setMsg("添加控制器失败");
            \DB::rollback();
            return false;
        }
        \DB::commit();
        return true;
    }

    public function _dealData($data) {
        $data['modelPath'] =  app_path() . "/Models/" . $data['model'] . ".php";
        $data['modelUse'] =   'App\Models\\' . $data['model'];
        $data['modelName'] =   $data['model'];

        $data['repositoriesPath'] =  app_path() . "/Repositories/" . $data['repositories'] . ".php";
        $data['repositoriesUse'] =  'App\Repositories\\' . str_replace('/','\\',$data['repositories']);
        $data['CriteriaMultiWherePath'] =  app_path() . "/Repositories/" . substr($data['repositories'],0,strrpos ($data['repositories'], "/")) . "/Criteria/MultiWhere" . ".php"; ;
        $data['CriteriaMultiWhereUse'] =  substr($data['repositoriesUse'],0,strrpos ($data['repositoriesUse'], "\\")) . "\\Criteria\\MultiWhere" ;
        $data['repositoriesName'] =  substr(strrchr( $data['repositories'], '/'), 1);
        $data['controlPath'] =  app_path() . "/Http/Controllers/Admin/" . $data['control'] . ".php";
        $data['controlUse'] =  'App\Repositories\\' . str_replace('/','\\',$data['control']);
        $data['controlName'] =  substr(strrchr( $data['control'], '/'), 1);

        $data['viewBaseSort'] =   'admin/'. strtolower(substr($data['control'],0,-10));
        $data['viewPath'] = base_path() . "/resources/views/" . $data['viewBaseSort'];
        $data['viewSortPath'] = str_replace('/','.',$data['viewBaseSort']);

        $this->_modelTpl = __DIR__ . "/tpl/model.tpl";
        $this->_repositoriesTpl = __DIR__ . "/tpl/repositories.tpl";
        $this->_CriteriaMultiWhereTpl = __DIR__ . "/tpl/creteriaMultiWhere.tpl";
        $this->_controlTpl = __DIR__ . "/tpl/controller.tpl";
        $this->_viewTpl = __DIR__ . "/tpl/view/";
        $this->_data = $data;
        $this->_date =  date("Y-m-d H:i:s");
        $this->_fieldData = $resultRow = \DB::select("SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE,COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA= ? AND TABLE_NAME= ? ",[env('DB_DATABASE'),$this->_data['table']]);
        foreach($this->_fieldData as $data) {
            if($data->COLUMN_KEY == "PRI") {
                $this->_fieldPrimary = $data->COLUMN_NAME;
                break;
            }
        }

    }

    /**
     *
     * 添加菜单
     *
     */

    public function _addMenu(){
        $obj = new AdminMenusModel();
        $addData['pid'] = $this->_data['menu_pid'];
        $addData['display'] = 1;
        $addData['name'] = $this->_data['desc'];
        $addData['path'] = $this->_data['path'] . "/index";
        $baseObj = $obj->create($addData);
        if(!$baseObj) {
            return false;
        }
        //添加
        $addData['display'] = 0;
        $addData['path'] = $this->_data['path'] . "/create";
        $addData['pid'] = $baseObj->id;
        $addData['name'] = "添加";
        $ok = $obj->create($addData);
        if(!$ok) {
            return false;
        }

        //修改
        $addData['display'] = 0;
        $addData['path'] = $this->_data['path'] . "/update";
        $addData['pid'] = $baseObj->id;
        $addData['name'] = "修改";
        $ok = $obj->create($addData);

        if(!$ok) {
            return false;
        }
        //删除
        $addData['display'] = 0;
        $addData['path'] = $this->_data['path'] . "/destroy";
        $addData['pid'] = $baseObj->id;
        $addData['name'] = "删除";
        $ok = $obj->create($addData);

        if(!$ok) {
            return false;
        }

        //查看
        $addData['display'] = 0;
        $addData['path'] = $this->_data['path'] . "/view";
        $addData['pid'] = $baseObj->id;
        $addData['name'] = "查看";
        $ok = $obj->create($addData);

        if(!$ok) {
            return false;
        }
        //check
        $addData['display'] = 0;
        $addData['path'] = $this->_data['path'] . "/check";
        $addData['pid'] = $baseObj->id;
        $addData['name'] = "选择数据";
        $ok = $obj->create($addData);

        if(!$ok) {
            return false;
        }
        if(dict($this->_data['table'],'status')) {
            //check
            $addData['display'] = 0;
            $addData['path'] = $this->_data['path'] . "/status";
            $addData['pid'] = $baseObj->id;
            $addData['name'] = "状态变更";
            if(!$ok) {
                return false;
            }
        }

        return true;
    }

    /**
     * 添加模型
     */
    public function _addModel() {
        $filePath = $this->_data['modelPath'];
        if(file_exists($filePath) && $this->_coverage===false) {
            return true;
        }
        $notFillable = $this->notFillable;

        $date = $this->_date;
        $tpl = file_get_contents($this->_modelTpl);
        $table_primary = '';
        $fillable = "";
        foreach($this->_fieldData as $data) {
            if($data->COLUMN_KEY == "PRI") {
                $table_primary = $data->COLUMN_NAME;
            }elseif(!in_array($data->COLUMN_NAME,$notFillable)) {
                $fillable .= "\r\n                           '{$data->COLUMN_NAME}',";
            }
        }
       
        $fillable = $fillable ?  '['. substr($fillable,0,-1) ."\r\n                          ]": $fillable;
        $str = str_replace("{{table_comment}}", $this->_data['desc'], $tpl);
        $str = str_replace("{{table_name}}", $this->_data['table'], $str);
        $str = str_replace("{{table_primary}}", $table_primary, $str);
        $str = str_replace("{{fillable}}", $fillable, $str);
        $str = str_replace("{{class_name}}", $this->_data['model'], $str);
        $str = str_replace("{{date}}", $this->_date, $str);
        $ok = file_put_contents($filePath, $str);
        if(!$ok) {
            return true;
        }

        return true;
    }

    /**
     * 添加Service
     */
    public function _addService() {
        if(file_exists($this->_data['repositoriesPath']) && $this->_coverage===false) {
            return true;
        }
        $tpl = file_get_contents($this->_repositoriesTpl);
        $queryKeyord = "";
        foreach($this->_fieldData as $data) {

            $queryKeyord = " if(isset(\$this->search['{$data->COLUMN_NAME}']) && \$this->search['{$data->COLUMN_NAME}']) {
                                    \$model = \$model->where('{$data->COLUMN_NAME}',\$this->search['{$data->COLUMN_NAME}']);
                                 }\r\n";
        }


        $this->customMkdir(substr($this->_data['repositoriesPath'],0,strrpos ($this->_data['repositoriesPath'], "/")),  $mode = 0777, $recursive = true);
        $str = str_replace("{{desc}}", $this->_data['desc'], $tpl);
        $str = str_replace("{{modelUse}}", $this->_data['modelUse'], $str);
        $str = str_replace("{{sortPath}}", str_replace('/','\\',substr($this->_data['repositories'],0,strrpos ($this->_data['repositories'], "/"))), $str);
        $str = str_replace("{{repositoriesName}}", $this->_data['repositoriesName'], $str);
        $str = str_replace("{{modelName}}", $this->_data['modelName'], $str);
        $str = str_replace("{{primaryKey}}", $this->_fieldPrimary, $str);
        $str = str_replace("{{queryKeyord}}", $queryKeyord, $str);
        $str = str_replace("{{date}}", $this->_date, $str);
        $ok = file_put_contents($this->_data['repositoriesPath'], $str);
        return true;
    }



    /**
     * 添加Service
     */
    public function _addCriteriaMultiWhere() {
        if(file_exists($this->_data['CriteriaMultiWherePath']) && $this->_coverage===false) {
            return true;
        }
        $tpl = file_get_contents($this->_CriteriaMultiWhereTpl);
        $queryKeyord = "";
        foreach($this->_fieldData as $data) {

            $queryKeyord = " if(isset(\$this->search['{$data->COLUMN_NAME}']) && \$this->search['{$data->COLUMN_NAME}']) {
                                    \$model = \$model->where('{$data->COLUMN_NAME}',\$this->search['{$data->COLUMN_NAME}']);
                                 }\r\n";
        }


        $this->customMkdir(substr($this->_data['CriteriaMultiWherePath'],0,strrpos ($this->_data['CriteriaMultiWherePath'], "/")),  $mode = 0777, $recursive = true);

        $str = str_replace("{{desc}}", $this->_data['desc'], $tpl);
        $str = str_replace("{{sortPath}}", str_replace('/','\\',substr($this->_data['repositories'],0,strrpos ($this->_data['repositories'], "/"))), $str);

        $str = str_replace("{{queryKeyord}}", $queryKeyord, $str);
        $ok = file_put_contents($this->_data['CriteriaMultiWherePath'], $str);
        return true;
    }


    public function _addControl() {
        if(file_exists($this->_data['controlPath']) && $this->_coverage===false) {
            return true;
        }
        $this->customMkdir(substr($this->_data['controlPath'],0,strrpos ($this->_data['controlPath'], "/")),  $mode = 0777, $recursive = true);
        $str = file_get_contents($this->_controlTpl);

        $str = str_replace("{{desc}}", $this->_data['desc'], $str);
        $str = str_replace("{{path}}", $this->_data['path'], $str);
        $str = str_replace("{{repositoriesUse}}", $this->_data['repositoriesUse'], $str);
        $str = str_replace("{{sortPath}}", str_replace('/','\\',substr($this->_data['control'],0,strrpos ($this->_data['control'], "/"))), $str);
        $str = str_replace("{{repositoriesName}}", $this->_data['repositoriesName'], $str);
        $str = str_replace("{{CriteriaMultiWhereUse}}", $this->_data['CriteriaMultiWhereUse'], $str);

        $str = str_replace("{{controlName}}", $this->_data['controlName'], $str);
        $str = str_replace("{{viewSortPath}}", $this->_data['viewSortPath'], $str);
        $str = str_replace("{{date}}", $this->_date, $str);

        $ok = file_put_contents($this->_data['controlPath'], $str);
        $this->_addView();
        return true;

    }

    public function _addView(){
        if(file_exists($this->_data['viewPath']) && $this->_coverage===false) {
            return true;
        }
        $this->customMkdir($this->_data['viewPath'],  $mode = 0777, $recursive = true);

        ###index
        $str = file_get_contents($this->_viewTpl . "/index.blade.php");

        $listThStr = "";
        $listTdStr = "";
        $i = 0;
        foreach($this->_fieldData as $data) {
            if(!in_array($data->COLUMN_NAME,["deleted_at"]) && $data->DATA_TYPE !='text') {
                $i++;
                if($i>7) break;
                $listThStr .= "\r\n            <th class=\"sorting\" data-sort=\"{$data->COLUMN_NAME}\"> {$data->COLUMN_COMMENT} </th>";

                switch($data->DATA_TYPE) {
                    case "tinyint":
                        if(dict()->get($this->_data['table'],$data->COLUMN_NAME)) {
                            $listTdStr .= "\r\n            <td>{{ dict()->get('{$this->_data['table']}','{$data->COLUMN_NAME}',\$item->{$data->COLUMN_NAME}) }}</td>";

                        }elseif(dict()->get('global',$data->COLUMN_NAME)) {
                            $listTdStr .= "\r\n            <td>{{ dict()->get('global','{$data->COLUMN_NAME}',\$item->{$data->COLUMN_NAME}) }}</td>";

                        }else{
                            $listTdStr .= "\r\n            <td>{{ \$item->{$data->COLUMN_NAME} }}</td>";
                        }
                        break;
                    default:
                        $listTdStr .= "\r\n            <td>{{ \$item->{$data->COLUMN_NAME} }}</td>";

                        break;

                }

            }
        }

        $str = str_replace("{{desc}}", $this->_data['desc'], $str);
        $str = str_replace("{{path}}", $this->_data['path'], $str);
        $str = str_replace("{{primaryKey}}",  $this->_fieldPrimary, $str);
        $str = str_replace("{{listThStr}}",  $listThStr, $str);
        $str = str_replace("{{listTdStr}}",  $listTdStr, $str);

        $ok = file_put_contents($this->_data['viewPath'] . "/index.blade.php", $str);
        ###check
        $str = file_get_contents($this->_viewTpl . "/check.blade.php");

        $str = str_replace("{{desc}}", $this->_data['desc'], $str);
        $str = str_replace("{{path}}", $this->_data['path'], $str);
        $str = str_replace("{{primaryKey}}",  $this->_fieldPrimary, $str);
        $str = str_replace("{{listThStr}}",  $listThStr, $str);
        $str = str_replace("{{listTdStr}}",  $listTdStr, $str);
        $ok = file_put_contents($this->_data['viewPath'] . "/check.blade.php", $str);

        #view
        $str = file_get_contents($this->_viewTpl . "/view.blade.php");

        $str = str_replace("{{desc}}", $this->_data['desc'], $str);
        $str = str_replace("{{path}}", $this->_data['path'], $str);

        $str = str_replace("{{primaryKey}}",  $this->_fieldPrimary, $str);
        $viewTdStr = "";
        foreach($this->_fieldData as $data) {
            $viewTdStr .= "                     \r\n               <div class=\"list-group-item\">
                                                  \r\n                   <h3 class=\"list-group-item-heading\">{$data->COLUMN_COMMENT}</h3>
                                                   \r\n                   <p class=\"list-group-item-text\">";

            switch($data->DATA_TYPE) {
                case "tinyint":
                    if(dict()->get($this->_data['table'],$data->COLUMN_NAME)) {
                        $viewTdStr .= "{{ dict()->get('{$this->_data['table']}','{$data->COLUMN_NAME}',\$data['{$data->COLUMN_NAME}']) }}";

                    }elseif(dict()->get('global',$data->COLUMN_NAME)) {
                        $viewTdStr .= "{{ dict()->get('global','{$data->COLUMN_NAME}',\$data['{$data->COLUMN_NAME}']) }}";

                    }else{
                        $viewTdStr .= " {{ \$data['{$data->COLUMN_NAME}'] or ''}}";
                    }
                    break;
                default:
                    $viewTdStr .= " {{ \$data['{$data->COLUMN_NAME}'] or ''}}";
                    break;

            }

            $viewTdStr .= "</p>
                                                 \r\n               </div>";
        }

        $str = str_replace("{{viewTdStr}}",  $viewTdStr, $str);

        $ok = file_put_contents($this->_data['viewPath'] . "/view.blade.php", $str);

        #edit

        $str = file_get_contents($this->_viewTpl . "/edit.blade.php");

        $str = str_replace("{{desc}}", $this->_data['desc'], $str);
        $str = str_replace("{{path}}", $this->_data['path'], $str);

        $str = str_replace("{{primaryKey}}",  $this->_fieldPrimary, $str);
        $editTdStr = "";
        foreach($this->_fieldData as $data) {
            if(!in_array($data->COLUMN_NAME,[$this->_fieldPrimary,'created_at','updated_at',"deleted_at"])) {
                $editTdStr .= "    \r\n                <div class=\"form-group\">
                                    \r\n                 <label class=\"control-label col-sm-3\">{$data->COLUMN_COMMENT}</label>
                                    \r\n                   <div class=\"col-sm-9\">";

                switch($data->DATA_TYPE) {
                    case "tinyint":


                        if(dict()->get($this->_data['table'],$data->COLUMN_NAME)) {
                            $editTdStr .= " @foreach(dict()->get('{$this->_data['table']}','{$data->COLUMN_NAME}') as \$key=>\$val)
                                                   <label class=\"radio-inline\">
                                                       <input type=\"radio\" name=\"data[{$data->COLUMN_NAME}]\" value=\"\$key\" @if(isset(\$data['{$data->COLUMN_NAME}']) && \$data['{$data->COLUMN_NAME}'] == \$key)checked=\"checked\" @endif/>{{\$val}}
                                                   </label>
                                            @endforeach";

                        }elseif(dict()->get('global',$data->COLUMN_NAME)) {
                            $editTdStr .= " @foreach(dict()->get('global','{$data->COLUMN_NAME}') as \$key=>\$val)
                                                   <label class=\"radio-inline\">
                                                       <input type=\"radio\" name=\"data[{$data->COLUMN_NAME}]\" value=\"\{{\$key}}\" @if(isset(\$data['{$data->COLUMN_NAME}']) && \$data['{$data->COLUMN_NAME}'] == \$key)checked=\"checked\" @endif/>{{\$val}}
                                                   </label>
                                            @endforeach";

                        }else{
                            $editTdStr .= "\r\n                     <input id=\"data_{$data->COLUMN_NAME}\" name=\"data[{$data->COLUMN_NAME}]\" class=\"form-control\" value=\"{{ \$data['{$data->COLUMN_NAME}'] or ''}}\" required=\"\" aria-required=\"true\"  placeholder=\"\">";
                        }
                        break;
                    case "text":
                        $editTdStr .= "\r\n                     <textarea name=\"data[{$data->COLUMN_NAME}]\" id=\"editor{$data->COLUMN_NAME}\" required=\"\" aria-required=\"true\" class=\"form-control\" rows=\"10\">{{ \$data['{$data->COLUMN_NAME}'] or ''}}</textarea>
                                       \r\n                     {!! editor('editor{$data->COLUMN_NAME}', ['position' => 'local', 'folder' => '/upload/common'], ['themeType' => 'simple', 'height' => '300px']) !!}
                                           ";

                        break;
                    case "datetime":
                        $editTdStr .= "\r\n  <input name=\"data[{$data->COLUMN_NAME}]\" class=\"form-control laydate-icon help-block m-b-none\" style=\"width:200px; height:34px;\" value=\"{{ \$data['{$data->COLUMN_NAME}'] or ''}}\" placeholder=\"{$data->COLUMN_COMMENT}\" onclick=\"laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})\" aria-invalid=\"false\">";


                        break;
                    default:
                        $editTdStr .= "\r\n                     <input id=\"data_{$data->COLUMN_NAME}\" name=\"data[{$data->COLUMN_NAME}]\" class=\"form-control\" value=\"{{ \$data['{$data->COLUMN_NAME}'] or ''}}\" required=\"\" aria-required=\"true\"  placeholder=\"\">";
                        break;

                }
                $editTdStr .=" \r\n                    </div>
                                \r\n                </div>";

            }
        }

        $str = str_replace("{{editTdStr}}",  $editTdStr, $str);

        $ok = file_put_contents($this->_data['viewPath'] . "/edit.blade.php", $str);
        return true;
    }

    public function customMkdir($dir)
    {
        if(!file_exists($dir)) {
            \File::makeDirectory($dir,  $mode = 0755, $recursive = true);
        }
    }



}