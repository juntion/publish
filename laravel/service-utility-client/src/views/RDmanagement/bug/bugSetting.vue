<template>
    <div>
        <a-modal    title="编辑绑定负责人"
                class="modal-pms"
                v-model="dialogVisible1"
                :confirmLoading="btnLoad"
                @cancel="cancel(1)"
                @ok="ok(1)"
                :maskClosable="false"
                destroyOnClose
                width="380px">
                    <a-form-model
                            :model="principalForm"
                            ref="principalForm">
                        <div v-if="editType" style="margin-bottom:10px">
                            <p style="margin-bottom:10px"><span style="color:red">*</span> 部门: </p>
                            <a-tag class="deptTags"
                            closable
                            v-for="(dept,index) in depts" :key="dept.id"
                            @close="closeDept($event,dept,index)" >{{dept.name}}</a-tag>
                        </div>
                        <a-form-model-item prop="frontend_program_user_id" style="margin-bottom:20px"
                                        :rules="{
                                            required: true,
                                            message: '请选择',
                                            trigger: 'change',
                                        }">
                                <span slot="label">前台程序负责人</span>
                                <a-select
                                        v-model="principalForm.frontend_program_user_id"
                                        allowClear
                                        showSearch
                                        optionFilterProp="children"
                                        @search="search($event, 1)"
                                        placeholder="请输入英文名搜索"
                                        title="请输入英文名搜索">
                                <a-select-option v-for="k in options_1"
                                                :key="k.id">{{k.name}}</a-select-option>
                            </a-select>
                        </a-form-model-item>
                        <a-form-model-item prop="frontend_product_user_id" style="margin-bottom:20px" :rules="{
                                            required: true,
                                            message: '请选择',
                                            trigger: 'change',
                                        }">
                                <span slot="label">前台产品负责人</span>
                                <a-select
                                        v-model="principalForm.frontend_product_user_id"
                                        allowClear
                                        showSearch
                                        optionFilterProp="children"
                                        @search="search($event, 2)"
                                        placeholder="请输入英文名搜索"
                                        title="请输入英文名搜索">
                                <a-select-option v-for="k in options_2"
                                                :key="k.id">{{k.name}}</a-select-option>
                            </a-select>
                        </a-form-model-item>
                        <a-form-model-item prop="backend_program_user_id" style="margin-bottom:20px" :rules="{
                                            required: true,
                                            message: '请选择',
                                            trigger: 'change',
                                        }">
                                <span slot="label">后台程序负责人</span>
                                <a-select
                                        v-model="principalForm.backend_program_user_id"
                                        allowClear
                                        showSearch
                                        optionFilterProp="children"
                                        @search="search($event, 3)"
                                        placeholder="请输入英文名搜索"
                                        title="请输入英文名搜索">
                                <a-select-option v-for="k in options_3"
                                                :key="k.id">{{k.name}}</a-select-option>
                            </a-select>
                        </a-form-model-item>
                        <a-form-model-item prop="backend_product_user_id" style="margin-bottom:20px" :rules="{
                                            required: true,
                                            message: '请选择',
                                            trigger: 'change',
                                        }">
                                <span slot="label">后台产品负责人</span>
                                <a-select
                                        v-model="principalForm.backend_product_user_id"
                                        allowClear
                                        showSearch
                                        optionFilterProp="children"
                                        @search="search($event, 4)"
                                        placeholder="请输入英文名搜索"
                                        title="请输入英文名搜索">
                                <a-select-option v-for="k in options_4"
                                                :key="k.id">{{k.name}}</a-select-option>
                            </a-select>
                        </a-form-model-item>
                        <a-form-model-item prop="test_user_id"  :rules="{
                                            required: true,
                                            message: '请选择',
                                            trigger: 'change',
                                        }">
                                <span slot="label">测试负责人</span>
                                <a-select
                                        v-model="principalForm.test_user_id"
                                        allowClear
                                        showSearch
                                        optionFilterProp="children"
                                        @search="search($event, 5)"
                                        placeholder="请输入英文名搜索"
                                        title="请输入英文名搜索">
                                <a-select-option v-for="k in options_5"
                                                :key="k.id">{{k.name}}</a-select-option>
                            </a-select>
                        </a-form-model-item>

                    </a-form-model>
        </a-modal>

        <a-modal    title="新增类型"
                    class="modal-pms"
                   v-model="dialogVisible2"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(2)"
                   @ok="ok(2)"
                   :maskClosable="false"
                   destroyOnClose
                   width="700px">
                        <a-form-model
                                :model="addForm"
                                style="display: flex;"
                                ref="addForm">
                                <div style="width:50%;margin-right:20px">
                                    <p style="margin-bottom: 10px;"><span style="color:red">*</span> 原因类型: </p>
                                    <a-form-model-item
                                        v-for="(item,index) in addForm.reasons" :key="index"
                                    :prop="'reasons.' + index + '.reason'"
                                    :rules="{
                                            required: true,
                                            message: '请输入类型名称',
                                            trigger: 'blur',
                                        }"
                                        :style="{'margin-bottom':index=== addForm.reasons.length-1 ? '0': '10px'}">
                                            <a-input v-model="item.reason" placeholder="请输入类型名称"></a-input>
                                    </a-form-model-item>
                                </div>
                                <div style="flex:1">
                                    <p style="margin-bottom: 10px;"><span style="color:red">*</span>  分析说明是否必填：<span class="cup" @click="addReasonsType" style="float:right;color:#378EEF"><a-icon type="plus" /> 添加</span></p>
                                    <a-form-model-item
                                        v-for="(item,index) in addForm.reasons" :key="index"
                                        :prop="'reasons.' + index + '.required_analyse'"
                                        :rules="{
                                                required: true,
                                                message: '请选择',
                                                trigger: 'change',
                                            }"
                                            :style="{'margin-bottom':index=== addForm.reasons.length-1 ? '0': '10px'}">
                                                <a-select placeholder="请选择"
                                                        style="width:92%"
                                                                        v-model="item.required_analyse"
                                                                        >
                                                                <a-select-option :value="0">非必填</a-select-option>
                                                                <a-select-option :value="1">必填</a-select-option>
                                                </a-select>
                                                <span style="margin-left:10px;" class="iconfont fz12 cup" @click="delReason(index)">&#xe64d;</span>
                                    </a-form-model-item>
                                </div>
                        </a-form-model>
        </a-modal>
         <a-modal title="提示"
                    class="modal-pms"
                   v-model="dialogVisible3"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(3)"
                   @ok="ok(3)"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                    <div>
                        <div class="tac">
                            <p style="font-size:16px;margin-bottom:10px;margin-top:20px">确定<span style="color:red"> 删除 </span>此原因类型?</p>
                            <p style="color:#F88D49;margin-bottom:20px;line-height: 1;">删除后不可恢复,请谨慎操作</p>
                        </div>
                    </div>
                    <div slot="footer" class="tac">
                            <a-button @click="ok(3)" type="primary">确定</a-button>
                            <a-button @click="cancel(3)">取消</a-button>
                    </div>
        </a-modal>
        <a-modal    title="编辑类型"
                    class="modal-pms"
                   v-model="dialogVisible4"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(4)"
                   @ok="ok(4)"
                   :maskClosable="false"
                   destroyOnClose
                   width="700px">
                        <a-form-model
                                :model="editForm"
                                style="display: flex;"
                                ref="editForm">
                                <div style="width:50%;margin-right:20px">
                                    <p style="margin-bottom: 10px;"><span style="color:red">*</span> 原因类型: </p>
                                    <a-form-model-item
                                    prop="reason"
                                    :rules="{
                                            required: true,
                                            message: '请输入类型名称',
                                            trigger: 'blur',
                                        }">
                                        <a-input v-model="editForm.reason" placeholder="请输入类型名称"></a-input>
                                    </a-form-model-item>
                                </div>
                                <div style="flex:1">
                                    <p style="margin-bottom: 10px;"><span style="color:red">*</span>  分析说明是否必填：</p>
                                    <a-form-model-item

                                        prop="required_analyse"
                                        :rules="{
                                                required: true,
                                                message: '请选择',
                                                trigger: 'change',
                                            }"
                                            >
                                                <a-select placeholder="请选择"
                                                        style="width:100%%"
                                                                        v-model="editForm.required_analyse"
                                                                        >
                                                                <a-select-option :value="0">非必填</a-select-option>
                                                                <a-select-option :value="1">必填</a-select-option>
                                                </a-select>

                                    </a-form-model-item>
                                </div>
                        </a-form-model>
        </a-modal>
         <a-card >
              <a-button type="primary"
                    v-if="activeKey===2 && canDo('pm.bugs.reason.store')"
                    class="cup"
                    @click="addType"
                    style="position: absolute; right: 24px;z-index:100"
                    >
                <a-icon type="plus"  />新增类型</a-button>
              <a-tabs v-model="activeKey">
                    <a-tab-pane tab="绑定负责人" :key="1">
                        <div class="table-list" >
                                <!-- 选择筛选 -->
                        <div class="select-box" >
                            <a-select placeholder="部门"
                                    labelInValue
                                    showSearch
                                    optionFilterProp="children"
                                    v-model="searchData.dept"
                                    style="width: 120px;margin-right: 10px;">
                                <a-select-option v-for="item in options2"
                                            :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                            <div  style="width: 232px;position:relative;top: -0.5px;display: inline-block">
                                <a-input-search placeholder="部门/负责人/关键字"
                                                v-model="searchMsg"
                                                @search="onSearch" />
                            </div>
                            <div class="upload_box">
                            <div class="popup_opinion_submit_box after">
                                <ul class="popup_opinion_submit_file">
                                <span>筛选：</span>
                                    <li v-if="searchData.dept"><b>部门：{{searchData.dept.label}}</b>
                                        <i class="icon iconfont"
                                        @click="reset(1)">&#xe631;</i>
                                    </li>

                                </ul>
                            </div>
                         </div>
                        </div >
                            <a-table :rowSelection="{selectedRowKeys: selectedRowKeys, onChange: onSelectChange}"
                                :rowKey="(record, index) => record.id"
                                :columns="columns"
                                :loading="loading"
                                :pagination="pagination1"
                                :dataSource="data"
                                 @change="changePage">
                                <div slot="department" slot-scope="department">
                                        {{department.name}}
                                </div>
                                <div slot="backend_program_user_name" slot-scope="backend_program_user_name,record">
                                        <p>后台程序负责人: {{backend_program_user_name ? backend_program_user_name : '--'}}</p>
                                        <p>前台程序负责人: {{record.frontend_program_user_name ? record.frontend_program_user_name : '--'}}</p>
                                </div>
                                <div slot="frontend_product_user_name" slot-scope="frontend_product_user_name,record">
                                        <p>后台产品负责人: {{record.backend_product_user_name ? record.backend_product_user_name : '--'}}</p>
                                        <p>前台产品负责人: {{record.frontend_product_user_name ? record.frontend_product_user_name : '--'}}</p>
                                </div>
                                <div slot="test_user_name" slot-scope="test_user_name">
                                        {{test_user_name ? test_user_name : '--'}}
                                </div>
                                 <div slot="operate" class="operate" slot-scope="e,record">
                                    <span class="icon iconfont"
                                        v-if="canDo('pm.bugs.principal.update')"
                                        @click="editPeople(record)"
                                        title="编辑">&#xe637;</span>

                                </div>
                            </a-table>
                        </div>

                    </a-tab-pane>
                    <a-tab-pane tab="故障原因配置" :key="2">
                             <a-table
                                :rowKey="(record, index) => record.id"
                                :columns="columns2"
                                :loading="loading2"
                                :dataSource="data2"
                                :pagination="false"
                                class="table-2"
                                 >
                                <div slot="required_analyse" slot-scope="required_analyse">
                                    <p v-if="required_analyse===0">* 非必填</p>
                                    <p v-if="required_analyse===1"><span style="color:red">*</span> 必填</p>
                                </div>
                                <div slot="operate" class="operate cup" slot-scope="operate,record">
                                    <span class="icon iconfont"
                                        @click="showEdit(record)"
                                        v-if="canDo('pm.bugs.reason.update')"
                                        title="编辑">&#xe637;</span>
                                    <span class="icon iconfont "
                                        @click="showDel(record.id)"
                                        v-if="canDo('pm.bugs.reason.delete')"
                                        title="删除">&#xe64d;</span>
                                </div>
                            </a-table>
                    </a-tab-pane>
              </a-tabs>
         </a-card>
          <div v-if="activeKey===1">
                <div class="table-eidt"   :style="{width:screenWidth+'px',height:'64px'}" v-if="data.length>0">
                    <a-table :rowSelection="{selectedRowKeys: selectedRowKeys, onChange: onSelectChange}"
                            :rowKey="(record, index) => record.id"
                            :columns="columns"
                            :pagination="pagination1"
                            @change="changePage"
                            :dataSource="data">
                    </a-table>
                    <span class="select-lengs select-lengs-eidt">
                    全选
                    </span>
                    <span class="select-lengs">
                        <a-button v-if="canDo('pm.bugs.principal.batchBinding')" @click="editMore(selectedRowKeys)"  style="margin-right:10px;" type="primary">批量绑定负责人</a-button>
                        <template v-if="hasSelected">
                            {{`选中 ${selectedRowKeys.length} 个部门`}}
                        </template>
                    </span>
                </div>
            </div>
    </div>
