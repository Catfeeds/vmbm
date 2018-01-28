<?php
/**
 *  配置列表
 *  @author  system
 *  @version    1.0
 *  @date 2017-05-31 04:56:09
 *
 */
namespace App\Http\Controllers\Admin\Base;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Repositories\Base\Criteria\OrderBy;
use App\Repositories\Settings\Criteria\MultiWhere;
use App\Repositories\Settings\SettingsRepository;
use App\Models\BaseSettingsModel;

class SettingsController extends Controller
{
    private $repository;

    public function __construct(SettingsRepository $repository) {
        if(!$this->repository) $this->repository = $repository;
    }

    function index(Request $reqeust) {
        $search['keyword'] = $reqeust->input('keyword');
        $query = $this->repository->pushCriteria(new MultiWhere($search));

        if(isset($request['sort_field']) && $request['sort_field'] && isset($request['sort_field_by'])) {
        $query = $query->pushCriteria(new OrderBy($request['sort_field'],$request['sort_field_by']));
        }
        $list = $query->paginate();
        return view('admin.base.settings.index',compact('list'));
    }


    function check(Request $reqeust) {
        $request = $reqeust->all();
        $search['keyword'] = $reqeust->input('keyword');
        $orderby = array();
        if(isset($request['sort_field']) && $request['sort_field'] && isset($request['sort_field_by'])) {
            $orderby[$request['sort_field']] = $request['sort_field_by'];
        }
        $list = $this->repository->search($search,$orderby);
        return view('admin.base.settings.check',compact('list'));
    }


    /**
     * 添加
     * 
     */
    public function create(Request $reqeust)
    {
        if($reqeust->method() == 'POST') {
            return $this->_createSave();
        }
        return view('admin.base.settings.edit', [
            'categories' => BaseSettingsModel::where('category', '=', 'category')->get(),
        ]);
    }

    /**
     * 保存修改
     */
    private function _createSave(){
        $data = (array) request('data');
        if ($this->repository->where(['category' => $data['category'], 'key' => $data['key']])->exists()) {
            $url[] = array('url'=>U( 'Base/Settings/index'),'title'=>'返回列表');
            return $this->showWarning('该类别下已有相同键存在!',$url);
        }
        $data['sort'] = empty($request->sort) ? 0 : $request->sort;

        $id = $this->repository->create($data);
        if($id) {
            $url[] = array('url'=>U( 'Base/Settings/index'),'title'=>'返回列表');
            $url[] = array('url'=>U( 'Base/Settings/create'),'title'=>'继续添加');
            $this->showMessage('添加成功',$url);
        }else{
            $url[] = array('url'=>U( 'Base/Settings/index'),'title'=>'返回列表');
            return $this->showWarning('添加失败',$url);
        }
    }
    
    /**
     * 
     * 修改
     * 
     * 
     */
    public function update(Request $reqeust) {
        if($reqeust->method() == 'POST') {
            return $this->_updateSave();
        }
        $data = $this->repository->find($reqeust->get('id'));
        $categories = BaseSettingsModel::where('category', '=', 'category')->get();
        return view('admin.base.settings.edit',compact('data','categories'));
    }

    /**
     * 保存修改
     */
    private function _updateSave() {
        $data = (array) request('data');
        if ($this->repository->where(['category' => $data['category'], 'key' => $data['key']])->exists()) {
            $url[] = array('url'=>U( 'Base/Settings/index'),'title'=>'返回列表');
            return $this->showWarning('该类别下已有相同键存在!',$url);
        }
        $ok = $this->repository->update(request('id'),$data);
        if($ok) {
            $url[] = array('url'=>U( 'Base/Settings/index'),'title'=>'返回列表');
            return $this->showMessage('操作成功',urldecode(request('_referer')));
        }else{
            $url[] = array('url'=>U( 'Base/Settings/index'),'title'=>'返回列表');
            return $this->showWarning('操作失败',$url);
        }
    }

    public function view(Request $reqeust) {
        $data = $this->repository->find(request('id'));
        return view('admin.base.settings.view',compact('data'));
    }


    /**
     *
     * 状态改变
     *
     */
    public function status(Request $reqeust) {
        $ok = $this->repository->updateStatus(request('id'),request('status'));
        if($ok) {
            return $this->showMessage('操作成功');
        }else{
            return $this->showWarning('操作失败');
        }
    }
    
    /**
     * 删除
     */
    public function destroy(Request $reqeust) {
        $bool = $this->repository->destroy($reqeust->get('id'));
        if($bool) {
            return  $this->showMessage('操作成功');
        }else{
            return  $this->showWarning("操作失败");
        }
    }
}