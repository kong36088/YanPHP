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
│   │   └── Util                     --工具类库
│   └── Server                     --分层应用根目录（这里是Server代码）
│   │   ├── Cache                    --缓存
│   │   ├── Compo                    --自定义组件
│   │   ├── Config                   --配置
│   │   ├── Controller               --控制器，用于编写业务逻辑
│   │   ├── Logs                     --日志存放
│   │   ├── Model                    --模型层
│   │   └── Util                     --工具类库
├── System                       --框架目录
│   └── Yan
│       ├── Common
│       └── Core
│           ├── Compo
│           └── Exception

```

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

### 配置

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