</template>
<script>
import { getBugsPrincipal, getBugsReason, editPrincipal, addReason, delReason, editReason, editMorePrincipal } from '@/api/RDmanagement/bug/setting.js'
import { getlDepartment, getBindPeople } from '@/api/RDmanagement/dropDown'
import { canDo } from '@/plugins/common'
import { searchUserList } from '@/api/userManage/index.js'
const columns = [
  {
    title: '部门',
    dataIndex: 'department',
    key: 'department',
    scopedSlots: { customRender: 'department' },
    width: 110
  },
  {
    title: '程序负责人',
    key: 'backend_program_user_name',
    dataIndex: 'backend_program_user_name',
    scopedSlots: { customRender: 'backend_program_user_name' },
    width: '28%'
  },
  {
    title: '产品负责人',
    key: 'frontend_product_user_name',
    dataIndex: 'frontend_product_user_name',
    scopedSlots: { customRender: 'frontend_product_user_name' },
    width: '28%'
  },
  {
    title: '测试负责人',
    key: 'test_user_name',
    dataIndex: 'test_user_name',
    scopedSlots: { customRender: 'test_user_name' },
    width: '28%'
  },

  {
    title: '操作',
    key: 'operate',
    dataIndex: 'operate',
    scopedSlots: { customRender: 'operate' },
    width: 70
  }

]
const columns2 = [
  {
    title: '原因类型',
    dataIndex: 'reason',
    key: 'reason',
    width: '48%'
  },
  {
    title: '分析说明',
    key: 'required_analyse',
    dataIndex: 'required_analyse',
    scopedSlots: { customRender: 'required_analyse' },
    width: '48%'
  },

  {
    title: '操作',
    key: 'operate',
    dataIndex: 'operate',
    scopedSlots: { customRender: 'operate' },
    width: 70
  }

]
let search = []
export default {
  data () {
    return {
      searchData: {
        dept: undefined
      },
      loading: true,
      loading2: true,
      btnLoad: false,
      dialogVisible1: false,
      dialogVisible2: false,
      dialogVisible3: false,
      dialogVisible4: false,
      dialogVisible5: false,
      principalForm: {
        backend_product_user_id: undefined,
        backend_program_user_id: undefined,
        frontend_product_user_id: undefined,
        frontend_program_user_id: undefined,
        test_user_id: undefined
      },
      addForm: {
        reasons: [{
          reason: undefined,
          required_analyse: undefined
        }, {
          reason: undefined,
          required_analyse: undefined
        }, {
          reason: undefined,
          required_analyse: undefined
        }]
      },
      editForm: {
        reason: undefined,
        required_analyse: undefined
      },
      activeKey: 1,
      id: undefined,
      data: [],
      reasonId: undefined,
      columns,
      data2: [],
      columns2,
      options: [],
      options2: [],
      options_1: [],
      options_2: [],
      options_3: [],
      options_4: [],
      options_5: [],
      searchMsg: '',
      selectedRowKeys: [],
      depts: [],
      editType: undefined,
      pagination1: {
        showSizeChanger: true,
        pageSizeOptions: ['10', '20', '30', '50'],
        total: 10,
        current: 1,
        pageSize: 10
      },
      screenWidth: this.$store.state.recount.pageWidth
    }
  },
  computed: {
    hasSelected () {
      return this.selectedRowKeys.length > 0
    }
  },
  watch: {
    '$store.state.recount.pageWidth' (newVal) {
      this.screenWidth = newVal
    },
    searchData: {
      handler (newVal, oldVal) {
        if (!this.searchMsg) {
          search['keyword'] = undefined
        }
        if (newVal.dept) {
          search['dept_id'] = newVal.dept.key
        } else {
          search['dept_id'] = undefined
        }

        this.loading = true
        let params = { dept_id: search['dept_id'],
          keyword: search['keyword'],
          limit: this.pagination1.pageSize || 10 }
        this.getPrincipalAll(params)
      },
      deep: true
    }
  },
  created () {
    getlDepartment().then(res => {
      if (res.code === 200) {
        this.options2 = res.data.departments
      }
    })
    this.getPrincipalAll()
    this.getBugsReasonAll()
    getBindPeople().then(res => {
      if (res.code === 200) {
        this.options = res.data.users
      }
    })
  },
  methods: {
    canDo,
    search (e, type) {
      this.$nextTick(() => {
        let self = this
        this.timer = searchUserList(this.timer, e, function (data) {
          if (type === 1) {
            self.options_1 = data.data.users
          } else if (type === 2) {
            self.options_2 = data.data.users
          } else if (type === 3) {
            self.options_3 = data.data.users
          } else if (type === 4) {
            self.options_4 = data.data.users
          } else if (type === 5) {
            self.options_5 = data.data.users
          }
        })
      })
    },
    onSearch (value) {
      if (value) {
        search['keyword'] = '%' + value.trim() + '%'
      } else {
        search['keyword'] = undefined
      }
      this.loading = true
      let params = {
        limit: this.pagination1.pageSize || 10,
        page: this.pagination1.current,
        dept_id: search['dept_id'],
        keyword: search['keyword']
      }
      this.getPrincipalAll(params)
    },
    editMore (e) {
      if (e.length > 1) {
        // 根据勾选数组匹配data中的属性
        let depts = []
        let arr = e.map(item => {
          let obj = {}
          this.data.forEach(item2 => {
            if (item2.id === item) {
              obj.id = item
              obj.department = item2.department
              depts.push(item2.department)
            }
          })
          return obj
        })
        this.depts = depts
        this.editType = 1
        this.dialogVisible1 = true
        this.options_1 = []
        this.options_2 = []
        this.options_3 = []
        this.options_4 = []
        this.options_5 = []
        this.principalForm = {}
      } else {
        this.$message.error('请勾选两个及以上')
      }
    },
    closeDept (e, dept, index) {
      e.preventDefault()
      this.depts.splice(index, 1)
    },
    showEdit (record) {
      this.dialogVisible4 = true
      this.reasonId = record.id
      this.editForm.reason = record.reason
      this.editForm.required_analyse = record.required_analyse
    },
    showDel (id) {
      this.dialogVisible3 = true
      this.reasonId = id
    },
    delReason (index) {
      this.addForm.reasons.splice(index, 1)
    },
    addReasonsType () {
      this.addForm.reasons.push({ reason: undefined, required_analyse: undefined })
    },
    reset (index) {
      if (index === 1) {
        this.searchData.dept = undefined
      }
    },
    cancel (index) {
      if (index === 1) {
        this.dialogVisible1 = false
        this.options_1 = []
        this.options_2 = []
        this.options_3 = []
        this.options_4 = []
        this.options_5 = []
        this.$refs.principalForm.resetFields()
      } else if (index === 2) {
        this.dialogVisible2 = false
        this.$refs['addForm'].resetFields()
      } else if (index === 3) {
        this.dialogVisible3 = false
      } else if (index === 4) {
        this.dialogVisible4 = false
        this.$refs.editForm.resetFields()
      }
    },
    ok (index) {
      if (index === 1) {
        this.$refs.principalForm.validate(valid => {
          if (valid) {
            if (this.editType) {
              let depts = this.depts.map(item => {
                return item.id
              })
              let params = { ...this.principalForm, dept_ids: depts }
              this.btnLoad = true
              editMorePrincipal(params).then(res => {
                this.$message.success('批量编辑成功')
                this.dialogVisible1 = false
                this.options_1 = []
                this.options_2 = []
                this.options_3 = []
                this.options_4 = []
                this.options_5 = []
                this.$refs.principalForm.resetFields()
                this.getPrincipalAll()
                this.btnLoad = false
              }).catch(error => {
                this.btnLoad = false
                this.$message.error(error.response ? error.response.data.message : error.message)
              })
            } else {
              this.btnLoad = true
              editPrincipal(this.id, this.principalForm).then(res => {
                this.$message.success('编辑成功')
                this.dialogVisible1 = false
                this.options_1 = []
                this.options_2 = []
                this.options_3 = []
                this.options_4 = []
                this.options_5 = []
                this.$refs.principalForm.resetFields()
                this.getPrincipalAll()
                this.btnLoad = false
              }).catch(error => {
                this.btnLoad = false
                this.$message.error(error.response ? error.response.data.message : error.message)
              })
            }
          } else {
            return false
          }
        })
      } else if (index === 2) {
        this.$refs['addForm'].validate(valid => {
          if (valid) {
            this.btnLoad = true
            addReason(this.addForm).then(res => {
              this.$message.success('新增类型成功')
              this.dialogVisible2 = false
              this.$refs['addForm'].resetFields()
              this.getBugsReasonAll()
              this.btnLoad = false
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else {
            return false
          }
        })
      } else if (index === 3) {
        this.btnLoad = true
        delReason(this.reasonId).then(res => {
          this.$message.success('删除成功')
          this.dialogVisible3 = false
          this.getBugsReasonAll()
          this.btnLoad = false
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (index === 4) {
        this.$refs.editForm.validate(valid => {
          if (valid) {
            this.btnLoad = true
            editReason(this.reasonId, this.editForm).then(res => {
              this.$message.success('修改类型成功')
              this.dialogVisible4 = false
              this.$refs.editForm.resetFields()
              this.getBugsReasonAll()
              this.btnLoad = false
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else {
            return false
          }
        })
      }
    },
    addType () {
      this.dialogVisible2 = true
    },
    editPeople (record) {
      this.dialogVisible1 = true
      this.editType = 0
      this.id = record.dept_id
      if (record.backend_product_user_id) {
        this.principalForm.backend_product_user_id = record.backend_product_user_id
        this.options_4 = [{ id: record.backend_product_user_id, name: record.backend_product_user_name }]
      } else {
        this.principalForm.backend_product_user_id = undefined
        this.options_4 = []
      }
      if (record.backend_program_user_id) {
        this.principalForm.backend_program_user_id = record.backend_program_user_id
        this.options_3 = [{ id: record.backend_program_user_id, name: record.backend_program_user_name }]
      } else {
        this.principalForm.backend_program_user_id = undefined
        this.options_3 = []
      }
      if (record.frontend_product_user_id) {
        this.principalForm.frontend_product_user_id = record.frontend_product_user_id
        this.options_2 = [{ id: record.frontend_product_user_id, name: record.frontend_product_user_name }]
      } else {
        this.principalForm.frontend_product_user_id = undefined
        this.options_2 = []
      }
      if (record.frontend_program_user_id) {
        this.principalForm.frontend_program_user_id = record.frontend_program_user_id
        this.options_1 = [{ id: record.frontend_program_user_id, name: record.frontend_program_user_name }]
      } else {
        this.principalForm.frontend_program_user_id = undefined
        this.options_1 = []
      }
      if (record.test_user_id) {
        this.principalForm.test_user_id = record.test_user_id
        this.options_5 = [{ id: record.test_user_id, name: record.test_user_name }]
      } else {
        this.principalForm.test_user_id = undefined
        this.options_5 = []
      }
    },
    getPrincipalAll (params) {
      if (!params) {
        params = {
          limit: this.pagination1.pageSize || 10,
          page: this.pagination1.current,
          dept_id: search['dept_id'],
          keyword: search['keyword']
        }
      }
      getBugsPrincipal(params).then(res => {
        this.data = res.data.data
        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      }).catch(error => {
        this.loading = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    getBugsReasonAll (params) {
      getBugsReason(params).then(res => {
        this.data2 = res.data
        this.loading2 = false
      })
    },
    onSelectChange (selectedRowKeys) {
      this.selectedRowKeys = selectedRowKeys
    },
    changePage (e) {
      this.loading = true
      let params = { filters: search, page: e.current, limit: e.pageSize }
      this.getPrincipalAll(params)
    }
  }
}
</script>
<style lang="less" scoped>

.table-list /deep/.ant-table-body {
    overflow-x:auto !important;
}
.table-eidt /deep/ .ant-table-thead .ant-table-selection-column {
        display: block;
        text-align: left;
        padding-left: 20px;
}
.table-list /deep/ .ant-table-thead .ant-table-selection-column {
    text-align: left;
    padding-left: 20px ;
}

.table-list /deep/.ant-table-tbody > tr > td.ant-table-selection-column {
    text-align: left;
    padding-left: 20px !important;
}
.table-eidt /deep/ .ant-table-body {
  margin: 10px 0px 0px 0px;
}
.table-eidt /deep/.ant-table-tbody {
  display: none;
}
.table-eidt /deep/ .ant-table-thead th {
  display: none;
}
.table-eidt /deep/ .ant-table-thead .ant-table-selection-column {
  display: block;
  background: #fff !important;
  width:auto;
}
.table-eidt /deep/ .ant-table {
  float: left;
}
.table-eidt /deep/.ant-table-placeholder {
  display: none;
}
.table-list /deep/.ant-table-pagination {
  display: none;
}
    .deptTags{
        margin-bottom: 10px;
        margin-right: 10px;
        border: 0 !important;
        height: 30px;
        line-height: 28px;
        background:rgba(38,163,224,.2);
        color:rgba(38,163,224,1);
        /deep/.anticon-close{
            display: none;
        }
        &:hover{
            color:#FFFFFF;
            background:rgba(38,163,224,1);
            /deep/.anticon-close{
                display: inline-block;
                color:#FFFFFF;
            }
        }
    }
    .operate .icon{
            color: #378eef;
            font-size: 12px;
            margin-right: 10px;
            cursor: pointer;
    }
   .table-2 /deep/.ant-table-body,/deep/.ant-table-thead{
        tr td:first-child,th:first-child{
            padding-left: 20px;
        }
    }
    .select-lengs {
        line-height: 32px;
        height: 32px;
        position: absolute;
        left: 89px;
        top: 16px;
        color: #bbb;
        font-size: 12px;
    }
    .select-lengs-eidt {
    left: 45px;
    //   top: 27px;
    }
</style>
