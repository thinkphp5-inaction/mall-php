<?php
/**
 * @author xialeistudio
 * @date 2019-06-16
 */

namespace app\index\controller;


use app\index\service\UserService;
use think\Controller;
use think\Exception;
use think\Request;
use think\response\Json;

/**
 * Class UserController
 * @package app\index\controller
 */
class User extends Controller
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
            session('userId', $user['id']);
            return json_msg('ok');
        } catch (Exception $e) {
            return json_msg($e->getMessage(), $e->getCode() ?: 500);
        }
    }
}