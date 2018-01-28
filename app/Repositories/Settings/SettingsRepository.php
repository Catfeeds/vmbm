<?php
/**
 *   配置列表
 *  @author  system
 *  @version    1.0
 *  @date 2017-05-31 04:56:09
 *
 */
namespace App\Repositories\Settings;

use App\Repositories\Base\Repository;


class SettingsRepository extends Repository {

    public function model() {
        return \App\Models\BaseSettingsModel::class;
    }

    
}
