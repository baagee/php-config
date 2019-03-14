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
abstract class ConfigBase
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
     * @var string
     */
    protected static $configSuffix = 'php';

    /**
     * @param string $configPath
     * @param string $configParser
     * @param string $configSuffix
     */
    public static function init(string $configPath, string $configParser = '', string $configSuffix = '')
    {
        if (static::$isInit === false) {
            static::$configPath = rtrim($configPath, DIRECTORY_SEPARATOR);
            if (!empty($configParser)) {
                static::$configParser = $configParser;
            }
            if (!empty($configSuffix)) {
                self::$configSuffix = $configSuffix;
            }
            static::$isInit = true;
        }
    }
}
