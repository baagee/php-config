# Config
php Config library

内置获取配置文件的方法
```php
interface ConfigInterface
{
    public static function get(string $key);
}
```

### 支持json,php,yaml,ini,xml配置文件解析获取

### 示例代码：

#### 解析ini配置
ini配置文件memcache.ini
```ini
;memcache配置
host = 127.0.0.1
port = 9089
password = fsdt3ty4e
[other]
abc=pp0
```

```php
// 解析ini配置文件
ini方法两个参数 第一个是配置文件存放的根目录 
\BaAGee\Config\Config::init(__DIR__ . '/config', \BaAGee\Config\Parser\ParseIniFile::class);
$password = \BaAGee\Config\Config::get('memcache/password');// 获取memcache文件的password值
$host     = \BaAGee\Config\Config::get('memcache/host');
```

#### 解析yaml配置
meituan.yaml配置
```yaml
server:
  host: 127.0.0.1
  port: 9098
access_key: dsgfdsgdf
access_token: 98y8u67
```
```php
include_once __DIR__ . '/../vendor/autoload.php';
使用内置的yaml配置解析 需要安装yaml扩展
\BaAGee\Config\Config::init(__DIR__ . '/config', \BaAGee\Config\Parser\ParseYamlFile::class);
$meituanServer = \BaAGee\Config\Config::get('meituan/server');
$accessKey     = \BaAGee\Config\Config::get('meituan/access_key');
var_dump($meituanServer, $accessKey);
```

#### 配置文件支持子目录存放和获取
假设配置文件存放在tests/config/service/meituan.yaml
php代码：
```php
include_once __DIR__ . '/../vendor/autoload.php';
使用内置的yaml配置解析 需要安装yaml扩展
\BaAGee\Config\Config::init(__DIR__ . '/config', \BaAGee\Config\Parser\ParseYamlFile::class);
// 从config目录开始 service文件夹下meituan.yaml配置文件下的server的值
$meituanServer = \BaAGee\Config\Config::get('service/meituan/server');
$accessKey     = \BaAGee\Config\Config::get('service/meituan/access_key');
var_dump($meituanServer, $accessKey);
```

### 使用自定义的配置文件结构
假设配置文件：tests/config/keyvalue.kv
```
name=>小冰
age=>17
sex=>女
```
解析kv文件的php代码；
```php
//继承 \BaAGee\Config\Base\ParseConfigAbstract
class ParseKVFile extends \BaAGee\Config\Base\ParseConfigAbstract
{
    // 声明配置文件后缀
    protected static $configSuffix = 'kv';
    
    // 具体的解析方法，返回解析后的配置数组
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
```
获取配置文件信息
```php
include_once __DIR__ . '/../vendor/autoload.php';
// 引入解析类
include_once __DIR__ . '/ParseKVFile.php';
// 自定义配置文件解析获取
\BaAGee\Config\Config::init(__DIR__ . '/config', ParseKVFile::class);
$name = \BaAGee\Config\Config::get('keyvalue/name');
$age  = \BaAGee\Config\Config::get('keyvalue/age');

echo 'name：' . $name . PHP_EOL;
echo 'age：' . $age . PHP_EOL;
```
输出结果：
```
name：小冰
age：17
```

### 其他具体使用：tests目录
