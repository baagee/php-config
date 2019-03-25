<?php
/**
 * Desc:
 * User: baagee
 * Date: 2019/3/25
 * Time: 下午2:32
 */

class ParseKVFile extends \BaAGee\Config\Base\ParseConfigAbstract
{
    protected static $configSuffix = 'kv';

    public static function parse(string $configFile): array
    {
        if (is_file($configFile)) {
            $content       = file_get_contents($configFile);
            $content_array = explode(PHP_EOL, $content);
            $config        = [];
            foreach ($content_array as $item) {
                list($key, $val) = explode('=>', $item);
                $config[$key] = $val;
            }
            return $config;
        }
    }
}