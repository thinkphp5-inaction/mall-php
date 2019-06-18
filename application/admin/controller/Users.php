<?php
/**
 * @author xialeistudio
 * @date 2019-06-18
 */

namespace app\admin\controller;

use app\admin\service\UserService;
use think\exception\DbException;
use think\Request;

/**
 * Class Users
 * @package app\admin\controller
 */
class Users extends BaseController
{
    public function index(Request $request)
    {
        $size = $request->param('size', 10);
        try {
            $list = UserService::Factory()->list($size);
            $this->assign('list', $list);
            $this->assign('page', $list->render());
            return $this->fetch();
        } catch (DbException $e) {
            return $this->error($e->getMessage());
        }
    }
}