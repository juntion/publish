<template>
    <div>
        <a-modal title="更改版本信息"
                   class="modal-pms"
                   v-model="visible"
                   okText="提交"
                   @ok="ok"
                   :confirmLoading="btnLoad"
                   :maskClosable="false"
                   destroyOnClose
                   width="700px">
                   <div class="tips-box" v-if="tipsShow">
                      检测到此需求关联的产品绑定了多个发版产品，请注意存在同时发版，保持充足沟通！
                       <span class="iconfont fz12" @click="closeTips">&#xe631;</span>
                   </div>
                <a-form-model
                                :model="submitForm"
                                ref="submitForm">

                         <a-row class="marginB20">
                                <a-col :lg="12"
                                    :md="12"
                                    :sm="12"
                                    style="padding-right: 20px"
                                    >
                                    <a-form-model-item prop="release_type" label="发版信息"  :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                        <a-radio-group v-model="submitForm.release_type">
                                            <a-radio :value="0">跟随版本发布</a-radio>
                                            <a-radio :value="1">hotfix上线</a-radio>
                                            <a-radio :value="2">无需发布</a-radio>
                                        </a-radio-group>
                                </a-form-model-item>
                                </a-col>
                            </a-row>

                        <div v-if="submitForm.release_type===0 ">
                            <a-row class="marginB20">
                                <a-col :lg="12"
                                    :md="12"
                                    :sm="24"
                                    style="padding-right: 20px"
                                    >
                                    <a-form-model-item prop="branch_name" label="分支名" :rules="[{ required: true, message: '请输入', trigger: 'blur' }]">
                                            <a-input placeholder="请输入" v-model="submitForm.branch_name" />
                                    </a-form-model-item>
                                </a-col>
                                <a-col :lg="12"
                                    :md="12"
                                    :sm="24"
                                    >

                                    <a-form-model-item prop="release_version_id" label="纳入版本" :rules="[{ required: true,  message: '请选择', trigger: 'change' }]">
                                                 <GroupSelect mode="default" v-model="submitForm.release_version_id" ></GroupSelect>
                                    </a-form-model-item>
                                </a-col>
                            </a-row>
                            <a-row class="marginB20">
                                <a-col :lg="12"
                                    :md="12"
                                    :sm="24"
                                    style="padding-right: 20px"
                                    >
                                    <a-form-model-item prop="has_sql" label="SQL" :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                            <a-select  placeholder="请选择" v-model="submitForm.has_sql">
                                                <a-select-option :value="1">有 </a-select-option>
                                                <a-select-option :value="0">无 </a-select-option>
                                            </a-select>
                                    </a-form-model-item>
                                </a-col>
                                <a-col :lg="12"
                                    :md="12"
                                    :sm="24"
                                    >
                                    <a-form-model-item prop="stress_test" label="压力测试" :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                            <a-select v-model="submitForm.stress_test" placeholder="请选择">
                                                <a-select-option :value="1">需要 </a-select-option>
                                                <a-select-option :value="0">不需要 </a-select-option>
                                            </a-select>
                                    </a-form-model-item>
                                </a-col>
                            </a-row>
                        </div>
                        <a-form-model-item prop="release_comment" label="说明" >
                                        <a-textarea placeholder="请输入" v-model="submitForm.release_comment" :rows="4" />
                        </a-form-model-item>

             </a-form-model>
             </a-modal>
    </div>
</template>
<style lang="less" scoped>
    .tips-box{
        position: relative;
        width: 500px;
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
</style>
<script>
import { bus } from '@/plugins/bus'
import GroupSelect from '@/components/GroupSelect'
import { devEditVersions, designEditVersions } from '@/api/RDmanagement/ProductMaintenance/edition.js'
export default {
  components: { GroupSelect },
  data () {
    return {
      visible: false,
      btnLoad: false,
      tipsShow: true,
      taskId: undefined,
      submitForm: {
        release_type: undefined,
        branch_name: undefined,
        has_sql: undefined,
        release_version_id: undefined,
        stress_test: 0,
        release_comment: undefined
      }
    }
  },
  props: {
    type: {
      type: String
    }
  },
  mounted () {
    bus.$on('editVersionModalShow', data => {
      this.taskId = data.id
      this.submitForm.release_type = data.release_type
      if (data.release_type === 0) {
        this.submitForm.branch_name = data.branch_name
        this.submitForm.has_sql = data.has_sql
        this.submitForm.stress_test = data.stress_test
        this.$nextTick(() => {
          this.submitForm.release_version_id = data.release_version_id
        })
      }
      this.submitForm.release_comment = data.release_comment || undefined

      this.tipsShow = true
      this.visible = true
    })
  },
  beforeDestroy () {
    bus.$off('editVersionModalShow')
  },
  methods: {
    closeTips () {
      this.tipsShow = false
    },
    ok () {
      this.$refs.submitForm.validate(valid => {
        if (valid) {
          this.btnLoad = true
          if (this.type === 'dev') {
            devEditVersions(this.taskId, this.submitForm).then(res => {
              this.visible = false
              this.btnLoad = false
              this.$message.success('更改成功')
              this.$parent.taskDetails = false
              this.$parent.getTaskAll()
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else {
            designEditVersions(this.taskId, this.submitForm).then(res => {
              this.visible = false
              this.btnLoad = false
              this.$message.success('更改成功')
              this.$parent.taskDetails = false
              this.$parent.getTaskAll()
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          }
        } else {
          return false
        }
      })
    }
  }

}
</script>
