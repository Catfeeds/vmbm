<?php
/**
 *   {{desc}}
 *  @author  system
 *  @version    1.0
 *  @date {{date}}
 *
 */
namespace App\Repositories\{{sortPath}};

use App\Repositories\Base\Repository;


class {{repositoriesName}} extends Repository {

    public function model() {
        return \App\Models\{{modelName}}::class;
    }

    
}
