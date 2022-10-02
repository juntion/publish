<template>
  <div style="display: inline;position: relative;">
    <span @click="showMore"
          style="cursor: pointer;">
      高级筛选
      <a-icon type="down" />
    </span>
    <div class="modal" v-if="showSearch" @click="showSearch=false">
      <div class="searchMore"

         @click.stop="showSearch=true"
         >
      <div class="search">
        <div class="from">
          <a-form>
            <div style="text-align:right;margin:0 20px 20px 20px;padding-top:20px;"
                 class="header">
              <a-select v-model="data.andOr"
                        style="width: 60px;margin-left:20px;"
                        class="left">
                <a-select-option value="and">且</a-select-option>
                <a-select-option value="or">或</a-select-option>
              </a-select>
              <span @click="add"
                    class="addPM">
                <a-icon type="plus" /> 新增条件
              </span>
            </div>
            <div class="saixuan">
                  <div v-for="(item,index) in data.form" :key="index"  class="saixuan-box">
                    <a-select
                                placeholder="请选择"
                                v-model="item.condition"
                                style="width: 128px;margin-right:10px"
                                @change="handleChange($event,item)">
                        <a-select-option value="number">Bug编号</a-select-option>
                        <a-select-option value="productLine">产品线</a-select-option>
                        <a-select-option value="productName">产品名称</a-select-option>
                         <a-select-option value="demand.number">需求编号</a-select-option>
                        <a-select-option value="demand.name">需求名称</a-select-option>
                        <a-select-option value="project.number">项目编号</a-select-option>
                        <a-select-option value="project.name">项目名称</a-select-option>
                        <a-select-option value="created_at">发布时间</a-select-option>
                        <a-select-option value="finish_time">完成时间</a-select-option>
                        <a-select-option value="dept_id">部门</a-select-option>
                        <a-select-option value="promulgator_id">发布人</a-select-option>
                        <a-select-option value="operation_platform">操作平台</a-select-option>
                        <a-select-option value="program_principal_id">程序负责人</a-select-option>
                        <a-select-option value="product_principal_id">产品负责人</a-select-option>
                        <a-select-option value="test_principal_id">测试负责人</a-select-option>
                        <a-select-option value="handlers.handler_id">程序跟进人</a-select-option>
                        <a-select-option value="reason_id">原因类型</a-select-option>
                        <a-select-option value="data_restore">数据修复情况</a-select-option>
                        <a-select-option value="expiration_date">处理时限</a-select-option>
                        <a-select-option value="status">处理状态</a-select-option>
                        <a-select-option value="labels.name">bug标签</a-select-option>
                    </a-select>
                    <!-- 运算符 -->
                    <a-select placeholder="请选择"
                                style="width: 128px;margin-right:10px"
                                v-model="item.judge"
                               >
                        <a-select-option value="is" v-if="item.condition != 'created_at' && item.condition != 'finish_time' && item.condition != 'expiration_date' ">是</a-select-option>
                        <a-select-option value="like" v-if="item.condition == 'productLine' || item.condition == 'productName'|| item.condition == 'demand.name' || item.condition == 'project.name'
                         || item.condition == 'dept_id' || item.condition == 'operation_platform' || item.condition == 'reason_id'
                         || item.condition == 'data_restore' || item.condition == 'labels.name'">包含</a-select-option>
                    </a-select>

                    <a-range-picker
                                v-if="item.condition == 'created_at' || item.condition == 'finish_time' || item.condition == 'expiration_date'"
                                v-model="item.value"
                                class="last"
                               />

                     <a-select   v-else-if="item.condition == 'dept_id'"
                                        v-model="item.value"
                                        placeholder="请选择"
                                        showSearch
                                        optionFilterProp="children"
                                        class="last"
                                        >
                                <a-select-option v-for="item in options"
                                :key="item.id">{{item.name}}</a-select-option>
                    </a-select>
                    <a-select   v-else-if="item.condition == 'data_restore'"
                                        v-model="item.value"
                                        placeholder="请选择"
                                        class="last"
                                        >
                                <a-select-option :value="1">未修复</a-select-option>
                                <a-select-option :value="2">已修复</a-select-option>
                                <a-select-option :value="3">无需程序修复</a-select-option>
                                <a-select-option :value="4">程序无法修复</a-select-option>
                    </a-select>
                    <a-select   v-else-if="item.condition == 'labels.name'"
                                        v-model="item.value"
                                        placeholder="请选择"
                                        class="last"
                                        >
                                <a-select-option value="财务审批通过">财务审批通过</a-select-option>
                                <a-select-option value="财务审批驳回">财务审批驳回</a-select-option>
                                <a-select-option value="内控审批通过">内控审批通过</a-select-option>
                                <a-select-option value="内控审批驳回">内控审批驳回</a-select-option>
                                <a-select-option value="验收不合格">验收不合格</a-select-option>
                                <a-select-option value="已验收">已验收</a-select-option>
                                <a-select-option value="Bug已关闭">Bug已关闭</a-select-option>
                    </a-select>
                     <a-select   v-else-if="item.condition == 'reason_id'"
                                        v-model="item.value"
                                        placeholder="请选择"
                                        showSearch
                                        optionFilterProp="children"
                                        class="last"
                                        >
                                 <a-select-option v-for="item in bugReasons"
                                                            :key="item.id">{{item.reason}}</a-select-option>
                    </a-select>

                    <a-select   v-else-if="item.condition == 'status'"
                                        v-model="item.value"
                                        placeholder="请选择"
                                        class="last"
                                        >
                                <!-- 0：待指派；1：待受理；2：处理中；3：待复核；4：排期中；5：已处理；6：不处理；7：已撤销；9：财务待审批；10：内控待审批 -->
                                <a-select-option :value="0">待指派</a-select-option>
                                <a-select-option :value="1">待受理</a-select-option>
                                <a-select-option :value="2">处理中</a-select-option>
                                <a-select-option :value="3">待复核</a-select-option>
                                <a-select-option :value="4">排期中</a-select-option>
                                <a-select-option :value="5">已处理</a-select-option>
                                <a-select-option :value="6">不处理</a-select-option>
                                <a-select-option :value="7">已撤销</a-select-option>
                                <a-select-option :value="9">财务待审批</a-select-option>
                                <a-select-option :value="10">内控待审批</a-select-option>
                    </a-select>
                    <a-select   v-else-if="item.condition == 'operation_platform'"
                                        v-model="item.value"
                                        placeholder="请选择"
                                        class="last"
                                        >
                            <a-select-option :value="2">后台PC端</a-select-option>
                            <a-select-option :value="3">PDA</a-select-option>
                            <a-select-option :value="1">FS平台</a-select-option>
                            <a-select-option :value="5">Community中文</a-select-option>
                            <a-select-option :value="6">Community英文</a-select-option>
                            <a-select-option :value="7">Arms</a-select-option>
                            <a-select-option :value="4">APP</a-select-option>
                    </a-select>
                     <!-- 人员下拉框 -->
                        <a-select    v-else-if="item.condition == 'promulgator_id' ||item.condition ==  'program_principal_id' ||item.condition ==  'product_principal_id'
                        ||item.condition ==  'test_principal_id' ||item.condition ==  'handlers.handler_id'"
                                    v-model="item.value"
                                    showSearch
                                    @search="search"
                                    :defaultActiveFirstOption="false"
                                    :showArrow="false"
                                    :filterOption="false"
                                    placeholder="请选择"
                                    class="last"
                                    >
                            <a-select-option v-for="d in searchUser" :key="d.id">{{d.name}}</a-select-option>
                        </a-select>
                    <!-- 人员下拉框 -->

                    <a-input placeholder="请输入"
                             class="last"
                             v-model="item.value"
                             v-else-if="item.condition == 'number' || 'productLine' || 'productName' || 'demand.number'
                             || 'demand.name' || 'project.number' || 'project.name'" />

                    <span v-if="data.form.length > 1"
                            class="dynamic-delete-button iconfont"
                            type="close"
                            @click="() => remove(index)">&#xe631;</span>
                </div>

            </div>
             <div class="btn">
                    <a-button type="primary"
                        @click="screen"
                        >筛选</a-button>
                </div>
          </a-form>
        </div>
      </div>
    </div>
    </div>

  </div>
