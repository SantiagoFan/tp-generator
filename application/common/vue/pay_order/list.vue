<template>
    <div class="app-container">
        <!--查询过滤-->
        <div class="filter-container">
            <el-input v-model="listQuery.search" placeholder="请输入搜索关键词" style="width: 200px;" class="filter-item" @keyup.enter.native="SearchData" />
            <j-advanced-query v-model="listQuery.query" :fields="fields" @change="SearchData" />
            <el-button class="filter-item" type="primary" icon="el-icon-search" @click="SearchData">搜索</el-button>
        </div>
        <!--动作组-->
        <div class="action-container">
            <el-button-group>
                <el-button class="action-item" type="primary" icon="el-icon-edit" @click="HandleCreate">添加</el-button>
                <el-button class="action-item" icon="el-icon-delete" @click="BatchDelete">删除</el-button>
            </el-button-group>
        </div>
        <!--表开始-->
        <el-table ref="singleTable" v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%" @sort-change="sortChange">
            <el-table-column type="selection"></el-table-column>
            <el-table-column align="center" label="ID-支付记录表" style="text-align:center;">
            <template slot-scope="{row}">
                <el-link :href="'#/pay_order/detail?id='+ row.id" type="primary">{{ row.id }}</el-link>
            </template>
        </el-table-column>
                        <el-table-column align="center" prop="title" label="支付项目名称" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" prop="is_refund" label="是否为退款" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" prop="state" label="支付完成状态" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" prop="business_name" label="业务类别：1" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" prop="business_no" label="内部业务" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" prop="pay_channel" label="支付渠道：alipay" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" prop="pay_channel_no" label="支付渠道" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" prop="amount" label="操作金额" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" prop="real_amount" label="实际交易金额" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" prop="apply_time" label="下单时间" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" prop="complete_time" label="交易完成时间" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" prop="original_id" label="原始交易订单" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" prop="original_amount" label="原订单交易金额" style="text-align:center;"></el-table-column>
                        <el-table-column align="center" width="180" label="操作">
            <template slot-scope="{row}">
                <el-button type="text" icon="el-icon-edit" @click="HandleUpdate(row)">编辑</el-button>
                <el-divider direction="vertical"></el-divider>
                <el-dropdown @command="RowCommand">
                    <span class="el-button--text">更多<i class="el-icon-arrow-down el-icon--right"></i></span>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item :command="{row,'command':'delete'}">删除</el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </template>
            </el-table-column>
            <!--列结束-->
        </el-table>
        <!--分页-->
        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="loadData" />
    </div>
</template>
<script>

import api from '@/api/pay_order'
import commonList from '@/utils/commonList'
// import Pagination from '@/components/Pagination' // 推荐全局注册

export default {
    name: 'PayOrderList',
    // components: { Pagination },
    mixins: [commonList],
    created() {
        this.loadData() // 页面加载创建时加载数据
    },
    data() {
        return {
            api,
            fields:[
                { 'name': 'id', 'label': '支付记录表' },
                { 'name': 'title', 'label': '支付项目名称' },
                { 'name': 'is_refund', 'label': '是否为退款' },
                { 'name': 'state', 'label': '支付完成状态' },
                { 'name': 'business_name', 'label': '业务类别：1' },
                { 'name': 'business_no', 'label': '内部业务' },
                { 'name': 'pay_channel', 'label': '支付渠道：alipay' },
                { 'name': 'pay_channel_no', 'label': '支付渠道' },
                { 'name': 'amount', 'label': '操作金额','type': 'number' },
                { 'name': 'real_amount', 'label': '实际交易金额','type': 'number' },
                { 'name': 'apply_time', 'label': '下单时间','type': 'datetime' },
                { 'name': 'complete_time', 'label': '交易完成时间','type': 'datetime' },
                { 'name': 'original_id', 'label': '原始交易订单' },
                { 'name': 'original_amount', 'label': '原订单交易金额','type': 'number' },
                ]
        }
    },
    methods:{
    }
}
</script>