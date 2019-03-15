<?php
/**
 * Desc: 解析ini配置
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
class ParseIniFile extends ParseConfigAbstract
{
    protected static $configSuffix = 'ini';

    /**
     * @param string $configFile
     * @return array
     */
    public static function parse(string $configFile): array
    {
        if (is_file($configFile)) {
            $res = parse_ini_file($configFile, true);
            return $res == null ? [] : $res;
        } else {
            return [];
        }
    }
}
