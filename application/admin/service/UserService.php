<?php
/**
 * @author xialeistudio
 * @date 2019-06-18
 */

namespace app\admin\service;


use app\common\model\User;
use app\common\service\Service;
use think\exception\DbException;
use think\Paginator;

/**
 * Class UserService
 * @package app\admin\service
 */
class UserService extends Service
{
    /**
     * 用户列表
     * @param int $size
     * @return Paginator
     * @throws DbException
     */
    public function list( $size = 10)
    {
        $model = new User();
        $model->order(['id' => 'desc']);
        return $model->paginate($size);
    }
}