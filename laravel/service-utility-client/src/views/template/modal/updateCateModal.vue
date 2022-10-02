<template>
    <a-modal :title="$t('template.modal.updateCate')"
             v-model="updateCateModalShow"
             :confirmLoading="updateCateBtnLoading"
             @ok="updateCateData">
        <a-form :form="updateCateForm">
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
                        initialValue: JSON.parse(getCurrentCateData.locale)[key],
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
import { updateCategories } from '../../../api/sidebar'
import Vue from 'vue'
import { defaultIcons, setInputErrors } from '../../../plugins/common'
import { mapGetters } from 'vuex'

export default {
  name: 'updateCateModal',
  data () {
    return {
      defaultIcons,
      updateCateModalShow: false,
      updateCateBtnLoading: false,
      updateCateForm: this.$form.createForm(this),
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
    updateCateData () {
      this.updateCateBtnLoading = true
      this.updateCateForm.validateFields((err, values) => {
        if (err === null) {
          let params = {
            id: this.getCurrentCateData.key,
            name: values.name,
            parent_id: this.getCurrentCateData.parent_id,
            comment: values.comment,
            icon: values.icon
          }
          let langArr = {}
          for (let item in languages) {
            Vue.set(langArr, item, values[item])
          }
          params.locale = JSON.stringify(langArr)
          updateCategories(params).then(data => {
            this.updateCateBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('template.notify.updateCategorySuccess'))
              this.$store.dispatch('getTemplateTreeByTId')
              this.updateCateModalShow = false
            } else {
              this.$message.error(this.$t('template.notify.updateCategoryError'))
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
            this.updateCateBtnLoading = false
            setInputErrors(error, this.updateCateForm)
          })
        } else {
          this.updateCateBtnLoading = false
        }
      })
    }
  },
  mounted () {
    bus.$on('updateCateModalShow', data => {
      this.nameValidate.initialValue = this.getCurrentCateData.title
      this.commentValidate.initialValue = this.getCurrentCateData.comment
      this.iconValidate.initialValue = this.getCurrentCateData.slots.icon
      this.updateCateForm.resetFields()
      this.updateCateModalShow = true
    })
  },
  computed: {
    ...mapGetters(['getCurrentCateData'])
  }
}
</script>

<style scoped>

</style>
