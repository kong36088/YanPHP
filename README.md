# Guide

- [Documentation](#documentation)
    - [hello world](#hello-world)
    - [路由](#路由)
        - [默认路由规则](#默认路由规则)
        - [自定义路由规则](#自定义路由规则)
    - [配置](#配置)
        - [系统配置相关](#系统配置相关)
        - [日志配置相关](#日志配置相关)
        - [database](#database)
    - [YAssert](#yassert) 
    - [入参和Input](#入参和input) 
        - [用法介绍](#用法介绍)
        - [相关入参规则](#相关入参规则)
        - [获取输入参数](#获取输入参数)
    - [Database](#database) 
    - [Session](#session) 
    - [Nginx](#nginx) 
    - [Apache](#apache)
    - [Tests](#tests)
    - [License](#license)


# Documentation

这是一个面向API的服务型框架

目录结构
```
├── Application                  --你的代码目录
│   ├── Cgi                        --分层应用根目录（这里是Cgi代码）
│   │   ├── Cache                    --缓存
│   │   ├── Compo                    --自定义组件
│   │   ├── Config                   --配置
│   │   ├── Controller               --控制器，用于编写业务逻辑
│   │   ├── Logs                     --日志存放
│   │   ├── Model                    --模型层
│   │   ├── Param                    --入参定义，以及参数校验
│   │   └── Util                     --工具类库
│   └── Server                     --分层应用根目录（这里是Server代码）
│   │   ├── Cache                    --缓存
│   │   ├── Compo                    --自定义组件
│   │   ├── Config                   --配置
│   │   ├── Controller               --控制器，用于编写业务逻辑
│   │   ├── Logs                     --日志存放
│   │   ├── Model                    --模型层
│   │   ├── Param                    --入参定义，以及参数校验
│   │   └── Util                     --工具类库
├── System                       --框架目录
│   └── Yan
│       ├── Common
│       └── Core
│           ├── Compo
│           └── Exception

```

## hello world

来编写我们的第一个hello world

首先我们需要先新增一个控制器
新建一个控制器文件 `Application/Cgi/Controller/HelloController.php`
``` php
<?php
namespace App\Cgi\Controller;

use Yan\Core\Compo\ResultInterface;
use Yan\Core\Controller;

class HelloController extends Controller
{

    public function index(): ResultInterface
    {
        return $this->succ('hello world');
    }
}
```
紧接着到`Param`目录下创建我们的控制器入参规则，
`Application/Cgi/Param/HelloController.ini`内容如下：
``` ini
[index]
```
用命令行重新加载composer中注册的命名空间：
``` bash
composer dump-autoload
```

最后，用浏览器访问我们刚才编写的hello world：`http://localhost/interface.php/hello/index`

返回结果为以下内容
``` json
{
    "code": 0,
    "message": "hello world",
    "data": []
}
```

若有新增类库文件，**记得一定要运行一次 `composer dump-autoload` 以重新加载命名空间**

## 路由

### 默认路由规则
默认路由寻路路径是：/interface.php/controller/method
controller代表您的控制器，method是指向的方法

举例：http://localhost/interface.php/user/getUser
这个路径映射到`UserController`的`getUser`方法

### 自定义路由规则
当然，您也可以自定义自己的路由规则。
路由规则存放在 `Application/YourLevel/Config/router.php` 
``` php
$config['default_method'] = 'index';   //默认方法

$config['route'] = [
    '/' => [    //被映射的路径
        'request_method' => ['GET','POST'],   //支持的http动作，支持GET和POST
        'controller' => 'App\\Cgi\\Controller\\UserController',  //所映射到的控制器，需要包含命名空间，映射到Application/Cgi/Controller/UserController
        'method' => 'index'       //所映射到的方法，映射到UserController的index方法
    ],
    '/user' => [
        'request_method' => ['GET'],    //支持的http动作，支持GET
        'controller' => 'App\\Cgi\\Controller\\UserController',    //所映射到的控制器，需要包含命名空间，映射到Application/Cgi/Controller/UserController
        'method' => 'getUser'     //映射到UserController的index方法getUser方法
    ],
];

```

## 配置

配置文件统一存放在 `Application/YourLevel/Config` 目录下
`Application`下的各个文件夹对应着您应用的各个分层，每一层都采用自己独立的Config配置

#### 系统配置相关
``` php
$config['namespace'] = 'App\\Cgi';
```
这里用于配置你的应用层采用的命名空间，在新添加应用层后请勿忘记修改这里的配置哦。

``` php
$config['session_path'] = BASE_PATH.'/Cache/session';
$config['session_name'] = 'YAN_SESSION';
```
`session_path` 用于配置session存放的僦
`session_name` 用于配置session名称，即用于标识用户session id的key值

#### 日志配置相关

几种日志等级。比如日志等级配置为`INFO`，则INFO及INFO以上的（NOTICE、WARING、ERROR）等等级的日志将会被记录。
```
/**
'DEBUG'
'INFO'
'NOTICE'
'WARNING'
'ERROR'
'CRITICAL'
'ALERT'
'EMERGENCY'
*/

$config['log_level'] = 'DEBUG';
```

日志存放路径
```
/**
 * The log path
 */
$config['log_path'] = BASE_PATH . '/logs/cgi.log';
```

```
/**
 *  最大存放的日志文件数量
 */
$config['log_max_file'] = 0;
/**
 * 配置日志记录的格式
 * "[%datetime%] %channel%.%level_name%: %message% %context%\n";
 */
$config['log_format'] = "[%datetime%]-%extra.process_id% %channel%.%level_name%: %message% %context%\n";
```

#### database

`database.php`

|config|options|description|
|:-----------:|:-----------:|:-----------:|
|`db_host`||DB host|
|`db_user`||用户名|
|`db_password`||密码|
|`db_port`| 3306/(others)|端口号|
|`db_database`||库|
|`db_charset`|utf8/(others)||
|`db_driver`| mysql/postgres/sqlite/sqlsrv |目前支持四种数据库类型|


## YAssert

YanPHP内嵌的断言支持。感谢[beberlei/assert](https://github.com/beberlei/assert)提供类库支持

详细的使用方法在这里：[YassertDocument](https://github.com/kong36088/YanPHP/tree/master/doc/YAssert.md)

## 入参和Input

### 用法介绍
所有入参都需要定义在应用目录路径下的Param目录，并且可以对其进行相关的参数校验操作。

下面我们会举例对该功能进行讲解。

例如我们需要请求`UserController`的`index`方法，那么我们需要创建一个`入参配置文件` `Param/UserController.ini`

文件内容如下：
```ini
[index]
user_id="starts_with[1]|required|numeric|between[1,123]"
page="numeric"
domain="string|numeric"
arr="array"

[getUser]

```
“=”号左边的是需要的入参，右边的是需要验证的规则。规则都是`Validator`内置好的，基于[Respect/Validation](https://github.com/Respect/Validation)开发
并且只有被定义在`入参配置文件`中的参数才会被Input类所识别，其余参数一律丢弃。

若参数不符合规则要求，则会直接返回错误信息。

如若你需要为参数配置多个验证规则，可以用 `|` 进行规则分割，例子：`domain="string|length[1,20]"`。
在这个例子中，我们要求domain必须是字符串类型，并且长度在1-20个字符之间。


### 相关入参规则

|规则|参数|使用说明|例子|
|:---:|:---:|:---:|:---:|
|required|否|参数必填||
|integer|否|整型||
|numeric|否|所有字符都是数字（不区分变量类型）||
|float|否|浮点型||
|string|否|字符型||
|array|否|数组型||
|valid_ip|否|验证是否为一个有效的ip||
|json|否|验证是否为合法json格式||
|email|否|验证是否为合法邮箱||
|domain|否|验证是否为合法域名||
|regex|是|正则匹配|regex[/[0-9]+/]|
|starts_with|是|是否以规定的字符开头|starts_with[ab]|
|ends_with|是|是否以规定的字符结束|ends_with[ab]|
|between|是|数值在定义的范围之间|between[1,100]|
|min|是|定义最小不小于|min[1]|
|max|是|定义最大不大于|max[100]|
|length|是|定义字符串长度在定义范围内|length[1,100]|
|equal|是|入参的值必须等于定义的值|equal[123]|

### 获取输入参数

```php 
Input::get('user_id'); //获取参数user_id

Input::set('user_id',1); //设置参数
```

## Database

The Illuminate Database component is a full database toolkit for PHP, providing an expressive query builder, ActiveRecord style ORM, and schema builder. It currently supports MySQL, Postgres, SQL Server, and SQLite. It also serves as the database layer of the Laravel PHP framework.


> `composer require "illuminate/events"` required when you need to use observers with Eloquent.

Once the Capsule instance has been registered. You may use it like so:

**Using The Query Builder**

```PHP
$users = Capsule::table('users')->where('votes', '>', 100)->get();
```
Other core methods may be accessed directly from the Capsule in the same manner as from the DB facade:
```PHP
$results = Capsule::select('select * from users where id = ?', array(1));
```

**Using The Schema Builder**

```PHP
Capsule::schema()->create('users', function ($table) {
    $table->increments('id');
    $table->string('email')->unique();
    $table->timestamps();
});
```

**Using The Eloquent ORM**

```PHP
class User extends Illuminate\Database\Eloquent\Model {}

$users = User::where('votes', '>', 1)->get();
```

或者使用YanPHP提供的风格
```PHP
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class User extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'uid';

    protected $keyType = 'int';

    public function getById($id): Collection
    {
        return $this->where([$this->primaryKey => $id])->get();
    }

    public function getByCond($cond): Collection
    {
        return $this->where($cond)->get();
    }

    public function updateByCond($cond, $update): bool
    {
        return $this->where($cond)->update($update);
    }

    public function deleteById($id)
    {
        return $this->where($id)->delete();
    }
}


$UserModel = new User();
$UserModel->getById(1); // 获取user表中uid为1的用户数据信息

```

For further documentation on using the various database facilities this library provides, consult the [Laravel database documentation](https://docs.golaravel.com/docs/5.4/database/).

## Session

用法示例
``` php
use Yan\Core\Session;

Session::set('a','b');  //设置session值

$sessionVaue = Session::get('a');  //获取session中的值

Session::destroy(); //销毁所有session
```

Session类中有以下方法
``` php
/**
 * @method static mixed get($key, $alt = null)
 * @method static mixed set($key, $val)
 * @method static null clear()
 * @method static mixed getFlash($key, $alt = null)
 * @method static null setFlash($key, $val)
 * @method static null clearFlash()
 * @method static mixed getFlashNext($key, $alt = null)
 * @method static null setFlashNow($key, $val)
 * @method static null clearFlashNow()
 * @method static null keepFlash()
 * @method boo null destroy()
 */
```

## Nginx

我们需要把每一层应用层作为你的根目录
``` bash
# 这里是你的Cgi层
server 
{
    listen       80;
    server_name  cgi.example.com;
    index index.shtml index.html index.htm interface.php;
    root  root  /path/to/root/YanPHP/Application/Cgi/;
     location / {
        try_files $uri $uri/ =404;
        if (!-e $request_filename)
        {
            rewrite (.*) /interface.php;
        }
    }
    location ~ .*\.(php|php5)?$
    {
        fastcgi_pass  127.0.0.1:9000;
        fastcgi_index index.php;
        include fastcgi.conf;
    }
    access_log  /var/log/YanPHP/access.log;
    error_log   /var/log/YanPHP/error.log;
}

# 这里是你的Server层
server 
{
    listen       80;
    server_name  server.example.com;
    index index.shtml index.html index.htm interface.php;
    root  root  /path/to/root/YanPHP/Application/Server/;
     location / {
        try_files $uri $uri/ =404;
        if (!-e $request_filename)
        {
            rewrite (.*) /interface.php;
        }
    }
    location ~ .*\.(php|php5)?$
    {
        fastcgi_pass  127.0.0.1:9000;
        fastcgi_index index.php;
        include fastcgi.conf;
    }
    access_log  /var/log/YanPHP/access.log;
    error_log   /var/log/YanPHP/error.log;
}
```

## Apache

如果你需要进行url重写，那么你需要开启 `rewrite module`。
YanPHP已经为你编写好了 `.htaccess` 文件，并且存放在每一个应用层的目录下。

``` apacheconfig
<VirtualHost *:80>
    DocumentRoot "/path/to/root/YanPHP/Application/Cgi/;"
    ServerName cgi.example.com
    AddType application/x-httpd-php .php
    <Directory />
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
        DirectoryIndex interface.php
    </Directory>
</VirtualHost>

<VirtualHost *:80>
    DocumentRoot "/path/to/root/YanPHP/Application/Server/;"
    ServerName server.example.com
    AddType application/x-httpd-php .php
    <Directory />
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
        DirectoryIndex interface.php
    </Directory>
</VirtualHost>
```

## Tests

YanPHP编写了相关的测试用例，可以通过运行一下命令进行单元测试，同时也欢迎提交pull request进行测试用例的补充。
``` bash
phpunit --configuration phpunit.xml
```

## License

MIT