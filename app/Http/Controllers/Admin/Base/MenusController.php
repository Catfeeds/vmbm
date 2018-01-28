<?php
/**
 *  文章
 *  @author  Mike <m@9026.com>
 *  @version    1.0
 *  @date 2015年10月15日
 *
 */
namespace App\Http\Controllers\Admin\Base;
use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\Menus;
use Request;

class MenusController extends Controller
{

    private $_service;

    public function __construct ()
    {
        if (!$this->_service) $this->_service = new Menus();
    }

    function index ()
    {
        $search['keyword'] = Request::input('keyword');
        $list = $this->_service->getMenusTree($search);
        return view('admin.base.menus.index', compact('list'));
    }

    public function _showEdit ()
    {
        $MenusTrees = $this->_service->getMenusTree();
        view()->share("MenusTrees", $MenusTrees);
    }

    /**
     * 添加
     */
    public function create ()
    {
        if (Request::method() == 'POST') {
            return $this->_createSave();
        }
        $this->_showEdit();
        return view('admin.base.menus.edit');
    }

    private function _createSave ()
    {
        $id = $this->_service->create(Request::input('data'));
        if (isset($id->id)) {
            //更新菜单层级关系
            $level = $this->_service->getLevel($id->id);
            $this->_service->update($id->id, ['level' => $level]);
            
            $url[] = array(
                    'url' => U( 'Base/Menus/index'),
                    'title' => '返回列表'
            );
            $url[] = array(
                    'url' => U( 'Base/Menus/create'),
                    'title' => '继续添加'
            );
            $this->showMessage('添加成功', $url);
        } else {
            $url[] = array(
                    'url' => U( 'Base/Menus/index'),
                    'title' => '返回列表'
            );
            $this->showWarning('添加失败', $url);
        }
    }

    /**
     * 修改
     */
    public function update ()
    {
        if (Request::method() == 'POST') {
            return $this->_updateSave();
        }
        $this->_showEdit();
        $data = $this->_service->find(Request::input('id'));
        return view('admin.base.menus.edit', compact('data'));
    }

    private function _updateSave ()
    {
        $data = Request::input('data');
        $data['level'] = $this->_service->getLevel(Request::input('id'));
        $ok = $this->_service->update(Request::input('id'), $data);
        if ($ok) {
            $url[] = array(
                    'url' => U( 'Base/Menus/index'),
                    'title' => '返回列表'
            );
            $this->showMessage('操作成功', urldecode(Request::input('_referer')));
        } else {
            $url[] = array(
                    'url' => U( 'Base/Menus/index'),
                    'title' => '返回列表'
            );
            $this->showWarning('操作失败', $url);
        }
    }

    /**
     * 删除
     */
    public function destroy ()
    {
        $bool = $this->_service->destroy(Request::input('id'));
        if ($bool) {
            $this->showMessage('操作成功');
        } else {
            $this->showWarning("操作失败");
        }
    }
}