<template>
  <div class="setsubsidiaryCompany">
<a-modal
            :title="$t('user.modal.setSubsidiaryCompany')"
            v-model="setSubsidiaryCompanyModalShow"
            :confirmLoading="setSubsidiaryCompanyBtnLoading"
            @ok="setSubsidiaryCompany"
    >
        <a-form :form="setSubsidiaryCompanyForm">
            <a-form-item :label="$t('user.modal.subsidiaryCompany')"
                         :label-col="{ span: 6 }"
                         :wrapper-col="{ span: 16 }">
                <a-select
                        showSearch
                        :placeholder="$t('user.modal.subsidiaryCompany')"
                        v-decorator="['company_id' , subsidiaryCompanyFormValidate]"
                        allowClear
                        optionFilterProp="children"
                        @change="positionChange"
                >
                    <a-select-option v-for="(item, key) in getSubsidiaryCompanies" :key="key" :value="item.id">{{item.company_name}}</a-select-option>
                </a-select>
            </a-form-item>
        </a-form>
    </a-modal>
  </div>

</template>

<script>
import { setSubsidiaryCompanies } from '../../../../api/userManage'
import Vue from 'vue'
import { bus } from '../../../../plugins/bus'
import { mapGetters } from 'vuex'
import { setInputErrors } from '../../../../plugins/common'

export default {
  data () {
    return {
      showLanguage: false,
      setSubsidiaryCompanyForm: this.$form.createForm(this),
      setSubsidiaryCompanyModalShow: false,
      setSubsidiaryCompanyBtnLoading: false,
      subsidiaryCompanyFormValidate: {
        validateTrigger: ['submit'],
        initialValue: '',
        rules: [
          { required: true, message: () => this.$t('user.modal.selectSbusidiaryCompany') }]
      }
    }
  },
  methods: {
    // 设置所属子公司
    setSubsidiaryCompany () {
      this.setSubsidiaryCompanyForm.validateFields((err, value) => {
        if (err === null) {
          let params = {}
          this.setSubsidiaryCompanyBtnLoading = true
          if (this.getIsGroupSet) {
            params = value
            params.groupSet = true
            params.company_id = this.setSubsidiaryCompanyForm.getFieldValue('company_id')
            params.user_ids = this.getSelectRows
          } else {
            params.groupSet = false
            params.company_id = this.setSubsidiaryCompanyForm.getFieldValue('company_id')
            params.id = this.getCurrentUser.id
          }
          setSubsidiaryCompanies(params).then(data => {
            if (data.status === 'success') {
              this.$message.success(this.$t('user.modal.setSubsidiaryCompanySuccess'))
              this.$store.dispatch('getUser')
              this.setSubsidiaryCompanyModalShow = false
              this.$store.commit('SET_SELECT_ROWS', [])
            } else {
              this.$message.error(this.$t('user.modal.setSubsidiaryCompanyError'))
            }
            this.setSubsidiaryCompanyBtnLoading = false
          }).catch(error => {
            setInputErrors(error, this.setSubsidiaryCompanyForm)
            this.$message.error(error.response ? error.response.data.message : error.message)
            this.setSubsidiaryCompanyBtnLoading = false
          })
        } else {
          return false
        }
      })
    },
    positionChange (value) {
      if (value > 0) {
        Vue.set(this.subsidiaryCompanyFormValidate, 'initialValue', value)
      }
    }
  },
  computed: {
    ...mapGetters(['getAllOptions', 'getSelectRows', 'getIsGroupSet', 'getCurrentUser', 'getLanguage', 'getSubsidiaryCompanies'])
  },
  mounted () {
    bus.$on('showSubsidiaryCompany', (data) => {
      if (this.getIsGroupSet || data) {
        Vue.set(this.subsidiaryCompanyFormValidate, 'initialValue', '')
        this.setSubsidiaryCompanyForm.resetFields()
      } else {
        let defaultDepart = this.getCurrentUser.company !== null ? this.getCurrentUser.company.company_name : ''
        Vue.set(this.subsidiaryCompanyFormValidate, 'initialValue', defaultDepart)
        this.setSubsidiaryCompanyForm.resetFields()
      }
      this.setSubsidiaryCompanyModalShow = true
    })
  }
}
</script>

<style scoped>

</style>
