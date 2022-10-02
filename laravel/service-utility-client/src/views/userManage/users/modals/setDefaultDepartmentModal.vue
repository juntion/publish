<template>
    <a-modal  :title="$t('user.modal.setDefaultDepartment')"
              v-model="setDepartmentModalShow"
              :confirmLoading="setDepartmentBtnLoading"
              @ok="setDepartment"
    >
        <a-form :form="setDepartmentForm">
            <a-form-item :label="$t('user.modal.defaultDepartment')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-tree-select
                        v-decorator="['department_id', departmentValidate]"
                        showSearch
                        treeNodeFilterProp="title"
                        :placeholder="$t('user.modal.chooseDepartment')"
                        allowClear
                        :treeData="getDepartmentTree"
                >
                </a-tree-select>
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import Vue from 'vue'
import { mapGetters } from 'vuex'
import { bus } from '../../../../plugins/bus'
import { setDefaultDepartment } from '../../../../api/userManage'
import { setInputErrors } from '../../../../plugins/common'

export default {
  name: 'setDefaultDepartmentModal',
  data () {
    return {
      setDepartmentModalShow: false,
      setDepartmentBtnLoading: false,
      setDepartmentForm: this.$form.createForm(this),
      departmentValidate: {
        validateTrigger: ['submit'],
        initialValue: '',
        rules: [
          { required: true, message: () => this.$t('user.modal.departmentRequire') }]
      }
    }
  },
  methods: {
  // 设置默认部门
    setDepartment () {
      this.setDepartmentForm.validateFields(err => {
        if (err === null) {
          let params = {}
          this.setDepartmentBtnLoading = true
          if (this.getIsGroupSet) {
            params.groupSet = true
            params.department_id = this.setDepartmentForm.getFieldValue('department_id')
            params.user_ids = this.getSelectRows
          } else {
            params.groupSet = false
            params.department_id = this.setDepartmentForm.getFieldValue('department_id')
            params.id = this.getCurrentUser.id
          }
          setDefaultDepartment(params).then(data => {
            if (data.status === 'success') {
              this.$message.success(this.$t('user.modal.setDepartmentSuccess'))
              this.$store.dispatch('getUser')
              this.setDepartmentModalShow = false
            } else {
              this.$message.error(data.message)
            }
            this.setDepartmentBtnLoading = false
          }).catch(error => {
            setInputErrors(error, this.setDepartmentForm)
            this.$message.error(error.response ? error.response.data.message : error.message)
            this.setDepartmentBtnLoading = false
          })
        } else {
          return false
        }
      })
    }
  },
  computed: {
    ...mapGetters(['getDepartmentTree', 'getSelectRows', 'getIsGroupSet', 'getCurrentUser'])
  },
  mounted () {
    bus.$on('showDepartmentModal', () => {
      if (this.getIsGroupSet) {
        Vue.set(this.departmentValidate, 'initialValue', '')
        this.setDepartmentForm.resetFields()
      } else {
        let defaultDepart = this.getCurrentUser.department.id !== undefined ? this.getCurrentUser.department[0].id.toString() : ''
        Vue.set(this.departmentValidate, 'initialValue', defaultDepart)
        this.setDepartmentForm.resetFields()
      }
      this.setDepartmentModalShow = true
    })
  }
}
</script>

<style scoped>

</style>
