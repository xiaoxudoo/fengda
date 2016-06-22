<?php
include __DIR__ . '/vendor/autoload.php';
use EasyWeChat\Foundation\Application;

$options = [
    'debug'     => true,
    'app_id'    => 'wx575cf8308f69672f',
    'secret'    => '',
    'token'     => 'weixin',
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easywechat.log',
    ],
    // ...
];

$app = new Application($options);

?>
