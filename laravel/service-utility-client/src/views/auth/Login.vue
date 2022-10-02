<template>
  <a-form :form="loginForm" @submit="loginSubmit" class="login-box">
    <a-form-item :class="{'has-value': userFlag}">
      <a-input size="large" :placeholder="$t('auth.username')" v-decorator="usernameDecorator" @focus="focusUser" @blur="blurUser">
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)"/>
      </a-input>
    </a-form-item>
    <a-form-item :class="{'has-value': psdFlag}" style="position: relative;">
      <a-input size="large" :type="psdVisible ? 'text' : 'password'" v-decorator="passwordDecorator" :placeholder="$t('auth.password')"  @focus="focusPsd" @blur="blurPsd">
        <a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)"/>
        <i slot="suffix" class="iconfont layout-eye" :class="psdVisible?'icon-eyeopen1':'icon-eyeclose'" @click="changePsdStatus"></i>
      </a-input>
    </a-form-item>
    <a-form-item v-if="showCode" :class="{'has-value': codeFlag}" class="item-code">
      <a-input size="large" v-decorator="codeDecorator" :placeholder="$t('auth.code')"  @focus="focusCode" @blur="blurCode">
        <a-icon slot="prefix" type="safety" style="color:rgba(0,0,0,.25)"/>
        <a-button slot="suffix" :disabled="sendCodeDisabled" @click="sendMail" type="link" size="small" :title="messages">{{sendCodeMsg}}</a-button>
      </a-input>
    </a-form-item>
    <a-form-item class="remember-me">
      <a-checkbox v-decorator="['remember', {initialValue: false}]">{{ $t('auth.remember') }}</a-checkbox>
      <div class="go-reset">
        <span>{{ $t('auth.resetTip') }}</span>
        <a href="javascript:;" @click="goReset">{{ $t('auth.goReset') }}</a>
      </div>
    </a-form-item>
    <a-form-item>
      <a-button
        size="large"
        html-type="submit"
        type="primary"
        :loading="loginLoading"
        block>{{ $t('auth.login') }}
      </a-button>
    </a-form-item>
  </a-form>
</template>

<script>
import { mapGetters } from 'vuex'
import Cookie from 'js-cookie'
import { sendMail } from '../../api/auth'

