<template>
    <a-modal :title="$t('system.settings.verificationCodeTitle')"
             v-model="isShow"
             :confirmLoading="setMailBtnLoading"
             @ok="setMail"
             width="380px"
             class="p-modal"
    >
        <div class="p-tip no-btn marginB18">{{ $t('system.settings.verificationCodeTips') }}</div>
        <a-form :form="form">
            <a-form-item v-bind="formItemLayout" style="margin-bottom: 0;">
                <p class="p-title must">{{ $t('system.settings.verificationCode') }}</p>
                <a-input
                        class="p-input-1"
                        :placeholder="$t('system.settings.emailPlaceholder')"
                        v-decorator="['code_email',emailValidate]">
                </a-input>
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import { bus } from '../../../../plugins/bus'
import { mapGetters } from 'vuex'
import { setCodeEmail } from '../../../../api/system/setting'
import { setInputErrors } from '../../../../plugins/common'

export default {
  name: 'setMailModal',
  data () {
    return {
      isShow: false,
      setMailBtnLoading: false,
      form: this.$form.createForm(this),
      emailValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: this.$t('system.settings.emailRuleMsg') },
          { validator: this.handleCheckEmail }
        ]
      },
      formItemLayout: { labelCol: { span: 5 }, wrapperCol: { span: 16 } }
    }
  },
  methods: {
    setMail () {
      this.form.validateFields((err, values) => {
        if (err) return false
        this.setMailBtnLoading = true
        setCodeEmail(values).then(data => {
          if (data.status === 'success') {
            this.$store.dispatch('refresh')
            this.$message.success(this.$t('system.settings.setCodeEmailSuccess'))
            this.isShow = false
          } else {
            this.$message.success(this.$t('system.settings.setCodeEmailFailed'))
          }
          this.$store.dispatch('refresh')
        }).catch(error => {
          setInputErrors(error, this.form)
          this.$message.error(error.response ? error.response.data.message : error.message)
        }).finally(data => {
          this.setMailBtnLoading = false
        })
      })
    },
    handleCheckEmail (rule, value, callback) {
      if (value.indexOf('@feisu.com') === -1) {
        let err = this.$t('system.settings.EmailError') // 两次输入密码不一致
        callback(err)
      } else {
        callback()
      }
    }
  },
  mounted () {
    bus.$on('SetMailModalShow', (data) => {
      this.isShow = true
      this.emailValidate.initialValue = this.getAuthUser.code_email
      this.form.resetFields()
    })
  },
  computed: {
    ...mapGetters(['getAuthUser'])
  }
}
</script>

<style lang="less">
  .p-modal {
    padding-bottom: 1px;
    top: 35%;

    .ant-modal-header {
      padding: 13px 54px 13px 20px;
      color: #666;
    }

    .ant-modal-title {
      color: #666;
      font-weight: 600;
    }

    .ant-modal-close {
      width: 48px;
      height: 48px;

      .ant-modal-close-x {
        width: 100%;
        height: 100%;
        line-height: 48px;
        font-size: 18px;
      }
    }

    .ant-modal-body {
      padding: 20px 20px 0;
    }

    .ant-modal-footer {
      border-top: 0;
      padding: 20px;
      text-align: left;

      .ant-btn-primary {
        float: left;
        margin-left: 0;
        margin-right: 10px;
        background-color: #378eef;
        text-align: center;
        line-height: 32px;
        padding-left: 20px;
        padding-right: 20px;
        border: 0;
        border-radius: 3px;
        color: #fff;
        height: 32px;
      }

      .ant-btn-primary:hover {
        opacity: 0.9;
        background-color: #378eef;
      }

      .ant-btn-default {
        height: 34px;
        padding-left: 20px;
        padding-right: 20px;
        border-color: #ccc;
        border-radius: 3px;
        color: #666;
      }

      .ant-btn-default:hover {
        opacity: 0.9;
        color: #666;
      }
    }

    .ant-form-item-control-wrapper {
      width: 100%;
    }
  }
</style>
