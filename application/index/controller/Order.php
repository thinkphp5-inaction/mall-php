<?php
/**
 * @author xialeistudio
 * @date 2019-06-16
 */

namespace app\index\controller;

use app\index\service\OrderService;
use think\Exception;
use think\Request;
use think\response\Json;

/**
 * Class Order
 * @package app\index\controller
 */
class Order extends BaseController
{
    /**
     * 支付
     * @param Request $request
     * @return Json
     */
    public function pay(Request $request)
    {
        try {
            $userId = $this->loginRequired();
            OrderService::Factory()->pay($request->param('order_id'), $userId);
            return json_msg('ok');
        } catch (Exception $e) {
            return json_msg($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * 订单列表
     * @param Request $request
     * @return Json
     */
    public function list(Request $request)
    {
        try {
            $userId = $this->loginRequired();
            $list = OrderService::Factory()->list($userId, $request->param('page', 1), $request->param('size', 10));
            return json($list);
        } catch (Exception $e) {
            return json_msg($e->getMessage(), $e->getCode() ?: 500);
        }
    }
}