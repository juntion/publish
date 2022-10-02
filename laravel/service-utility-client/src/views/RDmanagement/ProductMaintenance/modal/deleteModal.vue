<template>
    <div>
             <a-modal title="提示"
                   class="modal-pms"
                   v-model="visible"
                   @cancel="cancel"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                    <div class="del-info">
                        <p>
                           <span v-if="type==='product'">确认将{{info.name}}及其所有版本号信息</span>
                           <span v-else>确认将{{info.full_version}}版本号信息</span>
                        <span class="del-word"> 删除 </span>吗?</p>
                        <p> 删除后不可恢复，请谨慎操作</p>
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
    .del-info{
        text-align: center;
        line-height: 1;
        padding: 18px 0;
        .del-word{
            color: #FF4A4A;
        }
        p:nth-child(1){
            color: #666666;
            font-size: 16px;
            margin-bottom: 10px;
        }
        p:nth-child(2){
            color: #F88D49;
            font-size: 12px;
        }
    }
</style>
<script>
import { bus } from '@/plugins/bus'
import { delPublishingProducts, delVersions } from '@/api/RDmanagement/ProductMaintenance/edition.js'
export default {
  data () {
    return {
      visible: false,
      btnLoad: false,
      id: undefined,
      type: undefined,
      info: {}
    }
  },
  mounted () {
    bus.$on('delPublishingModalShow', data => {
      this.info = data
      this.type = data.type
      this.id = data.id
      this.visible = true
    })
  },
  beforeDestroy () {
    bus.$off('delPublishingModalShow')
  },
  methods: {
    cancel () {
      this.visible = false
    },
    ok () {
      this.btnLoad = true
      if (this.type === 'product') {
        delPublishingProducts(this.id).then(res => {
          this.visible = false
          this.btnLoad = false
          this.$message.success('删除成功')
          this.$parent.getProList()
          this.$parent.getConfirmNum()
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else {
        delVersions(this.id).then(res => {
          this.visible = false
          this.btnLoad = false
          this.$message.success('删除成功')
          this.$parent.getVersionsList(this.info.release_product_id)
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    }
  }
}
</script>
