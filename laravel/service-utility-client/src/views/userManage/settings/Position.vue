<template>
    <div style="padding-right: 90px;">
        <div class="setting-title">{{ $t('system.settings.positionTitle') }}</div>
        <a-form style="width: 100%;" :form="form" @submit="handleSubmit" class="title-manage">
            <a-form-item v-bind="formItemLayout">
                <p class="p-title must" style="margin-bottom: 0;">{{ $t('system.settings.language') }}</p>
                <a-select
                        @change="languageChange"
                        showSearch
                        v-decorator="['language',languageValidate]"
                        allowClear
                        optionFilterProp="children"
                        :placeholder="$t('system.settings.PositionSelPlaceholder')"
                >
                    <a-select-option v-for="(item, key) in languageData" :key="key" :value="item.assistant_id">{{item.assistant_name}}</a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item v-bind="formItemLayout">
                <p class="p-title must" style="margin-bottom: 0;">{{ $t('system.settings.positionType') }}</p>
                <a-select
                        @change="TypeChange"
                        showSearch
                        v-decorator="['positionType',positionTypeValidate]"
                        allowClear
                        optionFilterProp="children"
                        :placeholder="$t('system.settings.PositionSelPlaceholder')"
                >
                    <a-select-option v-for="(item, key) in typeData" :key="key" :value="item.assistant_id">{{item.assistant_name}}</a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item v-bind="formItemLayout">
                <p class="p-title must" style="margin-bottom: 0;">{{ $t('system.settings.positionName') }}</p>
                <a-select
                        showSearch
                        v-decorator="['positionName',positionNameValidate]"
                        allowClear
                        optionFilterProp="children"
                        :placeholder="$t('system.settings.PositionSelPlaceholder')"
                >
                    <a-select-option v-for="(item, key) in nameData" :key="key" :value="item.assistant_id">{{item.assistant_name}}</a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item>
                <a-button type="primary" htmlType="submit" :loading="loading" class="p-btn" style="display: block;">{{ $t('system.settings.submit') }}</a-button>
            </a-form-item>
        </a-form>
    </div>
</template>

<script>
import { getAssistantLevel, setAssistantLevel } from '../../../api/system/setting'
import _ from 'lodash'
import { setInputErrors } from '../../../plugins/common'

export default {
  name: 'Position',
  data () {
    return {
      form: this.$form.createForm(this),
      formItemLayout: { labelCol: { span: 5 }, wrapperCol: { span: 19 } },
      languageValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: this.$t('system.settings.languageRequired') }
        ]
      },
      positionTypeValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: this.$t('system.settings.positionTypeRequired') }
        ]
      },
      positionNameValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: this.$t('system.settings.positionNameRequired') }
        ]
      },
      loading: false,
      allData: [],
      languageData: [],
      typeData: [],
      nameData: []
    }
  },
  methods: {
    languageChange (val) {
      this.form.setFieldsValue({
        positionType: '',
        positionName: ''
      })
      this.typeData = _.filter(this.allData, function (item) {
        return item.pid === val
      })
    },
    TypeChange (val) {
      this.form.setFieldsValue({
        positionName: ''
      })
      let levelData = _.filter(this.allData, function (item) {
        return item.pid === val
      })
      let ids = []
      _.map(levelData, function (item) {
        ids.push(item.assistant_id)
      })
      this.nameData = _.filter(this.allData, function (item) {
        return ids.indexOf(item.pid) > -1
      })
    },
    getDataInfo () {
      let params = {
        types: [0, 1, 2, 3]
      }
      getAssistantLevel(params).then(data => {
        this.allData = data.data
        this.languageData = _.filter(data.data, function (item) {
          return item.type === '0' && item.pid === '0'
        })
        this.showUserInfoData()
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handleSubmit (e) {
      e.preventDefault()
      this.form.validateFields((err, values) => {
        if (err) return false
        let params = {}
        params.assistant_id = values.positionName
        let selectedData = _.filter(this.allData, function (item) {
          return Number(item.assistant_id) === Number(values.positionName)
        })
        params.assistant_name = selectedData[0]['assistant_name']
        this.loading = true
        setAssistantLevel(params).then(data => {
          if (data.status === 'success') {
            this.$store.dispatch('refresh')
            this.$message.success(this.$t('system.settings.setSalesPositionSuccess'))
            this.loading = false
          } else {
            this.$message.success(this.$t('system.settings.setSalesPositionFailed'))
          }
        }).catch(error => {
          setInputErrors(error, this.form)
          this.$message.error(error.response ? error.response.data.message : error.message)
        }).finally(() => {
          this.loading = false
        })
      })
    },
    async showUserInfoData () {
      let assistantId = JSON.parse(localStorage.getItem('user'))['assistant_id']
      if (Boolean(assistantId) === false) {
        return false
      }
      let NameData = _.filter(this.allData, function (item) {
        return Number(item.assistant_id) === Number(assistantId)
      })
      let levelId = NameData[0]['pid']
      let levelData = _.filter(this.allData, function (item) {
        return Number(item.assistant_id) === Number(levelId)
      })
      let typeId = levelData[0]['pid']
      let TypeData = _.filter(this.allData, function (item) {
        return Number(item.assistant_id) === Number(typeId)
      })
      let languageId = TypeData[0]['pid']
      await this.languageChange(languageId)
      await this.TypeChange(typeId)
      this.form.setFieldsValue({
        language: languageId,
        positionType: typeId,
        positionName: assistantId.toString()
      })
    }
  },
  created () {
    this.getDataInfo()
  }
}
</script>

<style lang="less">
  .title-manage{

    .ant-select-selection {
      border: 0;
      border-bottom: 1px solid #ccc;
      border-radius: 0;
      font-size: 12px;
      box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);

      .ant-select-selection__rendered {
        margin-left: 0;
      }
    }
  }
</style>
