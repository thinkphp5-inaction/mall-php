<?php
/**
 * @author xialeistudio
 * @date 2019-06-16
 */

namespace app\index\service;


use app\common\model\Goods;
use app\common\model\Order;
use app\common\service\Service;
use PDOStatement;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;

/**
 * Class GoodsService
 * @package app\index\service
 */
class GoodsService extends Service
{
    /**
     * 数据列表
     * @param int $page
     * @param int $size
     * @return false|PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function list($page = 1, $size = 10)
    {
        $model = new Goods();
        $model->order(['id' => 'desc']);
        $model->page($page, $size);
        return $model->select();
    }

    /**
     * 商品详情
     * @param int $id
     * @return Goods|null
     * @throws DbException
     * @throws Exception
     */
    public function show($id)
    {
        $goods = Goods::get($id);
        if (empty($goods)) {
            throw new Exception('商品不存在', 404);
        }
        return $goods;
    }

    /**
     * 购买
     * @param int   $goodsId
     * @param int   $userId
     * @param array $data
     * @return Order
     * @throws Exception
     */
    public function buy($goodsId, $userId, array $data)
    {
        $goods = GoodsService::Factory()->show($goodsId);
        $data = [
            'title' => $goods->title,
            'price' => $goods->price,
            'status' => Order::STATUS_CREATED,
            'realname' => $data['realname'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'remark' => $data['remark'] ?? '',
            'snapshot' => $goods->toArray(),
            'goods_id' => $goodsId,
            'user_id' => $userId
        ];
        $order = new Order();
        $order->data($data);
        if (!$order->save()) {
            throw new Exception('购买失败');
        }
        return $order;
    }
}