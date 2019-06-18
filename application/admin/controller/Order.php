<?php
/**
 * @author xialeistudio
 * @date 2019-06-18
 */

namespace app\admin\controller;

use app\admin\service\OrderService;
use think\Exception;
use think\exception\DbException;
use think\Request;

/**
 * Class Order
 * @package app\admin\controller
 */
class Order extends BaseController
{
    /**
     * @param Request $request
     * @return mixed|void
     */
    public function index(Request $request)
    {
        $status = $request->param('status');
        $status = $status === '' ? null : $status;
        $size = $request->param('size', 10);
        try {
            $list = OrderService::Factory()->list($status, $size);
            $this->assign('page', $list->render());
            $this->assign('list', $list);
            return $this->fetch();
        } catch (DbException $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return mixed|void
     */
    public function show(Request $request)
    {
        try {
            $order = OrderService::Factory()->show($request->param('id'));
            $this->assign('order', $order);
            return $this->fetch();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}