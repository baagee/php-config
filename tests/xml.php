<?php
/**
 * Desc:
 * User: baagee
 * Date: 2019/3/14
 * Time: 下午10:05
 */
include_once __DIR__ . '/../vendor/autoload.php';

\BaAGee\Config\Config::init(__DIR__ . '/config', \BaAGee\Config\Parser\XmlParser::class);

$app_name = \BaAGee\Config\Config::get('app/main/app_name');
$host     = \BaAGee\Config\Config::get('app/mysql/host');
var_dump($app_name, $host);