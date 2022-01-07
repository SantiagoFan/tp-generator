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

            if(in_array("Model",$data['template'])){ $g->buildModel($info); }
            if(in_array("Controller",$data['template'])){ $g->buildController($info); }
            if(in_array("Validator",$data['template'])){ $g->buildValidate($info); }
            if(in_array("VueList",$data['template'])){ $g->buildVueList($info); }
            if(in_array("VueDetail",$data['template'])){ $g->buildVueDetail($info); }
            if(in_array("VueEdit",$data['template'])){ $g->buildVueEdit($info); }
            if(in_array("VueApiJs",$data['template'])){ $g->buildVueApiJs($info); }

            return json(['code'=>20000,'message'=>'成功']);

        }catch (Exception $e) {
            return json(['code'=>50000,'message'=>$e->getMessage()]);
        }
    }
}