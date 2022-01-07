<?php

namespace app\index\controller\pay;

use JoinPhpPayment\base\BaseNotifyController;
use think\App;

class Notify extends BaseNotifyController
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        PaymentConfig::init();
    }
}