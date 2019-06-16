<?php
/**
 * @author xialeistudio
 * @date 2019-06-16
 */

namespace app\index\controller;


use Firebase\JWT\JWT;
use think\Config;
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
        $authorization = request()->header('Authorization');
        if (empty($authorization)) {
            throw new Exception('请登录', 401);
        }
        $payload = JWT::decode($authorization, Config::get('jwt.key'), ['HS256']);
        if (empty($payload) || $payload->expired_at < time()) {
            throw new Exception('请登录', 401);
        }
        return $payload->user_id;
    }
}