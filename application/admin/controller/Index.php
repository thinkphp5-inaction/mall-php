<?php
/**
 * @author xialeistudio
 * @date 2019-06-13
 */

namespace app\admin\controller;

/**
 * Class Index
 * @package app\admin\controller
 */
class Index extends BaseController
{
    public function index()
    {
        $this->redirect('/admin/goods');
    }
}