</template>
<script>

import { searchUserList } from '@/api/userManage/index.js'
// import { getlDepartment } from '@/api/recount'
import { getBugsReason } from '@/api/RDmanagement/bug/setting.js'
import moment from 'moment'
export default {
  data () {
    return {
      showSearch: false,
      data: {
        andOr: 'and',
        form: [
          { condition: undefined, judge: undefined, value: undefined },
          { condition: undefined, judge: undefined, value: undefined },
          { condition: undefined, judge: undefined, value: undefined }
        ]
      },
      searchUser: [],
      options: this.department,
      bugReasons: [],
      productManager: [],
      desginMainManager: [],
      devManager: [],
      testManager: [],
      productMembers: [],
      interactionManager: [],
      visualManager: [],
      frontEndManager: [],
      mobileManager: [],
      UIManager: []
    }
  },
  props: {
    department: {
      type: Array
    }
  },
  watch: {
    department (newVal) {
      this.options = newVal
    }
  },
  created () {
    getBugsReason().then(res => {
      if (res.code === 200) {
        this.bugReasons = res.data
      }
    })
  },
  methods: {
    moment,
    screen () {
      let data = JSON.parse(JSON.stringify(this.data))
      data.form.map(item => {
        if (item.condition === 'created_at' || item.condition === 'finish_time') {
          if (item.value) {
            item.value[0] = moment(item.value[0]).format('YYYY-MM-DD')
            item.value[1] = moment(item.value[1]).format('YYYY-MM-DD')
          }
        }
        if (item.condition === 'attentionAble.user_id') {
          item.value = item.value.map(k => {
            return k.key
          }).toString()
        }
      })
      this.$emit('search', data)
    },
    search (e) {
      this.$nextTick(() => {
        let self = this
        this.timer = searchUserList(this.timer, e, function (data) {
          self.searchUser = data.data.users
        })
      })
    },
    showMore () {
      this.showSearch = !this.showSearch
    },
    handleChange (e, item) {
      item.value = undefined
      item.judge = undefined
    },
    remove (index) {
      this.data.form.splice(index, 1)
    },
    add () {
      this.data.form.push({ condition: undefined, judge: undefined, value: undefined })
    }
  }
}
</script>
<style lang="less" scoped>
.last{
    width: 232px;
    margin-right:10px
}
.modal{
    // background: rgba(0, 0, 0, 0.6);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 10;
}
.searchMore {
  position: absolute;
  left: 70%;
  transform: translateX(-50%);
  top: 270px;
  width: 570px;
  background-color: #fff;
  z-index: 100;
  box-shadow:0px 8px 25px 0px rgba(102,102,102,0.25);
}
.ant-form-item {
  margin-bottom: 16px !important;
}
.header {
  height: 62px;
  line-height: 32px;
  border-bottom: 1px solid #ccdfe2e6;
}

.left {
  position: absolute;
  top: 20px;
  left: 0;
}
.form {
  max-height: 660px;
}
.addPM {

  cursor: pointer;
  font-size: 12px;
  color:#378EEF;
}
.dynamic-delete-button {
  cursor: pointer;
  position: relative;
  top: 0px;
  font-size: 12px;
  color: #bbbbbb;
  transition: all 0.3s;
}
.dynamic-delete-button:hover {
  color: #777;
}
.dynamic-delete-button[disabled] {
  cursor: not-allowed;
  opacity: 0.5;
}
</style>
