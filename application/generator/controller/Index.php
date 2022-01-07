<?php


namespace app\generator\controller;



use app\common\model\Model_PayOrder;
use app\generator\core\Generator;
use think\Controller;
use think\Db;
use think\Exception;
use think\facade\Env;
use think\facade\Request;
use think\response\Json;
use think\response\View;

class Index extends Controller
{

    public function index(){

        $g =  new Generator([
            'mode'=>Generator::MODE_FORCE_COVER
        ]);
        $table_name ='pay_order';
        $info =  $g->getTableInfo($table_name,'common');
        try{
            $g->buildModel($info);
            $g->buildController($info);
            $g->buildVueList($info);
            $g->buildVueDetail($info);
        }catch (Exception $e) {
            vdump($e->getMessage());
        }
    }
}