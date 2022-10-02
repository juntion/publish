<template>
  <div class="p-part">
    <div class="clearFl marginB20" v-if="canDo('company.add')">
      <div class="add-btn fr" :class="canAdd ? (canEdit ? '' : 'disabled') : 'disabled'" style="width: 90px;" @click="addCompany"><i class="iconfont iconxinzeng"></i>添加公司</div>
    </div>
    <div class="table-2">
      <table width="100%" class="add-table">
        <thead>
          <tr>
            <td width="5.34%">主体编码</td>
            <td width="7.36%">公司类型</td>
            <td width="12.27%">公司简称</td>
            <td width="7.36%">主体标识</td>
            <td width="12.27%">公司全称</td>
            <td width="12.27%">外语名称</td>
            <td width="7.36%">公司国家</td>
            <td width="7.36%">时差</td>
            <td width="14.72%">简介</td>
            <td width="4.17%">显示</td>
            <td width="5.77%">状态</td>
            <td width="">操作</td>
          </tr>
        </thead>
        <tbody v-if="addList.length > 0">
          <tr class="edit-tr" v-for="(item, index) in addList" :key="item.id">
            <td width="5.34%"></td>
            <td width="7.36%">
              <div style="padding-right: 20px;position: relative;">
                <selectSecond :data="selectData" :defaultValue="item.type === 1 ? '母公司' : (item.type === 2 ? '子公司' : (item.type === 3 ? '分公司' : '请选择'))" :dataId="item.id" @getSelectValue="addSelVal" :class="index > 5 ? 'toTop': ''"></selectSecond>
                <div class="tip">* 请选择</div>
              </div>
            </td>
            <td width="12.27%">
              <div style="padding-right: 30px;position: relative;">
                <a-input type="text" placeholder="请输入公司简称" :defaultValue="item.company_simple_name" :maxLength="10" @blur="e => changeAddValue(e.target.value, item.id, 'company_simple_name')" />
                <div class="tip">* 请填写</div>
              </div>
            </td>
            <td width="7.36%">
              <div style="padding-right: 30px;position: relative;">
                <a-input type="text" placeholder="缩写" :defaultValue="item.main_tag" :maxLength="5" @blur="e => changeAddValue(e.target.value, item.id, 'main_tag')" />
                <div class="tip">* 请填写</div>
              </div>
            </td>
            <td width="12.27%">
              <div style="padding-right: 30px;position: relative;">
                <a-input type="text" placeholder="请输入公司全称" :defaultValue="item.company_name" @blur="e => changeAddValue(e.target.value, item.id, 'company_name')" />
                <div class="tip">* 请填写</div>
              </div>
            </td>
            <td width="12.27%">
              <div style="padding-right: 30px;position: relative;">
                <a-input type="text" placeholder="请输入英文全称" :defaultValue="item.company_english_name" @blur="e => changeAddValue(e.target.value, item.id, 'company_english_name')" />
                <div class="tip">* 请填写</div>
              </div>
            </td>
            <td width="7.36%">
              <div style="padding-right: 10px;position: relative;">
                <a-select
                  class="country-sel"
                  show-search
                  placeholder="请选择"
                  option-filter-prop="children"
                  style="width: 100%"
                  :filter-option="filterOption"
                  @change="changeAddValue($event, item.id, 'country')"
                  :getPopupContainer="triggerNode => triggerNode.parentNode"
                >
                  <a-select-option v-for="(list) in countrys" :key="list.id" :value="list.name">
                    {{ list.name }}
                  </a-select-option>
                </a-select>
                <div class="tip">* 请选择</div>
              </div>
            </td>
            <td width="7.36%">
              <div style="padding-right: 30px;position: relative;">
                <a-input type="number" placeholder="请输入时差" :defaultValue="item.time_zone" @blur="e => changeAddValue(e.target.value, item.id, 'time_zone')" />
                <div class="tip">* 请填写</div>
              </div>
            </td>
            <td width="14.72%">
              <div style="padding-right: 30px;position: relative;">
                <a-textarea placeholder="请输入简介" style="height: 70px;" :defaultValue="item.profile" @blur="e => changeAddValue(e.target.value, item.id, 'profile')" />
              </div>
            </td>
            <td width="4.17%">
              <a-switch class="switch-btn" :defaultChecked="item.is_show === 1 ? true : false" @change="ifAddShow($event, item.id)" />
            </td>
            <td width="5.77%"></td>
            <td width="">
              <div><a class="btn-a" @click="() => saveAdd(item.id)">添加</a></div>
              <div><a class="btn-a cancel" @click="() => cancelAdd(item.id)">取消</a></div>
            </td>
          </tr>
        </tbody>
      </table>
      <a-table
        :columns="columns"
        :data-source="list"
        :loading="loading"
        :pagination="pagination"
        @change="handleTableChange"
        rowKey="id"
        :rowClassName="rowClassName"
        :showHeader="false"
        :class="(addList.length) % 2 === 0 ? '' : 'type1'"
      >
        <template slot="type" slot-scope="text, record, index">
          <div v-if="record.editable" style="padding-right: 20px;">
            <selectSecond :data="selectData" :defaultValue="record.type === 1 ? '母公司' : (record.type === 2 ? '子公司' : (record.type === 3 ? '分公司' : '--'))" :dataId="record.id" @getSelectValue="selVal" :class="index > 5 ? 'toTop': ''"></selectSecond>
          </div>
          <div v-else>
            {{ record.type === 1 ? '母公司' : (record.type === 2 ? '子公司' : (record.type === 3 ? '分公司' : '--')) }}
          </div>
        </template>
        <template slot="company_simple_name" slot-scope="text, record">
          <div v-if="record.editable" style="padding-right: 30px;">
            <a-input type="text" placeholder="请输入公司简称" :defaultValue="text" :maxLength="10" @blur="e => changeValue(e.target.value, record.id, 'company_simple_name')" />
          </div>
          <div v-else>
            <div style="padding-right: 30px;">{{ text ? text : publicJS.blankData }}</div>
          </div>
        </template>
        <template slot="main_tag" slot-scope="text, record">
          <div v-if="record.editable" style="padding-right: 30px;">
            <a-input type="text" placeholder="缩写" :defaultValue="text" :maxLength="5" @blur="e => changeValue(e.target.value, record.id, 'main_tag')" />
          </div>
          <div v-else>
            <div style="padding-right: 30px;">{{ text ? text : publicJS.blankData }}</div>
          </div>
        </template>
        <template slot="company_name" slot-scope="text, record">
          <div v-if="record.editable" style="padding-right: 30px;">
            <a-input type="text" placeholder="请输入公司全称" :defaultValue="text" @blur="e => changeValue(e.target.value, record.id, 'company_name')" />
          </div>
          <div v-else>
            <div style="padding-right: 30px;">{{ text ? text : publicJS.blankData }}</div>
          </div>
        </template>
        <template slot="company_english_name" slot-scope="text, record">
          <div v-if="record.editable" style="padding-right: 30px;">
            <a-input type="text" placeholder="请输入英文全称" :defaultValue="text" @blur="e => changeValue(e.target.value, record.id, 'company_english_name')" />
          </div>
          <div v-else>
            <div style="padding-right: 30px;">{{ text ? text : publicJS.blankData }}</div>
          </div>
        </template>
        <template slot="country" slot-scope="text, record">
          <div v-if="record.editable" style="padding-right: 10px;">
            <a-select
              class="country-sel"
              show-search
              placeholder="请选择"
              option-filter-prop="children"
              :style="{width: '100%', color: (text ? '': '#bbb')}"
              :filter-option="filterOption"
              :defaultValue="text ? text : '请选择'"
              @change="changeValue($event, record.id, 'country')"
              :getPopupContainer="triggerNode => triggerNode.parentNode"
            >
              <a-select-option v-for="(item) in countrys" :key="item.id" :value="item.name">
                {{ item.name }}
              </a-select-option>
            </a-select>
          </div>
          <div v-else>
            <div style="padding-right: 20px;">{{ text ? text : publicJS.blankData }}</div>
          </div>
        </template>
        <template slot="time_zone" slot-scope="text, record">
          <div v-if="record.editable" style="padding-right: 30px;">
            <a-input type="number" placeholder="请输入时差" :defaultValue="text" @blur="e => changeValue(e.target.value, record.id, 'time_zone')" />
          </div>
          <div v-else>
            <div style="padding-right: 30px;">{{ text === 'null' ? publicJS.blankData : (text > 0 ? ('+' + text) : text) }}</div>
          </div>
        </template>
        <template slot="profile" slot-scope="text, record">
          <div v-if="record.editable" style="padding-right: 30px;">
            <a-textarea placeholder="请输入简介" :defaultValue="text === 'null' || !text  ? '' : text" style="height: 70px;" @blur="e => changeValue(e.target.value, record.id, 'profile')" />
          </div>
          <div v-else>
            <div style="padding-right: 30px;" :title="text === 'null' ? '' : text">{{ text === 'null' || !text  ? publicJS.blankData : (text.length > 40 ? text.substring(0, 40) + '...' : text ) }}</div>
          </div>
        </template>
        <template slot="status" slot-scope="text, record">
          <div v-if="text === 1" @click="() => logStatus(record.id)" :style="{cursor: (canDo('company.status') ? 'pointer' : 'default')}"><i class="iconfont icondaishenhe" style="color: #4ed0ae;"></i>运营中</div>
          <div v-else-if="text === 0" @click="() => logStatus(record.id)" :style="{cursor: (canDo('company.status') ? 'pointer' : 'default')}"><i class="iconfont icondaishenhe" style="color: #ff4d50;"></i>已注销</div>
        </template>
        <template slot="is_show" slot-scope="text, record">
          <div v-if="record.editable">
            <a-switch class="switch-btn" :defaultChecked="(text === 1 ? true : false)" @change="ifShow($event, record)" />
          </div>
          <div v-else>
            <!--
              <a-switch class="switch-btn" :checked="(text === 1 ? true : false)" disabled />
            -->
            <div class="switch-btn-1" :class="text === 1 ? 'checked': ''"></div>
          </div>
        </template>
        <template slot="operate" slot-scope="text, record">
          <div v-if="record.editable">
            <div><a class="btn-a" @click="() => saveEdit(record)">保存</a></div>
            <div><a class="btn-a cancel" @click="() => cancelEdit(record.id)">取消</a></div>
          </div>
          <div v-else>
            <div v-if="canDo('company.update')"><a class="btn-a" :class="canEdit ? (canAdd ? '' : 'disabled') : 'disabled'" @click="() => editCompany(record.id)">编辑</a></div>
            <div v-if="record.status === 1 && canDo('company.changeStatus')">
              <a class="btn-a" @click="() => logoutCompany(record.id)">注销</a>
            </div>
            <div v-else-if="record.status === 0 && canDo('company.changeStatus')">
              <a class="btn-a" @click="() => restoreCompany(record.id)">恢复</a>
            </div>
            <div v-if="!canDo('company.update') && !canDo('company.changeStatus')">{{ publicJS.blankData }}</div>
          </div>
        </template>
      </a-table>
    </div>
    <!-- 保存修改提示框 -->
    <a-modal
      class="tip-modal"
      width="380px"
      title="提示"
      :visible="visibleSave"
      :confirm-loading="saveLoading"
      :maskClosable="false"
      @ok="saveOk"
      @cancel="saveCancel"
    >
      <p class="tip-txt">所编辑内容<span style="color: #FEB300;">将被更新</span>！</p>
    </a-modal>
    <!-- 取消修改提示框 -->
    <a-modal
      class="tip-modal"
      width="380px"
      title="提示"
      :visible="visibleSaveCancel"
      :confirm-loading="false"
      :maskClosable="false"
      @ok="cancelSaveOk"
      @cancel="cancelSaveCancel"
    >
      <p class="tip-txt">所编辑内容<span style="color: #FF4A4A;">将被取消</span>！</p>
    </a-modal>
    <!-- 保存新增提示框 -->
    <a-modal
      class="tip-modal"
      width="380px"
      title="提示"
      :visible="visibleSaveAdd"
      :confirm-loading="saveLoadingAdd"
      :maskClosable="false"
      @ok="saveOkAdd"
      @cancel="saveCancelAdd"
    >
      <p class="tip-txt">确认创建一个新公司？</p>
    </a-modal>
    <!-- 取消新增提示框 -->
    <a-modal
      class="tip-modal"
      width="380px"
      title="提示"
      :visible="visibleSaveCancelAdd"
      :confirm-loading="false"
      :maskClosable="false"
      @ok="cancelSaveOkAdd"
      @cancel="cancelSaveCancelAdd"
    >
      <p class="tip-txt">确认取消创建一个公司？</p>
    </a-modal>
    <!-- 注销 -->
    <a-modal
      class="normal-modal"
      width="380px"
      :title="logoutText"
      :visible="visibleLogout"
      :confirm-loading="logoutLoading"
      :maskClosable="false"
      @ok="logoutOk"
      @cancel="logoutCancel"
    >
      <div>
        <p class="p-title must">备注：</p>
        <a-textarea :placeholder="logoutPlaceholder" style="height: 80px;" v-model="logoutReason" />
      </div>
    </a-modal>
    <!-- 记录 -->
    <a-modal
      class="normal-modal company-status-log"
      width="700px"
      title="状态变动记录"
      :visible="visibleStatusLog"
      :confirm-loading="false"
      :maskClosable="true"
      :footer="null"
      @cancel="statusLogCancel"
    >
      <div>
        <a-table
          :columns="columnsLog"
          :data-source="listLog"
          :loading="loadingLog"
          :pagination="false"
          :scroll="{ y: 600 }"
          rowKey="created_at"
          class="table-log"
        >
          <template slot="statusLog" slot-scope="text">
            <div :style="{'color': (text === '运营中' ? '#3DCCA6' : ( text === '已注销' ? '#FF4A4A' : '#378EEF' ))}">{{ text }}</div>
          </template>
          <template slot="user_name" slot-scope="text">
            <div style="color: #666;">{{ text }}</div>
          </template>
          <template slot="comment" slot-scope="text">
            <div class="p-ellipsis" style="color: #666;" :title="text">{{ text }}</div>
          </template>
        </a-table>
      </div>
    </a-modal>
  </div>
