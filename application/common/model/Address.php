<?php
/**
 * @author xialeistudio
 * @date 2019-06-13
 */

namespace app\common\model;

use think\Model;

/**
 * 收货地址
 * Class Address
 * @package app\common\model
 * @property int    $id
 * @property string $realname
 * @property string $phone
 * @property string $address
 * @property bool   $default
 * @property int    $user_id
 */
class Address extends Model
{
    protected $type = [
        'default' => 'boolean'
    ];
}