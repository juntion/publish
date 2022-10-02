<template>
  <a-form :form="sendResetMailForm" @submit="sendMailSubmit" class="send-reset">
    <a-form-item class="reset-tit">{{ $t('auth.resetPassword') }}</a-form-item>
    <a-form-item :class="{'has-value': sendFlag}">
      <a-input size="large" :placeholder="$t('auth.username')" v-decorator="emailDecorator" @focus="focusSend" @blur="blurSend">
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)"/>
      </a-input>
    </a-form-item>
    <a-form-item>
      <a-button
        size="large"
        html-type="submit"
        type="primary"
        :loading="mailLoading"
        :disabled="isMailSend"
        block>{{ $t('auth.reset') }}
      </a-button>
    </a-form-item>
  </a-form>
</template>

<script>
import _ from 'lodash'
import { setInputErrors } from '../../plugins/common'
export default {
  name: 'ResetMail',
  data () {
    return {
      mailLoading: false,
      isMailSend: false,
      sendFlag: false,
      sendResetMailForm: this.$form.createForm(this)
    }
  },
  computed: {
    emailDecorator () {
      return ['username', { rules: [{ required: true, message: () => this.$t('auth.rules.username') }] }]
    }
  },
  methods: {
    sendMailSubmit (e) {
      e.preventDefault()
      this.sendResetMailForm.validateFields((err, values) => {
        if (err) return
        this.mailLoading = true
        this.$store.dispatch('sendResetEmail', values).then(() => {
          this.isMailSend = true
          this.mailLoading = false
          this.$message.success(this.$t('auth.sendMailSuccess'))
        }).catch(err => {
          if (err.response.data.errors !== undefined) {
            setInputErrors(err, this.sendResetMailForm)
            this.$message.error(_.values(err.response.data.errors)[0][0])
          } else {
            this.$message.error(err.response.data.message || err.message)
          }
          this.mailLoading = false
        })
      })
    },
    focusSend () {
      this.sendFlag = true
    },
    blurSend () {
      this.sendFlag = this.sendResetMailForm.getFieldValue('username') ? 1 : 0
    }
  }
}
</script>

<style lang="less">
  .send-reset {
    position: relative;
    padding-top: 24px;

    .ant-form-item {
      margin-bottom: 30px;
    }

    .ant-form-item:nth-of-type(3) {
      margin-bottom: 45px;
    }

    .reset-tit {
      width: 100%;
      position: absolute;
      text-align: center;
      top: -40px;
      font-size: 18px;
      color: #666;
      font-weight: 600;
    }
  }
</style>
