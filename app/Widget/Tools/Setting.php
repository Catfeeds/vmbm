<?php
/**
 * User: Mike
 * Email: m@9026.com
 * Date: 2016/6/28
 * Time: 16:49
 */

namespace App\Widget\Tools;

use App\Models\BaseSettingsModel;

class Setting
{
    private function _treeSelect($tree, $fid, $prefix) {
        $select = '';
        foreach ($tree as $node) {
            $lv = $node['level'];
            $data = $node['data'];
            $children = $node['children'];

            $padding = '';
            for ($i = 0; $i < $lv; $i++) {
                $padding .= $prefix;
            }

            if($data->id == $fid) {
                $select .= '<option value="' . $data->id . '" selected>' . $padding . $data->value . '[' . $data->category . ']' . '</option>';
            } elseif($data->id != $fid) {
                $select .= '<option value="' . $data->id . '">' . $padding . $data->value . '[' . $data->category . ']' . '</option>';
            }
            if (!empty($children)) {
                $select .= $this->_treeSelect($children, $fid, $prefix);
            }
        }
        return $select;
    }

    public function treeSelect($field, $fid = 0, $prefix = '&nbsp;&nbsp;&nbsp;&nbsp;')
    {
        $chTree = BaseSettingsModel::tree();
        $select = '<select class="form-control input-sm" name="' . $field . '">';
        $select .= '<option value="0">~~无~~</option>';
        if(count($chTree) > 0) {
            $select .= $this->_treeSelect($chTree, $fid, $prefix);
        }
        $select .= '</select>';
        return $select;
    }

}