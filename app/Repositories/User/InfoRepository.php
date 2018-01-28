<?php
/**
 *   用户表
 *  @author  system
 *  @version    1.0
 *  @date 2017-05-30 12:16:56
 *
 */
namespace App\Repositories\User;

use App\Repositories\Base\Repository;


class InfoRepository extends Repository {

    public function model() {
        return \App\Models\UserInfoModel::class;
    }

    
}
