<template>
    <a-modal
            :title="$t('user.modal.setPosition')"
            v-model="setPositionModalShow"
            :confirmLoading="setPositionBtnLoading"
            @ok="setPosition"
    >
        <a-form :form="setPositionForm">
            <a-form-item :label="$t('user.modal.position')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }">
                <a-select
                        showSearch
                        :placeholder="$t('user.modal.position')"
                        v-decorator="[getIsGroupSet ? 'position_id' : 'position_ids[]', positionValidate]"
                        allowClear
                        optionFilterProp="children"
                        @change="positionChange"
                >
                    <a-select-option v-for="(item, key) in getAllOptions" :key="key" :data-type="item.type" :value="item.id">{{JSON.parse(item.locale)[getLanguage]}}</a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item :label="$t('user.modal.serviceArea')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }"
                         v-if="showArea"
            >
                <a-select
                        showSearch
                        :placeholder="$t('user.modal.serviceArea')"
                        v-decorator="['is_customer_service',serviceAreaValidate]"
                        allowClear
                        optionFilterProp="children"
                >
                    <a-select-option v-for="(item, key) in serviceArea" :key="key" :value="item.id">{{JSON.parse(item.locale)[getLanguage]}}</a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item :label="$t('user.modal.saleType')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }"
                         v-if="showLanguage"
            >
                <a-select
                        showSearch
                        :placeholder="$t('user.modal.saleType')"
                        v-decorator="['which_language',saleTypeValidate]"
                        allowClear
                        optionFilterProp="children"
                >
                    <a-select-option v-for="(item, key) in salesType" :key="key" :value="item.id">{{JSON.parse(item.locale)[getLanguage]}}</a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item :label="$t('user.modal.station')"
                         :label-col="{ span: 4 }"
                         :wrapper-col="{ span: 18 }"
                         v-if="postsShow"
            >
                <a-select
                        showSearch
                        :placeholder="$t('user.modal.station')"
                        v-decorator="['post_id',teamlValidate]"
                        allowClear
                        optionFilterProp="children"
                >
                    <a-select-option v-for="(item, key) in postsData" :key="key" :value="item.id">{{JSON.parse(item.locale)[getLanguage]}}</a-select-option>
                </a-select>
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import { setPositions } from '../../../../api/userManage'
import Vue from 'vue'
import { bus } from '../../../../plugins/bus'
import { mapGetters } from 'vuex'
import _ from 'lodash'
import { serviceArea, salesType, setInputErrors } from '../../../../plugins/common'

export default {
  name: 'setPositionModal',
  data () {
    return {
      postsData: [],
      postsShow: false,
      serviceArea,
      salesType,
      showLanguage: false,
      showArea: false,
      setPositionForm: this.$form.createForm(this),
      setPositionModalShow: false,
      setPositionBtnLoading: false,
      positionValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('user.modal.positionRequire') }]
      },
      serviceAreaValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('user.modal.serviceAreaRequire') }]
      },
      saleTypeValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('user.modal.saleTypeRequire') }]
      },
      teamlValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('user.modal.stationRequire') }]
      }
    }
  },
  methods: {
    // 设置职称
    setPosition () {
      this.setPositionForm.validateFields((err, value) => {
        if (err === null) {
          let params = {}
          this.setPositionBtnLoading = true
          if (this.getIsGroupSet) {
            params = value
            params.groupSet = true
            params.user_ids = this.getSelectRows
          } else {
            params = value
            params.groupSet = false
            params.position_ids = [this.setPositionForm.getFieldValue('position_ids[]')]
            params.id = this.getCurrentUser.id
            if (value.post_id !== undefined) {
              params.post_ids = [value.post_id]
            }
          }
          setPositions(params).then(data => {
            if (data.status === 'success') {
              this.$message.success(this.$t('user.modal.setPositionSuccess'))
              this.$store.dispatch('getUser')
              this.setPositionModalShow = false
            } else {
              this.$message.error(this.$t('user.modal.setPositionError'))
            }
            this.setPositionBtnLoading = false
          }).catch(error => {
            setInputErrors(error, this.setPositionForm)
            this.$message.error(error.response ? error.response.data.message : error.message)
            this.setPositionBtnLoading = false
          })
        } else {
          return false
        }
      })
    },
    positionChange (value, data) {
      let type = data !== undefined ? data.data.attrs['data-type'] : 0
      this.showArea = false
      this.showLanguage = false
      this.postsShow = false
      if (Number(type) === 1) {
        this.showArea = true
      }
      if (Number(type) === 2) {
        this.showLanguage = true
      }
      let index = data !== undefined ? data.data['key'] : -1
      if (index > -1) {
        let posts = this.getAllOptions[index]['posts']
        if (posts.length > 0) {
          this.postsShow = true
          Vue.set(this.teamlValidate, 'initialValue', '')
          this.setPositionForm.resetFields(['post_id'])
          this.postsData = posts
        }
      }
    }
  },
  computed: {
    ...mapGetters(['getAllOptions', 'getSelectRows', 'getIsGroupSet', 'getCurrentUser', 'getLanguage'])
  },
  mounted () {
    bus.$on('showPositionModal', (data) => {
      this.showArea = false
      this.showLanguage = false
      this.postsShow = false
      if (this.getIsGroupSet || data) {
        Vue.set(this.positionValidate, 'initialValue', [])
        this.setPositionForm.resetFields()
      } else {
        let positionsArr = ''
        let type = 0
        if (this.getCurrentUser.positions.length > 0) {
          positionsArr = this.getCurrentUser.positions[0]['id']
          type = this.getCurrentUser.positions[0]['type']
        }
        if (Number(type) === 1) {
          this.showArea = true
          Vue.set(this.serviceAreaValidate, 'initialValue', this.getCurrentUser.is_customer_service)
        }
        if (Number(type) === 2) {
          this.showLanguage = true
          Vue.set(this.saleTypeValidate, 'initialValue', this.getCurrentUser.which_language)
        }
        if (Number(type) === 3) {
          this.postsShow = true
          let position = this.getCurrentUser.positions
          let index = _.find(this.getAllOptions, ['id', position[0]['id']])
          this.postsData = index.posts
          Vue.set(this.teamlValidate, 'initialValue', this.getCurrentUser.posts[0]['id'])
        }
        Vue.set(this.positionValidate, 'initialValue', positionsArr)
        this.setPositionForm.resetFields()
      }
      this.setPositionModalShow = true
    })
  }
}
</script>

<style scoped>

</style>
