<?php


namespace app\index\controller\pay;


use JoinPhpPayment\core\IPayableOrder;
use JoinPhpPayment\core\IPaymentConfig;
use JoinPhpPayment\core\PayChannel;
use JoinPhpPayment\core\PayClient;
use JoinPhpPayment\core\PayFactory;
use think\Exception;
use think\facade\Config;
use think\Model;

class PaymentConfig implements IPaymentConfig
{
    public static function init(){
        $config  = new self();
        PayFactory::init($config);
    }
    /**
     * @param string $type
     * @return string[]
     */
    public function getPayConfig(string $type){
        if($type=='wxpay'){
            return Config::get('payment.wxpay');
        }
    }

    /**
     * 获取业务订单实例
     * @param string $business_name
     * @param string $business_no
     * @return IPayableOrder
     * @throws Exception
     */
    public function getBusinessOrder(string $business_name,string $business_no): IPayableOrder
    {
        if($business_name =='my_order'){
            return MyOrder::get($business_no);
        }
        else{
            throw new Exception('业务订单未定义：'.$business_name);
        }
    }

    /**
     * 客户端类型 对应支付渠道
     * @param string $client
     * @return string
     */
    public function getPayChannel(string $client): string
    {
        // 客戶端支付方式映射支付渠道
        $channel=[
            PayClient::WEIXIN_MP => PayChannel::WEIXIN_PAY_JS,
            PayClient::WEIXIN_QRCODE => PayChannel::WEIXIN_PAY_NATIVE,
            PayClient::ALI_MP => PayChannel::ALI_PAY_JS,
            PayClient::ALI_PAY_QRCODE => PayChannel::ALI_PAY_NATIVE,
        ];
        return $channel[$client];
    }
}