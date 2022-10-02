<template>
    <a-modal :title="title"
             v-model="setPermissionModalShow"
             :confirmLoading="setPermissionBtnLoading"
             @ok="setPermission"
             @cancel="cancel"
             width="1000px"
             heig
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
            <a-divider >{{$t('common.hasProfiles')}}</a-divider>
            <a-form-item>
                <a-popconfirm :title="$t('department.notify.deleteProfile')" @confirm="delUserProfilesById(item.profile_id)"  :okText="$t('common.ok')" :cancelText="$t('common.cancel')" v-for="(item, key) in hasProfiles" :key="key">
                    <a href="#" class="delSpan" >{{item.profile_name}}<a-icon type="delete" /></a>
                </a-popconfirm>
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>
import { bus } from '../../../plugins/bus'
import { mapGetters } from 'vuex'
import { DelUserProfiles, getUserErpProfiles, SetUserProfiles } from '../../../api/department'
import _ from 'lodash'

export default {
  name: 'setPermissionModal',
  data () {
    return {
      title: () => this.$t('department.action.SetPermissions'),
      setPermissionBtnLoading: false,
      setPermissionModalShow: false,

      form: this.$form.createForm(this),
      uid: '',
      Validate: {
        initialValue: []
      },
      oldData: [],
      hasProfiles: []
    }
  },
  methods: {
    cancel () {
      this.form.resetFields()
      this.Validate.initialValue = []
    },
    async setPermission () {
      // let delData = _.difference(this.oldData, this.form.getFieldValue('profile_ids'))
      let params = { profile_ids: this.form.getFieldValue('profile_ids'), id: this.uid }
      this.AddUserProfiles(params)
      // for (let i in delData) {
      //   console.log(i, delData[i])
      //   await this.delUserProfiles({ id: this.uid, profile_id: delData[i] })
      // }
    },
    async getErpProfiles () {
      this.setPermissionBtnLoading = true
      await getUserErpProfiles({ id: this.uid }).then(data => {
        let profiles = []
        this.hasProfiles = data.data
        _.forEach(data.data, function (value) {
          profiles.push(value.profile_id)
        })
        this.$nextTick(() => {
          this.form.setFieldsValue({ 'profile_ids': profiles })
        })
        this.Validate.initialValue = profiles

        this.oldData = profiles
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
      this.setPermissionBtnLoading = false
    },
    AddUserProfiles (params) {
      this.setPermissionBtnLoading = true
      SetUserProfiles(params).then(data => {
        if (data.status === 'success') {
          this.$message.success(this.$t('department.notify.AddErpProfilesSuccess'))
          this.setPermissionModalShow = false
          this.setPermissionBtnLoading = false
        } else {
          this.$message.error(this.$t('department.notify.AddErpProfilesError'))
        }
      }).catch(error => {
        this.setPermissionBtnLoading = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    delUserProfiles (params) {
      DelUserProfiles(params).then(data => {
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    delUserProfilesById (pid) {
      this.setPermissionBtnLoading = true
      let params = {
        id: this.uid,
        profile_id: pid
      }
      DelUserProfiles(params).then(data => {
        if (data.status === 'success') {
          this.$message.success(this.$t('department.notify.delErpProfilesSuccess'))
          this.getErpProfiles()
        } else {
          this.setPermissionBtnLoading = false
          this.$message.error(this.$t('department.notify.delErpProfilesError'))
        }
      }).catch(error => {
        this.setPermissionBtnLoading = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    }
  },
  mounted () {
    bus.$on('showSetPermissionModal', data => {
      this.setPermissionModalShow = true
      this.uid = data
      this.getErpProfiles()
    })
  },
  computed: {
    ...mapGetters(['getErpAllProfiles'])
  }
}
</script>

<style scoped>
    .delSpan{
        display: inline-block;
        padding: 5px 10px;
        margin: 0 10px;
    }
</style>
