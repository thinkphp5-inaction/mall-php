<?php
/**
 * @author xialeistudio
 * @date 2019-06-16
 */

namespace app\index\service;


use app\common\model\User;
use app\common\service\Service;
use Firebase\JWT\JWT;
use think\Config;
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
     * @return User|array|null
     * @throws Exception
     * @throws DbException
     */
    public function oauth(array $info)
    {
        $session = WechatService::Factory()->getSession($info['code']);
        $openid = $session['openid'];
        unset($info['code']);

        $user = User::get(['openid' => $openid]);
        if (empty($user)) {
            $user = new User();
            $user->openid = $openid;
        }

        $user->nickname = $info['nickname'];
        $user->avatar = $info['avatar'];

        if (false === $user->save()) {
            throw new Exception('授权失败');
        }
        $user = $user->toArray();
        $user['token'] = JWT::encode([
            'user_id' => $user['id'],
            'expired_at' => time() + 7 * 24 * 3600
        ], Config::get('jwt.key'));
        return $user;
    }
}