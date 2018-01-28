<?php
/**
 *------------------------------------------------------
 * 全局数据字典的调用，提供配置缓存的类型
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @date      2016/5/26 11:17
 * @version   V1.0
 *
 */

namespace App\Services\Base;

use App\Models\BaseDictDataModel;
use Illuminate\Support\Facades\Cache;

class DictData
{
    private $_dict;
    private $_model;
    private $_mmCache = 'table_dict_data_all';

    public function __construct() {
        if( !$this->_model ) $this->_model = new BaseDictDataModel();
    }

    /**
     * 取得数据字典对应数据
     *
     * @param string $table_code 数据字典的类型
     * @param string $code 数据字典代码
     * @param string $val 数据字典数据对应下标
     * @return array  返回数据字典数组
     * @throws CException  $table_code, $code 不能为空
     *
     */
    public function get($table_code, $code, $val = null)
    {
        $mKey = Cache::get($this->_mmCache);
        if(isset($mKey[$table_code][$code])) {
            $arr = $mKey[$table_code][$code];
        }else{
            $this->updateCache();
            if(isset($this->_dict[$table_code][$code])) {
                $arr = $this->_dict[$table_code][$code];
            }else{
                $arr = [];
            }
        }
        if(!$arr) {
            return null;
        }
        if(isset($val)) {
            if(array_key_exists($val, $arr)) {
                return $arr[$val];
            }else{
                return '';
            }
        }else{
            return $arr;
        }
    }

    /**
     * 创建Select代码
     *
     * @param string $table_code 数据字典的类型
     * @param string $code 数据字典代码
     * @param string $selection 被选中的值。
     * @param array $htmlOptions
     * 额外的HTML属性：如 [name=>'cate', id=>'cate'] 这些属性作用在select上。
     * 若使用特定关键字empty时，自动创建一个option，
     *     empty: 字符串，指定空选项的文本，它的值为空。
     *     empty: 数组，option的value值对应key，文本对应value。
     */
    public function select($table_code, $code, $selection = null, $htmlOptions = [])
    {
        $selectOption = $htmlOptions;
        unset($selectOption['empty']);
        $html = "<select";
        foreach($selectOption as $key => $val) {
            $html .= " {$key}=\"{$val}\"";
        }
        $html .= ">\n";
        if (isset ( $htmlOptions ['empty'] )) {
            $value = "";
            $label = $htmlOptions ['empty'];
            if (is_array ( $label )) {
                $value = array_keys ( $label );
                $value = $value [0];
                $label = array_values ( $label );
                $label = $label [0];
            }
            $html .= "<option value=\"{$value}\">{$label}</option>\n";
        }
        $optionHtml = $this->option($table_code, $code, $selection);
        $html .= $optionHtml;
        $html .= "</select>";
        return $html;
    }

    /**
     * 创建select的option选项
     *
     * @param $table_code
     * @param $code
     * @param null $selection
     * @return string
     */
    public function option($table_code, $code, $selection = null)
    {
        $data = $this->get($table_code, $code);
        $html = "";
        foreach ($data as $k => $v) {
            $html .= "<option value=\"{$k}\"";
            if($k == $selection) {
                $html .= " selected ";
            }
            $html .= ">{$v}</option>\n";
        }
        return $html;
    }

    /**
     * 更新对应数据字典，如参数都为空全部更新
     *
     * @param string $table_code 需要更新的类型
     * @param string $code 需要更新的代码
     * @return bool  返回成功失败
     * @throws CException
     */
    public function updateCache()
    {
        $obData = $this->_model->all();
        $dict = array();
        foreach($obData as $key => $value) {
            $dict[$value->dict_table_code][$value->dict_code][$value->value] = $value->name;
        }
        $this->_dict = $dict;
        Cache::forever($this->_mmCache, $this->_dict);
        return true;
    }

}
