<?php
/**
 * @author xialeistudio
 * @date 2019-06-16
 */

namespace app\index\controller;

use app\index\service\AddressService;
use think\Exception;
use think\Request;
use think\response\Json;

/**
 * 地址
 * Class Address
 * @package app\index\controller
 */
class Address extends BaseController
{
    /**
     * 添加地址
     * @param Request $request
     * @return Json
     */
    public function create(Request $request)
    {
        try {
            $userId = $this->loginRequired();
            $data = $request->post();
            $errmsg = $this->validate($data, [
                'realname|姓名' => 'require',
                'phone|手机号码' => 'require',
                'address|地址' => 'require'
            ]);
            if ($errmsg !== true) {
                return json_msg($errmsg, 400);
            }
            AddressService::Factory()->create($data, $userId);
            return json_msg('ok');
        } catch (Exception $e) {
            return json_msg($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * 所有地址
     * @return Json
     */
    public function all()
    {
        try {
            $userId = $this->loginRequired();
            $list = AddressService::Factory()->all($userId);
            return json($list);
        } catch (Exception $e) {
            return json_msg($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * @param Request $request
     * @return Json
     */
    public function show(Request $request)
    {
        try {
            $userId = $this->loginRequired();
            $data = AddressService::Factory()->show($request->param('id'), $userId);
            return json($data);
        } catch (Exception $e) {
            return json_msg($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * @param Request $request
     * @return Json
     */
    public function update(Request $request)
    {
        try {
            $userId = $this->loginRequired();
            $data = $request->post();
            $errmsg = $this->validate($data, [
                'id' => 'require',
                'realname|姓名' => 'require',
                'phone|手机号码' => 'require',
                'address|地址' => 'require'
            ]);
            if ($errmsg !== true) {
                return json_msg($errmsg, 400);
            }
            AddressService::Factory()->update($data['id'], $data, $userId);
            return json_msg('ok');
        } catch (Exception $e) {
            return json_msg($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * @param Request $request
     * @return Json
     */
    public function delete(Request $request)
    {
        try {
            $userId = $this->loginRequired();
            AddressService::Factory()->delete($request->param('id'), $userId);
            return json_msg('ok');
        } catch (Exception $e) {
            return json_msg($e->getMessage(), $e->getCode() ?: 500);
        }
    }
}