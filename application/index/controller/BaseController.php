<?php
/**
 * @author xialeistudio
 * @date 2019-06-16
 */

namespace app\index\controller;


use think\Controller;
use think\Exception;

/**
 * Class BaseController
 * @package app\index\controller
 */
class BaseController extends Controller
{
    /**
     * @return mixed
     * @throws Exception
     */
    protected function loginRequired()
    {
        $userId = session('userId');
        if (empty($userId)) {
            throw new Exception('请登录', 401);
        }
        return $userId;
    }
}