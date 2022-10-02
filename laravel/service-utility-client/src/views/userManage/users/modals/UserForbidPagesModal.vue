<template>
    <a-modal
            :title="$t('user.modal.forbidUserPages')"
            v-model="usersBindTemplateModalShow"
            :confirmLoading="usersBindTemplateBtnLoading"
            @ok="usersBindTemplate">
        <a-form :form="usersBindTemplateForm">
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
            <a-form-item :label="$t('user.modal.page')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-select
                        showSearch
                        :placeholder="$t('user.modal.chooseSub')"
                        :disabled="isDisableChoose"
                        v-decorator="['page', sidebarValidate]"
                        allowClear
                >
                    <a-select-option
                            v-for="(item, key) in templates"
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
import { getAllPagesOfOneSystem, usersForbidPages } from '../../../../api/userManage'
import { setInputErrors } from '../../../../plugins/common'

export default {
  name: 'usersBindTemplate',
  data () {
    return {
      usersBindTemplateModalShow: false,
      usersBindTemplateBtnLoading: false,
      usersBindTemplateForm: this.$form.createForm(this),
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
      templates: []
    }
  },
  methods: {
    usersBindTemplate () {
      if (this.isDisableChoose) {
        this.$message.error(this.$t('user.modal.choosePage'))
        return false
      }
      this.usersBindTemplateForm.validateFields((err, values) => {
        if (err === null) {
          this.usersBindTemplateBtnLoading = true
          let params = {
            user_ids: this.getSelectRows,
            page_id: values.page
          }
          usersForbidPages(params).then(data => {
            this.usersBindTemplateBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('user.modal.forbidPageSuccess'))
              this.usersBindTemplateModalShow = false
            } else {
              this.$message.error(this.$t('user.modal.forbidPageError'))
            }
          }).catch(error => {
            setInputErrors(error, this.usersBindTemplateForm)
            this.$message.error(error.response.data.message || error.message)
            this.usersBindTemplateBtnLoading = false
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
      getAllPagesOfOneSystem({ guard_name: event }).then(data => {
        this.isDisableChoose = false
        this.templates = data.data
      }).catch(error => {
        this.$message.error(error.response.data.message || error.message)
      })
    }
  },
  mounted () {
    bus.$on('showForbidUsersPage', data => {
      this.isDisableChoose = true
      this.usersBindTemplateForm.resetFields()
      this.usersBindTemplateModalShow = true
    })
  },
  computed: {
    ...mapGetters(['getSubsData', 'getLanguage', 'getSelectRows'])
  }
}
</script>

<style scoped>

</style>
