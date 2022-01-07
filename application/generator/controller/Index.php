<?php


namespace app\generator\controller;



use app\common\model\Model_PayOrder;
use app\generator\core\Generator;
use app\generator\core\VueGenerator;
use think\Controller;
use think\Db;
use think\Exception;
use think\facade\Config;
use think\facade\Env;
use think\facade\Request;
use think\response\Json;
use think\response\View;

class Index extends Controller
{
    public function index(){
        return view();
    }
    public function getTableList(): Json
    {
        $g =  new VueGenerator();
        $db_name =  Config::get('database.database');
        $list = $g->getTableNameList($db_name);
        return json($list);
    }
    public function getTableColumns(): Json
    {
        $table_name = input('post.table_name');
        $g =  new VueGenerator();
        $list = $g->getTableColumns($table_name);
        return json($list);
    }

    public function create(){
        $data = input('post.');
        $g =  new VueGenerator([
            'mode'=>Generator::MODE_FORCE_COVER
        ]);
        $table_name = $data['table_name'];
        try{
            $info =  $g->getTableInfo($table_name,'common');

            $info['table_desc'] = $data['table_desc'];


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