export default {
  data () {
    return {
      showCode: false,
      loginLoading: false,
      userFlag: false,
      psdFlag: false,
      psdVisible: false,
      codeFlag: false,
      loginForm: this.$form.createForm(this),
      rememberData: {
        username: '',
        password: ''
      },
      messages: '',
      codeCountDown: 60,
      sendCodeDisabled: true,
      sendCodeMsg: this.$t('auth.resendCode')
    }
  },
  computed: {
    ...mapGetters(['getLanguage']),
    usernameDecorator () {
      return ['username', { initialValue: this.rememberData.username, rules: [{ required: true, message: () => this.$t('auth.rules.username') }] }]
    },
    passwordDecorator () {
      return ['password', { initialValue: this.rememberData.password, rules: [{ required: true, message: () => this.$t('auth.rules.password') }] }]
    },
    codeDecorator () {
      return ['code', { rules: [{ required: true, message: () => this.$t('auth.rules.code') }] }]
    }
  },
  watch: {
    getLanguage () {
      this.loginForm.resetFields()
    }
  },
  methods: {
    async loginSubmit (e) {
      e.preventDefault()
      await this.loginForm.validateFields(async (err, values) => {
        if (err) return
        this.loginLoading = true
        let returnUrl = Cookie.get('returnUrl')
        values.remember = values.remember ? 1 : 0
        if (returnUrl && !Cookie.get('guardName')) {
          this.$message.error(this.$t('common.paramsError'))
          this.loginLoading = false
          return false
        }

        values.guard_name = returnUrl ? Cookie.get('guardName') : 'uums'
        let clientToken = Cookie.get('client_token_' + values.username.toLowerCase())
        if (clientToken !== undefined) {
          values.client_token = clientToken
        }
        let clientGroup = Cookie.get('client_group')
        if (clientGroup !== undefined) {
          values.client_group = clientGroup
        }
        await this.$store.dispatch('login', values).then(() => {
          let ticket = Cookie.get('ticket')
          Cookie.remove('ticket')
          if (returnUrl) {
            let concatStr = returnUrl.indexOf('?') > 0 ? '&' : '?'
            Cookie.remove('returnUrl')
            window.location.href = returnUrl + concatStr + 'ticket=' + ticket
          } else {
            this.loginLoading = false
            this.$router.push({ name: 'dashboard' })
          }
        }).catch(err => {
          this.loginLoading = false
          if (err.response && err.response.data.code === 423) {
            this.showCode = true
            this.beginTime()
            if (err.response.data.errors && err.response.data.errors.email) {
              this.messages = err.response.data.errors.email
            }
            // Cookie.set('showCode', true, { expires: new Date(new Date().getTime() + 10 * 60 * 1000) })
          }
          let errorMessage = err.message
          if (err.response && err.response.data.message) {
            errorMessage = err.response.data.message
          }
          this.$message.error(errorMessage)
        })
      })
    },
    goReset () {
      this.$router.push({ name: 'authSendResetEmail' })
    },
    focusUser () {
      this.userFlag = true
    },
    blurUser () {
      this.userFlag = this.loginForm.getFieldValue('username') ? 1 : 0
    },
    focusPsd () {
      this.psdFlag = true
    },
    blurPsd () {
      this.psdFlag = this.loginForm.getFieldValue('password') ? 1 : 0
    },
    focusCode () {
      this.codeFlag = true
    },
    blurCode () {
      this.codeFlag = this.loginForm.getFieldValue('code') ? 1 : 0
    },
    changePsdStatus () {
      this.psdVisible = !this.psdVisible
    },
    sendMail () {
      let params = {}
      params.username = this.loginForm.getFieldValue('username')
      this.sendCodeDisabled = true
      sendMail(params).then(data => {
        if (data.status === 'success') {
          this.$message.success(this.$t('auth.sendMailSuccess'))
          this.beginTime()
          if (this.messages === '') {
            this.messages = data.data.email
          }
        } else {
          this.$message.error(this.$t('auth.sendMailError'))
        }
      }).catch(error => {
        this.sendCodeDisabled = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    beginTime () {
      this.codeCountDown = 60
      this.sendCodeDisabled = true
      this.timer()
    },
    timer () {
      setTimeout(() => {
        this.codeCountDown--
        let msg = []
        if (this.codeCountDown < 10) {
          msg = ['0', this.codeCountDown]
        } else {
          msg = [this.codeCountDown]
        }
        this.sendCodeMsg = this.$root.$t('auth.resendTimeLeft', msg)
        if (!(this.codeCountDown > 0)) {
          this.sendCodeMsg = this.$root.$t('auth.resendCode')
          this.sendCodeDisabled = false
        } else {
          this.timer()
        }
      }, 1000)
    }
  },
  created () {
    // this.showCode = Boolean(Cookie.get('showCode'))
    this.userFlag = this.loginForm.getFieldValue('username') ? 1 : 0
    this.psdFlag = this.loginForm.getFieldValue('password') ? 1 : 0
  }
}
</script>

<style lang="less">
  .login-box {
    .ant-checkbox + span {
      color: #999;
      font-size: 12px;
    }

    .go-reset {
      float: right;
      font-size: 12px;
      color: #999;

      >a{
        color: #378eef;
      }
    }

    .ant-form-item {
      margin-bottom: 13px;
    }

    .ant-form-item:nth-of-type(2) {
      margin-bottom: 2px;
    }

    .ant-form-item.item-code {
      margin-top: 13px;
      margin-bottom: 2px;
    }

    .ant-form-item.remember-me {
      margin-bottom: 18px;
    }
  }
</style>
