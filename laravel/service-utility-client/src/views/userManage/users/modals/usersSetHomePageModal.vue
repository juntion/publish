<template>
    <a-modal :title="$t('user.modal.setUsersHomePage')"
    v-model="usersSetHomePageModalShow"
    :confirmLoading="usersSetHomePageBtnLoading"
    @ok="SetHomePage">
        <a-form :form="usersSetHomePageForm">
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
                        v-decorator="['page', sidebarValidate]"
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
import { mapGetters } from 'vuex'
import { usersSetHomePage } from '../../../../api/userManage'
import { getHomePageList } from '../../../../api/subsystem'

export default {
  name: 'usersSetHomePageModal',
  data () {
    return {
      usersSetHomePageModalShow: false,
      usersSetHomePageBtnLoading: false,
      usersSetHomePageForm: this.$form.createForm(this),
      isDisableChoose: true,
      sidebarValidate: {
        validateTrigger: ['submit'],
        initialValue: '',
        rules: [
          { required: true, message: () => this.$t('user.modal.pageRequire') }]
      },
      subsValidate: {
        validateTrigger: ['submit'],
        initialValue: '',
        rules: [
          { required: true, message: () => this.$t('user.modal.subRequire') }]
      },
      pages: []
    }
  },
  methods: {
    SetHomePage () {
      if (this.isDisableChoose) {
        this.$message.error(this.$t('user.modal.choosePage'))
        return false
      }
      this.usersSetHomePageForm.validateFields((err, values) => {
        if (err === null) {
          this.usersSetHomePageBtnLoading = true
          let params = {
            user_ids: this.getSelectRows,
            page_id: values.page,
            guard_name: values.subsystem
          }
          usersSetHomePage(params).then(data => {
            this.usersSetHomePageBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('user.modal.setHomePageSuccess'))
              this.usersSetHomePageModalShow = false
            } else {
              this.$message.success(this.$t('user.modal.setHomePageError'))
            }
          }).catch(error => {
            this.$message.error(error.response.data.message || error.message)
            this.usersSetHomePageBtnLoading = false
          })
        } else {
          return false
        }
      })
    },
    changeTemplates (event) {
      this.isDisableChoose = true
      if (event === undefined) {
        return false
      }
      getHomePageList({ guard_name: event }).then(data => {
        this.isDisableChoose = false
        this.pages = data.data.homepages
      }).catch(error => {
        this.$message.error(error.response.data.message || error.message)
      })
    }
  },
  mounted () {
    bus.$on('showSetUsersHomePage', data => {
      this.isDisableChoose = true
      this.usersSetHomePageForm.resetFields()
      this.usersSetHomePageModalShow = true
    })
  },
  computed: {
    ...mapGetters(['getSubsData', 'getLanguage', 'getSelectRows'])
  }
}
</script>

<style scoped>

</style>
