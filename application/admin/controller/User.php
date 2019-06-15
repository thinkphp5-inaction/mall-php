<?php
/**
 * @author xialeistudio
 * @date 2019-06-13
 */

namespace app\admin\controller;


use app\admin\service\AdminService;
use think\Exception;
use think\Request;
use think\Session;

/**
 * Class UserController
 * @package app\admin\controller
 */
class User extends BaseController
{
    protected function _initialize()
    {
    }

    /**
     * 登录界面
     * @return mixed
     */
    public function login()
    {
        return $this->fetch();
    }

    /**
     * 登录
     * @param Request $request
     */
    public function do_login(Request $request)
    {
        $errmsg = $this->validate($request->post(), [
            'username|账号' => 'require',
            'password|密码' => 'require'
        ]);
        if ($errmsg !== true) {
            $this->error($errmsg);
            return;
        }
        try {
            AdminService::Factory()->login($request->post('username'), $request->post('password'));
            $this->redirect('/admin/index/index');
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        Session::clear();
        $this->redirect('/admin/user/login');
    }
}