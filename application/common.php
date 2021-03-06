<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\response\Json;

/**
 * 输出JSON
 * @param string $errmsg
 * @param int    $errcode
 * @param array  $extra
 * @return Json
 */
function json_msg($errmsg, $errcode = 0, $extra = [])
{
    return json(['errmsg' => $errmsg, 'errcode' => $errcode, 'extra' => $extra]);
}