</template>
<script>
import { getCompanyList, updateCompanyInfo, updateCompanyStatus, getStatusLog, addCompanyInfo, getCountrys, getAllCompanys } from '../../../api/toolManagement/mainCompany/index'
import selectSecond from '@/components/selectSecond'
import _ from 'lodash'
import { canDo } from '@/plugins/common'

const columns = [
  {
    title: '主体编码',
    dataIndex: 'number',
    key: 'number',
    width: '5.34%'
  }, {
    title: '公司类型',
    dataIndex: 'type',
    key: 'type',
    scopedSlots: { customRender: 'type' },
    width: '7.36%'
  }, {
    title: '公司简称',
    dataIndex: 'company_simple_name',
    key: 'company_simple_name',
    scopedSlots: { customRender: 'company_simple_name' },
    width: '12.27%'
  }, {
    title: '主体标识',
    dataIndex: 'main_tag',
    key: 'main_tag',
    scopedSlots: { customRender: 'main_tag' },
    width: '7.36%'
  }, {
    title: '公司全称',
    dataIndex: 'company_name',
    key: 'company_name',
    scopedSlots: { customRender: 'company_name' },
    width: '12.27%'
  }, {
    title: '外语名称',
    dataIndex: 'company_english_name',
    key: 'company_english_name',
    scopedSlots: { customRender: 'company_english_name' },
    width: '12.27%'
  }, {
    title: '公司国家',
    dataIndex: 'country',
    key: 'country',
    scopedSlots: { customRender: 'country' },
    width: '7.36%'
  }, {
    title: '时差',
    dataIndex: 'time_zone',
    key: 'time_zone',
    scopedSlots: { customRender: 'time_zone' },
    width: '7.36%'
  }, {
    title: '简介',
    dataIndex: 'profile',
    key: 'profile',
    scopedSlots: { customRender: 'profile' },
    width: '14.72%'
  }, {
    title: '显示',
    dataIndex: 'is_show',
    key: 'is_show',
    scopedSlots: { customRender: 'is_show' },
    width: '4.17%'
  }, {
    title: '状态',
    dataIndex: 'status',
    key: 'status',
    scopedSlots: { customRender: 'status' },
    width: '5.77%'
  }, {
    title: '操作',
    dataIndex: 'operate',
    key: 'operate',
    scopedSlots: { customRender: 'operate' }
  }
]

