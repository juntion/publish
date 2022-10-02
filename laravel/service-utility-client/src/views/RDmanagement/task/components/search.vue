<template>
  <div style="display: inline;position: relative;">
    <span @click="showMore"
          style="cursor: pointer;">高级筛选
      <a-icon type="down" />
    </span>
    <div class="modal" v-if="showSearch" @click="showSearch=false">

        <div class="searchMore"
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

                    <div v-for="(item,index) in data.form" :key="index" class="saixuan-box">
                        <a-select
                                    placeholder="请选择"
                                    v-model="item.condition"
                                    style="width: 128px;margin-right:10px"
                                    @change="handleChange($event,item)">
                            <a-select-option value="number">任务编号</a-select-option>
                            <a-select-option value="demand.number">需求编号</a-select-option>
                            <a-select-option value="demand.name">需求标题</a-select-option>
                            <a-select-option value="priority">P级别</a-select-option>
                            <a-select-option value="productLine">产品线</a-select-option>
                            <a-select-option value="productName">产品名称</a-select-option>
                            <a-select-option value="poductModule">产品模块</a-select-option>
                            <a-select-option value="productCategory">模块标签</a-select-option>
                            <a-select-option value="promulgator_id">发布人</a-select-option>
                            <a-select-option value="principal_user_id">{{type==="design" ? '主负责人' : '实际负责人'}}</a-select-option>
                            <a-select-option value="main_principal_user_id" v-if="type!=='design'">主负责人</a-select-option>
                            <a-select-option value="parts.principal_user_id" v-if="type==='design'">角色负责人</a-select-option>
                            <a-select-option :value="type==='design' ? 'parts.subTasks.handler_id' : 'subTasks.handler_id'">跟进人</a-select-option>
                            <a-select-option value="design_type" v-if="type==='design'">设计类型</a-select-option>
                            <a-select-option value="status">状态</a-select-option>
                            <a-select-option value="created_at">发布时间</a-select-option>
                            <a-select-option value="verify_time" v-if="type=='design'">审核时间</a-select-option>
                            <a-select-option value="finishTime">完成时间</a-select-option>
                            <a-select-option value="content">任务描述</a-select-option>
                        </a-select>
                        <!-- 运算符 -->
                        <a-select placeholder="请选择"
                                    style="width: 128px;margin-right:10px"
                                    v-model="item.judge"
                                >
                            <a-select-option value="is" v-if="item.condition != 'created_at' && item.condition != 'finishTime' && item.condition != 'verify_time'">是</a-select-option>
                            <a-select-option value="like" v-if="item.condition != 'promulgator_id' &&item.condition != 'principal_user_id' &&item.condition != 'main_principal_user_id'
                            && item.condition != 'parts.subTasks.handler_id' && item.condition != 'subTasks.handler_id' && item.condition != 'status' && item.condition != 'parts.principal_user_id' && item.condition != 'design_type'
                            && item.condition != 'created_at' && item.condition != 'finishTime' && item.condition != 'verify_time'">包含</a-select-option>
                        </a-select>

                        <a-range-picker
                                    v-if="item.condition == 'created_at' || item.condition == 'finishTime' || item.condition == 'verify_time'"
                                    v-model="item.value"
                                    class="last"
                                />
                        <!-- 人员下拉框 -->
                        <a-select    v-else-if="item.condition == 'promulgator_id' ||item.condition ==  'main_principal_user_id' ||item.condition ==  'principal_user_id' ||item.condition ==  'parts.subTasks.handler_id' ||item.condition ==  'subTasks.handler_id'||item.condition ==  'parts.principal_user_id' "
                                    v-model="item.value"
                                    showSearch
                                    @search="search($event,item)"
                                    :defaultActiveFirstOption="false"
                                    :showArrow="false"
                                    :filterOption="false"
                                    placeholder="请选择"
                                    class="last"
                                    >
                            <a-select-option v-for="d in item.searchUser" :key="d.id">{{d.name}}</a-select-option>
                        </a-select>
                        <!-- 人员下拉框 -->

                        <a-select   v-else-if="item.condition == 'status' && type== 'dev'"

                                    v-model="item.value"
                                    placeholder="请选择"
                                    class="last"
                                    >
                        <!--  dev 0：等待中；1：待指派；2：未开始；3：进行中；4：已提交；5：已完成；6：已暂停；7：已撤销； -->
                            <a-select-option value="0" >等待中</a-select-option>
                            <a-select-option value="1" >待指派</a-select-option>
                            <a-select-option value="2" >未开始</a-select-option>
                            <a-select-option value="3" >进行中</a-select-option>
                            <a-select-option value="4" >已提交</a-select-option>
                            <a-select-option value="5" >已完成</a-select-option>
                            <a-select-option value="6" >已暂停</a-select-option>
                            <a-select-option value="7" >已撤销</a-select-option>
                        </a-select>
                        <a-select   v-else-if="item.condition == 'status' && type== 'test'"

                                    v-model="item.value"
                                    placeholder="请选择"
                                    class="last"
                                    >
                        <!-- test 0：等待中；1：待指派；2：待测试；3：测试中；4：已完成；5：已暂停；6：已撤销；7：已提交；8：待发布； -->
                            <a-select-option value="0" >等待中</a-select-option>
                            <a-select-option value="1" >待指派</a-select-option>
                            <a-select-option value="2" >待测试</a-select-option>
                            <a-select-option value="3" >测试中</a-select-option>
                            <a-select-option value="4" >已完成</a-select-option>
                            <a-select-option value="5" >已暂停</a-select-option>
                            <a-select-option value="6" >已撤销</a-select-option>
                            <a-select-option value="7" >已提交</a-select-option>
                            <a-select-option value="8" >待发布</a-select-option>
                        </a-select>
                        <a-select   v-else-if="item.condition == 'status' && type== 'design'"
                                    v-model="item.value"
                                    placeholder="请选择"
                                    class="last"
                                    >
                            <!-- design 0：等待中；1：待审核；2：待指派；3：未开始；4：进行中；5：已提交；6：已完成；7：已暂停；8：已撤销； -->
                            <a-select-option value="0" >等待中</a-select-option>
                            <a-select-option value="1" >待审核</a-select-option>
                            <a-select-option value="2" >待指派</a-select-option>
                            <a-select-option value="3" >未开始</a-select-option>
                            <a-select-option value="4" >进行中</a-select-option>
                            <a-select-option value="5" >已提交</a-select-option>
                            <a-select-option value="6" >已完成</a-select-option>
                            <a-select-option value="7" >已暂停</a-select-option>
                            <a-select-option value="8" >已撤销</a-select-option>
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
                        <a-select   v-else-if="item.condition == 'design_type'"
                                    v-model="item.value"
                                    placeholder="请选择"
                                    class="last"
                                    >
                            <!-- 0：分阶段设计；1：同时设计；2：设计优先； -->
                            <a-select-option value="0" >分阶段设计</a-select-option>
                            <a-select-option value="1" >同时设计</a-select-option>
                            <a-select-option value="2" >设计优先</a-select-option>
                        </a-select>
                        <a-input placeholder="请输入"
                                class="last"
                                v-model="item.value"
                                v-else-if="item.condition == 'number' || 'demand.number' ||  'productLine' || 'productName' || 'poductModule' || 'productCategory' || 'demand.name' || 'content'"/>

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
import moment from 'moment'
export default {
  data () {
    return {
      showSearch: false,
      data: {
        andOr: 'and',
        form: [
          { condition: undefined, judge: undefined, value: undefined, searchUser: [] },
          { condition: undefined, judge: undefined, value: undefined, searchUser: [] },
          { condition: undefined, judge: undefined, value: undefined, searchUser: [] }
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
    type: {
      type: String
    }
  },
  created () {

  },
  methods: {
    moment,
    screen () {
      let data = JSON.parse(JSON.stringify(this.data))
      data.form.map(item => {
        if (item.condition === 'created_at' || item.condition === 'finishTime' || item.condition === 'verify_time') {
          if (item.value) {
            item.value[0] = moment(item.value[0]).format('YYYY-MM-DD')
            item.value[1] = moment(item.value[1]).format('YYYY-MM-DD')
          }
        }
      })
      this.$emit('search', data)
    },
    search (e, item) {
      this.$nextTick(() => {
        // let self = this
        this.timer = searchUserList(this.timer, e, function (data) {
          item.searchUser = data.data.users
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
      this.data.form.push({ condition: undefined, judge: undefined, value: undefined, searchUser: [] })
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
  top: 335px;
  width: 570px;
  background-color: #fff;
  z-index: 100;
  box-shadow: 0px 5px 15px 0px rgba(223,226,230,0.8);
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
