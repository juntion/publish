<template>
    <a-modal :title="title"
             v-model="distributionPermissionsModalShow"
             :confirmLoading="distributionPermissionsBtnLoading"
             @ok="distributionPermissions"
             width="1000px"
    >
        <a-form :form="form">
            <a-form-item>
                <a-checkbox-group
                        v-decorator="['profile_ids', Validate]"
                        style="width: 100%;"
                >
                    <a-row>
                        <a-col :span="6" v-for="(item, key) in getErpAllProfiles" :key="key">
                            <a-checkbox :value="item.profile_id">
                                {{item.profile_name}}
                            </a-checkbox>
                        </a-col>
                    </a-row>
                </a-checkbox-group>
            </a-form-item>
            <a-divider >{{$t('common.user')}}</a-divider>
                <a-form-item>
                    <a-checkbox-group
                            v-decorator="['user_ids', UserValidate]"
                            style="width: 100%;"
                    >
                        <a-row>
                            <a-col :span="4" v-for="(item, key) in canSetUserData" :key="key">
                                <a-checkbox :value="item.id">
                                    {{item.name}}
                                </a-checkbox>
                            </a-col>
                        </a-row>
                    </a-checkbox-group>
                </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import { bus } from '../../../plugins/bus'
import { mapGetters } from 'vuex'
import { SetUsersProfiles, getCanSetUsers } from '../../../api/department'

export default {
  name: 'distributionPermissionsModal',
  data () {
    return {
      title: () => this.$t('department.action.distributionPermissions'),
      distributionPermissionsModalShow: false,
      distributionPermissionsBtnLoading: false,
      form: this.$form.createForm(this),
      Validate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('department.notify.profilesRequire') }]
      },
      UserValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('department.notify.usersRequire') }]
      },
      canSetUserData: [],
      department_id: undefined
    }
  },
  methods: {
    distributionPermissions () {
      this.form.validateFields((err, value) => {
        if (err === null) {
          this.distributionPermissionsBtnLoading = true
          SetUsersProfiles(value).then(data => {
            if (data.status === 'success') {
              this.distributionPermissionsBtnLoading = false
              this.distributionPermissionsModalShow = false
              this.$message.success(this.$t('department.notify.AddUsersErpProfilesSuccess'))
            } else {
              this.distributionPermissionsBtnLoading = false
              this.$message.error(this.$t('department.notify.AddUsersErpProfilesError'))
            }
          }).catch(error => {
            this.distributionPermissionsBtnLoading = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        } else {
          return false
        }
      })
    },
    getCanSetUserData (departmentId) {
      getCanSetUsers({ department_id: departmentId }).then(data => {
        this.canSetUserData = data.data
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    }
  },
  mounted () {
    bus.$on('ShowDistributionPermissionsModal', data => {
      this.distributionPermissionsModalShow = true
      this.UserValidate.initialValue = []
      this.Validate.initialValue = []
      if (data.department_id !== this.department_id || !this.canSetUserData) {
        this.canSetUserData = []
        this.department_id = data.department_id
        this.getCanSetUserData(data.department_id)
      }
      this.form.resetFields()
    })
  },
  computed: {
    ...mapGetters(['getErpAllProfiles'])
  }
}
</script>

<style scoped>

</style>
