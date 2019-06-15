<?php
/**
 * @author xialeistudio
 * @date 2019-06-13
 */

namespace app\common\model;


use think\Model;

/**
 * 用户
 * Class User
 * @package app\common\model
 * @property int    $id
 * @property string $nickname
 * @property string $avatar
 * @property string $openid
 * @property int    $created_at
 * @property string $created_ip
 */
class User extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = false;

    protected $insert = ['created_ip'];

    protected function setCreatedIpAttr()
    {
        return request()->ip();
    }
}