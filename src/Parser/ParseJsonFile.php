<?php
/**
 * Desc: 解析json配置
 * User: baagee
 * Date: 2019/3/14
 * Time: 下午10:03
 */

namespace BaAGee\Config\Parser;

use BaAGee\Config\Base\ParseConfigAbstract;

/**
 * Class ParsePHPFile
 * @package BaAGee\Config\Parser
 */
class ParseJsonFile extends ParseConfigAbstract
{
    protected static $configSuffix = 'json';

    /**
     * @param string $configFile
     * @return array
     */
    public static function parse(string $configFile): array
    {
        if (is_file($configFile)) {
            $res = json_decode(file_get_contents($configFile), true);
            return $res == null ? [] : $res;
        } else {
            return [];
        }
    }
}
