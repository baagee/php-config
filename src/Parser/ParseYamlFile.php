<?php
/**
 * Desc: 解析yaml配置
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
class ParseYamlFile extends ParseConfigAbstract
{
    /**
     * @param string $configFile
     * @return array
     */
    public static function parse(string $configFile): array
    {
        if (is_file($configFile)) {
            return yaml_parse_file($configFile);;
        } else {
            return [];
        }
    }
}
