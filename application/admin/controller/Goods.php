<?php
/**
 * @author xialeistudio
 * @date 2019-06-13
 */

namespace app\admin\controller;

use app\admin\service\AdminService;
use app\admin\service\GoodsService;
use think\Exception;
use think\exception\DbException;
use think\Request;

/**
 * Class Goods
 * @package app\admin\controller
 */
class Goods extends BaseController
{
    /**
     * 商品列表
     * @param Request $request
     * @return mixed|void
     */
    public function index(Request $request)
    {
        try {
            $list = GoodsService::Factory()->list($request->get('size', 1), $request->get('keyword'));
            $this->assign('page', $list->render());
            $this->assign('list', $list);
            return $this->fetch();
        } catch (DbException $e) {
            return $this->error($e->getMessage());
        }
    }

    public function publish()
    {
        return $this->fetch();
    }

    /**
     * 发布商品
     * @param Request $request
     */
    public function do_publish(Request $request)
    {
        $errmsg = $this->validate($request->post(), [
            'title|名称' => 'require|max:40',
            'description|简介' => 'max:100',
            'price|价格' => 'require|>=:0',
            'stock|库存' => 'require|>=:0',
            'status|状态' => 'require|>=:0',
            'content|详情内容' => 'require'
        ]);
        if ($errmsg !== true) {
            $this->error($errmsg);
            return;
        }
        $thumb = $request->file('thumb');
        if (empty($thumb)) {
            $this->error('缩略图不能为空');
            return;
        }
        try {
            $data = $request->post();
            $data['thumb'] = AdminService::Factory()->upload($thumb);
            GoodsService::Factory()->publish($data);
            $this->success('发布成功', '/admin/goods/index');
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 编辑商品
     * @param Request $request
     */
    public function do_update(Request $request)
    {
        $errmsg = $this->validate($request->post(), [
            'id|商品ID' => 'require',
            'title|名称' => 'require|max:40',
            'description|简介' => 'max:100',
            'price|价格' => 'require|>=:0',
            'stock|库存' => 'require|>=:0',
            'status|状态' => 'require|>=:0',
        ]);
        if ($errmsg !== true) {
            $this->error($errmsg);
            return;
        }
        try {
            GoodsService::Factory()->update($request->post());
            $this->success('编辑成功', '/admin/goods/index');
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 删除商品
     * @param Request $request
     */
    public function do_delete(Request $request)
    {
        $errmsg = $this->validate($request->param(), [
            'id|商品ID' => 'require'
        ]);
        if ($errmsg !== true) {
            $this->error($errmsg);
            return;
        }
        try {
            GoodsService::Factory()->delete($request->param('id'));
            $this->success('删除成功');
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}