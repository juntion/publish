<template>
  <a-form :form="resetPasswordFrom" @submit="submitReset" class="psd-reset">
    <a-form-item :class="{'has-value': psdFlag}">
      <a-input type="password" size="large" :placeholder="$t('auth.newPassword')" v-decorator="passwordDecorator" @focus="focusPsd" @blur="blurPsd">
        <a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)"/>
      </a-input>
    </a-form-item>
    <a-form-item :class="{'has-value': newPsdFlag}">
      <a-input type="password" size="large" :placeholder="$t('auth.confirmPassword')" v-decorator="passwordConfirmDecorator" @focus="focusNewPsd" @blur="blurNewPsd">
        <a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)"/>
      </a-input>
    </a-form-item>
    <a-form-item>
      <a-button
        size="large"
        html-type="submit"
        type="primary"
        :loading="resetLoading"
        block>{{ $t('auth.reset') }}
      </a-button>
    </a-form-item>
  </a-form>
</template>

<script>
import _ from 'lodash'
import { passReg, setInputErrors } from '../../plugins/common'
export default {
  name: 'PasswordReset',
  data () {
    return {
      username: this.$route.query.username,
      token: this.$route.params.token,
      resetLoading: false,
      psdFlag: false,
      newPsdFlag: false,
      resetPasswordFrom: this.$form.createForm(this)
    }
  },
  computed: {
    passwordDecorator () {
      return ['password', { rules: [{ required: true, message: () => this.$t('auth.rules.password') }, {
        validator: this.handleCheckPassword
      }] }]
    },
    passwordConfirmDecorator () {
      return ['password_confirmation', {
        rules: [{
          required: true,
          message: () => this.$t('auth.rules.passwordConfirm')
        }]
      }]
    }
  },
  created () {
    if (!this.username || !this.token) {
      this.$message.error(this.$t('auth.paramsError'))
      this.$router.push({ name: 'authLogin' })
    }
  },
  methods: {
    submitReset (e) {
      e.preventDefault()
      this.resetPasswordFrom.validateFields(async (err, values) => {
        if (err) return
        this.resetLoading = true
        await this.$store.dispatch('resetPassword', {
          ...values,
          token: this.$route.params.token || '',
          username: this.$route.query.username || ''
        }).then(() => {
          this.resetLoading = false
          this.$message.success(this.$t('auth.resetPasswordSuccess'))
          this.$router.push({
            name: 'authLogin'
          })
        }).catch(err => {
          if (err.response.data.errors !== undefined) {
            setInputErrors(err, this.resetPasswordFrom)
            this.$message.error(_.values(err.response.data.errors)[0][0])
          } else {
            this.$message.error(err.response.data.message || err.message)
          }
        })
        this.resetLoading = false
      })
    },
    focusPsd () {
      this.psdFlag = true
    },
    blurPsd () {
      this.psdFlag = this.resetPasswordFrom.getFieldValue('password') ? 1 : 0
    },
    focusNewPsd () {
      this.newPsdFlag = true
    },
    blurNewPsd () {
      this.newPsdFlag = this.resetPasswordFrom.getFieldValue('password_confirmation') ? 1 : 0
    },
    handleCheckPassword (rule, value, callback) {
      if (!passReg.test(value)) {
        let err = this.$t('system.settings.passwordFormat') // 密码长度8-16位，为字母数字组成
        callback(err)
      }
      callback()
    }
  }
}
</script>

<style lang="less">
  .psd-reset {
    .ant-form-item:nth-of-type(1){
      margin-bottom: 13px;
    }

    .ant-form-item:nth-of-type(2n) {
      margin-bottom: 30px;
    }

    .ant-form-item:nth-of-type(3) {
      margin-bottom: 45px;
    }
  }
</style>
