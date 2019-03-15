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

    protected static $configSuffix = '';

    /**
     * 获取配置文件后缀
     * @return string
     */
    public static function getConfigSuffix(): string
    {
        return static::$configSuffix;
    }

    /**
     * @param string $configFile
     * @return array
     */
    abstract public static function parse(string $configFile): array;
}
