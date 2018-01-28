<?php
/**
 * 操作日志
 *  @author  Mike <m@9026.com>
 *  @version    1.0
 *  @date 2015年10月15日
 *
 */
namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Controller;
use Request;
use App\Services\User\Payinfo;
use App\Utils\AliLog;
use Carbon\Carbon;

class ActionlogController extends Controller {
    private $_service;
    private $_viewdata;
    private $_aTopic = [ 'action-view-log'=>'访问日志','action-operate-log'=>'操作日志'];
    /**
     * 初始化Service
     */
    public function __construct()
    {
        parent::__construct();
    
        if(!$this->_service) $this->_service = new Payinfo();
        
        $this->_viewdata = array();
    }
    
    /**
     * 列表
     */
    function index()
    {
        $obj = new AliLog();
        $this->_viewdata['aTopIc'] = $this->_aTopic;
        $this->_viewdata['topic'] = Request::input('topic','action-view-log');
        $this->_viewdata['aLine'] = [50=>'50行',100=>'100行',200=>'200行'];
        $this->_viewdata['line']  = Request::input('line',50);
        $this->_viewdata['start_time']  = Request::input('start_time',Carbon::yesterday());
        $this->_viewdata['end_time']  = Request::input('end_time',Carbon::tomorrow());
        $query = '';
        $data = $obj->listLogs('admin-operate-log',
                                strtotime($this->_viewdata['start_time']),
                                strtotime($this->_viewdata['end_time']), 
                                $this->_viewdata['topic'],
                                $query,
                                $this->_viewdata['line']
                );
        $request = Request::all();
        $search['keyword'] = Request::input('keyword');
        
        $orderby = array();
        if(isset($request['sort_field']) && $request['sort_field'] && isset($request['sort_field_by'])) {
            $orderby[$request['sort_field']] = $request['sort_field_by'];
        }
        $this->_viewdata['data'] = $data;
    
        return view('admin.base.actionlog.index', $this->_viewdata);
    }
    
    
    
    
    
}
