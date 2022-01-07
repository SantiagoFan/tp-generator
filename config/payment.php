<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | 支付相关配置
// +----------------------------------------------------------------------

use think\facade\Config;
use think\facade\Env;

return [

    // +----------------------------------------------------------------------
    // | 微信支付
    // +----------------------------------------------------------------------
    'wxpay'=>[
        'app_id' => 'wxf8d67b61ffc37ece',
        'mch_id' => '1528513281',
        'key' => '3dffb68220e1e99a7e49e96b518c8664',   // 支付 API 密钥
        'pay_notify_url' =>'http://' . Config::get('app_host') . '/index/pay.Notify/wxpay',
        'refund_notify_url' =>'http://' . Config::get('app_host') . '/index/pay.Notify/wxrefund',
        'cert_path' =>Env::get('root_path'). 'cert/apiclient_cert.pem', // XXX: 绝对路径！！！！
        'key_path' =>Env::get('root_path'). 'cert/apiclient_key.pem'
    ]
];
