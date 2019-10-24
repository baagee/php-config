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
     * @var array 缓存key=>value
     */
    protected static $valueCache = [];

    /**
     * @var array 缓存配置文件的值
     */
    protected static $configArray = [];

    protected const FAST_KEY = 'config_fast_cache';

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

    /**
     * 快速缓存
     * @param string $cachePath
     */
    public static function fast($cachePath = '')
    {
        if (empty($cachePath)) {
            $cachePath = self::$configPath;
        }
        $fastFile = $cachePath . DIRECTORY_SEPARATOR . static::FAST_KEY . '.php';
        if (is_file($fastFile)) {
            self::$valueCache = include $fastFile;
        } else {
            static::dump('');
            register_shutdown_function(function () use ($fastFile) {
                try {
                    file_put_contents($fastFile, '<?php' . PHP_EOL . 'return ' . var_export(static::$valueCache, true) . ';');
                } catch (\Throwable $e) {

                }
            });
        }
    }

    protected static function dump($topKey = '')
    {
        $topKey = trim($topKey, '/');
        $dirs   = scandir(static::$configPath . DIRECTORY_SEPARATOR . $topKey);
        $suffix = trim(call_user_func(static::$configParser . '::getConfigSuffix'));
        foreach ($dirs as $fd) {
            if (!in_array($fd, ['.', '..', static::FAST_KEY])) {
                $tt      = trim($topKey . '/' . str_replace('.' . $suffix, '', $fd), '/');
                $subFile = implode(DIRECTORY_SEPARATOR, [static::$configPath, $topKey, $fd]);
                if (is_dir($subFile)) {
                    static::dump($tt);
                } else {
                    if (strpos($fd, '.' . $suffix) !== false) {
                        $temp                    = call_user_func(static::$configParser . '::parse', $subFile);
                        static::$valueCache[$tt] = $temp;
                        static::subDump($tt, $temp);
                    }
                }
            }
        }
    }

    protected static function subDump($top, array $c)
    {
        foreach ($c as $k => $v) {
            static::$valueCache[$top . '/' . $k] = $v;
            if (is_array($v)) {
                static::subDump($top . '/' . $k, $v);
            }
        }
    }
}
