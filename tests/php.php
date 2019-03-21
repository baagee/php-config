<?php
/**
 * Desc:
 * User: baagee
 * Date: 2019/3/14
 * Time: 下午7:49
 */
include_once __DIR__ . '/../vendor/autoload.php';

\BaAGee\Config\Config::init(__DIR__ . '/config', \BaAGee\Config\Parser\ParsePHPFile::class);

$user = \BaAGee\Config\Config::get('/service/mysql/user');
$mysql = \BaAGee\Config\Config::get('/service/mysqls');
$mysql = \BaAGee\Config\Config::get('/service/mysql');
$mysql = \BaAGee\Config\Config::get('/mysql/host');
// $mysql = \BaAGee\Config\Config::get('/mysql/user');
var_dump($user,$mysql);
echo 'OVER' . PHP_EOL;