# YanPHP
一个面向API的服务型框架

目录结构
```
├── Application                  --你的代码目录
│   ├── Cgi                        --分层应用根目录（这里是Cgi代码）
│   │   ├── Cache                    --缓存
│   │   ├── Compo                    --自定义组件
│   │   ├── Config                   --配置
│   │   ├── Controller               --控制器，用于编写业务逻辑
│   │   ├── Logs                     --日志存放
│   │   ├── Model                    --模型层
│   │   ├── Param                    --入参定义，以及参数校验
│   │   └── Util                     --工具类库
│   └── Server                     --分层应用根目录（这里是Server代码）
│   │   ├── Cache                    --缓存
│   │   ├── Compo                    --自定义组件
│   │   ├── Config                   --配置
│   │   ├── Controller               --控制器，用于编写业务逻辑
│   │   ├── Logs                     --日志存放
│   │   ├── Model                    --模型层
│   │   ├── Param                    --入参定义，以及参数校验
│   │   └── Util                     --工具类库
├── System                       --框架目录
│   └── Yan
│       ├── Common
│       └── Core
│           ├── Compo
│           └── Exception

```

## hello world

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

#### config

日志配置相关

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

例如我们需要请求`UserController`的`index`方法，那么我们需要创建一个`入参配置文件` `/Param/UserController.ini`

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

### 相关入参规则


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