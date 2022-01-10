<?php


namespace app\common\controller;

use app\common\model\Model_PayOrder;
use think\response\Json;
use think\facade\Request;

/**
* 订单 控制器
* Class PayOrder
* @package app\common\controller
*/
class PayOrder extends Controller
{

    /**
    * 更新或者保存数据
    * @return Json
    */
    public function saveData(): Json
    {
        try {
            $param = Request::param('post.');
            if(isset($param['id'])){
                Model_PayOrder::updateModel($param);
            }else{
                Model_PayOrder::createModel($param);
            }
        }catch (\Exception $e){
            return json(['code'=>50000,'message'=>$e->getMessage()]);
        }
    }

    /**
    * 查询详情信息
    */
    public function getDetail(): Json
    {
        try{
            $data =  Request::param('id');
            $result  =  Model_PayOrder::getDetail($data);
            return json(['code' => 20000, 'data' => $result,'message'=>'查询成功']);
        }catch (\Exception $e){
            return json(['code'=>50000,'message'=>$e->getMessage()]);
        }
    }

    /**
    * 分页查询列表
    * @return Json
    */
    public function getList(): Json
    {
        try {
            $param = Request::param('post.');
            $data = Model_PayOrder::getList($param);
            $data['code'] = 20000;
            $data['message'] = '成功';
            return json($data);
        }catch (\Exception $e){
            return json(['code'=>50000,'message'=>$e->getMessage()]);
        }
    }
    /**
    * 分页查询列表
    * @return Json
    */
    public function deleteData(): Json
    {
        try {
            $ids = Request::param('post.ids');
            //物理删除
            Model_PayOrder::deleteBatch($ids);
            return json(['code' => 20000, "message" => "删除成功"]);
        }catch (\Exception $e){
            return json(['code'=>50000,'message'=>$e->getMessage()]);
        }
    }
}