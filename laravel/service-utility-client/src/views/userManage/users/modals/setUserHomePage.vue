<template>
    <a-modal :title="$t('user.modal.setUserHomePage')"
             v-model="SetHomePageModalShow"
             :confirmLoading="SetHomePageBtnLoading"
             @ok="SetHomePage">
        <a-form
            :form="SetHomePageForm">
            <a-form-item :label="$t('user.modal.sub')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-select
                        showSearch
                        v-decorator="['subsystem', subsValidate]"
                        allowClear
                        @change="changeTemplates"
                >
                    <a-select-option
                            v-for="(item, key) in getSubsData"
                            :key="key"
                            :value="item.guard_name">
                        {{JSON.parse(item.locale)[getLanguage]}}
                    </a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item :label="$t('user.modal.homePage')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-select
                        showSearch
                        :placeholder="$t('user.modal.chooseSub')"
                        :disabled="isDisableChoose"
                        v-decorator="['page', pageValidate]"
                        allowClear
                        optionFilterProp="children"
                >
                    <a-select-option
                            v-for="(item, key) in pages"
                            :key="key"
                            :value="item.id"
                    >
                        {{JSON.parse(item.locale)[getLanguage]}}
                    </a-select-option>
                </a-select>
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import { bus } from '../../../../plugins/bus'
import { getUserHomePage, setHomePage } from '../../../../api/userManage'
import { getHomePageList } from '../../../../api/subsystem'
import { mapGetters } from 'vuex'
import { setInputErrors } from '../../../../plugins/common'

export default {
  name: 'setUserHomePage',
  data () {
    return {
      uid: '',
      SetHomePageModalShow: false,
      SetHomePageBtnLoading: false,
      SetHomePageForm: this.$form.createForm(this),
      subsValidate: {
        validateTrigger: ['submit'],
        initialValue: '',
        rules: [
          { required: true, message: () => this.$t('user.modal.subRequire') }]
      },
      pageValidate: {
        validateTrigger: ['submit'],
        initialValue: '',
        rules: [
          { required: true, message: () => this.$t('user.modal.pageRequire') }]
      },
      isDisableChoose: true,
      pages: []
    }
  },
  methods: {
    async changeTemplates (val) {
      this.isDisableChoose = true
      if (val === undefined) {
        return false
      }
      let params = {
        guard_name: val
      }
      getHomePageList(params).then(data => {
        this.isDisableChoose = false
        this.pages = data.data.homepages
      }).catch(error => {
        this.$message.error(error.response.data.message || error.message)
      })
      let userParams = {
        id: this.uid,
        filters: {
          guard_name: val
        }
      }
      getUserHomePage(userParams).then(data => {
        if (data.status === 'success' && data.data.homepages.length > 0) {
          this.pageValidate.initialValue = data.data.homepages[0]['id']
        }
      }).catch(error => {
        this.$message.error(error.response.data.message || error.message)
      })
    },
    SetHomePage () {
      if (this.isDisableChoose) {
        this.$message.error(this.$t('user.modal.choosePage'))
        return false
      }
      this.SetHomePageForm.validateFields((err, values) => {
        if (err === null) {
          this.SetHomePageBtnLoading = true
          let params = {
            id: this.uid,
            page_id: values.page,
            guard_name: values.subsystem
          }
          setHomePage(params).then(data => {
            this.SetHomePageBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('user.modal.setHomePageSuccess'))
              this.SetHomePageModalShow = false
            } else {
              this.$message.error(this.$t('user.modal.setHomePageError'))
            }
          }).catch(error => {
            setInputErrors(error, this.SetHomePageForm)
            this.$message.error(error.response.data.message || error.message)
            this.SetHomePageBtnLoading = false
          })
        } else {
          return false
        }
      })
    }
  },
  mounted () {
    bus.$on('showSetUserHomePageModal', data => {
      this.isDisableChoose = true
      this.pageValidate.initialValue = ''
      this.SetHomePageForm.resetFields()
      this.uid = data
      this.SetHomePageModalShow = true
    })
  },
  computed: {
    ...mapGetters(['getSubsData', 'getLanguage'])
  }
}
</script>

<style scoped>

</style>
