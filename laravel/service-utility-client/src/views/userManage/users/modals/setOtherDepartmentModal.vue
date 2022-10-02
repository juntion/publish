<template>
    <a-modal :title="$t('user.modal.setOthersDepartment')"
             v-model="setDepartmentModalShow"
             :confirmLoading="setDepartmentBtnLoading"
             @ok="setOtherDepartment"
    >

        <a-form :form="setOtherDepartmentForm">
            <a-form-item :label="$t('user.modal.otherDepartment')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-tree-select
                        v-decorator="['department_id', departmentValidate]"
                        showSearch
                        treeNodeFilterProp="title"
                        :placeholder="$t('user.modal.chooseOthersDepartment')"
                        :multiple="true"
                        allowClear
                        :treeData="getDepartmentTree"
                >
                </a-tree-select>
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import { bus } from '../../../../plugins/bus'
import Vue from 'vue'
import { mapGetters } from 'vuex'
import { setOtherDepartments } from '../../../../api/userManage'
import { setInputErrors } from '../../../../plugins/common'

export default {
  name: 'setOtherDepartmentModal',
  data () {
    return {
      setDepartmentModalShow: false,
      setDepartmentBtnLoading: false,
      setOtherDepartmentForm: this.$form.createForm(this),
      departmentValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('user.modal.othersDepartmentRequire') }]
      }
    }
  },
  methods: {
    setOtherDepartment () {
      this.setOtherDepartmentForm.validateFields(err => {
        if (err === null) {
          this.setDepartmentBtnLoading = true
          let params = this.setOtherDepartmentForm.getFieldsValue()
          params.id = this.getCurrentUser.id
          setOtherDepartments(params).then(data => {
            if (data.status === 'success') {
              this.$message.success(this.$t('user.modal.setOthersDepartmentSuccess'))
              this.$store.dispatch('getUser')
              this.setDepartmentModalShow = false
            } else {
              this.$message.success(this.$t('user.modal.setOthersDepartmentError'))
              this.$store.dispatch('getUser')
            }
            this.setDepartmentBtnLoading = false
          }).catch(error => {
            setInputErrors(error, this.setOtherDepartmentForm)
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
    ...mapGetters(['getDepartmentTree', 'getCurrentUser'])
  },
  mounted () {
    bus.$on('showOtherDepartmentModal', data => {
      this.setDepartmentModalShow = true
      Vue.set(this.departmentValidate, 'initialValue', this.getCurrentUser.department_ids)
      this.setOtherDepartmentForm.resetFields()
    })
  }
}
</script>

<style scoped>

</style>
