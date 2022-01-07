/**
 * 通用编辑页
 */
export default {
  data() {
    return {
      primary_key: 'id',
      editLoading: false, // 正在加载标志
      formData: {
      }
    }
  },
  mounted() {

  },
  methods: {
    // 重置编辑样本
    resetDate() {
      this.formData = { }
      this.formData[this.primary_key] = undefined;
    },
    fetchData(id) {
      this.api.getDetail({id:id}).then(res => {
        this.formData = res.data
      })
    },
    // 提交添加
    CreateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          this.api.saveData(this.formData).then(() => {
            this.$notify({ title: '成功', message: '创建成功', type: 'success', duration: 2000 })
          })
        }
      })
    },
  }
}
