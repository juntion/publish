<template>
    <div>
             <a-modal title="开启/关闭"
                    class="modal-pms"
                   v-model="visible"
                   :confirmLoading="btnLoad"
                   @cancel="cancel"
                   @ok="ok"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                    <div>
                              <a-form-model
                                :model="switchForm"
                                ref="switchForm">
                                <a-form-model-item label="开启/关闭" style="margin-bottom:20px">
                                    <a-switch size="small"  v-model="switchForm.status"/>
                                </a-form-model-item>
                                <a-form-model-item prop="comment" label="操作说明" :rules="[{ required: true, message: '请输入操作说明', trigger: 'blur' }]">
                                    <a-textarea placeholder="请输入操作说明" v-model="switchForm.comment" :rows="4" />
                                </a-form-model-item>
                              </a-form-model>
                    </div>
             </a-modal>
    </div>
</template>

<style lang="less" scoped>
    /deep/.ant-switch-checked {
        background: #3DCCA6;
    }
</style>
<script>
import { bus } from '@/plugins/bus'
import { switchPublishingProducts } from '@/api/RDmanagement/ProductMaintenance/edition.js'
export default {
  data () {
    return {
      visible: false,
      btnLoad: false,
      id: undefined,
      switchForm: {
        status: false,
        comment: undefined
      }
    }
  },
  mounted () {
    bus.$on('switchPublishingModalShow', data => {
      this.switchForm.status = Boolean(data.status)
      this.id = data.id
      this.visible = true
    })
  },
  beforeDestroy () {
    bus.$off('switchPublishingModalShow')
  },
  methods: {
    cancel () {
      this.$refs.switchForm.resetFields()
    },
    ok () {
      this.$refs.switchForm.validate(valid => {
        if (valid) {
          const form = Object.assign({}, this.switchForm)
          if (form.status) {
            form.status = 1
          } else {
            form.status = 0
          }
          this.btnLoad = true
          switchPublishingProducts(this.id, form).then(res => {
            this.visible = false
            this.btnLoad = false
            this.$message.success(form.status ? '开启成功' : '关闭成功')
            this.$refs.switchForm.resetFields()
            this.$parent.getProList()
          }).catch(error => {
            this.btnLoad = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        } else {
          return false
        }
      })
    }
  }
}
</script>
