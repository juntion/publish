<template>
    <!-- 更新用户信息的模态框 -->
    <a-modal
            :title="$t('user.modal.updateUser')"
            v-model="UpdateUserModalShow"
            :confirmLoading="UserInfoBtnLoading"
            @ok="updateUserInfo"
    >
        <a-form :form="updateUserForm">
            <a-form-item :label="$t('user.modal.username')"
                         :label-col="{ span: 5 }"
                         :wrapper-col="{ span: 18 }">
                <a-input v-decorator="['name', nameValidate]"/>
            </a-form-item>
            <a-form-item :label="$t('user.modal.email')"
                         :label-col="{ span: 5 }"
                         :wrapper-col="{ span: 18 }">
                <a-input v-decorator="['email', emailValidate]"/>
            </a-form-item>
            <a-form-item :label="$t('user.modal.serviceArea')"
                         :label-col="{ span: 5 }"
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
                         :label-col="{ span: 5 }"
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
<!--            <a-form-item :label="$t('user.modal.station')"-->
<!--                         :label-col="{ span: 5 }"-->
<!--                         :wrapper-col="{ span: 18 }"-->
<!--                         v-if="postsShow"-->
<!--            >-->
<!--                <a-select-->
<!--                        showSearch-->
<!--                        :placeholder="$t('user.modal.station')"-->
<!--                        v-decorator="['post_ids',teamlValidate]"-->
<!--                        allowClear-->
<!--                        optionFilterProp="children"-->
<!--                >-->
<!--                    <a-select-option v-for="(item, key) in postsData" :key="key" :value="item.id">{{JSON.parse(item.locale)[getLanguage]}}</a-select-option>-->
<!--                </a-select>-->
<!--            </a-form-item>-->
            <a-form-item :label="$t('user.modal.adminLevel')"
                         :label-col="{ span: 5 }"
                         :wrapper-col="{ span: 18 }"
            >
                <a-select
                        showSearch
                        :placeholder="$t('user.modal.adminLevel')"
                        v-decorator="['admin_level',adminLevelValidate]"
                        allowClear
                        optionFilterProp="children"
                >
                    <a-select-option v-for="(item, key) in getAdminLevels" :key="key" :value="item.profile_id">{{item.profile_name}}</a-select-option>
                </a-select>
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import { mapGetters } from 'vuex'
import { bus } from '../../../../plugins/bus'
import Vue from 'vue'
import { updateUseInfo } from '../../../../api/userManage'
import { salesType, serviceArea, setInputErrors } from '../../../../plugins/common'
import _ from 'lodash'

export default {
  name: 'updateUserModal',
  data () {
    return {
      postsShow: false,
      postsData: [],
      salesType,
      serviceArea,
      showLanguage: true,
      showArea: true,
      updateUserForm: this.$form.createForm(this),
      nameValidate: {
        validateTrigger: ['submit'],
        initialValue: '',
        rules: [
          { required: true, message: () => this.$t('user.modal.nameRequire') }]
      },
      emailValidate: {
        validateTrigger: ['submit'],
        initialValue: '',
        rules: [
          { required: true, message: () => this.$t('user.modal.emailRequire') }]
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
      adminLevelValidate: {
        validateTrigger: ['submit']
        // rules: [
        //   { required: true, message: () => this.$t('user.modal.adminLevelRequire') }]
      },
      teamlValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('user.modal.stationRequire') }]
      },
      UpdateUserModalShow: false,
      UserInfoBtnLoading: false
    }
  },
  methods: {
    updateUserInfo () {
      this.updateUserForm.validateFields((err, value) => {
        if (err === null) {
          this.UserInfoBtnLoading = true
          let params = value
          params.id = this.getCurrentUser.id
          if (value.post_ids !== undefined) {
            params.post_ids = [value.post_ids]
          }
          if (value.admin_level === null) {
            delete params.admin_level
          }
          updateUseInfo(params).then(data => {
            this.UserInfoBtnLoading = false
            if (data.status === 'success') {
              this.$message.success(this.$t('user.modal.updateUserSuccess'))
              this.UpdateUserModalShow = false
              this.$store.dispatch('getUser')
            } else {
              this.$message.error(this.$t('user.modal.updateUserError'))
            }
          }).catch(error => {
            setInputErrors(error, this.updateUserForm)
            this.UserInfoBtnLoading = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        }
      })
    }
  },
  computed: {
    ...mapGetters(['getUpdateUserModalShow', 'getCurrentUser', 'getLanguage', 'getAdminLevels', 'getAllOptions'])
  },
  mounted () {
    bus.$on('showUpdateInfoModal', () => {
      this.showArea = false
      this.showLanguage = false
      this.postsShow = false
      Vue.set(this.nameValidate, 'initialValue', this.getCurrentUser.name)
      Vue.set(this.emailValidate, 'initialValue', this.getCurrentUser.email)
      Vue.set(this.adminLevelValidate, 'initialValue', this.getCurrentUser.admin_level != null ? this.getCurrentUser.admin_level.toString() : '')
      this.updateUserForm.resetFields()
      this.UpdateUserModalShow = true
      let position = this.getCurrentUser.positions
      let type = 0
      if (position.length > 0) {
        type = position[0]['type']
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
        let index = _.find(this.getAllOptions, ['id', position[0]['id']])
        this.postsData = index.posts
        Vue.set(this.teamlValidate, 'initialValue', this.getCurrentUser.posts[0]['id'])
      }
    })
  }
}
</script>

<style scoped>

</style>
