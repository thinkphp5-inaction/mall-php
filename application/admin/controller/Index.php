<?php
/**
 * @author xialeistudio
 * @date 2019-06-13
 */

namespace app\admin\controller;

use think\Request;

/**
 * Class Index
 * @package app\admin\controller
 */
class Index extends BaseController
{
    public function index()
    {
        return $this->fetch();
    }

    public function upload(Request $request)
    {

    }
}