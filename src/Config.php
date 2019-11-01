<?php
/**
 * Desc: 配置获取类
 * User: baagee
 * Date: 2019/3/14
 * Time: 下午7:32
 */

namespace BaAGee\Config;

use BaAGee\Config\Base\ConfigAbstract;
use BaAGee\Config\Base\ConfigInterface;

/**
 * Class Config
 * @package BaAGee\Config
 */
class Config extends ConfigAbstract implements ConfigInterface
{
    /**
     * 获取配置文件
     * @param string $name 配置名 类似 Config::get('mysql/host')获取的就是mysql.php配置的host值
     * @param null   $default 默认值
     * @return mixed|null
     */
    public static function get(string $name, $default = null)
    {
        $value = $default;
        $name  = trim($name, '/');
        if (array_key_exists($name, self::$valueCache)) {
            //缓存值存在直接返回
            $value = self::$valueCache[$name];
        } else {
            // 将key转成数组
            $nameArr = explode('/', $name);
            // 前面的Key
            $topKey = '';
            foreach ($nameArr as $item) {
                // 拼接子路径
                $topKey .= DIRECTORY_SEPARATOR . $item;
                $topKey = trim($topKey, '/');
                if (isset(self::$configArray[$topKey])) {
                    // 如果有缓存子路径的值
                    $value = self::getConfValue($name, $topKey);
                } else {
                    // 完整的路径
                    $path = self::$configPath . DIRECTORY_SEPARATOR . $topKey;
                    if (!is_dir($path)) {
                        // 不是文件夹
                        $suffix            = trim(call_user_func(self::$configParser . '::getConfigSuffix'));
                        $currentConfigFile = $path;//文件路径
                        if ($suffix) {
                            $currentConfigFile .= '.' . $suffix;
                        }
                        if (is_file($currentConfigFile)) {
                            // 解析配置文件
                            $res = call_user_func(self::$configParser . '::parse', $currentConfigFile);
                            if (!empty($res)) {
                                // 将配置文件缓存
                                self::$configArray[$topKey] = $res;
                                $value                      = self::getConfValue($name, $topKey);
                            }
                        }
                    }
                }
            }
        }
        return $value;
    }

    /**
     * 已知缓存配置，查找精确的配置项
     * @param $name
     * @param $topKey
     * @return mixed|null
     */
    private static function getConfValue($name, $topKey)
    {
        $pos = strpos($name, $topKey);
        if ($pos === false) {
            return null;
        }
        $lastKey = substr_replace($name, '', $pos, strlen($topKey));
        if (empty($lastKey)) {
            $value = self::$configArray[$topKey];
        } else {
            $value = self::findConfVal(self::$configArray[$topKey], $lastKey);
        }
        self::$valueCache[$name] = $value;
        return $value;
    }

    /**
     * 递归查找值
     * @param $conf_arr
     * @param $keys_str
     * @return null
     */
    private static function findConfVal($conf_arr, $keys_str)
    {
        $keys = array_filter(explode('/', $keys_str));
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
