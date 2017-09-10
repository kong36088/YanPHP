# YanPHP
一个面向API的服务型框架

目录结构


## 路由

默认路由寻路路径是：/interface/controller/method
controller代表您的控制器，method是指向的方法

当然，您也可以自定义自己的路由规则

``` php
$config['default_method'] = 'index';   //默认方法

$config['route'] = [
    '/' => [    //被映射的路径
        'request_method' => ['GET','POST'],   //支持的http动作
        'controller' => 'App\\Cgi\\Controller\\UserController',  //所映射到的控制器
        'method' => 'index'       //所映射到的方法
    ],
    '/user' => [
        'request_method' => ['GET'],
        'controller' => 'App\\Cgi\\Controller\\UserController',
        'method' => 'getUser'
    ],
];

```

## YAssert

YanPHP内嵌的断言支持。感谢[beberlei/assert](https://github.com/beberlei/assert)提供类库支持

详细的使用方法在这里：[YassertDocument](https://github.com/kong36088/YanPHP/tree/master/doc/YAssert.md)