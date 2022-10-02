<template>
    <div>
             <a-modal
                   :title="releaseType === 'online'? '发布上线' : '发布测试'"
                   class="modal-pms"
                   v-model="visible"
                   @cancel="cancel"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                   <div>
                     <div v-if="releaseType === 'test'">
                       <div class="tips-box" v-if="tipsShow">
                         <span>
                          注意：所有功能均满足发布测试条件，确认后该版本状态将变为“版本测试中”，关联需求将批量更新测试。不可撤销，谨慎操作！
                         </span>
                         <span class="iconfont fz12" @click="closeTips">&#xe631;</span>
                       </div>
                     </div>
                     <div v-else-if="releaseType === 'online'">
                       <div class="tips-box" v-if="tipsShow">
                         <span>
                          注意：所有功能均满足发布上线条件，确认后该版本状态将变为“已发布上线”，关联需求将批量验收完成。不可撤销，谨慎操作！
                         </span>
                         <span class="iconfont fz12" @click="closeTips">&#xe631;</span>
                       </div>
                     </div>
                     <div v-else>
                       <span>
                        <div class="modal-tip">确认将“<span style="color: #3DCCA6;">{{ taskName }}</span>”发布至测试站吗？</div>
                       </span>
                     </div>
                   </div>
                    <a-form-model :model="form" v-if="releaseType === 'online' || releaseType === 'test'">
                         <a-form-model-item  label="备注" >
                            <a-textarea placeholder="请输入备注" v-model="form.comment" :rows="4" />
                         </a-form-model-item>
                    </a-form-model>
                    <div slot="footer" class="tac">
                         <a-button @click="ok" :loading="btnLoad" type="primary">确定</a-button>
                         <a-button @click="cancel">取消</a-button>
                    </div>
             </a-modal>

             <a-modal title="提示"
                   class="modal-pms"
                   v-model="visible2"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                   <div class="release-success-info" v-if="releaseType === 'online'">
                        <p>版本号{{successInfo.version}}已成功发布上线 </p>
                        <p>共{{successInfo.demands.length}}条需求完成验收~</p>
                    </div>
                   <div class="release-success-info" v-else-if="releaseType === 'test'">
                       <p>{{testSuccessInfo}}</p>
                       <p>如需修改，可点击页面版本号进行编辑等操作~</p>
                   </div>
                   <div v-else class="release-feature">版本功能点发布测试成功~</div>
                    <div slot="footer" class="tac">
                         <a-button @click="ok2" type="primary">确定</a-button>
                    </div>
             </a-modal>
    </div>
</template>

<style lang="less" scoped>
    .tips-box{
        position: relative;
        width: 340px;
        background: #FFF2EA;
        color: #F88D49;
        padding:8px 30px 10px 10px;
        border: 1px solid #FFD8BF;
        border-radius: 5px;
        margin-bottom: 20px;
        & >.iconfont{
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    }
    .tips-text{
        line-height: 1;
    }
    .release-success-info{
        text-align: center;
        line-height: 1;
        padding: 20px 0;
        p:nth-child(1){
            color: #666666;
            font-size: 16px;
        }
        p:nth-child(2){
            color: #F88D49;
            font-size: 12px;
            margin-top: 10px;
        }

    }
    .modal-tip {
      text-align: center;
      font-size: 16px;
      line-height: 24px;
      padding: 10px 20px;
    }
    .release-feature {
      font-size: 16px;
      text-align: center;
      padding: 20px 0;
    }
</style>
<script>
import { bus } from '@/plugins/bus'
import { testVersions, onlineVersions, testVersionsFeature } from '@/api/RDmanagement/ProductMaintenance/edition.js'
export default {
  data () {
    return {
      visible: false,
      visible2: false,
      btnLoad: false,
      id: undefined,
      info: {},
      tipsShow: true,
      testSuccessInfo: '',
      taskName: '',
      successInfo: {
        demands: []
      },
      form: {
        is_confirmed: 1,
        comment: undefined
      }
    }
  },
  watch: {

  },
  props: {
    releaseType: {
      type: String
    }
  },
  mounted () {
    bus.$on('releaseModalShow', data => {
      this.id = data.id
      this.info = data
      this.tipsShow = true
      this.visible = true
      this.taskName = (data.demand ? (data.demand.name ? data.demand.name : '') : '') + (data.task_title ? data.task_title : '')
    })
  },
  beforeDestroy () {
    bus.$off('releaseModalShow')
  },
  methods: {
    cancel () {
      this.visible = false
      this.form.comment = undefined
    },
    ok () {
      this.btnLoad = true
      if (this.releaseType === 'test') {
        testVersions(this.id, this.form).then(res => {
          this.btnLoad = false
          this.visible = false
          this.form.comment = undefined
          this.visible2 = true
          this.testSuccessInfo = res.message
          this.$parent.getFeaturesList(this.id)
          this.$parent.getVersionsList(this.info.release_product_id)
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (this.releaseType === 'online') {
        onlineVersions(this.id, this.form).then(res => {
          this.btnLoad = false
          this.visible = false
          this.form.comment = undefined
          this.visible2 = true
          this.successInfo = res.data
          this.$parent.getFeaturesList(this.id)
          this.$parent.getVersionsList(this.info.release_product_id)
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else {
        this.$delete(this.form, 'comment')
        this.$set(this.form, 'task_type', this.releaseType)
        testVersionsFeature(this.id, this.form).then(res => {
          this.btnLoad = false
          this.visible = false
          this.visible2 = true
          this.successInfo = res.data
          this.$parent.getFeaturesList(this.info.version.id)
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    },
    ok2 () {
      this.visible2 = false
    },
    closeTips () {
      this.tipsShow = false
    }
  }
}
</script>
