<?php
/**
 * @author xialeistudio
 * @date 2019-06-13
 */

namespace app\common\service;

/**
 * 业务基类
 * Class Service
 * @package app\common\service
 */
class Service
{
    private static $_instances = [];

    /**
     * @return static|mixed
     */
    public static function Factory()
    {
        $className = get_called_class();
        if (isset(self::$_instances[$className])) {
            return self::$_instances[$className];
        }
        self::$_instances[$className] = new static();
        return self::$_instances[$className];
    }
}