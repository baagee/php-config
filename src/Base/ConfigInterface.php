<?php
/**
 * Desc: Config接口
 * User: baagee
 * Date: 2019/3/14
 * Time: 下午7:33
 */

namespace BaAGee\Config\Base;

interface ConfigInterface
{
    public static function get(string $key);
}
