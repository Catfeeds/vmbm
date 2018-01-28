<?php
/**
 * 创建增删改查
 * User: Mike
 * Email: m@9026.com
 * Date: 2016/6/4
 * Time: 17:14
 */

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Controller;
use App\Services\CRUD\CRUD;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\Menus;
use Request;


class CrudController extends Controller
{
    function create() {
        if(Request::method() == 'POST') {
            return $this->_createSave();
        }
        $schema = env("DB_DATABASE");

        $tables = DB::select("SELECT TABLE_NAME,TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA='$schema'");

        $MenusTrees = (new Menus())->getMenusTree();
        return view('admin.base.crud.create',compact('tables','MenusTrees'));
    }
    private function _createSave() {
        $data = Request::all();
        $obj = new CRUD();
        $ok = $obj->create($data);
        if($ok) {
            $this->showMessage("操作成功");
        }else{
            $this->showWarning("操作失败:" . $obj->getMessage());
        }
    }



    public function getTable(){
        $table = request()->get('table');
        $schema = env("DB_DATABASE");
        $data = DB::select("SELECT COLUMN_NAME,COLUMN_KEY FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='{$schema}' AND TABLE_NAME='{$table}';");
    }

    public function checkModelPath($modelPath = null) {
        if(!$modelPath) {
            $modelPath = request()->get('path');
        }
        $modelPath = app_path() . "/Models/" . $modelPath . ".php";
        if(file_exists($modelPath)) {
            return json_encode(['status'=>FAILURE_CODE,'msg'=>'注意！！Model文件已存在，系统重复不会创建!!!']);
        }else{
            return json_encode(['status'=>SUCESS_CODE]);
        }
    }

    public function checkServicePath($modelPath = null) {
        if(!$modelPath) {
            $modelPath = request()->get('path');
        }
        $modelPath = app_path() . "/Repositories/" . $modelPath . ".php";
        if(file_exists($modelPath)) {
            return json_encode(['status'=>FAILURE_CODE,'msg'=>'注意！！Service文件已存在，系统重复不会创建!!!']);
        }else{
            return json_encode(['status'=>SUCESS_CODE]);
        }
    }

    public function checkControllerPath($modelPath = null) {
        if(!$modelPath) {
            $modelPath = request()->get('path');
        }
        $modelPath = app_path() . "/Http/Controllers/Admin/" . $modelPath . ".php";
        if(file_exists($modelPath)) {
            return json_encode(['status'=>FAILURE_CODE,'msg'=>'注意！！Controller文件已存在，系统重复不会创建!!!']);
        }else{
            return json_encode(['status'=>SUCESS_CODE]);
        }
    }
    public function checkPath($modelPath = null) {
        if(!$modelPath) {
            $modelPath = request()->get('path');
        }
        $modelPath = app_path() . "/Http/Controllers/Admin/" . $modelPath . ".php";
        if(file_exists($modelPath)) {
            return json_encode(['status'=>FAILURE_CODE,'msg'=>'注意！！Controller文件已存在，系统重复不会创建!!!']);
        }else{
            return json_encode(['status'=>SUCESS_CODE]);
        }
    }
}