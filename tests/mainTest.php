<?php
/**
 * Desc:
 * User: baagee
 * Date: 2019/7/27
 * Time: 20:39
 */

use BaAGee\Config\Config;
use BaAGee\Config\Parser\PhpParser;

include __DIR__ . '/../vendor/autoload.php';

class mainTest extends \PHPUnit\Framework\TestCase
{

    public function tearDown()
    {
        \BaAGee\Config\Config::reset();
    }

    public function testIni()
    {
        \BaAGee\Config\Config::init(__DIR__ . '/config', \BaAGee\Config\Parser\IniParser::class);
        $password = \BaAGee\Config\Config::get('memcache/password');
        $host     = \BaAGee\Config\Config::get('memcache/host');
        $this->assertEquals($host, "127.0.0.1");
    }

    public function testJson()
    {
        \BaAGee\Config\Config::init(__DIR__ . '/config', \BaAGee\Config\Parser\JsonParser::class);
        $password = \BaAGee\Config\Config::get('redis/password');
        $host     = \BaAGee\Config\Config::get('redis/host');
        $this->assertEquals($password, "234r34t3");
    }

    public function testXml()
    {
        \BaAGee\Config\Config::init(__DIR__ . '/config', \BaAGee\Config\Parser\XmlParser::class);
        $app_name = \BaAGee\Config\Config::get('app/main/app_name');
        $host     = \BaAGee\Config\Config::get('app/mysql/host');
        $this->assertEquals(trim($host), 'localhost');
    }

    public function testYaml()
    {
        \BaAGee\Config\Config::init(__DIR__ . '/config', \BaAGee\Config\Parser\YamlParser::class);
        $meituanServer = \BaAGee\Config\Config::get('meituan/server/host');
        $this->assertEquals($meituanServer, '127.0.0.1');
        $accessKey = \BaAGee\Config\Config::get('service/meituan/access_key');
        $this->assertEquals($accessKey, '90909090');
    }

    public function testPHP()
    {
        \BaAGee\Config\Config::init(__DIR__ . '/config', \BaAGee\Config\Parser\PhpParser::class);
        $user = \BaAGee\Config\Config::get('/service/mysql/user');
        $this->assertEquals($user, 'sdgsf');
        $mysqls = \BaAGee\Config\Config::get('/service/mysqls');
        $this->assertEquals($mysqls, null);
        $nnn = \BaAGee\Config\Config::get('/service/mysql/nnn');
        $this->assertEquals($nnn, null);
    }

    public function testKV()
    {
        include_once __DIR__ . '/ParseKVFile.php';
        // 自定义配置文件解析获取
        \BaAGee\Config\Config::init(__DIR__ . '/config', ParseKVFile::class);
        $name = \BaAGee\Config\Config::get('keyvalue/name');
        $age  = \BaAGee\Config\Config::get('keyvalue/age');
        $this->assertEquals($name, '小冰');
    }

    public function testDefault()
    {
        \BaAGee\Config\Config::init(__DIR__ . '/config', PhpParser::class);
        $val = Config::get('aaa/default', 'default');
        $this->assertEquals('default', $val);
    }

    public function testFast()
    {
        \BaAGee\Config\Config::init(__DIR__ . '/config', PhpParser::class);

        Config::fast(__DIR__);

        $t1 = microtime(true);
        for ($i = 0; $i < 100; $i++) {
            $c = Config::get('service/ddd/asd/cc/ddd/dd');
        }
        $t2 = microtime(true);
        var_dump($t2 - $t1);
        $this->assertEquals($t2, $t2);
    }
}

