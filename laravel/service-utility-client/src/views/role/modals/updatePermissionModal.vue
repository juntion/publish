<template>
    <a-modal :title="$t('role.permission.updateTitle')"
             v-model="updatePermissionModalShow"
             :confirmLoading="updatePermissionBtnLoading"
             @ok="updatePermissionData">
        <a-form :form="updatePermissionForm">
            <a-form-item :label="$t('common.comment')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-textarea
                        v-decorator="['comment', commentValidate]"
                ></a-textarea>
            </a-form-item>
            <a-divider >{{$t('common.languages')}}</a-divider>
            <a-form-item
                    v-for="(item, key) in languages"
                    :key="key"
                    :label="item"
                    :label-col="{ span: 4 }"
                    :wrapper-col="{ span: 18 }">
                <a-input
                        v-decorator="[key, {
                        initialValue: JSON.parse(getCurrentPermissionData.locale)[key],
                        validateTrigger: ['submit'],
                        rules: [
                        { required: true, message: $t('common.langRequire') }]
                      }]"
                />
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import { bus } from '../../../plugins/bus'
import { languages } from '../../../plugins/lang'
import Vue from 'vue'
import { updatePermission } from '../../../api/role'
import { mapGetters } from 'vuex'

export default {
  name: 'updatePermissionModal',
  data () {
    return {
      updatePermissionModalShow: false,
      updatePermissionBtnLoading: false,
      updatePermissionForm: this.$form.createForm(this),
      commentValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('role.permission.commentRequire') }]
      },
      languages: languages
    }
  },
  methods: {
    updatePermissionData () {
      this.updatePermissionBtnLoading = true
      this.updatePermissionForm.validateFields((err, values) => {
        if (err === null) {
          let params = {
            id: this.getCurrentPermissionData.id,
            comment: values.comment
          }
          let langArr = {}
          for (let item in languages) {
            Vue.set(langArr, item, values[item])
          }
          params.locale = JSON.stringify(langArr)
          updatePermission(params).then(data => {
            this.updatePermissionBtnLoading = false
            if (data.status === 'success') {
              this.updatePermissionModalShow = false
              this.$message.success(this.$t('role.permission.updatePermissionSuccess'))
              this.$store.dispatch('fetchPermissionsList')
            } else {
              this.$message.error(this.$t('role.permission.updatePermissionError'))
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
            this.updatePermissionBtnLoading = false
          })
        } else {
          this.updatePermissionBtnLoading = false
          return false
        }
      })
    }
  },
  mounted () {
    bus.$on('showUpdatePermissionModal', data => {
      this.commentValidate.initialValue = this.getCurrentPermissionData.comment
      this.updatePermissionForm.resetFields()
      this.updatePermissionModalShow = true
    })
  },
  computed: {
    ...mapGetters(['getCurrentPermissionData'])
  }
}
</script>

<style scoped>

</style>
