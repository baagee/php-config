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

    // 重置config
    public static function reset()
    {
        static::$configPath   = '';
        static::$configParser = ParsePHPFile::class;
        static::$isInit       = false;
    }

    // /**
    //  * @return array
    //  */
    // public static function getCache(): array
    // {
    //     return self::$cache;
    // }
    //
    //
    // protected static $cache = [];
    //
    // public static function dump($topKey = '')
    // {
    //     $topKey = trim($topKey, '/');
    //     $dirs   = scandir(self::$configPath . '/' . $topKey);
    //     foreach ($dirs as $fd) {
    //         if (!in_array($fd, ['.', '..'])) {
    //             $tt = trim($topKey . '/' . str_replace('.php', '', $fd), '/');
    //             if (is_dir(self::$configPath . '/' . $topKey . '/' . $fd)) {
    //                 self::dump($tt);
    //             } else {
    //                 if (strpos($fd, '.php') !== false) {
    //                     $temp             = include self::$configPath . '/' . $topKey . '/' . $fd;
    //                     self::$cache[$tt] = $temp;
    //                     self::eee($tt, $temp);
    //                 }
    //             }
    //         }
    //     }
    // }
    //
    // protected static function eee($top, array $c)
    // {
    //     foreach ($c as $k => $v) {
    //         self::$cache[$top . '/' . $k] = $v;
    //         if (is_array($v)) {
    //             self::eee($top . '/' . $k, $v);
    //         }
    //     }
    // }
}
