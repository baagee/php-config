<?php
/**
 * Desc:
 * User: baagee
 * Date: 2019/3/14
 * Time: 下午10:05
 */
include_once __DIR__ . '/../vendor/autoload.php';

\BaAGee\Config\Config::init(__DIR__ . '/config', \BaAGee\Config\Parser\IniParser::class);

$password = \BaAGee\Config\Config::get('memcache/password');
$host     = \BaAGee\Config\Config::get('memcache/host');

var_dump($host, $password);