<?php
/**
 * @author xialeistudio
 * @date 2019-06-13
 */

namespace app\common\model;


use think\Model;
use traits\model\SoftDelete;

/**
 * 商品
 * Class Goods
 * @package app\common\model
 * @property int    $id
 * @property string $title
 * @property string $thumb
 * @property string $description
 * @property double $price
 * @property int    $stock
 * @property int    $status
 * @property string $content
 * @property int    $created_at
 * @property int    $updated_at
 */
class Goods extends Model
{
    use SoftDelete;
    const STATUS_ONLINE = 1; // 上架
    const STATUS_OFFLINE = 0; // 下架

    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    protected $deleteTime = 'deleted_at';
}