<?php
/**
 * @author xialeistudio
 * @date 2019-06-16
 */

namespace app\index\controller;

use app\index\service\GoodsService;
use think\Exception;
use think\Request;
use think\response\Json;

/**
 * 商品
 * Class Goods
 * @package app\index\controller
 */
class Goods extends BaseController
{
    /**
     * @param Request $request
     * @return Json
     */
    public function list(Request $request)
    {
        try {
            $this->loginRequired();
            $list = GoodsService::Factory()->list($request->param('page', 1), $request->param('size', 10));
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
            $this->loginRequired();
            $goods = GoodsService::Factory()->show($request->param('id'));
            return json($goods);
        } catch (Exception $e) {
            return json_msg($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * 购买
     * @param Request $request
     * @return Json
     */
    public function buy(Request $request)
    {
        try {
            $userId = $this->loginRequired();
            $data = $request->post();
            $errmsg = $this->validate($data, [
                'goods_id' => 'require',
                'realname|姓名' => 'require',
                'phone|手机' => 'require',
                'address|地址' => 'require',
            ]);
            if ($errmsg !== true) {
                return json_msg($errmsg, 400);
            }

            $order = GoodsService::Factory()->buy($data['goods_id'], $userId, $data);
            return json($order->toArray());
        } catch (Exception $e) {
            return json_msg($e->getMessage(), $e->getCode() ?: 500, explode(PHP_EOL, $e->getTraceAsString()));
        }
    }
}