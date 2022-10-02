<template>
    <a-modal :title="$t('template.modal.addCate')"
             v-model="addCateModalShow"
             :confirmLoading="addCateBtnLoading"
             @ok="addCateData">
        <a-form :form="addCateForm">
            <a-form-item :label="$t('template.modal.name')"
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
            <a-form-item :label="$t('template.modal.icon')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-select
                        v-decorator="['icon', iconValidate]"
                >
                    <a-select-option v-for="(item, key) in defaultIcons" :value="item" :key="key"><a-icon :type="item" /></a-select-option>
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
import { newCategories } from '../../../api/sidebar'
import Vue from 'vue'
import { defaultIcons, setInputErrors } from '../../../plugins/common'

export default {
  name: 'addCateModal',
  data () {
    return {
      defaultIcons,
      addCateModalShow: false,
      addCateBtnLoading: false,
      addCateForm: this.$form.createForm(this),
      nameValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('template.modal.nameRequire') }]
      },
      commentValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('template.notify.commentRequire') }]
      },
      iconValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('template.modal.iconRequire') }]
      },
      languages: languages,
      parent_id: 0
    }
  },
  methods: {
    addCateData () {
      this.addCateBtnLoading = true
      this.addCateForm.validateFields((err, values) => {
        if (err === null) {
          let params = {
            name: values.name,
            parent_id: this.parent_id,
            sidebar_template_id: this.$route.params.id,
            comment: values.comment,
            icon: values.icon
          }
          let langArr = {}
          for (let item in languages) {
            Vue.set(langArr, item, values[item])
          }
          params.locale = JSON.stringify(langArr)
          newCategories(params).then(data => {
            this.addCateBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('template.notify.addCategorySuccess'))
              bus.$emit('updateCateTreeData')
              this.addCateModalShow = false
            } else {
              this.$message.error(this.$t('template.notify.addCategoryError'))
            }
          }).catch(error => {
            this.addCateBtnLoading = false
            this.$message.error(error.response ? error.response.data.message : error.message)
            setInputErrors(error, this.addCateForm)
          })
        } else {
          this.addCateBtnLoading = false
        }
      })
    }
  },
  mounted () {
    bus.$on('addCateModalShow', data => {
      this.addCateForm.resetFields()
      this.addCateModalShow = true
      this.parent_id = data
    })
  }
}
</script>

<style scoped>

</style>
