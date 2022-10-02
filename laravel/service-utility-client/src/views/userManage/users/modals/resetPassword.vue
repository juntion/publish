<template>
    <a-modal  :title="$t('system.settings.passwordSetting')"
        v-model="resetModalShow"
        :confirmLoading="resetBtnLoading"
        @ok="resetPwd"
        >
    <a-form :form="resetForm">
        <a-form-item :label="$t('system.settings.newPassword')" v-bind="formItemLayout">
            <a-input
                    type="password"
                    :placeholder="$t('system.settings.newPasswordPlaceholder')"
                    v-decorator="['password', passwordValidate]" />
        </a-form-item>
        <a-form-item :label="$t('system.settings.confirmPassword')" v-bind="formItemLayout">
            <a-input
                    v-decorator="['password_confirmation', confirmPasswordValidate]"
                    type="password"
                    :placeholder="$t('system.settings.confirmPasswordPlaceholder')"></a-input>
        </a-form-item>
    </a-form>
    </a-modal>
</template>

<script>
import { bus } from '../../../../plugins/bus'
import { resetUserPassword } from '../../../../api/userManage'
import { passReg, setInputErrors } from '../../../../plugins/common'

export default {
  name: 'resetPassword',
  data () {
    return {
      id: 0,
      resetModalShow: false,
      resetBtnLoading: false,
      resetForm: this.$form.createForm(this),
      formItemLayout: { labelCol: { span: 6 }, wrapperCol: { span: 18 } },
      password: '',
      password_confirmation: '',
      passwordValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('system.settings.newPasswordRuleMsg') },
          { validator: this.handleCheckPassword }
        ]
      },
      confirmPasswordValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('system.settings.confirmPasswordRuleMsg') },
          { validator: this.handleCheckPasswordConfirm }
        ]
      }
    }
  },
  methods: {
    resetPwd () {
      this.resetBtnLoading = true
      this.resetForm.validateFields((err, values) => {
        if (err === null) {
          values.id = this.id
          resetUserPassword(values).then(data => {
            if (data.status === 'success') {
              this.$message.success(this.$t('system.settings.successPassword'))
              this.resetBtnLoading = false
              this.resetModalShow = false
            } else {
              this.$message.success(this.$t('system.settings.successPassword'))
            }
          }).catch(error => {
            this.resetBtnLoading = false
            setInputErrors(error, this.resetForm)
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        } else {
          this.resetBtnLoading = false
          return false
        }
      })
    },
    handleCheckPassword (rule, value, callback) {
      if (!passReg.test(value)) {
        let err = this.$t('system.settings.passwordFormat') // 密码长度8-16位，为字母数字组成
        callback(err)
      }
      callback()
    },
    handleCheckPasswordConfirm (rule, value, callback) {
      const form = this.resetForm
      if (value !== form.getFieldValue('password')) {
        let err = this.$t('system.settings.differentPassword') // 两次输入密码不一致
        callback(err)
      } else {
        callback()
      }
    }
  },
  mounted () {
    bus.$on('showRestPasswordModal', (id) => {
      this.id = id
      this.resetModalShow = true
      this.resetForm.resetFields()
    })
  }
}
</script>

<style scoped>

</style>
