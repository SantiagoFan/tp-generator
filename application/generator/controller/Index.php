<?php


namespace app\generator\controller;



use app\common\model\Model_PayOrder;
use app\generator\core\Generator;
use app\generator\core\VueGenerator;
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
        $g =  new VueGenerator([
            'mode'=>Generator::MODE_FORCE_COVER
        ]);
        $table_name ='pay_order';
        vdump("---------------代码自动生成 表信息--------------------------------------");
        $info =  $g->getTableInfo($table_name,'common');
        vdump('数据表'.$info['table_name']);
        vdump('生成模块'.$info['module_name']);
        vdump('模型名'.$info['model_name']);
        vdump('控制器名'.$info['controller_name']);
        vdump('主键'.$info['pk']);
        try{
            vdump("---------------代码自动生成 开始--------------------------------------");
            vdump("生成Model");
            $g->buildModel($info);
            vdump("生成Controller");
            $g->buildController($info);
            vdump("生成VueList");
            $g->buildVueList($info);
            vdump("生成VueDetail");
            $g->buildVueDetail($info);
            vdump("生成VueEdit");
            $g->buildVueEdit($info);
            vdump("生成VueApiJS");
            $g->buildVueApiJs($info);
            vdump("---------------代码自动生成 结束--------------------------------------");
        }catch (Exception $e) {
            vdump($e->getMessage());
        }
    }
}