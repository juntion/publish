<template>
    <div>
             <a-modal title="提示"
                   class="modal-pms"
                   v-model="visible"
                   @cancel="cancel"
                   :maskClosable="false"
                   destroyOnClose
                   width="400px">
                   <div class="confirm-info" style="line-height:57px" v-if="info.product_confirmed">
                       <p>取消已确认的标记，取消后可再次标记确认</p>
                   </div>
                    <div class="confirm-info" v-else>
                        <p>确认无误，可以发布~ </p>
                        <p v-if="info.version">此功能{{info.version.full_version}}版本中发布，预计上线时间为{{info.version.expected_release_online_time}}</p>
                        <p>如需撤销或延迟发布上线，请联系任务处理人进行更改操作</p>
                    </div>

                    <div slot="footer" class="tac">
                         <a-button @click="ok" :loading="btnLoad" type="primary">确定</a-button>
                         <a-button @click="cancel">取消</a-button>
                    </div>
             </a-modal>
    </div>
</template>

<style lang="less" scoped>
    /deep/.ant-switch-checked {
        background: #3DCCA6;
    }
    .confirm-info{
        text-align: center;
        line-height: 1;
        height: 77px;
        padding: 10px 0;
        p:nth-child(1){
            color: #666666;
            font-size: 16px;
        }
        p:nth-child(2){
            color: #F88D49;
            font-size: 12px;
            margin-top: 10px;
            margin-bottom: 4px;
        }
         p:nth-child(3){
            color: #F88D49;
            font-size: 12px;
        }
    }
</style>
<script>
import { bus } from '@/plugins/bus'
import { confirmVersions, cancelConfirmVersions } from '@/api/RDmanagement/ProductMaintenance/edition.js'
export default {
  data () {
    return {
      visible: false,
      btnLoad: false,
      id: undefined,
      info: {}
    }
  },
  mounted () {
    bus.$on('confirmModalShow', data => {
      this.info = data
      this.id = data.id
      this.visible = true
    })
  },
  beforeDestroy () {
    bus.$off('confirmModalShow')
  },
  methods: {
    cancel () {
      this.visible = false
    },
    ok () {
      this.btnLoad = true
      if (!this.info.product_confirmed) {
        confirmVersions(this.id, { task_type: this.info.task_type }).then(res => {
          this.visible = false
          this.btnLoad = false
          this.$message.success('确认成功')
          this.$parent.getFeaturesList(this.info.release_version_id)
          this.$parent.getConfirmNum()
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else {
        cancelConfirmVersions(this.id, { task_type: this.info.task_type }).then(res => {
          this.visible = false
          this.btnLoad = false
          this.$message.success('取消确认成功')
          this.$parent.getFeaturesList(this.info.release_version_id)
          this.$parent.getConfirmNum()
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    }
  }
}
</script>