const columnsLog = [
  {
    title: '时间',
    dataIndex: 'created_at',
    key: 'created_at',
    width: '24.55%'
  }, {
    title: '状态',
    dataIndex: 'status',
    key: 'status',
    scopedSlots: { customRender: 'statusLog' },
    width: '13.03%'
  }, {
    title: '操作人',
    dataIndex: 'user_name',
    key: 'user_name',
    scopedSlots: { customRender: 'user_name' },
    width: '15.76%'
  }, {
    title: '备注',
    dataIndex: 'comment',
    key: 'comment',
    scopedSlots: { customRender: 'comment' }
  }
]

export default {
  data () {
    return {
      columns: columns,
      columnsLog: columnsLog,
      list: [],
      reList: [],
      addList: [],
      listLog: [],
      countrys: [],
      visibleSaveAdd: false,
      visibleSaveCancelAdd: false,
      visibleSave: false,
      visibleSaveCancel: false,
      visibleLogout: false,
      visibleStatusLog: false,
      loading: false,
      loadingLog: false,
      saveLoading: false,
      saveLoadingAdd: false,
      logoutLoading: false,
      canAdd: true,
      canEdit: true,
      editId: -1,
      cancelId: -1,
      logoutID: -1,
      addId: 0,
      logoutReason: '',
      logoutText: '',
      logoutPlaceholder: '',
      logoutStatus: '',
      selectCompany: '',
      selectData: [],
      pagination: {
        showSizeChanger: true,
        pageSizeOptions: ['10', '20', '30', '50'],
        total: 10,
        current: 1,
        pageSize: 10
      }
    }
  },
  components: {
    selectSecond
  },
  created () {
    let params = { 'limit': 20, 'page': 1 }
    this.loading = true
    getCompanyList(params).then(res => {
      if (res.code === 200) {
        this.list = res.data.data.map(item => {
          item['editable'] = false
          return item
        })
        // 缓存数据
        this.reList = this.list.map(item => ({ ...item }))
        // 分页处理
        this.pagination.total = res.data.total
        this.pagination.current = res.data.current_page
        this.pagination.pageSize = res.data.per_page
        this.loading = false
      }
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
    // 获取国家数据
    getCountrys().then(res => {
      if (res.code === 200) {
        // 将国家数据转换成json格式
        for (let key in res.data) {
          this.countrys.push({ id: key, name: res.data[key].en })
        }
      }
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
    // 下拉框数据处理
    this.getCompanysData().then(res => {
      if (!res) {
        this.$message.error('公司类型下拉框数据获取失败')
      }
    })
  },
  methods: {
    canDo,
    refreshList (limit, page) {
      let params = { 'limit': limit, 'page': page }
      getCompanyList(params).then(res => {
        if (res.code === 200) {
          this.list = res.data.data.map(item => {
            item['editable'] = false
            return item
          })
          // 更新缓存数据
          this.reList = this.list.map(item => ({ ...item }))
          // 更新下拉框数据
          this.getCompanysData().then(res => {
            if (res) {
              this.canAdd = true
              this.canEdit = true
            }
          })
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    getCompanysData () {
      // 初始化下拉数据
      let flag1 = true
      let flag2 = true
      this.selectData = [
        {
          text: '子公司',
          type: 2,
          id: '',
          child: []
        }, {
          text: '分公司',
          type: 3,
          id: '',
          child: []
        }, {
          text: '母公司',
          type: 1,
          id: '',
          child: []
        }
      ]
      // 获取所有母公司
      getAllCompanys(1).then(res => {
        if (res.code === 200) {
          res.data.company.map(item => {
            this.selectData[0].child.push({
              text: item.company_name,
              type: 2,
              id: item.id,
              child: []
            })
            this.selectData[1].child.push({
              text: item.company_name,
              type: 3,
              id: item.id,
              child: []
            })
          })
          flag1 = true
        }
      }).catch(error => {
        flag1 = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
      // 获取所有子公司
      getAllCompanys(2).then(res => {
        if (res.code === 200) {
          res.data.company.map(item1 => {
            this.selectData[0].child.push({
              text: item1.company_name,
              type: 2,
              id: item1.id,
              child: []
            })
            this.selectData[1].child.push({
              text: item1.company_name,
              type: 3,
              id: item1.id,
              child: []
            })
          })
          flag2 = true
        }
      }).catch(error => {
        flag2 = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
      if (flag1 && flag2) {
        return Promise.resolve(true)
      } else {
        return Promise.resolve(false)
      }
    },
    ifShow (checked, record) {
      let reTarget = this.reList.filter(item => record.id === item.id)[0]
      if (reTarget) {
        reTarget.is_show = checked ? 1 : 0
      }
    },
    editCompany (key) {
      if (!this.canEdit) return
      if (!this.canAdd) return
      let target = this.list.filter(item => key === item.id)[0]
      let reTarget = this.reList.filter(item => key === item.id)[0]
      if (target) {
        target.editable = true
        reTarget.editable = true
      }
      this.canEdit = false
    },
    cancelEdit (key) {
      var target = this.list.filter(item => key === item.id)[0]
      var reTarget = this.reList.filter(item => key === item.id)[0]
      if (_.isEqual(target, reTarget)) {
        target.editable = false
        reTarget.editable = false
        Object.assign(reTarget, target)
        this.canEdit = true
        this.visibleSaveCancel = false
        this.cancelId = -1
        return
      }
      this.visibleSaveCancel = true
      this.cancelId = key
    },
    saveEdit (record) {
      this.editId = record.id
      let target = this.list.filter(item => record.id === item.id)[0]
      let reTarget = this.reList.filter(item => record.id === item.id)[0]
      if (_.isEqual(target, reTarget)) {
        this.$message.warning('未更改内容！')
        return
      }
      let text = ((reTarget.type === '') ? '公司类型、' : '') + ((reTarget.company_simple_name === '') ? '公司简称、' : '') + ((reTarget.main_tag === '') ? '主体标识、' : '') + ((reTarget.company_name === '') ? '公司名称、' : '') + ((reTarget.company_english_name === '') ? '外语名称、' : '') + ((reTarget.country === '') ? '公司国家、' : '') + ((reTarget.time_zone === '') ? '时差' : '')
      if (reTarget.type === '' || reTarget.company_simple_name === '' || reTarget.main_tag === '' || reTarget.company_name === '' || reTarget.company_english_name === '' || reTarget.country === '' || reTarget.time_zone === '') {
        this.$message.error(text + '不能为空')
        return
      }
      let pattern = new RegExp('[A-Za-z]+')
      let pattern1 = new RegExp('[\u4e00-\u9fa5]')
      let text1 = (pattern.test(reTarget.main_tag) ? '' : '主体标识需为英文、') + (pattern1.test(reTarget.company_english_name) ? '外语名称不能含中文' : '')
      if (!pattern.test(reTarget.main_tag) || pattern1.test(reTarget.company_english_name)) {
        this.$message.error(text1)
        return
      }
      this.visibleSave = true
    },
    saveOk () {
      var id = this.editId
      var form = new FormData()
      var target = this.list.filter(item => id === item.id)[0]
      var reTarget = this.reList.filter(item => id === item.id)[0]
      form.append('type', reTarget.type)
      form.append('company_simple_name', reTarget.company_simple_name)
      form.append('main_tag', reTarget.main_tag)
      form.append('company_name', reTarget.company_name)
      form.append('company_english_name', reTarget.company_english_name)
      form.append('country', reTarget.country)
      form.append('time_zone', reTarget.time_zone)
      form.append('profile', reTarget.profile)
      form.append('is_show', reTarget.is_show)
      if (reTarget.p_id) {
        form.append('p_id', reTarget.p_id)
      }
      this.saveLoading = true
      updateCompanyInfo(id, form).then(res => {
        if (res.code === 200) {
          target.editable = false
          reTarget.editable = false
          Object.assign(target, reTarget)
          this.canEdit = true
          this.visibleSave = false
          this.saveLoading = false
          this.editId = -1
          this.getCompanysData().then(res => {
            if (res) {
              this.$message.success('编辑成功')
            }
          })
        }
      }).catch(error => {
        this.visibleSave = false
        this.saveLoading = false
        this.editId = -1
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    saveCancel () {
      /* var id = this.editId
      var target = this.list.filter(item => id === item.id)[0]
      var reTarget = this.reList.filter(item => id === item.id)[0]
      Object.assign(reTarget, target)
      this.canEdit = true */
      this.visibleSave = false
      this.saveLoading = false
      this.editId = -1
    },
    changeValue (value, id, key) {
      let reTarget = this.reList.filter(item => id === item.id)[0]
      reTarget[key] = value
    },
    cancelSaveOk () {
      let key = this.cancelId
      let target = this.list.filter(item => key === item.id)[0]
      let reTarget = this.reList.filter(item => key === item.id)[0]
      if (target) {
        target.editable = false
        reTarget.editable = false
      }
      Object.assign(reTarget, target)
      this.canEdit = true
      this.canAdd = true
      this.visibleSaveCancel = false
      this.cancelId = -1
    },
    cancelSaveCancel () {
      this.visibleSaveCancel = false
      this.cancelId = -1
    },
    logoutCompany (id) {
      this.logoutID = id
      this.visibleLogout = true
      this.logoutText = '注销'
      this.logoutPlaceholder = '请输入注销原因'
      this.logoutStatus = 0
    },
    logoutOk () {
      let id = this.logoutID
      let comment = this.logoutReason
      let form = new FormData()
      let target = this.list.filter(item => id === item.id)[0]
      let reTarget = this.reList.filter(item => id === item.id)[0]
      if (!comment) {
        this.$message.error('请输入备注！')
        return false
      }
      form.append('comment', comment)
      this.logoutLoading = true
      updateCompanyStatus(id, form).then(res => {
        if (res.code === 200) {
          this.$message.success(this.logoutText + '成功')
          this.logoutLoading = false
          this.visibleLogout = false
          this.logoutID = -1
          target.status = this.logoutStatus
          reTarget.status = this.logoutStatus
          this.logoutStatus = ''
          this.logoutReason = ''
        }
      }).catch(error => {
        this.logoutLoading = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    logoutCancel () {
      this.visibleLogout = false
      this.logoutID = -1
      this.logoutStatus = ''
      this.logoutReason = ''
    },
    restoreCompany (id) {
      this.logoutID = id
      this.visibleLogout = true
      this.logoutText = '恢复'
      this.logoutPlaceholder = '请输入恢复原因'
      this.logoutStatus = 1
    },
    logStatus (id) {
      if (!canDo('company.status')) {
        return
      }
      getStatusLog(id).then(res => {
        if (res.code === 200) {
          this.visibleStatusLog = true
          this.listLog = res.data
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    statusLogCancel () {
      this.visibleStatusLog = false
      this.listLog = []
    },
    selVal (value) {
      let reTarget = this.reList.filter(item => value.dataId === item.id)[0]
      reTarget['type'] = value.type
      if (value.id) {
        reTarget['p_id'] = value.id
      } else {
        reTarget['p_id'] = ''
      }
    },
    filterOption (input, option) {
      return (
        option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
      )
    },
    addCompany () {
      if (!this.canAdd) return
      if (!this.canEdit) return
      this.addId++
      let obj = { id: this.addId, type: '', company_simple_name: '', main_tag: '', company_name: '', company_english_name: '', time_zone: 0, profile: '', is_show: 1, p_id: '', country: '' }
      this.addList.push(obj)
      this.canAdd = false
    },
    addSelVal (value) {
      let addTarget = this.addList.filter(item => value.dataId === item.id)[0]
      addTarget['type'] = value.type
      if (value.id) {
        addTarget['p_id'] = value.id
      } else {
        addTarget['p_id'] = ''
      }
    },
    changeAddValue (value, id, key) {
      let addTarget = this.addList.filter(item => id === item.id)[0]
      addTarget[key] = value
    },
    ifAddShow (checked, id) {
      let addTarget = this.addList.filter(item => id === item.id)[0]
      if (addTarget) {
        addTarget.is_show = checked ? 1 : 0
      }
    },
    cancelAdd (id) {
      let addTarget = this.addList.filter(item => id === item.id)[0]
      let obj = { id: this.addId, type: '', company_simple_name: '', main_tag: '', company_name: '', company_english_name: '', time_zone: 0, profile: '', is_show: 1, p_id: '', country: '' }
      if (_.isEqual(addTarget, obj)) {
        // 未做更改则直接删除
        let newArr = [...this.addList]
        _.remove(newArr, (n) => {
          return id === n.id
        })
        this.addList = newArr
        this.canAdd = true
        return
      }
      this.visibleSaveCancelAdd = true
      this.editId = id
    },
    cancelSaveOkAdd () {
      let id = this.editId
      let newArr = [...this.addList]
      _.remove(newArr, (n) => {
        return id === n.id
      })
      this.canEdit = true
      this.canAdd = true
      this.addList = newArr
      this.visibleSaveCancelAdd = false
      this.editId = -1
    },
    cancelSaveCancelAdd () {
      this.visibleSaveCancelAdd = false
      this.editId = -1
    },
    saveAdd (id) {
      let addTarget = this.addList.filter(item => id === item.id)[0]
      let text = ((addTarget.type === '') ? '公司类型、' : '') + ((addTarget.company_simple_name === '') ? '公司简称、' : '') + ((addTarget.main_tag === '') ? '主体标识、' : '') + ((addTarget.company_name === '') ? '公司名称、' : '') + ((addTarget.company_english_name === '') ? '外语名称、' : '') + ((addTarget.country === '') ? '公司国家、' : '') + ((addTarget.time_zone === '') ? '时差' : '')
      if (addTarget.type === '' || addTarget.company_simple_name === '' || addTarget.main_tag === '' || addTarget.company_name === '' || addTarget.company_english_name === '' || addTarget.country === '' || addTarget.time_zone === '') {
        this.$message.error(text + '不能为空')
        return
      }
      let pattern = new RegExp('[A-Za-z]+')
      let pattern1 = new RegExp('[\u4e00-\u9fa5]')
      let text1 = (pattern.test(addTarget.main_tag) ? '' : '主体标识需为英文、') + (pattern1.test(addTarget.company_english_name) ? '外语名称不能含中文' : '')
      if (!pattern.test(addTarget.main_tag) || pattern1.test(addTarget.company_english_name)) {
        this.$message.error(text1)
        return
      }
      this.visibleSaveAdd = true
      this.editId = id
    },
    saveOkAdd () {
      let id = this.editId
      let newArr = [...this.addList]
      let form = new FormData()
      let addTarget = this.addList.filter(item => id === item.id)[0]
      form.append('type', addTarget.type)
      form.append('company_simple_name', addTarget.company_simple_name)
      form.append('main_tag', addTarget.main_tag)
      form.append('company_name', addTarget.company_name)
      form.append('company_english_name', addTarget.company_english_name)
      form.append('country', addTarget.country)
      form.append('time_zone', addTarget.time_zone)
      form.append('profile', addTarget.profile)
      form.append('is_show', addTarget.is_show)
      if (addTarget.p_id) {
        form.append('p_id', addTarget.p_id)
      }
      this.saveLoadingAdd = true
      addCompanyInfo(form).then(res => {
        if (res.code === 200) {
          _.remove(newArr, (n) => {
            return id === n.id
          })
          this.canAdd = true
          this.addList = newArr
          this.refreshList(this.pagination.pageSize, this.pagination.current)
          this.getCompanysData().then(res => {
            if (res) {
              this.$message.success('添加成功')
            }
          })
          this.saveLoadingAdd = false
          this.visibleSaveAdd = false
          this.editId = -1
        }
      }).catch(error => {
        this.saveLoadingAdd = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    saveCancelAdd () {
      this.saveLoadingAdd = false
      this.visibleSaveAdd = false
      this.editId = -1
    },
    handleTableChange (selectedRowKeys, selectedRows) {
      // 分页处理
      this.refreshList(selectedRowKeys.pageSize, selectedRowKeys.current)
      this.pagination.total = selectedRowKeys.total
      this.pagination.current = selectedRowKeys.current
      this.pagination.pageSize = selectedRowKeys.pageSize
    },
    rowClassName (row, index) {
      if (row.editable) {
        return 'edit-tr'
      } else {
        return ''
      }
    }
  }
}
</script>

<style lang="less" scoped>
/deep/ .table-2 {
  td {
    line-height: 16px;
    padding: 15px 0 15px 20px !important;
  }
  th {
    line-height: 16px;
    padding: 15px 0 15px 20px !important;
  }
  .ant-table-body {
    margin-top: 0;
  }
  .switch-btn {
    background-color: #bbb;
    min-width: 24px;
    width: 28px;
    height: 14px;
  }
  .switch-btn.ant-switch-checked {
    background-color: #3ecca6;
  }
  .switch-btn:after {
    width: 10px;
    height: 10px;
  }
  .icondaishenhe {
    margin-right: 4px;
    font-size: 13px;
  }
  .ant-pagination {
    position: absolute;
    bottom: 20px;
    right: 0;
    margin: 0;
  }
  .ant-select-dropdown {
    width: 160px !important;
  }
}
/deep/ .table-log  {
  table {table-layout:fixed;}
  thead tr th {border-bottom: 1px solid #eee;}
  td {color: #bbb;word-break: break-all;}
  tr:hover td {animation: none !important;background: none !important;}
}
.tip-modal {
  .tip-txt {
    text-align: center;
    padding: 30px 0 22px;
    font-size: 16px;
  }
}
.p-part {
  position: relative;
  padding-bottom: 70px;

  /deep/ .ant-spin-nested-loading, /deep/ .ant-spin-container {
    position: unset;
  }
}

.add-btn {
  padding: 0 10px;
  background-color: #378EEF;
  border-radius:3px;
  line-height: 32px;
  color: #fff;
  font-size: 12px;
  text-align: center;
  cursor: pointer;

  .iconxinzeng {
    font-size: 9px;
    margin-right: 5px;
  }
}
.add-btn:hover {
  opacity: .9;
}
.add-btn.disabled {cursor: not-allowed; opacity: .5;}

.btn-a {
  color: #378EEF;
  text-decoration: none;
}
.btn-a.disabled {cursor: not-allowed; opacity: .5;}

.btn-a.cancel {
  color: #666;
}

.switch-btn-1 {
  width: 28px;
  height: 14px;
  background-color: #bbb;
  border-radius: 7px;
  opacity: 0.4;
  cursor: not-allowed;
  position: relative;
}
.switch-btn-1::after {
  content: '';
  display: block;
  width: 10px;
  height: 10px;
  position: absolute;
  background-color: #fff;
  left: 2px;
  top: 2px;
  border-radius: 50%;
}
.switch-btn-1.checked {
  background-color: #3ecca6;
}
.switch-btn-1.checked::after {
  left: auto;
  right: 2px;
}
.add-table {

  .tip {
    position: absolute;
    color: #ff4a4a;
    bottom: -18px;
  }

  tr:nth-of-type(2n) {
    background-color: #f8f8f8;
  }
  tr.edit-tr {
    background-color: rgba(55, 142, 239, 0.1);
    td {
      border-top: 1px solid rgba(55, 142, 239, 0.25);
      border-bottom: 1px solid rgba(55, 142, 239, 0.25);
    }
    td:first-child {
      border-radius: 5px 0 0 5px;
      border-left: 1px solid rgba(55, 142, 239, 0.25);
    }
    td:last-child {
      border-radius: 0 5px 5px 0;
      border-right: 1px solid rgba(55, 142, 239, 0.25);
    }
  }
}
/deep/ .table-2 .type1 .ant-table-body {
  tr:nth-of-type(2n) {
    background-color: rgba(255, 255, 255, 1);
  }
  tr:nth-of-type(2n-1) {
    background-color: #f8f8f8;
  }
}
/deep/ .table-2 .ant-table .ant-table-body {
  tr.edit-tr {
    background-color: rgba(55, 142, 239, 0.1);
    td {
      border-top: 1px solid rgba(55, 142, 239, 0.25);
      border-bottom: 1px solid rgba(55, 142, 239, 0.25);
    }
    td:first-child {
      border-radius: 5px 0 0 5px;
      border-left: 1px solid rgba(55, 142, 239, 0.25);
    }
    td:last-child {
      border-radius: 0 5px 5px 0;
      border-right: 1px solid rgba(55, 142, 239, 0.25);
    }
  }
}
</style>
<style lang="less">
.company-status-log {
  .ant-modal-body {
    padding: 0 20px 20px;
  }
  .ant-table-body {
    margin-top: 6px;
  }
}
</style>
