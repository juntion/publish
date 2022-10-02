<template>
    <a-modal :title="$t('position.list.update')"
             v-model="updatePositionModalShow"
             :confirmLoading="updatePositionBtnLoading"
             @ok="updatePosition">
        <a-form :form="updatePositionForm">
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
                    v-decorator="[key, {
                        initialValue: JSON.parse(getCurrentPosition.locale)[key],
                        validateTrigger: ['submit'],
                        rules: [
                        { required: true, message: $t('position.notify.langRequire') }]
                      }]"
                />
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import { bus } from '../../../plugins/bus'
import { languages } from '../../../plugins/lang'
import Vue from 'vue'
import { updatePositionInfo } from '../../../api/position'
import { mapGetters } from 'vuex'
import { setInputErrors } from '../../../plugins/common'

export default {
  name: 'updatePositionModal',
  data () {
    return {
      updatePositionModalShow: false,
      updatePositionBtnLoading: false,
      updatePositionForm: this.$form.createForm(this),
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
      languages: languages
    }
  },
  methods: {
    updatePosition () {
      this.updatePositionForm.validateFields((err, values) => {
        if (err === null) {
          this.updatePositionBtnLoading = true
          let params = {
            name: values.name,
            comment: values.comment
          }
          let langArr = {}
          for (let item in languages) {
            Vue.set(langArr, item, values[item])
          }
          params.locale = JSON.stringify(langArr)
          params.id = this.getCurrentPosition.id
          updatePositionInfo(params).then(data => {
            this.updatePositionBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('position.notify.updateSuccess'))
              this.updatePositionModalShow = false
              this.$store.dispatch('getPositionIndexData')
            } else {
              this.$message.error(this.$t('position.notify.updateSuccess'))
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
            this.updatePositionBtnLoading = false
            setInputErrors(error, this.updatePositionForm)
          })
        } else {
          return false
        }
      })
    }
  },
  mounted () {
    bus.$on('updatePositionModalShow', data => {
      this.updatePositionForm.resetFields()
      this.updatePositionModalShow = true
      Vue.set(this.nameValidate, 'initialValue', this.getCurrentPosition.name)
      Vue.set(this.commentValidate, 'initialValue', this.getCurrentPosition.comment)
    })
  },
  computed: {
    ...mapGetters(['getCurrentPosition'])
  }
}
</script>

<style scoped>

</style>
