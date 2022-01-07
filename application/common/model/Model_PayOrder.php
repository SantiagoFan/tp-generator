<?php
namespace app\common\model;

use JoinPhpCommon\utils\AdvancedQuery;
use think\db\Query;
use think\Model;

class Model_PayOrder extends Model{
    protected $table = "pay_order";

    /**
    * 查询详情
    * @param $condition array 查询条件
    * @return Model_PayOrder    */
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
}