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
            $list = GoodsService::Factory()->list($request->get('size', 10), $request->get('keyword'));
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
        try {
            $data = $request->post();
            $thumb = $request->file('thumb');
            if (!empty($thumb)) {
                $data['thumb'] = AdminService::Factory()->upload($thumb);
            }
            $errmsg = $this->validate($request->post(), [
                'title|名称' => 'require|max:40',
                'thumb|缩略图' => 'require',
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

            GoodsService::Factory()->publish($data);
            $this->success('发布成功', '/admin/goods/index');
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $goods = GoodsService::Factory()->show($request->param('id'));
            $this->assign('goods', $goods);
            return $this->fetch();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 编辑商品
     * @param Request $request
     */
    public function do_update(Request $request)
    {
        try {
            $data = $request->post();
            $thumb = $request->file('thumb_file');
            if (!empty($thumb)) {
                $data['thumb'] = AdminService::Factory()->upload($thumb);
            }
            $errmsg = $this->validate($data, [
                'id|商品ID' => 'require',
                'thumb|缩略图' => 'require',
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
            GoodsService::Factory()->update($data);
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