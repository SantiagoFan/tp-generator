/**
 * 通用编辑页
 */
export default {
  data() {
    return {
      primary_key: 'id',
      editLoading: false, // 正在加载标志
      rules:{},// 验证规则
      formData: {
      }
    }
  },
  methods: {
    // 重置编辑样本
    resetDate() {
      this.formData = { }
      this.formData[this.primary_key] = undefined;
    },
    fetchData() {
      // 获取数据前 请设置formData的主键数据
      this.api.getDetail({[this.primary_key]:this.formData[this.primary_key]}).then(res => {
        this.formData = res.data
      })
    },
    createAfter(){},
    // 提交添加
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          this.api.saveData(this.formData).then(res => {
            this.$notify({ title: '成功', message: '创建成功', type: 'success', duration: 2000 })
            this.createAfter(res)
          })
        }
      })
    }
  }
}
