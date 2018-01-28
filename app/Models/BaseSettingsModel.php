<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 配置列表
 *  @author  system;
 *  @version    1.0
 *  @date 2017-05-31 04:56:09
 *
 */
class BaseSettingsModel extends BaseModel
{
    /**
     * 数据表名
     *
     * @var string
     *
     */
    protected $table = 'base_settings';
    /**
    主键
     */
    protected $primaryKey = 'id';

    //分页
    protected $perPage = PAGE_NUMS;

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = [
                           'key',
                           'value',
                           'sort',
                           'category',
                           'pid',
                           'status'
                          ];

    public static function _tree($data, $pid = 0, $level = 0) {
        $result = [];
        foreach ($data as $k => $v) {
            if ($v->pid == $pid) {
                $node = [
                    'level'     => $level,
                    'data'      => $v,
                    'children'  => self::_tree($data, $v->id, $level + 1),
                ];
                $result[] = $node;
            }
        }
        return $result;
    }

    public static function tree() {
        return self::_tree(self::all(), 0, 0);
    }
}