import request from '@/utils/request'

const api = {
    /**
     * 新增或者更新
     */
    Save(data) {
        return request({
            url: '/common/pay_order/saveData',
            method: 'post',
            data
        })
    },
    /**
     * 列表查询
     */
    Query(data) {
        return request({
            url: '/common/pay_order/getList',
            method: 'post',
            data
        })
    },
    /*
    * 删除
    */
    Delete(data) {
        return request({
            url: '/common/pay_order/deleteData',
            method: 'post',
            data
        })
    },
    /*
    * 查询详情
    */
    Detail(data){
        return request({
            url: '/common/pay_order/getDetail',
            method: 'post',
            data
        })
    }
}

export default api
