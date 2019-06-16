<?php
/**
 * @author xialeistudio
 * @date 2019-06-13
 */

namespace app\admin\service;


use app\common\service\Service;
use think\Config;
use think\Exception;
use think\File;
use think\Session;

/**
 * 管理员
 * Class AdminService
 * @package app\admin\service
 */
class AdminService extends Service
{
    /**
     * 登录
     * @param string $username
     * @param string $password
     * @throws Exception
     */
    public function login($username, $password)
    {
        $admins = Config::get('admin');
        if (!isset($admins[$username]) || $admins[$username] != $password) {
            throw new Exception('账号或密码错误', 400);
        }
        Session::set('admin', $username);
    }

    /**
     * @param File $file
     * @return string
     * @throws Exception
     */
    public function upload(File $file)
    {
        if (!$file) {
            throw new Exception('您的请求有误');
        }
        $info = $file->move(__DIR__ . '/../../../public/uploads');
        if (!$info) {
            throw new Exception('上传失败');
        }
        return '/uploads/' . $info->getSaveName();
    }

    /**
     * @param File[] $files
     * @return array
     * @throws Exception
     */
    public function uploadMulti(array $files)
    {
        $result = [];
        foreach ($files as $file) {
            $info = $file->move(__DIR__ . '/../../../public/uploads');
            if (!$info) {
                throw new Exception('上传失败');
            }
            $result[] = '/public/uploads/'.$info->getSaveName();
        }
        return $result;
    }
}