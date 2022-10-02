<template>
    <a-modal :title="title"
             v-model="addDepartmentModalShow"
             :confirmLoading="addDepartmentBtnLoading"
             @ok="addDepartment"
    >
        <a-form :form="addDepartmentForm">
            <a-form-item :label="$t('department.list.parentDepartment')"
                         :label-col="{ span: 6 }"
                         v-if="getCurrentDepartment.action !== 'addChild' && getCurrentDepartment.action !== 'addFirstDepartment' && IsDepartmentShow"
                         :wrapper-col="{ span: 18 }"
            >
                <a-tree-select
                        showSearch
                        treeNodeFilterProp="title"
                        v-decorator="['parent_id',parentDepartmentValidate]"
                        allowClear
                        :treeData="getSelectDepartment"
                >
                </a-tree-select>
            </a-form-item>

            <a-form-item :label="$t('department.list.departmentName')"
                         :label-col="{ span: 6 }"
                         :wrapper-col="{ span: 18 }">
                <a-input
                        v-decorator="['name', nameValidate]"
                ></a-input>
            </a-form-item>
             <a-form-item :label="$t('department.list.code')"
                         v-if="show"
                         :label-col="{ span: 6 }"
                         :wrapper-col="{ span: 18 }">
                <a-input
                        :disabled="codeDisabled"
                        v-decorator="['code', codeValidate]"
                ></a-input>
            </a-form-item>
            <a-form-item :label="$t('department.list.baseDepartment')"
                         :label-col="{ span: 6 }"
                         :wrapper-col="{ span: 18 }"
                         v-if="canDo('departments.createBasic')"
            >
                <a-radio-group v-decorator="['is_base', baseDepartmentValidate]" @change="radioChange">
                    <a-radio value="1">
                        {{$t('common.yes')}}
                    </a-radio>
                    <a-radio value="0">
                        {{$t('common.no')}}
                    </a-radio>
                </a-radio-group>
            </a-form-item>
            <a-divider >{{$t('common.languages')}}</a-divider>
            <a-form-item
                    v-for="(item, key) in languages"
                    :key="key"
                    :label="item"
                    :label-col="{ span: 6 }"
                    :wrapper-col="{ span: 18 }">
                <a-input
                        v-decorator="[key, {
                        initialValue: JSON.parse(getCurrentDepartment.locale)[key],
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
import { mapGetters } from 'vuex'
import { languages } from '../../../plugins/lang'
import Vue from 'vue'
import { addDepartment, updateDepartmentInfo } from '../../../api/department'
import { canDo, setInputErrors } from '../../../plugins/common'

export default {
  name: 'addDepartmentModal',
  data () {
    return {
      title: '',
      show: true,
      codeDisabled: false,
      addDepartmentModalShow: false,
      addDepartmentBtnLoading: false,
      addDepartmentForm: this.$form.createForm(this),
      nameValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('department.notify.nameRequire') }]
      },
      codeValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('department.notify.codeRequire') }]
      },
      baseDepartmentValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('department.notify.baseDepartmentRequire') }]
      },
      parentDepartmentValidate: {
        validateTrigger: ['submit']
        // rules: [
        //   { required: true, message: () => this.$t('department.notify.parentDepartmentRequire') }]
      },
      languages: languages,
      IsDepartmentShow: false
    }
  },
  methods: {
    radioChange (val, obj) {
      if (val.target.value === '0') {
        this.IsDepartmentShow = true
      } else {
        this.IsDepartmentShow = false
      }
    },
    canDo,
    addDepartment () {
      this.addDepartmentForm.validateFields((err, values) => {
        if (err === null) {
          this.addDepartmentBtnLoading = true

          let params = {
            name: values.name,
            is_base: values.is_base,
            code: values.code
          }
          if (values.code) {
            params.code = values.code
          } else {
            params.code = undefined
          }
          let langArr = {}
          for (let item in languages) {
            Vue.set(langArr, item, values[item])
          }
          params.locale = JSON.stringify(langArr)
          if (this.getCurrentDepartment.action === 'addFirstDepartment') {
            params.parent_id = 0
            this.addNewDepartment(params)
          } else if (this.getCurrentDepartment.action === 'addChild') {
            params.parent_id = this.getCurrentDepartment.parent_id
            this.addNewDepartment(params)
          } else {
            params.id = this.getCurrentDepartment.id
            if (Number(this.getCurrentDepartment.is_base) === 1 && params.is_base === 1) {
              params.parent_id = this.getCurrentDepartment.parent_id
            } else {
              params.parent_id = values.parent_id === undefined ? 0 : values.parent_id
            }
            this.updateDepartment(params)
          }
        }
      })
    },
    addNewDepartment (params) {
      this.addDepartmentBtnLoading = true
      addDepartment(params).then(data => {
        if (data.status === 'success') {
          this.$message.success(this.$t('department.notify.addDepartmentSuccess'))
          this.addDepartmentModalShow = false
          bus.$emit('updateDepartmentLevelInfo')
          this.$store.dispatch('fetchDepartmentTree')
        } else {
          this.$message.error(this.$t('department.notify.addDepartmentError'))
        }
        this.addDepartmentBtnLoading = false
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
        this.addDepartmentBtnLoading = false
        setInputErrors(error, this.addDepartmentForm)
      })
    },
    updateDepartment (params) {
      this.addDepartmentBtnLoading = true
      updateDepartmentInfo(params).then(data => {
        if (data.status === 'success') {
          this.$message.success(this.$t('department.notify.updateDepartmentSuccess'))
          bus.$emit('updateDepartmentLevelInfo')
          this.addDepartmentModalShow = false
          this.$store.dispatch('fetchDepartmentTree')
        } else {
          this.$message.error(this.$t('department.notify.updateDepartmentError'))
        }
        this.addDepartmentBtnLoading = false
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
        this.addDepartmentBtnLoading = false
        setInputErrors(error, this.addDepartmentForm)
      })
    }
  },
  mounted () {
    bus.$on('showAddDepartmentModal', data => {
      this.addDepartmentForm.resetFields()
      this.addDepartmentModalShow = true
      Vue.set(this.nameValidate, 'initialValue', this.getCurrentDepartment.name)
      if (this.getCurrentDepartment.code) {
        this.codeDisabled = true
      } else {
        this.codeDisabled = false
      }
      Vue.set(this.codeValidate, 'initialValue', this.getCurrentDepartment.code)
      let isBase = this.getCurrentDepartment.is_base !== undefined ? this.getCurrentDepartment.is_base.toString() : '0'
      this.IsDepartmentShow = isBase === '0'
      let parentId = this.getCurrentDepartment.parent_id !== undefined ? this.getCurrentDepartment.parent_id.toString() : '0'
      parentId = parentId === '0' ? this.$t('common.noParentDepartment') : parentId
      Vue.set(this.baseDepartmentValidate, 'initialValue', isBase)
      Vue.set(this.parentDepartmentValidate, 'initialValue', parentId)
      switch (this.getCurrentDepartment.action) {
        case 'addFirstDepartment':
          this.title = this.$t('department.list.addLevel1')
          this.show = true
          break
        case 'addChild':
          this.title = this.$t('department.list.addChild')
          this.show = false
          break
        default:
          this.title = this.$t('department.list.updateInfo')
          if (parentId === this.$t('common.noParentDepartment')) {
            this.show = true
          } else {
            this.show = false
          }
      }
    })
  },
  computed: {
    ...mapGetters(['getCurrentDepartment', 'getSelectDepartment'])
  }
}
</script>

<style scoped>

</style>
