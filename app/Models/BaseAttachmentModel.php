<?php
/**
 *------------------------------------------------------
 * BaseAttachmentModel.php
 *------------------------------------------------------
 *
 * @author    m@9026.com
 * @date      2017/03/20 13:09
 * @version   V1.0
 *
 */

namespace App\Models;

class BaseAttachmentModel extends BaseModel
{
    //
    /**
     * 数据表名
     *
     * @var string
     *
     */
    protected $table = 'base_attachments';
    /**
    主键
     */
    protected $primaryKey = 'id';

    //分页
    protected $perPage = PAGE_NUMS;
}
