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
 * Class XmlParser
 * @package BaAGee\Config\Parser
 */
class XmlParser extends ParseConfigAbstract
{
    protected static $configSuffix = 'xml';

    /**
     * @param string $configFile
     * @return array
     */
    public static function parse(string $configFile): array
    {
        if (is_file($configFile)) {
            $xml = simplexml_load_file($configFile);
            $res = json_decode(json_encode($xml, JSON_UNESCAPED_UNICODE), true);
            return $res == null ? [] : $res;
        } else {
            return [];
        }
    }
}
