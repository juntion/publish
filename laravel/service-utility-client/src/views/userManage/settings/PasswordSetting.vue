<template>
  <div style="padding-right: 90px;">
    <div class="setting-title">{{ $t('system.settings.passwordSettingTitle') }}</div>
    <a-form style="width: 100%;" @submit="handleSubmit" :form="form" class="password-setting">
      <a-form-item v-bind="formItemLayout" style="margin-bottom: 29px;position: relative;">
        <p class="p-title must" style="margin-bottom: 4px;">{{ $t('system.settings.oldPassword') }}</p>
        <a-input
          class="p-input fontS12"
          :type="psd ? 'text' : 'password'"
          :placeholder="$t('system.settings.oldPasswordPlaceholder')"
          v-decorator="[
            'password_old',
            {validateTrigger: ['submit'],rules: [{ required: true, message: $t('system.settings.oldPasswordRuleMsg') },{
              validator: 'passRegCheck'
            }]}
          ]">
          <i slot="suffix" class="iconfont setting-eye" :class="psd?'icon-eyeopen1':'icon-eyeclose'" @click="changePsdStatus"></i>
          </a-input>
      </a-form-item>
      <a-form-item v-bind="formItemLayout" style="margin-bottom: 29px;">
        <p class="p-title must" style="margin-bottom: 4px;">{{ $t('system.settings.newPassword') }}</p>
        <a-input
          class="p-input fontS12"
          :type="psd_new ? 'text' : 'password'"
          :placeholder="$t('system.settings.newPasswordPlaceholder')"
          v-decorator="[
            'password',
            {validateTrigger: ['submit'],rules: [{ required: true, message: $t('system.settings.newPasswordRuleMsg')},{validator: handleCheckPassword}]}
          ]">
          <i slot="suffix" class="iconfont setting-eye" :class="psd_new?'icon-eyeopen1':'icon-eyeclose'" @click="changePsdStatus_new"></i>
          </a-input>
      </a-form-item>
      <a-form-item v-bind="formItemLayout" style="margin-bottom: 29px;">
        <p class="p-title must" style="margin-bottom: 4px;">{{ $t('system.settings.confirmPassword') }}</p>
        <a-input
          class="p-input fontS12"
          :type="psd_sure ? 'text' : 'password'"
          v-decorator="[
            'password_confirmation',
            {validateTrigger: ['submit'],rules: [{ required: true, message: $t('system.settings.confirmPasswordRuleMsg')},{validator: handleCheckPasswordConfirm}]}
          ]"
          :placeholder="$t('system.settings.confirmPasswordPlaceholder')">
          <i slot="suffix" class="iconfont setting-eye" :class="psd_sure?'icon-eyeopen1':'icon-eyeclose'" @click="changePsdStatus_sure"></i>
          </a-input>
      </a-form-item>
      <a-form-item>
        <a-button type="primary" class="p-btn" htmlType="submit" :loading="loading" style="display: block">{{ $t('system.settings.submit') }}</a-button>
      </a-form-item>
    </a-form>
  </div>
</template>

<script>
import { settingPassword } from '../../../api/system/setting'
import { setInputErrors, passReg } from '../../../plugins/common'

export default {
  name: 'PasswordSetting',
  data () {
    return {
      formItemLayout: { labelCol: { span: 6 }, wrapperCol: { span: 18 } },
      password_old: '',
      password: '',
      password_confirmation: '',
      form: this.$form.createForm(this),
      loading: false,
      psd: false,
      psd_new: false,
      psd_sure: false
    }
  },
  methods: {
    handleSubmit (e) {
      e.preventDefault()
      this.form.validateFields(async (err, values) => {
        if (err) return
        this.loading = true
        await settingPassword(values).then(() => {
          this.$message.success(this.$t('system.settings.successPassword'))
          this.$store.dispatch('logout')
        }).catch(error => {
          setInputErrors(error, this.form)
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
        this.loading = false
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
      const form = this.form
      if (value !== form.getFieldValue('password')) {
        let err = this.$t('system.settings.differentPassword') // 两次输入密码不一致
        callback(err)
      } else {
        callback()
      }
    },
    changePsdStatus () {
      this.psd = !this.psd
    },
    changePsdStatus_new () {
      this.psd_new = !this.psd_new
    },
    changePsdStatus_sure () {
      this.psd_sure = !this.psd_sure
    }
  }
}
</script>

<style lang="less" scoped>
  .setting-eye {
    right: 20px;
    font-size: 12px;
    line-height: 19px !important;
    cursor: pointer;
    margin-right: -2px;
  }

  .setting-eye.icon-eyeclose {
    transform: scale(0.67511);
    margin-right: -6px;
    display: block;
  }
</style>

<style lang="less">
  .password-setting {

    .ant-form-explain {
      top: 50px;
    }
  }
</style>
