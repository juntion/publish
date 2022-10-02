<template>
    <a-modal :title="$t('user.modal.setUserRole')"
                   v-model="SetRolePageModalShow"
                   :confirmLoading="SetRoleBtnLoading"
                   @ok="SetRole">
        <a-form
            :form="SetRoleForm">
            <a-form-item :label="$t('user.modal.sub')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-select
                        showSearch
                        v-decorator="['subsystem', subsValidate]"
                        allowClear
                        @change="changeTemplates"
                >
                    <a-select-option
                            v-for="(item, key) in getSubsData"
                            :key="key"
                            :value="item.guard_name">
                        {{JSON.parse(item.locale)[getLanguage]}}
                    </a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item :label="$t('user.modal.role')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-select
                        mode="multiple"
                        showSearch
                        :placeholder="$t('user.modal.chooseSub')"
                        :disabled="isDisableChoose"
                        v-decorator="['role_ids', roleValidate]"
                        allowClear
                        optionFilterProp="children"
                >
                    <a-select-option
                            v-for="(item, key) in roles"
                            :key="key"
                            :value="item.id"
                    >
                        {{JSON.parse(item.locale)[getLanguage]}}
                    </a-select-option>
                </a-select>
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import { getAllRoles } from '../../../../api/role'
import { getUserRoles, updateUserRoles, attachUserRoles } from '../../../../api/userManage'
import { bus } from '../../../../plugins/bus'
import { mapGetters } from 'vuex'
import { setInputErrors } from '../../../../plugins/common'

export default {
  name: 'setUserRoleModal',
  data () {
    return {
      batch: false,
      SetRolePageModalShow: false,
      SetRoleBtnLoading: false,
      SetRoleForm: this.$form.createForm(this),
      isDisableChoose: true,
      roleValidate: {
        validateTrigger: ['submit'],
        initialValue: '',
        rules: [
          { required: false, message: () => this.$t('user.modal.roleRequire') }]
      },
      subsValidate: {
        validateTrigger: ['submit'],
        initialValue: '',
        rules: [
          { required: true, message: () => this.$t('user.modal.subRequire') }]
      },
      roles: [],
      uid: 0
    }
  },
  methods: {
    changeTemplates (val) {
      this.isDisableChoose = true
      if (val === undefined) {
        this.roleValidate.initialValue = []
        return false
      }
      let params = {
        guard_name: val
      }
      getAllRoles(params).then(data => {
        this.isDisableChoose = false
        if (data.status === 'success' && data.data.data.length > 0) {
          this.roles = data.data.data
        }
      }).catch(error => {
        this.$message.error(error.response.data.message || error.message)
      })
      if (this.batch !== true) {
        let userParams = {
          id: this.uid,
          guard_name: val
        }
        getUserRoles(userParams).then(data => {
          let ids = []
          if (data.status === 'success' && data.data.roles.length > 0) {
            for (let item in data.data.roles) {
              ids.push(data.data.roles[item]['id'])
            }
          }
          this.roleValidate.initialValue = ids
        }).catch(error => {
          this.$message.error(error.response.data.message || error.message)
        })
      }
    },
    SetRole () {
      this.SetRoleForm.validateFields((err, values) => {
        if (err === null) {
          this.SetRoleBtnLoading = true
          if (this.batch === true) {
            this.batchAttachUserRoles(values)
          } else {
            this.updateSingleUserRoles(values)
          }
        } else {
          return false
        }
      })
    },
    updateSingleUserRoles (values) {
      let params = {
        id: this.uid,
        role_ids: values.role_ids,
        guard_name: values.subsystem
      }
      updateUserRoles(params).then(data => {
        this.SetRoleBtnLoading = false
        if (data.status === 'success') {
          this.$message.success(this.$t('user.modal.setRoleSuccess'))
          this.SetRolePageModalShow = false
        } else {
          this.$message.error(this.$t('user.modal.setRoleError'))
        }
      }).catch(error => {
        setInputErrors(error, this.SetRoleForm)
        this.$message.error(error.response.data.message || error.message)
        this.SetRoleBtnLoading = false
      })
    },
    batchAttachUserRoles (values) {
      let params = {
        user_ids: this.getSelectRows,
        role_ids: values.role_ids,
        guard_name: values.subsystem
      }
      attachUserRoles(params).then(data => {
        this.SetRoleBtnLoading = false
        if (data.status === 'success') {
          this.$message.success(this.$t('user.modal.setRoleSuccess'))
          this.SetRolePageModalShow = false
        } else {
          this.$message.error(this.$t('user.modal.setRoleError'))
        }
      }).catch(error => {
        setInputErrors(error, this.SetRoleForm)
        this.$message.error(error.response.data.message || error.message)
        this.SetRoleBtnLoading = false
      })
    }
  },
  mounted () {
    bus.$on('showSetRolesModal', (id, batch) => {
      this.SetRolePageModalShow = true
      this.isDisableChoose = true
      this.roleValidate.initialValue = []
      this.SetRoleForm.resetFields()
      if (id) {
        this.uid = id
      }
      if (batch) {
        this.batch = true
      } else {
        this.batch = false
      }
      let guardName = this.getSubsData[0].guard_name
      this.subsValidate.initialValue = guardName
      this.changeTemplates(guardName)
    })
  },
  computed: {
    ...mapGetters(['getSubsData', 'getLanguage', 'getSelectRows'])
  }
}
</script>

<style scoped>

</style>
