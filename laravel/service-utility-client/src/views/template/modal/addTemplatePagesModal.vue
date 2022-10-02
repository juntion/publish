<template>
    <a-modal
        :title="$t('template.modal.addPageTitle')"
        v-model="addCatePageModalShow"
        :confirmLoading="addCatePageBtnLoading"
        @ok="addCatePage">
        <a-form :form="addCatePageForm">
            <a-form-item :label="$t('template.modal.page')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-select
                        optionFilterProp="children"
                        mode="multiple"
                        v-decorator="['page_ids', pagesValidate]"
                >
                    <a-select-option v-for="(item, key) in getCurrentTemplatePages" :value="item.id" :key="key">{{JSON.parse(item.locale)[getLanguage]}}</a-select-option>
                </a-select>
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import { bus } from '../../../plugins/bus'
import { addCategoriesPage } from '../../../api/sidebar'
import { mapGetters } from 'vuex'
import { setInputErrors } from '../../../plugins/common'

export default {
  name: 'addTemplatePagesModal',
  data () {
    return {
      pagesValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('template.modal.pageRequire') }]
      },
      addCatePageModalShow: false,
      addCatePageBtnLoading: false,
      addCatePageForm: this.$form.createForm(this)
    }
  },
  methods: {
    addCatePage () {
      this.addCatePageBtnLoading = true
      this.addCatePageForm.validateFields((err, values) => {
        if (err === null) {
          let params = {
            id: this.getCurrentCateData.key,
            page_ids: values.page_ids
          }
          addCategoriesPage(params).then(data => {
            this.addCatePageBtnLoading = false
            if (data.status === 'success') {
              this.$store.dispatch('getTemplateTreeByTId')
              this.$message.success(this.$t('template.notify.addPageSuccess'))
              this.addCatePageModalShow = false
            } else {
              this.$message.error(this.$t('template.notify.addPageError'))
            }
          }).catch(error => {
            this.addCatePageBtnLoading = false
            this.$message.error(error.response ? error.response.data.message : error.message)
            setInputErrors(error, this.addCatePageForm)
          })
        } else {
          this.addCatePageBtnLoading = false
        }
      })
    }
  },
  mounted () {
    bus.$on('addCatePageModalShow', data => {
      this.addCatePageForm.resetFields()
      this.addCatePageModalShow = true
    })
  },
  computed: {
    ...mapGetters(['getCurrentTemplatePages', 'getLanguage', 'getCurrentCateData'])
  }
}
</script>

<style scoped>

</style>
