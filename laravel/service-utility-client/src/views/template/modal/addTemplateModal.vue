<template>
    <a-modal :title="$t('template.modal.addTitle')"
             v-model="addTemplateModalShow"
             :confirmLoading="addTemplateBtnLoading"
             @ok="addTemplateData">
        <a-form :form="addTemplateForm">
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
            <a-divider >{{$t('common.languages')}}</a-divider>
            <a-form-item
                    v-for="(item, key) in languages"
                    :key="key"
                    :label="item"
                    :label-col="{ span: 4 }"
                    :wrapper-col="{ span: 18 }">
                <a-input
                        v-decorator="[key, {
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
import { languages } from '../../../plugins/lang'
import { bus } from '../../../plugins/bus'
import Vue from 'vue'
import { newTemplate } from '../../../api/sidebar'
import { mapGetters } from 'vuex'
import { setInputErrors } from '../../../plugins/common'

export default {
  name: 'addTemplateModal',
  data () {
    return {
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
      languages: languages,
      addTemplateForm: this.$form.createForm(this),
      addTemplateModalShow: false,
      addTemplateBtnLoading: false
    }
  },
  methods: {
    addTemplateData () {
      this.addTemplateBtnLoading = true
      this.addTemplateForm.validateFields((err, values) => {
        if (err === null) {
          let params = {
            name: values.name,
            comment: values.comment,
            guard_name: this.getCurrentSub
          }
          let langArr = {}
          for (let item in languages) {
            Vue.set(langArr, item, values[item])
          }
          params.locale = JSON.stringify(langArr)
          newTemplate(params).then(data => {
            this.addTemplateBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('template.notify.addSuccess'))
              this.addTemplateModalShow = false
              this.$store.dispatch('fetchTemplate').catch(error => {
                this.$message.error(error.response ? error.response.data.message : error.message)
                this.$store.commit('SET_TEMPLATE_PAGE_LOADING', false)
              })
            } else {
              this.$message.error(this.$t('template.notify.addError'))
            }
          }).catch(error => {
            this.addTemplateBtnLoading = false
            this.$message.error(error.response ? error.response.data.message : error.message)
            setInputErrors(error, this.addTemplateForm)
          })
        } else {
          this.addTemplateBtnLoading = false
        }
      })
    }
  },
  mounted () {
    bus.$on('showAddTemplateModal', data => {
      this.addTemplateForm.resetFields()
      this.addTemplateModalShow = true
    })
  },
  computed: {
    ...mapGetters(['getSubsData', 'getLanguage', 'getCurrentSub'])
  }
}
</script>

<style scoped>

</style>
