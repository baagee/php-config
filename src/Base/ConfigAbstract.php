<?php
/**
 * Desc:
 * User: baagee
 * Date: 2019/3/14
 * Time: 下午7:38
 */

namespace BaAGee\Config\Base;

use BaAGee\Config\Parser\ParsePHPFile;

/**
 * Class ConfigBase
 * @package BaAGee\Config\Base
 */
abstract class ConfigAbstract
{
    use ProhibitNewClone;
    /**
     * @var bool
     */
    protected static $isInit = false;
    /**
     * @var string
     */
    protected static $configPath = '';
    /**
     * @var string
     */
    protected static $configParser = ParsePHPFile::class;

    /**
     * @param string $configPath
     * @param string $configParser
     * @throws \Exception
     */
    public static function init(string $configPath, string $configParser = '')
    {
        if (static::$isInit === false) {
            static::$configPath = rtrim($configPath, DIRECTORY_SEPARATOR);
            if (!empty($configParser)) {
                if (is_subclass_of($configParser, ParseConfigAbstract::class)) {
                    static::$configParser = $configParser;
                } else {
                    throw new \Exception($configParser . '没有继承' . ParseConfigAbstract::class);
                }
            }
            static::$isInit = true;
        }
    }
}
