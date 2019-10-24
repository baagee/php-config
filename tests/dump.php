<?php
/**
 * Desc:
 * User: baagee
 * Date: 2019/10/20
 * Time: 21:14
 */

use BaAGee\Config\Config;
use BaAGee\Config\Parser\ParseJsonFile;
use BaAGee\Config\Parser\ParsePHPFile;
use BaAGee\Config\Parser\ParseYamlFile;

include_once __DIR__ . '/../vendor/autoload.php';

\BaAGee\Config\Config::init(__DIR__ . '/config', ParsePHPFile::class);

Config::fast(__DIR__);

$t1 = microtime(true);
for ($i = 0; $i < 100; $i++) {
    $c = Config::get('service/ddd/asd/cc/ddd/dd');
}
$t2 = microtime(true);
var_dump($t2 - $t1);
