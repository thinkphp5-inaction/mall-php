<?php
/**
 * @author xialeistudio
 * @date 2019-06-16
 */

namespace app\index\service;


use app\common\model\Order;
use app\common\service\Service;
use PDOStatement;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;

/**
 * Class OrderService
 * @package app\index\service
 */
class OrderService extends Service
{
    /**
     * 支付
     * @param int $orderId
     * @param int $userId
     * @return Order
     */
    public function pay($orderId, $userId)
    {
        $model = new Order();
        return $model->transaction(function () use ($model, $userId, $orderId) {
            /** @var Order $order */
            $order = $model->where('order_id', $orderId)->lock(true)->find();

            if (empty($order) || $order->user_id != $userId) {
                throw new Exception('订单不存在', 404);
            }
            if ($order->status != Order::STATUS_CREATED) {
                throw new Exception('订单状态错误', 400);
            }
            $order->status = Order::STATUS_PAYED;
            $order->pay_at = time();
            if (!$order->save()) {
                throw new Exception('支付失败');
            }
            return $order;
        });
    }

    /**
     * 订单列表
     * @param int $userId
     * @param int $page
     * @param int $size
     * @return false|PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function list($userId, $page = 1, $size = 10)
    {
        $model = new Order();
        $model->where('user_id', $userId)->order(['order_id' => 'desc']);
        $model->page($page, $size);
        return $model->select();
    }

    /**
     * @param int $orderId
     * @param int $userId
     * @return Order|null
     * @throws DbException
     * @throws Exception
     */
    public function show($orderId, $userId)
    {
        $order = Order::get(['order_id' => $orderId, 'user_id' => $userId]);
        if (empty($order)) {
            throw new Exception('订单不存在');
        }
        return $order;
    }
}