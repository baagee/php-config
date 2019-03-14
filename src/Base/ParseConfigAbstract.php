<?php
/**
 * Desc: 配置文件解析
 * User: baagee
 * Date: 2019/3/14
 * Time: 下午8:02
 */

namespace BaAGee\Config\Base;

/**
 * Class ParseConfigAbstract
 * @package BaAGee\Config\Base
 */
abstract class ParseConfigAbstract
{
    use ProhibitNewClone;

    /**
     * @param string $configFile
     * @return array
     */
    abstract public static function parse(string $configFile): array;
}
