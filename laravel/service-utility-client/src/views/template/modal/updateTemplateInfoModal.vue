<template>
    <a-modal :title="$t('template.modal.updateTitle')"
             v-model="updateTemplateModalShow"
             :confirmLoading="updateTemplateBtnLoading"
             @ok="updateTemplateData">
        <a-form :form="updateTemplateForm">
            <a-form-item :label="$t('template.table.template')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-input
                        v-decorator="['name', nameValidate]"
                ></a-input>
            </a-form-item>
            <a-form-item :label="$t('common.comment')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-textarea
                        v-decorator="['comment', commentValidate]"
                ></a-textarea>
            </a-form-item>
            <a-form-item :label="$t('common.guard')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-select
                    showSearch
                    :placeholder="$t('common.guard')"
                    v-decorator="['guard_name', guardNameValidate]"
                    allowClear
                >
                    <a-select-option
                            v-for="(item, key) in getSubsData"
                            :key="key"
                            :value="item.guard_name">
                        {{item.guard_name}}
                    </a-select-option>
                </a-select>
            </a-form-item>
            <a-divider >{{$t('common.languages')}}</a-divider>
            <a-form-item
                    v-for="(item, key) in languages"
                    :key="key"
                    :label="item"
                    :label-col="{ span: 4 }"
                    :wrapper-col="{ span: 18 }">
                <a-input
                        v-decorator="[key, {
                        initialValue: JSON.parse(getTemplateCurrentData.locale)[key],
                        validateTrigger: ['submit'],
                        rules: [
                        { required: true, message: key + ' ' + $t('required') }]
                      }]"
                />
            </a-form-item>
        </a-form>
    </a-modal>
</template>
<script>
import { bus } from '../../../plugins/bus'
import { languages } from '../../../plugins/lang'
import { mapGetters } from 'vuex'
import Vue from 'vue'
import { updateTemplate } from '../../../api/sidebar'
import { setInputErrors } from '../../../plugins/common'

export default {
  name: 'updateTemplateInfoModal',
  data () {
    return {
      updateTemplateModalShow: false,
      updateTemplateBtnLoading: false,
      updateTemplateForm: this.$form.createForm(this),
      nameValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('template.notify.templateRequire') }]
      },
      commentValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('template.notify.commentRequire') }]
      },
      guardNameValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('template.notify.guardRequire') }]
      },
      languages: languages
    }
  },
  methods: {
    updateTemplateData () {
      this.updateTemplateBtnLoading = true
      this.updateTemplateForm.validateFields((err, values) => {
        if (err === null) {
          let params = {
            id: this.getTemplateCurrentData.id,
            name: values.name,
            comment: values.comment,
            guard_name: values.guard_name
          }
          let langArr = {}
          for (let item in languages) {
            Vue.set(langArr, item, values[item])
          }
          params.locale = JSON.stringify(langArr)
          updateTemplate(params).then(data => {
            this.updateTemplateBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('template.notify.updateSuccess'))
              this.updateTemplateModalShow = false
              this.$store.dispatch('fetchTemplate').catch(error => {
                this.$message.error(error.response ? error.response.data.message : error.message)
                this.$store.commit('SET_TEMPLATE_PAGE_LOADING', false)
              })
            } else {
              this.$message.error(this.$t('template.notify.updateError'))
            }
          }).catch(error => {
            this.updateTemplateBtnLoading = false
            this.$message.error(error.response ? error.response.data.message : error.message)
            setInputErrors(error, this.updateTemplateForm)
          })
        } else {
          this.updateTemplateBtnLoading = false
        }
      })
    }
  },
  mounted () {
    bus.$on('showUpdateTemplateModal', data => {
      this.updateTemplateForm.resetFields()
      this.nameValidate.initialValue = this.getTemplateCurrentData.name
      this.commentValidate.initialValue = this.getTemplateCurrentData.comment
      this.guardNameValidate.initialValue = this.getTemplateCurrentData.guard_name
      this.updateTemplateModalShow = true
    })
  },
  computed: {
    ...mapGetters(['getTemplateCurrentData', 'getSubsData', 'getLanguage'])
  }
}
</script>

<style scoped>

</style>
