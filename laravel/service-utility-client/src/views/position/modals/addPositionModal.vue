<template>
    <a-modal :title="$t('position.list.add')"
             v-model="addPositionModalShow"
             :confirmLoading="addPositionBtnLoading"
             @ok="addPosition">
        <a-form :form="addPositionForm">
            <a-form-item :label="$t('position.list.position')"
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
                        v-decorator="[key, langValidate]"
                />
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import { bus } from '../../../plugins/bus'
import { languages } from '../../../plugins/lang'
import Vue from 'vue'
import { addPosition } from '../../../api/position'
import { setInputErrors } from '../../../plugins/common'

export default {
  name: 'addPositionModal',
  data () {
    return {
      addPositionModalShow: false,
      addPositionBtnLoading: false,
      addPositionForm: this.$form.createForm(this),
      nameValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('position.notify.nameRequire') }]
      },
      commentValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('position.notify.commentRequire') }]
      },
      langValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('position.notify.langRequire') }]
      },
      languages: languages
    }
  },
  methods: {
    addPosition () {
      this.addPositionForm.validateFields((err, values) => {
        if (err === null) {
          this.addPositionBtnLoading = true
          let params = {
            name: values.name,
            comment: values.comment
          }
          let langArr = {}
          for (let item in languages) {
            Vue.set(langArr, item, values[item])
          }
          params.locale = JSON.stringify(langArr)
          addPosition(params).then(data => {
            this.addPositionBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('position.notify.addSuccess'))
              this.addPositionModalShow = false
              this.$store.dispatch('getPositionIndexData')
            } else {
              this.$message.error(this.$t('position.notify.addError'))
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
            this.addPositionBtnLoading = false
            setInputErrors(error, this.addPositionForm)
          })
        } else {
          return false
        }
      })
    }
  },
  mounted () {
    bus.$on('addPositionModalShow', data => {
      this.addPositionForm.resetFields()
      this.addPositionModalShow = true
    })
  }
}
</script>

<style scoped>

</style>
