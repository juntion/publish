<template>
    <a-modal :title="$t('subsystem.modal.updateSubsTitle')"
             v-model="updateSubSystemModalShow"
             :confirmLoading="updateSubSystemBtnLoading"
             @ok="updateSubSystemData">
        <a-form :form="updateSubSystemForm">
            <a-form-item :label="$t('subsystem.table.subsystem')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-input
                        v-decorator="['name', nameValidate]"
                ></a-input>
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
                        initialValue: JSON.parse(getCurrentSubSystemData.locale)[key],
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
import { mapGetters } from 'vuex'
import { updateSubSystemInfo } from '../../../api/subsystem'
import Vue from 'vue'
import { bus } from '../../../plugins/bus'
import { setInputErrors } from '../../../plugins/common'

export default {
  name: 'updateSubSystemModal',
  data () {
    return {
      updateSubSystemModalShow: false,
      updateSubSystemBtnLoading: false,
      updateSubSystemForm: this.$form.createForm(this),
      nameValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('subsystem.modal.nameRequire') }]
      },
      languages: languages
    }
  },
  methods: {
    updateSubSystemData () {
      this.updateSubSystemForm.validateFields((err, values) => {
        if (err === null) {
          this.updateSubSystemBtnLoading = true
          let params = {
            name: values.name
          }
          let langArr = {}
          for (let item in languages) {
            Vue.set(langArr, item, values[item])
          }
          params.locale = JSON.stringify(langArr)
          params.id = this.getCurrentSubSystemData.id
          updateSubSystemInfo(params).then(data => {
            this.updateSubSystemBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('subsystem.notify.updateSubsSuccess'))
              this.updateSubSystemModalShow = false
              this.$store.dispatch('fetchSubSystemData')
            } else {
              this.$message.error(this.$t('subsystem.notify.updateSubsError'))
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
            this.updateSubSystemBtnLoading = false
            setInputErrors(error, this.updateSubSystemForm)
          })
        } else {
          return false
        }
      })
    }
  },
  computed: {
    ...mapGetters(['getCurrentSubSystemData'])
  },
  mounted () {
    bus.$on('updateSubSystemInfoModalShow', data => {
      this.updateSubSystemModalShow = true
      Vue.set(this.nameValidate, 'initialValue', this.getCurrentSubSystemData.name)
    })
  }
}
</script>

<style scoped>

</style>
