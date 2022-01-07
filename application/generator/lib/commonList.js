/**
 * 通用列表页
 * 集成自动加载、高级查询、编辑、删除 简单创建
 */
export default {
  data() {
    return {
      list: [], // 数据列表对象
      total: 0, // 记录总数
      primary_key: 'id',
      listQuery: {
        page: 1,
        limit: 10, // 页大小
        order: 'id', // 默认排序方式,
        sort: 'DESC'
      },
      listLoading: false, // 正在加载标志

      dialogFormVisible: false, // 编辑窗体显示标志
      dialogStatus: '', // 窗体编辑类型 新增 create/update
      formData: {},
      rules: {}, // 表单提交验证规则 请在页面重写
    }
  },
  methods: {
    // -----------------------------------表格------------------------------------
    // 发送列表请求前
    loadListBefore(params) { return params },
    // 加载当前页数据
    loadData() {
      this.listLoading = true
      // 请求前处理
      this.loadListBefore(this.QueryParams)

      this.api.Query(this.listQuery).then(response => {
        if (this.afterLoadData) {
          response.data.items = this.afterLoadData(response.data.items, response.data)
        }
        this.list = response.data.items
        this.total = response.data.total
        this.listLoading = false
        this.$previewRefresh() // 为图片预览组件重新刷新url
      })
    },
    // 加载第一页数据
    SearchData() {
      this.listQuery.page = 1
      this.loadData()
    },
    // 切换排序
    sortChange(param) {
      this.listQuery.page = 1
      this.listQuery.sort = param.order === 'ascending' ? 'ASC' : 'DESC'
      this.listQuery.order = param.prop
      this.loadData()
    },
    // 表格筛选
    filterChange(param) {
      this.listQuery.filter = Object.assign(this.listQuery.filter || {}, param)
      this.loadData()
    },
    // 批量删除
    BatchDelete() {
      if (this.$refs['listTable'].selection.length > 0) {
        this.$confirm('即将批量删除数据, 是否继续?', '提示').then(() => {}).then(() => {
          var ids = this.$refs['listTable'].selection.map(a => a[this.primary_key])
          this.api.Delete(ids).then(response => {
            if (response.code === 20000) {
              this.$message({ message: '操作成功', type: 'success' })
              this.SearchData() // 重新加载数据
            } else {
              this.$message({ message: '操作失败', type: 'error' })
            }
          })
        }).catch(() => {
        })
      } else {
        this.$message({ message: '请选择删除的数据', type: 'error' })
      }
    },
    // 行删除
    RowDelete(row) {
      this.$confirm('即将删除数据, 是否继续?', '提示').then(() => {
        var ids = [row[this.primary_key]]
        this.api.Delete(ids).then(response => {
          if (response.code === 20000) {
            this.$message({ message: '操作成功', type: 'success' })
            this.SearchData() // 重新加载数据
          } else {
            this.$message({ message: '操作失败', type: 'error' })
          }
        })
      }).catch(() => {

      })
    },
    // -----------------------------------添加------------------------------------
    // 重置编辑样本
    resetTemp() {
      this.formData = { id: undefined }
    },
    // 显示添加窗体
    HandleCreate() {
      this.resetTemp()
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
    },
    // 显示编辑窗体
    HandleUpdate(row) {
      this.formData = Object.assign({}, row) // copy obj
      this.dialogStatus = 'update'
      this.dialogFormVisible = true
    },

    // 列表页提交数据
    ConfirmData() {
      if (this.dialogStatus === 'create') {
        this.CreateData()
      } else {
        this.UpdateData()
      }
    },
    // 提交添加
    CreateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          this.api.Create(this.formData).then(() => {
            this.dialogFormVisible = false
            this.SearchData()
            this.$notify({ title: '成功', message: '创建成功', type: 'success', duration: 2000 })
          })
        }
      })
    },
    // 提交修改
    UpdateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.formData)
          this.api.Update(tempData).then((response) => {
            for (const v of this.list) {
              if (v.id === this.formData.id) {
                const index = this.list.indexOf(v)
                this.list.splice(index, 1, this.formData)
                break
              }
            }
            this.dialogFormVisible = false
            this.$notify({ title: '成功', message: '更新成功', type: 'success', duration: 2000 })
            this.loadData()
          })
        }
      })
    }
  }
}
