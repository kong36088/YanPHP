<?php
/**
 * Longphp
 * Author: William Jiang
 */
/**
 * 配置默认控制器以及默认方法
 * 暂不支持路由修改功能
 */
$config['default_method'] = 'index';

$config['route'] = [
    '/' => [
        'request_method' => ['GET','POST'],
        'controller' => 'App\\Cgi\\Controller\\UserController',
        'method' => 'index'
    ],
    '/user' => [
        'request_method' => ['GET'],
        'controller' => 'App\\Cgi\\Controller\\UserController',
        'method' => 'getUser'
    ],
];
