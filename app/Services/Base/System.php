<?php
/**
 * User: Mike
 * Email: m@9026.com
 * Date: 2016/7/26
 * Time: 15:24
 */
namespace App\Services\Base;

use App\Models\SysConfigModel;
use Illuminate\Support\Facades\Cache;

/**
 *  全局数据字典的调用
 *
 *  提供配置缓存的类型
 *
 *  @author  wangzhoudong  <admin@zhen.pl>
 *  @version    1.0
 *
 */
class System {

    private $cacheKey = 'sys_config';

    public function __construct() {

    }

    public function getCoufig($key=null) {

        $config = Cache::get($this->cacheKey);
        if($config){
            if($key){
                $data = isset($config[$key]) ? $config[$key] : '';
            }else{
                $data = $config;
            }
        }else {
            $obj = new SysConfigModel();
            if ($key) {
                $data = $obj->select("value")->where("key", $key)->first();
                if ($data) {
                    $data = $data->value;
                }
            } else {
                $data = $obj->pluck('value', 'key');
            }
        }
        return $data;
    }

    public function saveConfig($data) {
        $obj = new SysConfigModel();
        foreach($data as $key=>$val) {
            $objVal = $obj->find($key);
            if ($objVal){
                $objVal->value = $val;
                $objVal->save();
            }else{
                $obj->create(['key' => $key,'value'=>$val]);
            }
        }

        $config = $obj->lists('value', 'key')->toArray();
        Cache::forever($this->cacheKey, $config);

        return true;
    }

}