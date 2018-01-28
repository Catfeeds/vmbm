<?php
/**
 *------------------------------------------------------
 * Tree.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @date      2016/5/26 11:17
 * @version   V1.0
 *
 */

namespace App\Services\Base;

class Tree {
    
    /**
    * 生成树型结构所需要的2维数组
    */
    public $arr = array();

    /**
    * 生成树型结构所需修饰符号
    */
    public $icon = array('│','├','└');
    public $nbsp = "&nbsp;";
    public $treeArr = array();

    /**
    * 构造函数，初始化类
    * @param array 2维数组，例如：
    * array(
    *      1 => array('id'=>'1','pid'=>0,'name'=>'一级栏目一'),
    *      2 => array('id'=>'2','pid'=>0,'name'=>'一级栏目二'),
    *      3 => array('id'=>'3','pid'=>1,'name'=>'二级栏目一'),
    *      4 => array('id'=>'4','pid'=>1,'name'=>'二级栏目二'),
    *      5 => array('id'=>'5','pid'=>2,'name'=>'二级栏目三'),
    *      6 => array('id'=>'6','pid'=>3,'name'=>'三级栏目一'),
    *      7 => array('id'=>'7','pid'=>3,'name'=>'三级栏目二'),
    *   )
    */
    public function init($arr = [])
    {
        $data = array();
        foreach ($arr AS $val){
            $data[$val['id']] = $val;
        }
        $this->arr = $data;
        $this->treeArr = array();
        return is_array($data);
    }

    /**
    * 得到父级数组
    * @param int
    * @return array
    */
    public function getParent($myid)
    {
        $newarr = array();
        if(!isset($this->arr[$myid])) return false;
        $pid = $this->arr[$myid]['pid'];
        if(isset($this->arr[$pid]['pid'])){
            $pid = $this->arr[$pid]['pid'];
        }
        if(is_array($this->arr)){
            foreach($this->arr as $id => $val){
                if($val['pid'] == $pid) $newarr[$id] = $val;
            }
        }
        return $newarr;
    }
    
    /**
     * 得到所有父级数组
     * @param int
     * @return array
     */
    public function getAllParents($myid, &$newarr = [])
    {
        
        if(!isset($this->arr[$myid])) return false;
        $pid = $this->arr[$myid]['pid'];

        if(isset($this->arr[$pid])){
            $newarr[$pid] = $this->arr[$pid];
            $this->getAllParents($pid, $newarr);
        }
        
        return array_reverse($newarr, true);
    }

    /**
    * 得到子级数组
    * @param int
    * @return array
    */
    public function getChild($myid)
    {
        $newarr = array();
        if(is_array($this->arr)){
            foreach($this->arr as $id => $val){
                if($val['pid'] == $myid) $newarr[$id] = $val;
            }
        }
        return $newarr ? $newarr : false;
    }

    /**
    * 得到当前位置数组
    * @param int
    * @return array
    */
    public function getPos($myid, &$newarr = [])
    {
        $a = array();
        if(!isset($this->arr[$myid])) return false;
        $newarr[] = $this->arr[$myid];
        $pid = $this->arr[$myid]['pid'];
        if(isset($this->arr[$pid])){
            $this->getPos($pid, $newarr);
        }
        if(is_array($newarr)){
            krsort($newarr);
            foreach($newarr as $v){
                $a[$v['id']] = $v;
            }
        }
        return $a;
    }
    
    /**
     * 得到树型结构
     * @param $myid        表示获得这个ID下的所有子级, 默认不包括自身
     * @param $spacer      间隔缩进     
     * @param $self        是否包含自身      
     */
    public function getTree($myid = 0, $spacer = '', $self = false)
    {
        if($self){
            $spacer = $spacer ? $spacer : $this->nbsp;
            $selfArr = $this->arr[$myid];
            $selfArr['spacer'] = '';
            $this->treeArr[] = $selfArr;
        }
        $number = 1;
        $child = $this->getChild($myid);
        if(is_array($child)){
            $total = count($child);
            foreach($child as $value){
                $j = $k = '';
                if($number == $total){
                    $j .= $this->icon[2];
                }else{
                    $j .= $this->icon[1];
                    $k = $spacer ? $this->icon[0] : '';
                }
                
                $nbsp = $this->nbsp;
                //间隔缩进
                $value['spacer'] = $spacer ? $spacer.$j : '';
                //层级关系
                $value['level'] = count(explode($nbsp, $value['spacer']));
                //生成带树状结构的新数组
                $this->treeArr[] = $value;
                $this->getTree($value['id'], $spacer.$k.$nbsp);
                $number++;
            }
        }
        return $this->_cateAppendChild($this->treeArr);
    }

    /**
     * 栏目是否含有子栏目
     * @param $cateArr
     * @return mixed
     */
    private function _cateAppendChild($cateArr)
    {
        //PID集合
        $pidArr = [];
        foreach($cateArr AS $val){
            $pidArr[$val['pid']] = $val['pid'];
        }
        //栏目ID在PID集合内，则含有子栏目
        foreach($cateArr AS $key => $val){
            if(in_array($val['id'], $pidArr)){
                $cateArr[$key]['child'] = 1;
            }else{
                $cateArr[$key]['child'] = 0;
            }
        }
        return $cateArr;
    }

}

