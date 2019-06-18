<?php
/**
 * @author xialeistudio
 * @date 2019-06-18
 */

namespace app\admin\service;


use app\common\model\Order;
use app\common\service\Service;
use think\Exception;
use think\exception\DbException;
use think\Paginator;

/**
 * Class OrderService
 * @package app\admin\service
 */
class OrderService extends Service
{
    /**
     * 订单列表
     * @param int $status
     * @param int $size
     * @return Paginator
     * @throws DbException
     */
    public function list($status = null, $size = 10)
    {
        $model = new Order();
        if (isset($status)) {
            $model->where('status', $status);
        }
        $model->order(['order_id' => 'desc']);
        return $model->paginate($size);
    }

    /**
     * @param int $id
     * @return Order|null
     * @throws DbException
     * @throws Exception
     */
    public function show($id)
    {
        $order = Order::get(['order_id' => $id]);
        if (empty($order)) {
            throw new Exception('订单不存在');
        }
        return $order;
    }
}