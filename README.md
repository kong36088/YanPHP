# YanPHP
一个面向API的服务型框架

目录结构


## 路由

### 默认路由规则
默认路由寻路路径是：/interface.php/controller/method
controller代表您的控制器，method是指向的方法

举例：http://localhost/interface.php/user/getUser
这个路径映射到`UserController`的`getUser`方法

### 自定义路由规则
当然，您也可以自定义自己的路由规则

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


## YAssert

YanPHP内嵌的断言支持。感谢[beberlei/assert](https://github.com/beberlei/assert)提供类库支持

详细的使用方法在这里：[YassertDocument](https://github.com/kong36088/YanPHP/tree/master/doc/YAssert.md)