<?php
/**
 * Desc: 配置获取类
 * User: baagee
 * Date: 2019/3/14
 * Time: 下午7:32
 */

namespace BaAGee\Config;

use BaAGee\Config\Base\ConfigBase;
use BaAGee\Config\Base\ConfigInterface;

/**
 * Class Config
 * @package BaAGee\Config
 */
class Config extends ConfigBase implements ConfigInterface
{
    /**
     * @var array 缓存key=>value
     */
    protected static $valueCache = [];

    /**
     * @var array 缓存配置文件的值
     */
    protected static $configArray = [];

    /**
     * 获取配置文件
     * @param string $name 配置名 类似 Config::get('mysql/host')获取的就是mysql.php配置的host值
     * @return mixed|null
     */
    public static function get(string $name)
    {
        $name = trim($name, '/');
        if (array_key_exists($name, self::$valueCache)) {
            //缓存值存在直接返回
            return self::$valueCache[$name];
        } else {
            $nameArr = explode('/', $name);
            $topKey  = array_shift($nameArr);
            if (isset(self::$configArray[$topKey])) {
                goto findConfVal;
            } else {
                $currentConfigFile = self::$configPath . DIRECTORY_SEPARATOR . $topKey . '.' . self::$configSuffix;
                $res               = call_user_func(self::$configParser . '::parse', $currentConfigFile);
                if (!empty($res)) {
                    self::$configArray[$topKey] = $res;
                    goto findConfVal;
                } else {
                    return null;
                }
            }
            findConfVal:
            if (empty($nameArr)) {
                $value = self::$configArray[$topKey];
            } else {
                $value = self::findConfVal(self::$configArray[$topKey], implode('/', $nameArr));
            }
            self::$valueCache[$name] = $value;
            return $value;
        }
    }

    /**
     * 递归查找值
     * @param $conf_arr
     * @param $keys_str
     * @return null
     */
    private static function findConfVal($conf_arr, $keys_str)
    {
        $keys = explode('/', $keys_str);
        $key  = array_shift($keys);
        if (isset($conf_arr[$key])) {
            $val = $conf_arr[$key];
            if (empty($keys)) {
                return $val;
            } else {
                return self::findConfVal($val, implode('/', $keys));
            }
        } else {
            return null;
        }
    }
}
