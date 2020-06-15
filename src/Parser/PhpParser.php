<?php
/**
 * Desc: 解析php配置文件
 * User: baagee
 * Date: 2019/3/14
 * Time: 下午8:06
 */

namespace BaAGee\Config\Parser;

use BaAGee\Config\Base\ParseConfigAbstract;

/**
 * Class PhpParser
 * @package BaAGee\Config\Parser
 */
class PhpParser extends ParseConfigAbstract
{
    protected static $configSuffix = 'php';

    /**
     * @param string $configFile
     * @return array
     */
    public static function parse(string $configFile): array
    {
        if (is_file($configFile)) {
            $res = include $configFile;
            return empty($res) ? [] : $res;
        } else {
            return [];
        }
    }
}
