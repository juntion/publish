<template>
    <a-modal
            :title="$t('user.modal.bindTemplate')"
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
            <a-form-item :label="$t('user.modal.template')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-select
                    showSearch
                    :placeholder="$t('user.modal.chooseSub')"
                    :disabled="isDisableChoose"
                    v-decorator="['sidebar_template_id', sidebarValidate]"
                    allowClear
                    optionFilterProp="children"
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
import { allTemplate } from '../../../../api/sidebar'
import { usersBindTemplate } from '../../../../api/userManage'
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
          { required: true, message: () => this.$t('user.modal.templateRequire') }]
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
        this.$message.error(this.$t('user.modal.chooseSub'))
        return false
      }
      this.usersBindTemplateForm.validateFields((err, values) => {
        if (err === null) {
          this.usersBindTemplateBtnLoading = true
          let params = {
            user_ids: this.getSelectRows,
            sidebar_template_id: values.sidebar_template_id,
            guard_name: values.subsystem
          }
          usersBindTemplate(params).then(data => {
            this.usersBindTemplateBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('user.modal.bindSuccess'))
              this.usersBindTemplateModalShow = false
            } else {
              this.$message.error(this.$t('user.modal.bindError'))
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
      this.usersBindTemplateForm.setFieldsValue({
        'sidebar_template_id': ''
      })
      if (event === undefined) {
        return false
      }
      allTemplate({ guard_name: event }).then(data => {
        this.isDisableChoose = false
        this.templates = data.data.sidebar_templates
      }).catch(error => {
        this.$message.error(error.response.data.message || error.message)
      })
    }
  },
  mounted () {
    bus.$on('showBindUsersTemplate', data => {
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
