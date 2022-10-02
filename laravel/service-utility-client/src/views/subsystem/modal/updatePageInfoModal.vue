<template>
    <a-modal :title="$t('subsystem.modal.updatePageTitle')"
             v-model="updatePageInfoModalShow"
             :confirmLoading="updatePageInfoBtnLoading"
             @ok="updateSubSystemData">
        <a-form :form="updatePageForm">
            <a-form-item :label="$t('subsystem.table.pageName')"
                         :label-col="{ span: 5 }"
                         :wrapper-col="{ span: 18 }">
                <a-input
                        v-decorator="['name', nameValidate]"
                ></a-input>
            </a-form-item>
            <a-form-item :label="$t('common.comment')"
                         :label-col="{ span: 5 }"
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
                    :label-col="{ span: 5 }"
                    :wrapper-col="{ span: 18 }">
                <a-input
                        v-decorator="[key, {
                        initialValue: JSON.parse(record.locale)[key],
                        validateTrigger: ['submit'],
                        rules: [
                        { required: true, message: $t('common.langRequire') }]
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
import { updatePageInfo } from '../../../api/subsystem'
import { setInputErrors } from '../../../plugins/common'

export default {
  name: 'updatePageInfoModal',
  data () {
    return {
      updatePageInfoModalShow: false,
      updatePageInfoBtnLoading: false,
      nameValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('subsystem.modal.pageNameRequire') }]
      },
      commentValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('subsystem.modal.commentRequire') }]
      },
      languages: languages,
      record: {
        locale: '{"en":""}'
      },
      updatePageForm: this.$form.createForm(this)
    }
  },
  methods: {
    updateSubSystemData () {
      this.updatePageInfoBtnLoading = true
      this.updatePageForm.validateFields((err, values) => {
        if (err === null) {
          let params = {
            id: this.record.id,
            name: values.name,
            comment: values.comment
          }
          let langArr = {}
          for (let item in languages) {
            Vue.set(langArr, item, values[item])
          }
          params.locale = JSON.stringify(langArr)
          updatePageInfo(params).then(data => {
            this.updatePageInfoBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('subsystem.notify.updatePageSuccess'))
              bus.$emit('refreshPageData')
              this.updatePageInfoModalShow = false
            } else {
              this.$message.error(this.$t('subsystem.notify.updatePageError'))
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
            this.updatePageInfoBtnLoading = false
            setInputErrors(error, this.updatePageForm)
          })
        } else {
          this.updatePageInfoBtnLoading = false
        }
      })
    }
  },
  mounted () {
    bus.$on('updatePageInfoModalShow', data => {
      this.record = data
      this.updatePageInfoModalShow = true
      this.nameValidate.initialValue = data.name
      this.commentValidate.initialValue = data.comment
      this.updatePageForm.resetFields()
    })
  }
}
</script>

<style scoped>

</style>
