<template>
  <div class="base-setting">
    <div class="setting-title">{{ $t('system.settings.baseSettingTitle') }}</div>
    <a-form style="width: calc(100% - 90px)" @submit="handleSubmit" :form="form">
      <a-form-item v-bind="formItemLayout" style="width: 100%; margin-bottom: 30px;">
        <p class="p-title disabled">{{ $t('system.settings.name') }}</p>
        <a-input class="p-input" :disabled="true" :placeholder="$t('system.settings.namePlaceholder')" v-model="name"></a-input>
      </a-form-item>
      <a-form-item v-bind="formItemLayout" style=" margin-bottom: 30px">
        <div class="p-title must">
          {{ $t('system.settings.email') }}
          <div class="fr p-a p-tip-b" @click="showSetEmailModal">
            <i class="p-icon-email fl" style="margin-right: 5px"></i>
            {{$t('system.settings.verificationCodeTitle')}}
            <div class="p-tip-1 right-b">
              <div class="arrow iconfont icon-sanjiao"></div>
              <div class="tip-box pd20" style="white-space: nowrap;" v-if="email">
                <div style="padding-bottom: 8px;border-bottom: 1px solid #efefef;">
                  {{ $t('system.settings.emailTipExist') }}
                </div>
                <div style="padding-top: 9px;">
                  <div class="p-title" style="color: #bbb;margin-bottom: 3px;">{{ $t('system.settings.emailTipExistTit') }}</div>
                  <div>{{ email }}</div>
                </div>
              </div>
              <div class="tip-box pd20"  style="width: 190px;" v-else>
                {{ $t('system.settings.emailTipNull') }}
              </div>
            </div>
          </div>
        </div>
        <a-input
                class="p-input"
                :placeholder="$t('system.settings.emailPlaceholder')"
                v-decorator="[
          'email',
          {
            validateTrigger: ['submit'],
            initialValue: this.getAuthUser.email,
            rules: [{ required: true, message: $t('system.settings.emailRuleMsg')}]
          }
        ]">
        </a-input>
      </a-form-item>
      <!-- 新增电话 -->
      <a-form-item v-bind="formItemLayout" style=" margin-bottom: 30px">
        <p class="p-title">{{ $t('system.settings.phone') }}</p>
        <a-input
                class="p-input ant-input"
                :placeholder="$t('system.settings.phonePlaceholder')"
                v-decorator="[
          'phone',
          {
            validateTrigger: ['submit'],
            initialValue: this.getAuthUser.admin_telephone,
            rules: [{ required: false, message: $t('system.settings.phoneRuleMsg')},{validator: this.phoneRule.bind(this)}]
          }
        ]">
        </a-input>
      </a-form-item>
      <a-form-item>
        <a-button type="primary" htmlType="submit" :loading="loading" class="p-btn" style="display: block;">{{ $t('system.settings.submit') }}</a-button>
      </a-form-item>
    </a-form>
    <SetEmailModal></SetEmailModal>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { settingBasicData } from '../../../api/system/setting'
import { setInputErrors } from '../../../plugins/common'
import { bus } from '../../../plugins/bus'
import SetEmailModal from './modal/setMailModal'

export default {
  name: 'BaseSetting',
  components: { SetEmailModal },
  data () {
    return {
      formItemLayout: { labelCol: { span: 3 }, wrapperCol: { span: 21 } },
      name: '',
      form: this.$form.createForm(this),
      loading: false,
      email: '',
      phone: ''
    }
  },
  created () {
    this.gender = this.getAuthUser.gender
    this.position = this.getAuthUser.position
    this.name = this.getAuthUser.name
    this.email = this.getAuthUser.code_email
    this.phone = this.getAuthUser.admin_telephone
  },
  computed: {
    ...mapGetters(['getAuthUser'])
  },
  methods: {
    // 新增电话验证
    phoneRule (rule, value, callback) {
      const regPhone = /^\d*$/
      if (!regPhone.test(value)) {
        // eslint-disable-next-line standard/no-callback-literal
        callback('仅输入数字')
        // eslint-disable-next-line no-useless-return
        return
      } else {
        this.phone = value
      }
      callback()
    },
    handleSubmit (e) {
      e.preventDefault()
      this.form.validateFields(async (err, values) => {
        if (err) return
        this.loading = true
        let params = {
          email: values.email,
          name: this.name,
          admin_telephone: this.phone
        }
        await settingBasicData(params).then(() => {
          this.$message.success(this.$t('notify.editSuccess'))
          this.$store.dispatch('baseSettingSuccess', params) // todo 重新再获取一次用户信息储存
        }).catch(error => {
          setInputErrors(error, this.form)
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
        this.loading = false
      })
    },
    showSetEmailModal () {
      bus.$emit('SetMailModalShow')
    }
  }
}
</script>

<style lang="less" scoped>
  .p-title {
    margin-bottom: 10px;
  }

</style>

<style lang="less">
    .p-input{
        padding-left: 10px;
    }
    .base-setting {

    .ant-form-explain {
      top: 45px;
    }
    .has-error .ant-input:focus{
      box-shadow: none;
    }
  }
</style>
