<?php
include __DIR__ . '/vendor/autoload.php';
use EasyWeChat\Foundation\Application;

$options = [
    'debug'     => true,
    'app_id'    => 'wx575cf8308f69672f',
    'secret'    => '2c65aaf7ab9b6ad417c26927b0a6070d',
    'token'     => 'weixin',
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easywechat.log',
    ],
    // ...
];

$app = new Application($options);

?>