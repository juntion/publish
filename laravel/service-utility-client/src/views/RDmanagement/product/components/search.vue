<template>
  <div style="display: inline;position: relative;">
    <span @click="showMore"
          style="cursor: pointer;">高级筛选
      <a-icon type="down" />
    </span>
    <div class="modal" v-if="showSearch" @click="showSearch=false">
        <div class="searchMore"
             :style="{top:top}"
             @click.stop="showSearch=true">
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
                            <a-select-option value="appeals.number">诉求编号</a-select-option>
                            <a-select-option value="number">需求编号</a-select-option>
                            <a-select-option value="name">需求标题</a-select-option>
                            <a-select-option value="priority">P级别</a-select-option>
                            <a-select-option value="source_project_id">项目来源</a-select-option>
                            <a-select-option value="productLine">产品线</a-select-option>
                            <a-select-option value="productName">产品名称</a-select-option>
                            <a-select-option value="productModule">产品模块</a-select-option>
                            <a-select-option value="productCategory">模块标签</a-select-option>
                            <a-select-option value="promulgator_id">发布人</a-select-option>
                            <a-select-option value="principal_user_id">产品负责人</a-select-option>
                            <a-select-option value="designManager">设计负责人</a-select-option>
                            <a-select-option value="devManager">开发负责人</a-select-option>
                            <a-select-option value="testManager">测试负责人</a-select-option>
                            <a-select-option value="status">状态</a-select-option>
                            <a-select-option value="created_at">发布时间</a-select-option>
                            <a-select-option value="finish_time">完成时间</a-select-option>
                            <a-select-option value="content">需求内容</a-select-option>
                            <a-select-option value="attentionAble.user_id">需要关注</a-select-option>
                        </a-select>
                        <!-- 运算符 -->
                        <a-select placeholder="请选择"
                                    style="width: 128px;margin-right:10px"
                                    v-model="item.judge"
                                >
                            <a-select-option value="is" v-if="item.condition != 'created_at' && item.condition != 'finish_time' ">是</a-select-option>
                            <a-select-option value="like" v-if="item.condition != 'promulgator_id' && item.condition != 'principal_user_id' && item.condition != 'designManager'
                            && item.condition != 'devManager' && item.condition != 'testManager' && item.condition != 'status'
                            && item.condition != 'created_at' && item.condition != 'finish_time' && item.condition != 'attentionAble.user_id'">包含</a-select-option>
                        </a-select>

                        <a-range-picker
                                    v-if="item.condition == 'created_at' || item.condition == 'finish_time'"
                                    v-model="item.value"
                                    class="last"
                                />
                        <!-- 人员下拉框 -->
                        <a-select    v-else-if="item.condition == 'promulgator_id' ||item.condition ==  'principal_user_id'
                        ||item.condition ==  'designManager' ||item.condition ==  'devManager' ||item.condition ==  'testManager'"
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
                       <a-select   v-else-if="item.condition == 'attentionAble.user_id'"
                                 v-model="item.value"
                                 mode="multiple"
                                 labelInValue
                                 showSearch
                                :defaultActiveFirstOption="false"
                                :showArrow="false"
                                :filterOption="false"
                                 @search="search"
                                 placeholder="请选择"
                                 class="last"
                                >
                         <a-select-option v-for="d in searchUser" :key="d.id">{{d.name}}</a-select-option>
                    </a-select>

                            <a-select   v-else-if="item.condition == 'status'"
                                        v-model="item.value"
                                        placeholder="请选择"
                                        class="last"
                                        >
                                <!-- 0：待审核；1：审核驳回；2：待推送；3：待指派；4：未处理；5：研发中；6：已提交；7：待测试；8：测试中；9：已完成；10：已暂停；11：已撤销； -->
                                <a-select-option value="0" >待审核</a-select-option>
                                <a-select-option value="1" >审核驳回</a-select-option>
                                <a-select-option value="2" >待推送</a-select-option>
                                <a-select-option value="3" >待指派</a-select-option>
                                <a-select-option value="4" >未处理</a-select-option>
                                <a-select-option value="5" >研发中</a-select-option>
                                <a-select-option value="6" >已提交</a-select-option>
                                <a-select-option value="7" >待测试</a-select-option>
                                <a-select-option value="8" >测试中</a-select-option>
                                <a-select-option value="9" >已完成</a-select-option>
                                <a-select-option value="10" >已暂停</a-select-option>
                                <a-select-option value="11" >已撤销</a-select-option>
                            </a-select>
                            <a-select   v-else-if="item.condition == 'priority'"
                                        v-model="item.value"
                                        placeholder="请选择"
                                        class="last"
                                        >
                                <a-select-option value="1" >1</a-select-option>
                                <a-select-option value="2" >2</a-select-option>
                                <a-select-option value="3" >3</a-select-option>
                                <a-select-option value="4" >4</a-select-option>
                                <a-select-option value="5" >5</a-select-option>
                            </a-select>
                            <projectSelect class="last" v-else-if="item.condition == 'source_project_id'" v-model="item.value"></projectSelect>
                            <a-input placeholder="请输入"
                                    class="last"
                                    v-model="item.value"
                                    v-else-if="item.condition == 'number' || 'appeals.number' || 'productLine' || 'productName' || 'poductModule' || 'productCategory' || 'name' || 'content'"/>

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
  </div>
</template>
<script>

import { searchUserList } from '@/api/userManage/index.js'
import { getlDepartment } from '@/api/recount'
import projectSelect from '@/components/projectSelect.vue'
import moment from 'moment'
export default {
  components: { projectSelect },
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
      options: [],
      searchUser: [],
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
    top: {
      type: String,
      default: '270px'
    }

  },
  created () {
    getlDepartment().then(res => {
      if (res.code === 200) {
        this.options = res.data.departments
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
  left: 63%;
  transform: translateX(-50%);
  top: 270px;
  width: 570px;
  background-color: #fff;
  z-index: 100;
  box-shadow:0px 8px 25px 0px rgba(102,102,102,0.25)
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
