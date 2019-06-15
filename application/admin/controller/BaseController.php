<?php
/**
 * @author xialeistudio
 * @date 2019-06-13
 */

namespace app\admin\controller;


use think\Controller;
use think\Session;

/**
 * Class BaseController
 * @package app\admin\controller
 */
class BaseController extends Controller
{
    protected function _initialize()
    {
        $this->loginRequired();
    }

    /**
     * 登录验证
     */
    protected function loginRequired()
    {
        $logged = Session::get('admin');
        if (!$logged) {
            $this->redirect('/admin/user/login');
            return;
        }
    }
}