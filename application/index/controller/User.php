<?php
/**
 * @author xialeistudio
 * @date 2019-06-16
 */

namespace app\index\controller;


use app\index\service\UserService;
use think\Exception;
use think\Request;
use think\response\Json;

/**
 * Class UserController
 * @package app\index\controller
 */
class User extends BaseController
{
    /**
     * 授权
     * @param Request $request
     * @return Json
     */
    public function oauth(Request $request)
    {
        $data = $request->post();
        $errmsg = $this->validate($data, [
            'code|授权码' => 'require',
            'nickname|昵称' => 'require',
            'avatar|头像' => 'require'
        ]);
        if ($errmsg !== true) {
            return json_msg($errmsg, 400);
        }
        try {
            $user = UserService::Factory()->oauth($data);
            return json($user);
        } catch (Exception $e) {
            return json_msg($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * 用户信息
     * @return Json
     */
    public function info()
    {
        try {
            $userId = $this->loginRequired();
            $user = \app\common\model\User::get($userId);
            return json($user->toArray());
        } catch (Exception $e) {
            return json_msg($e->getMessage(), $e->getCode() ?: 500);
        }
    }
}