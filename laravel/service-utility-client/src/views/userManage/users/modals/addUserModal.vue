  <template>
    <a-modal
            :title="$t('user.modal.addUser')"
            v-model="isShow"
            :confirmLoading="addUserBtnLoading"
            @ok="addUser"
    >
        <a-form :form="addForm">
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
            <a-form-item :label="$t('user.modal.defaultDepartment')"
                         :label-col="{ span: 5 }"
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
            <a-form-item :label="$t('user.modal.position')"
                         :label-col="{ span: 5 }"
                         :wrapper-col="{ span: 18 }">
                <a-select
                        @change="positionChange"
                        showSearch
                        :placeholder="$t('user.modal.position')"
                        v-decorator="['position_ids',positionValidate]"
                        allowClear
                        optionFilterProp="children"
                >
                    <a-select-option v-for="(item, key) in getAllOptions" :key="key" :data-type="item.type" :value="item.id">{{JSON.parse(item.locale)[getLanguage]}}</a-select-option>
                </a-select>
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

            <a-form-item :label="$t('user.modal.station')"
                         :label-col="{ span: 5 }"
                         :wrapper-col="{ span: 18 }"
                         v-if="postsShow"
            >
                <a-select
                        showSearch
                        :placeholder="$t('user.modal.station')"
                        v-decorator="['post_ids',teamlValidate]"
                        allowClear
                        optionFilterProp="children"
                >
                    <a-select-option v-for="(item, key) in postsData" :key="key" :value="item.id">{{JSON.parse(item.locale)[getLanguage]}}</a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item :label="$t('user.user.subsidiaryCompany')"
                         :label-col="{ span: 5 }"
                         :wrapper-col="{ span: 18 }"
            >
                <a-select
                        showSearch
                        :placeholder="$t('user.user.subsidiaryCompany')"
                        v-decorator="['company_id',subsidiaryCompany]"
                        allowClear
                        optionFilterProp="children"
                >
                    <a-select-option v-for="(item, key) in getSubsidiaryCompanies" :key="key" :value="item.id">{{item.company_name}}</a-select-option>
                </a-select>
            </a-form-item>
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
import { addNewUser } from '../../../../api/userManage'
import { bus } from '../../../../plugins/bus'
import { serviceArea, salesType, setInputErrors } from '../../../../plugins/common'

export default {
  name: 'addUserModal',
  data () {
    return {
      postsData: [],
      postsShow: false,
      serviceArea,
      salesType,
      showLanguage: false,
      showArea: false,
      nameValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('user.modal.nameRequire') }]
      },
      emailValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('user.modal.emailRequire') }]
      },
      departmentValidate: {
        validateTrigger: ['submit'],
        initialValue: '',
        rules: [
          { required: true, message: () => this.$t('user.modal.departmentRequire') }]
      },
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
      subsidiaryCompany: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('user.modal.adminLevelRequire') }]
      },
      adminLevelValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('user.modal.adminLevelRequire') }]
      },
      teamlValidate: {
        validateTrigger: ['submit'],
        rules: [
          { required: true, message: () => this.$t('user.modal.stationRequire') }]
      },
      addUserBtnLoading: false,
      addForm: this.$form.createForm(this),
      isShow: false
    }
  },
  methods: {
    addUser () {
      this.addForm.validateFields(err => {
        if (err === null) {
          this.addUserBtnLoading = true
          let parmas = this.addForm.getFieldsValue()
          parmas.position_ids = [parmas.position_ids]
          if (parmas.post_ids !== undefined) {
            parmas.post_ids = [parmas.post_ids]
          }
          addNewUser(parmas).then(data => {
            if (data.status === 'success') {
              this.$message.success(this.$t('user.modal.addUserSuccess'))
              this.$store.dispatch('getUser')
              this.isShow = false
            } else {
              this.$message.error(data.message)
            }
            this.addUserBtnLoading = false
          }).catch(error => {
            this.addUserBtnLoading = false
            setInputErrors(error, this.addForm)
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        } else {
          return false
        }
      }).catch(error => {
        this.addUserBtnLoading = false
        this.$message.error(error.response ? error.response.data.message : error.message)
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
          this.postsData = posts
        }
      }
    }
  },
  computed: {
    ...mapGetters(['getAllOptions', 'getDepartmentTree', 'getLanguage', 'getAdminLevels', 'getSubsidiaryCompanies'])
  },
  mounted () {
    let _this = this
    bus.$on('restAddUserModal', function () {
      _this.isShow = true
      _this.addForm.resetFields()
    })
    this.addFormVals = this.addForm.getFieldsValue()
  }

}
</script>

<style scoped>

</style>
