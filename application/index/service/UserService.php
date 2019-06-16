<?php
/**
 * @author xialeistudio
 * @date 2019-06-16
 */

namespace app\index\service;


use app\common\model\User;
use app\common\service\Service;
use think\Exception;
use think\exception\DbException;

/**
 * Class UserService
 * @package app\index\service
 */
class UserService extends Service
{
    /**
     * @param array $info
     * @return User|null
     * @throws Exception
     * @throws DbException
     */
    public function oauth(array $info)
    {
        $session = WechatService::Factory()->getSession($info['code']);
        $openid = $session['openId'];

        $user = User::get(['openid' => $openid]);
        if (!empty($user)) {
            $user->data($info);
        } else {
            $user = new User();
            $user->openid = $openid;
            $user->data($info);
        }

        if (!$user->save()) {
            throw new Exception('授权失败');
        }
        return $user;
    }
}