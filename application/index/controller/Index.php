<?php
namespace app\index\controller;

use app\common\AdvancedQuery;
use app\index\controller\pay\MyOrder;
use app\index\controller\pay\PaymentConfig;
use JoinPhpCommon\encrypt\SM3;
use JoinPhpCommon\utils\HttpHelper;
use JoinPhpCommon\utils\JwtAuth;
use JoinPhpCommon\utils\Pinyin;
use JoinPhpCommon\utils\Text;
use JoinPhpCommon\utils\Tree;
use JoinPhpPayment\core\PayClient;
use JoinPhpPayment\core\PayFactory;
use JoinPhpPayment\model\Model_PayOrder;
use think\Db;
use think\db\Query;
use think\db\Where;
use think\facade\Config;
use think\response\Xml;


class Index
{
    public function index(){
        vdump("xxxxxxxxxxx");
    }
    /**
     * @throws \Exception
     */
    public function http(){
        $http =  new HttpHelper([]);
        $res = $http
            ->setRequestContentType(HttpHelper::TYPE_FROM)
            ->request('http://t.cn/index/index/timeout',
            ['x'=>222,'ddd'=>77665]
            );
        vdump($res);
    }
    public function r(){
        $post =  input('post.');
        $get =  input('get.');
        return json(['post'=>$post,'get'=>$get]);
    }
    public function pay(){
        PaymentConfig::init();
        // 查询或者创建订单
        // $bus_order =  new MyOrder();
        $bus_order = MyOrder::get('10001');
        //调用支付客户端
        // 发起支付
//        $client = PayClient::WEIXIN_QRCODE; //小程序参数
//        $params = [];
//        // 获得支付参数
//        $res = $bus_order->PayOrder($client, $params);
//        vdump($res);
        $res = $bus_order->RefundOrder(0.01,'d');
        vdump($res);
    }
    public function encrypt(){
        $sm3 = new SM3();
        $str = $sm3->sign('DDSADADADASDSASDSAD');
        echo $str;
    }
    public function http2(){
        $http = new HttpHelper();
        $res = $http->get('http://t.cn/index/index/timeout',['a'=>1,'b'=>2]);
        vdump($res);
    }
    public function timeout(){
//        while (true){
//
//        }
        echo "ddddddddddd";
    }
    public function text(){
        $order_code = Text::build_order_no();
        echo $order_code;
    }
    public function tree(){
        $data = [
            ['name'=>"水果","id"=>"1","parent_id"=>''],
            ['name'=>"蔬菜","id"=>"2","parent_id"=>''],
            ['name'=>"西瓜","id"=>"3","parent_id"=>'1'],
            ['name'=>"橘子","id"=>"4","parent_id"=>'1'],
            ['name'=>"南瓜","id"=>"5","parent_id"=>'2'],
            ['name'=>"土豆","id"=>"6","parent_id"=>'2'],
        ];
        $tree = new Tree();
        vdump($data);
        $tree_data = $tree->makeTree($data);
        vdump(json_encode($tree_data));
    }

    public function hello($name = 'ThinkPHP5')
    {
        $res = Pinyin::convert('我是个神仙');
        vdump('拼音：'.$res);
        $jwt = new JwtAuth('test',
        'dsadadsads',
        't.cn',
        't.cn'
        );
        $data = [
            'uid'=>299632,
            'name'=>'张三'
        ];
        // 生成token
        $token = $jwt->CreateToken($data);
        vdump('TOKEN: '.$token);
        // 验证
        $is_success = $jwt->validateToken($token);
        vdump("is_success".$is_success);
        // 解析数据
        $data_2 = $jwt->parseToken($token);
        vdump($data_2);
        json();
        return 'hello';
    }

    public function user(){
        $jwt = new JwtAuth('test',
            'dsadadsads',
            't.cn',
            't.cn'
        );
        $data = [
            'uid'=>299632,
            'name'=>'张三'
        ];
        // 生成token
        $token = $jwt->CreateToken($data);
        vdump($token);
        // g
        $user = $jwt->GetUserData('',$token);
        vdump($user);
    }
}
