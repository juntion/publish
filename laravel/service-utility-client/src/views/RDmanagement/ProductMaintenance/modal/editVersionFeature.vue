<template>
    <div>
        <a-modal title="更改版本"
                   class="modal-pms"
                   v-model="visible"
                   :confirmLoading="btnLoad"
                   @cancel="cancel"
                   @ok="ok"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
              <a-form-model
                                :model="submitForm"
                                ref="submitForm">

                                 <a-form-model-item prop="release_type" label="发版信息" style="margin-bottom:20px" :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                        <a-radio-group v-model="submitForm.release_type">
                                            <a-radio :value="0">跟随版本发布</a-radio>
                                            <a-radio :value="1">hotfix上线</a-radio>
                                            <a-radio :value="2">无需发布</a-radio>
                                        </a-radio-group>
                                </a-form-model-item>
                                 <a-form-model-item v-show="submitForm.release_type===0" prop="release_version_id" style="margin-bottom:20px" :rules="[{ required: true,  message: '请选择', trigger: 'change' }]">
                                         <span slot="label"> 纳入版本</span>
                                         <GroupSelect mode="default" v-model="submitForm.release_version_id" ></GroupSelect>
                                </a-form-model-item>
                                <a-form-model-item v-show="submitForm.release_type===1">
                                    <p class="marginB20"  style="color:#FF4A4A"> * 可将此功能更新为Hotfix上线，将清除关联的版本信息，此操作无法撤销，谨慎操作！</p>
                                </a-form-model-item>
                                <a-form-model-item v-show="submitForm.release_type==2">
                                    <p class="marginB20"  style="color:#FF4A4A"> * 可将此功能更新为无需发布，将清除关联的版本信息，此操作无法撤销，谨慎操作！ </p>
                                </a-form-model-item>
                                 <a-form-model-item prop="release_comment" label="说明" >
                                        <a-textarea placeholder="请输入" v-model="submitForm.release_comment" :rows="4" />
                                </a-form-model-item>
              </a-form-model>
        </a-modal>
    </div>
</template>
<script>
import { bus } from '@/plugins/bus'
import GroupSelect from '@/components/GroupSelect'
import { editVersionsFeature } from '@/api/RDmanagement/ProductMaintenance/edition.js'
export default {
  components: { GroupSelect },
  data () {
    return {
      visible: false,
      btnLoad: false,
      id: undefined,
      submitForm: {
        task_type: undefined,
        release_type: undefined,
        release_version_id: undefined,
        release_comment: undefined
      }
    }
  },
  mounted () {
    bus.$on('editFeatureModalShow', data => {
      this.visible = true
      this.id = data.id
      this.submitForm.release_type = data.release_type
      this.submitForm.task_type = data.task_type
      this.$nextTick(() => {
        this.submitForm.release_version_id = data.version.id
      })
      this.submitForm.release_comment = data.release_comment
      console.log(data)
    })
  },
  beforeDestroy () {
    bus.$off('editFeatureModalShow')
  },
  methods: {
    ok () {
      this.$refs.submitForm.validate(valid => {
        if (valid) {
          this.submitForm.release_comment = this.submitForm.release_comment ? this.submitForm.release_comment : undefined
          this.btnLoad = true
          editVersionsFeature(this.id, this.submitForm).then(res => {
            this.btnLoad = false
            this.visible = false
            this.$parent.getFeaturesList(this.submitForm.release_version_id)
            this.$refs.submitForm.resetFields()
            this.$message.success('修改成功')
          }).catch(error => {
            this.btnLoad = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        } else {
          return false
        }
      })
    },
    cancel () {
      this.$refs.submitForm.resetFields()
    }

  }
}
</script>
