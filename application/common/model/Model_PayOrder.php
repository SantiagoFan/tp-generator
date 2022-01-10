<?php
namespace app\common\model;

use JoinPhpCommon\utils\AdvancedQuery;
use think\db\Query;
use think\Model;

/**
* 订单
* Class Model_PayOrder
* @package app\common\model
*/
class Model_PayOrder extends Model{
    protected $table = "pay_order";

    /**
    * 保存数据
    * @param $data array 数据
    * @return Model_PayOrder model
    */
    public static function createModel(array $data): Model_PayOrder    {
        // 设置默认数据
        $model = User::create($data);
        return $model;
    }
    /**
    * 更新数据
    * @param $data array 数据
    * @return Model_PayOrder model
    */
    public static function updateModel(array $data): Model_PayOrder    {
        $model =  new self();
        $model->allowField(true)->save($data,['id'=>$data['id']]);
        return $model;
    }
    /**
    * 查询详情
    * @param $condition array 查询条件
    * @return Model_PayOrder model
    */
    public static function getDetail(array $condition): Model_PayOrder    {
        return self::where($condition)->find();
    }

    /**
    * 查询列表
    * @param $condition array 条件
    * @return array  数据
    */
    public static function getList(array $condition) : array{
        //分页排序
        $sort = $condition['sort'] ?? 'desc';
        $order = $condition['order'] ?? 'id';
        $limit = $condition['limit'] ?? 20;
        $page = $condition["page"]??1;

        $query = new Query();
        // 高级查询条件
        AdvancedQuery::buildQuery($query,$condition);
        // 基础查询条件（键值对）
        AdvancedQuery::buildFilter($query,$condition);
        // 查询分页
        $list = self::where($query)
        ->order($order, $sort)
        ->paginate($limit,true,['type'=>$page]);

        return array('items' => $list->items(), 'total' => $list->total());
    }
    /**
    * 批量删除
    * @param $ids array 主键集合
    * @param $soft_delete bool 是否软删除
    * @return bool
    * @throws \Exception
    */
    public static function deleteBatch(array $ids, bool $soft_delete = false): bool
    {
        if($soft_delete){
            // 逻辑删除
            self::update(['is_delete'=>1],['id'=>$ids]);
            return true;
        }else{
            // 物理删除
            return self::where('id','in',$ids)->delete();
        }
    }
}