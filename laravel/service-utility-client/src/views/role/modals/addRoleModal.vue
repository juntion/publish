<template>
    <a-modal :title="$t('role.modal.addRole')"
        class="add-modal"
        v-model="addRoleModalShow"
        width="380px"
        :confirmLoading="addRoleBtnLoading"
        @ok="addRoleData">
        <a-form :form="addRoleForm" :layout="formLayout">
            <a-form-item :label="$t('role.table.roleName')">
                <a-input
                        v-decorator="['name', nameValidate]"
                ></a-input>
            </a-form-item>
            <a-form-item :label="$t('common.comment')" >
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
import { addRoles } from '../../../api/role'
import { mapGetters } from 'vuex'
import { setInputErrors } from '../../../plugins/common'

export default {
  name: 'addRoleModal',
  data () {
    return {
      formLayout: 'vertical',
      addRoleModalShow: false,
      addRoleBtnLoading: false,
      addRoleForm: this.$form.createForm(this),
      nameValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('role.notify.roleRequire') }]
      },
      commentValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('role.notify.commentRequire') }]
      },
      guardNameValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('role.notify.guardRequire') }]
      },
      languages: languages
    }
  },
  methods: {
    addRoleData () {
      this.addRoleBtnLoading = true
      this.addRoleForm.validateFields((err, values) => {
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
          addRoles(params).then(data => {
            this.addRoleBtnLoading = false
            if (data.status === 'success') {
              this.addRoleModalShow = false
              this.$message.success(this.$t('role.notify.addRoleSuccess'))
              this.$store.dispatch('fetchRolesList')
            } else {
              this.$message.error(this.$t('role.notify.addRoleSuccess'))
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
            this.addRoleBtnLoading = false
            setInputErrors(error, this.addRoleForm)
          })
        } else {
          this.addRoleBtnLoading = false
          return false
        }
      })
    }
  },
  mounted () {
    bus.$on('showAddRoleModal', data => {
      this.addRoleForm.resetFields()
      this.addRoleModalShow = true
    })
  },
  computed: {
    ...mapGetters(['getSubsData', 'getLanguage', 'getCurrentSub'])
  }
}
</script>

<style lang="less">
.add-modal{
   .ant-form-item{
      padding-bottom: 0!important
  }
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
