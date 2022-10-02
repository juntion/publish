<template>
    <a-modal :title="$t('role.modal.update')"
            class="update-modal"
             v-model="updateRoleModalShow"
             :confirmLoading="updateRoleBtnLoading"
             width="380px"
             @ok="updateRoleData">
        <a-form :form="updateRoleForm" :layout="formLayout">
            <a-form-item :label="$t('role.table.roleName')">
                <a-input
                        v-decorator="['name', name]" :disabled="true"
                ></a-input>
            </a-form-item>
            <a-form-item :label="$t('common.comment')">
                <a-textarea
                        v-decorator="['comment', commentValidate]"
                ></a-textarea>
            </a-form-item>
            <a-divider >{{$t('common.languages')}}</a-divider>
            <a-form-item
                    v-for="(item, key) in languages"
                    :key="key"
                    :label="item">
                <a-input
                        v-decorator="[key, {
                        initialValue: JSON.parse(getCurrentRoleData.locale)[key],
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
import { bus } from '../../../plugins/bus'
import { languages } from '../../../plugins/lang'
import Vue from 'vue'
import { updateRoles } from '../../../api/role'
import { mapGetters } from 'vuex'

export default {
  name: 'updateRoleModal',
  data () {
    return {
      formLayout: 'vertical',
      updateRoleModalShow: false,
      updateRoleBtnLoading: false,
      updateRoleForm: this.$form.createForm(this),
      commentValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('role.notify.commentRequire') }]
      },
      name: {},
      languages: languages
    }
  },
  methods: {
    updateRoleData () {
      this.updateRoleBtnLoading = true
      this.updateRoleForm.validateFields((err, values) => {
        if (err === null) {
          let params = {
            id: this.getCurrentRoleData.id,
            comment: values.comment
          }
          let langArr = {}
          for (let item in languages) {
            Vue.set(langArr, item, values[item])
          }
          params.locale = JSON.stringify(langArr)
          updateRoles(params).then(data => {
            this.updateRoleBtnLoading = false
            if (data.status === 'success') {
              this.updateRoleModalShow = false
              this.$message.success(this.$t('role.notify.updateSuccess'))
              this.$store.dispatch('fetchRolesList')
            } else {
              this.$message.error(this.$t('role.notify.updateError'))
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
            this.updateRoleBtnLoading = false
          })
        } else {
          this.updateRoleBtnLoading = false
          return false
        }
      })
    }
  },
  mounted () {
    bus.$on('showUpdateRoleModal', data => {
      // console.log(this.getCurrentRoleData)
      this.name.initialValue = this.getCurrentRoleData.name
      this.commentValidate.initialValue = this.getCurrentRoleData.comment
      this.updateRoleForm.resetFields()
      this.updateRoleModalShow = true
    })
  },
  computed: {
    ...mapGetters(['getCurrentRoleData'])
  }
}
</script>

<style lang="less">
.update-modal{
  .ant-modal-body{
    padding: 20px 20px 0 20px;
  }
  .ant-modal-footer{
    padding: 0 20px 20px 20px;
  }
  .ant-modal-footer{
    display: flex!important;
    justify-content: flex-start;
    align-items: center!important;
  }
}
</style>
