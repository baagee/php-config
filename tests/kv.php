<?php
/**
 * Desc:
 * User: baagee
 * Date: 2019/3/25
 * Time: 下午2:31
 */

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/ParseKVFile.php';
// 自定义配置文件解析获取
\BaAGee\Config\Config::init(__DIR__ . '/config', ParseKVFile::class);
$name = \BaAGee\Config\Config::get('keyvalue/name');
$age  = \BaAGee\Config\Config::get('keyvalue/age');

echo 'name：' . $name . PHP_EOL;
echo 'age：' . $age . PHP_EOL;