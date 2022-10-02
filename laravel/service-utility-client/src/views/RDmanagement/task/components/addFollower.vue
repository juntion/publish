<template>
    <div >
        <a-modal title="添加次要跟进人"
            class="modal-pms modal-addFollower"
            v-model="modalVisible"
            :confirmLoading="btnLoad"
            @cancel="cancel"
            @ok="ok"
            :maskClosable="false"
            destroyOnClose
            width="700px">
            <div>
                     <h3>{{title}} <span class="add-handler cup" @click="add" :style="{opacity:subtasks.length>4 ?  '.5' :'1'}"> <a-icon type="plus" /> 添加次要跟进人</span></h3>
                    <a-form-model
                        :model="{subtasks}"
                        ref="ruleForm">
                           <div class="other-subtask" v-for="(item,index) in subtasks" :key="index">
                                <span class="number">{{index+1}}</span>
                                <span class="iconfont del"
                                        v-if="subtasks.length > 1"
                                        @click="() => remove(index)">&#xe631;</span>
                                <a-row style="margin-bottom:20px">
                                    <a-col :lg="12"
                                            :md="12"
                                            :sm="24"
                                            style="padding-right: 10px">
                                        <a-form-model-item
                                                label="次要跟进人"
                                                :prop="'subtasks.' + index + '.user'"
                                                :rules="[{ required: true, message: '请选择跟进人', trigger: 'blur' }]">
                                                <!-- <a-select
                                                    v-model="item.user"
                                                    showSearch
                                                    labelInValue
                                                    optionFilterProp="children"
                                                    placeholder="请选择">
                                                    <a-select-option v-for="k in options"
                                                                    :title="k.name"
                                                                    :key="k.id">{{k.name}}</a-select-option>
                                                </a-select> -->
                                                <allPersonSelect :autoFocus="false"
                                                                @getSelectValue="handleSearch"
                                                                :selectValue="followerID[index]"
                                                                :searchData="followerArr[index]"
                                                                :index="index"
                                                                :ref="'followerRef' + index"
                                                                placeholder="请输入英文名搜索"
                                                                style="width: 100%;">
                                                </allPersonSelect>
                                        </a-form-model-item>
                                    </a-col>
                                    <a-col :lg="12"
                                            :md="12"
                                            :sm="24"
                                            >
                                        <a-form-model-item
                                                label="预计完成日期"
                                                :prop="'subtasks.' + index + '.expiration_date'"
                                                :rules="[{ required: true, message: '请选择截止时间', trigger: 'change' }]">
                                            <a-date-picker style="width:76%"
                                                    format="YYYY/MM/DD"
                                                    :allowClear="false"
                                                    @change="changeDate($event,item,index)"
                                                    :disabledDate="disabledDate"
                                                    v-model="item.expiration_date"
                                                    type="date"
                                                    placeholder="请选择日期">
                                            </a-date-picker>
                                             <span v-if="item.expiration_date" style="margin-left:6px">
                                                还剩<span style="color:#F88D49"> {{moment(item.expiration_date).diff(moment().startOf('day'), 'day')}} </span>天
                                            </span>
                                        </a-form-model-item>
                                    </a-col>
                            </a-row>
                            <a-row style="margin-bottom:20px" v-if="postType === 1">
                                    <a-col :lg="12"
                                            :md="12"
                                            :sm="24"
                                            style="padding-right: 10px">
                                        <a-form-model-item
                                            class="colon"
                                            :prop="'subtasks.' + index + '.standard_workload'"
                                            :rules="[{ required: true, message: '请输入', trigger: 'change' }]"
                                        >
                                        <span slot="label">考核标准工作量(天) :
                                            <a-popover
                                                    placement="bottomLeft"
                                                    arrowPointAtCenter>
                                                    <template slot="content">
                                                        <div style="max-width:216px;">
                                                        <p class="pop-title">考核标准工作量（天）：</p>
                                                        <div>
                                                            预计交付日期-当前日期-期间休息天数
                                                        </div>
                                                        <p class="pop-title">注意 ：</p>
                                                        <div>
                                                            当预计交付日期因项目需求周期影响，需延长或缩短时，并需重新定义考核标准工作量时，可点击调整，并说明原因，对应等级和系数按照此修改后的值计算。
                                                        </div>
                                                        </div>
                                                    </template>
                                                    <span class="iconfont fz12 cup">&#xe640;</span>
                                            </a-popover>
                                        </span>
                                            <div>
                                                <a-input-number
                                                    :disabled="!item.checked"
                                                    @change="changeWorkDay($event,item)"
                                                    v-model="item.standard_workload"
                                                    style="width:78%;margin-right:10px"
                                                    :min="1" />
                                                <a-checkbox
                                                :disabled="!item.standard_workload"
                                                 @change="adjustment($event,item)"
                                                v-model="item.checked">调整</a-checkbox>
                                            </div>
                                        </a-form-model-item>
                                    </a-col>

                                    <a-col :lg="12"
                                            :md="12"
                                            :sm="24"
                                            >
                                        <a-form-model-item
                                            class="colon"
                                            :prop="'subtasks.' + index + '.level'"
                                            :rules="[{ required: true, message: '请输入', trigger: 'change' }]">
                                            <span slot="label">绩效等级/系数 :
                                                <a-popover
                                                    placement="bottomLeft"
                                                    arrowPointAtCenter>
                                                    <template slot="content">
                                                        <div style="width:266px">
                                                            <p class="pop-title">绩效等级/系数：</p>
                                                            <div>根据标准工作量进行自动匹配：</div>
                                                            <table class="pop-table" style="border-collapse: collapse;">
                                                                <tr>
                                                                    <th> 标准工作量X (天)</th>
                                                                    <th> 绩效等级 </th>
                                                                    <th> 标准分系数 </th>
                                                                </tr>
                                                                <tr v-for="(item2,index) in tableData" :key="index">
                                                                <td>{{item2.day}}</td>
                                                                <td>{{item2.level}}</td>
                                                                <td>{{item2.grade}}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </template>
                                                    <span class="iconfont fz12 cup">&#xe640;</span>
                                                </a-popover>
                                            </span>
                                                <a-input v-model="item.level" disabled/>
                                        </a-form-model-item>
                                    </a-col>
                            </a-row>
                            <a-row v-if="item.checked">
                                <a-col :lg="24"
                                            :md="24"
                                            :sm="24"
                                            >
                                        <a-form-model-item class="colon"
                                        :prop="'subtasks.' + index + '.adjust_reason'"
                                        style="margin-bottom:20px"
                                        :rules="[{ required: true, message: '请输入调整原因', trigger: 'blur' }]">
                                        <span slot="label"> 调整原因 :<span style="color:#f88d49;margin-left:10px">标准工作量为自动根据预计交付日期计算,其变动会影响绩效等级和系数,请务必说明原因 </span></span>
                                    <a-textarea
                                            v-model="item.adjust_reason"
                                            style="height:80px"
                                            placeholder="请输入调整原因"

                                            />
                                        </a-form-model-item>
                                    </a-col>
                            </a-row>
                            <a-row>
                                <a-col :lg="24"
                                            :md="24"
                                            :sm="24"
                                            >
                                        <a-form-model-item
                                                label="任务分工要求"
                                                :prop="'subtasks.' + index + '.description'"
                                                :rules="[{ required: false, message: '请输入任务分工要求描述', trigger: 'blur' }]">
                                    <a-textarea
                                            v-model="item.description"
                                            :rows="4"
                                            placeholder="请输入任务分工要求描述"
                                            />
                                        </a-form-model-item>
                                    </a-col>
                            </a-row>
                            </div>
                    </a-form-model>
            </div>
        </a-modal>
    </div>
</template>

<script>
import allPersonSelect from '@/components/allPersonSelect'
import { testTaskHandler, designTaskHandler, devTaskHandler } from '@/api/RDmanagement/dropDown'
import { postSubtasksDev, getWorkload, getAchievements } from '@/api/RDmanagement/task/dev'
import { postSubtasksTest } from '@/api/RDmanagement/task/test'
import { postSubtasksDesign } from '@/api/RDmanagement/task/design'
import moment from 'moment'
export default {
  components: { allPersonSelect },
  data () {
    return {
      tableData: [
        { day: 'X＞15', level: 'S', grade: '1.4' },
        { day: '8＜X≤15', level: 'A', grade: '1.3' },
        { day: '5＜X≤8', level: 'B', grade: '1.2' },
        { day: '2＜X≤5', level: 'C', grade: '1.1' },
        { day: '1≤X≤2', level: 'D', grade: '1' }
      ],
      btnLoad: false,
      modalVisible: false,
      options: [],
      followerArr: [[]],
      followerID: [undefined],
      subtasks: [{
        user: undefined,
        expiration_date: undefined,
        description: undefined,
        standard_workload: undefined,
        level: undefined,
        checked: false,
        adjust_reason: undefined
      }]
    }
  },
  props: {
    id: {
      type: Number
    },
    postType: {
      type: Number
    },
    title: {
      type: String
    }
  },
  mounted () {
    if (this.postType === 1) {
      devTaskHandler().then(res => {
        if (res.code === 200) {
          this.options = res.data.users
        }
      })
    } else if (this.postType === 2) {
      testTaskHandler().then(res => {
        if (res.code === 200) {
          this.options = res.data.users
        }
      })
    } else if (this.postType === 3) {
      designTaskHandler().then(res => {
        if (res.code === 200) {
          this.options = res.data.users
        }
      })
    }
  },
  methods: {
    moment,
    handleSearch (e) {
      this.subtasks[e.index].user = { key: e.id, label: e.name }
    },
    cancel () {
      this.subtasks = [{
        user: undefined,
        expiration_date: undefined,
        description: undefined,
        standard_workload: undefined,
        level: undefined,
        checked: false,
        adjust_reason: undefined
      }]
      this.followerID = [undefined]
      this.followerArr = [[]]
      this.$refs['followerRef' + 0].value = undefined
      this.$refs.ruleForm.resetFields()
    },
    async changeDate (e, item, index) {
      if (e && this.postType === 1) {
        let params = { expiration_date: e.format('YYYY-MM-DD') }
        const res = await getWorkload(params)
        this.$nextTick(() => {
          item.standard_workload = res.data.standard_workload
          item.level = res.data.performance_level + '/' + res.data.standard_factor
        })
        this.$refs.ruleForm.clearValidate('subtasks.' + index + '.standard_workload')
        this.$refs.ruleForm.clearValidate('subtasks.' + index + '.level')
      } else {
        item.standard_workload = undefined
      }
    },
    async changeWorkDay (e, item) {
      let params = { workload: e }
      const res = await getAchievements(params)
      item.level = res.data.performance_level + '/' + res.data.standard_factor
    },
    async adjustment (e, item) {
      if (!e.target.checked) {
        let params = { expiration_date: item.expiration_date.format('YYYY-MM-DD') }
        const res = await getWorkload(params)
        item.standard_workload = res.data.standard_workload
        item.level = res.data.performance_level + '/' + res.data.standard_factor
      }
    },
    submit () {
      let params = []
      this.subtasks.forEach((item, i) => {
        params.push(JSON.parse(JSON.stringify(this.subtasks[i])))
        params[i].expiration_date = item['expiration_date'].format('YYYY-MM-DD')
        params[i].user_id = item.user.key
      })
      if (this.postType === 1) {
        this.btnLoad = true
        postSubtasksDev(this.id, params).then(res => {
          if (res.code === 200) {
            this.$message.success('创建子任务成功')
            this.btnLoad = false
            this.$refs.ruleForm.resetFields()
            this.subtasks = [{
              user: undefined,
              expiration_date: undefined,
              description: undefined,
              standard_workload: undefined,
              level: undefined,
              checked: false,
              adjust_reason: undefined
            }]
            this.modalVisible = false
            this.followerID = [undefined]
            this.followerArr = [[]]
            this.$refs['followerRef' + 0].value = undefined
            this.$parent.getTaskAll()
          }
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (this.postType === 2) {
        this.btnLoad = true
        postSubtasksTest(this.id, params).then(res => {
          if (res.code === 200) {
            this.$message.success('创建子任务成功')
            this.btnLoad = false
            this.modalVisible = false
            this.$parent.getTaskAll()
            this.$refs.ruleForm.resetFields()
            this.subtasks = [{
              user: undefined,
              expiration_date: undefined,
              description: undefined,
              standard_workload: undefined,
              level: undefined,
              checked: false,
              adjust_reason: undefined
            }]
            this.followerID = [undefined]
            this.followerArr = [[]]
            this.$refs['followerRef' + 0].value = undefined
          }
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (this.postType === 3) {
        this.btnLoad = true
        postSubtasksDesign(this.id, params).then(res => {
          if (res.code === 200) {
            this.$message.success('创建子任务成功')
            this.btnLoad = false
            this.modalVisible = false
            this.$parent.getTaskAll()
            this.$refs.ruleForm.resetFields()
            this.subtasks = [{
              user: undefined,
              expiration_date: undefined,
              description: undefined,
              standard_workload: undefined,
              level: undefined,
              checked: false,
              adjust_reason: undefined
            }]
            this.followerID = [undefined]
            this.followerArr = [[]]
            this.$refs['followerRef' + 0].value = undefined
          }
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    },
    ok () {
      this.$refs.ruleForm.validate(valid => {
        if (valid) {
          // 判断跟进人是否重复
          let arr = []
          let name = ''
          this.subtasks.map(item => {
            if (item.user) {
              arr.push(item.user.label)
            }
            if (arr.indexOf(item.user.label) !== -1) {
              name = item.user.label
            }
          })
          if ((new Set(arr)).size !== arr.length) {
            if (confirm(`检测到${name}重复,确认为其重复添加`)) {
              this.submit()
            }
          } else {
            this.submit()
          }
        } else {
          return false
        }
      })
    },
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment().startOf('day')
    },
    remove (e) {
      this.subtasks.splice(e, 1)
      this.followerID.splice(e, 1)
      this.followerArr.splice(e, 1)
      this.subtasks.forEach((item, index) => {
        this.$set(this.followerArr, index, [{ id: item.user.key, name: item.user.label }])
        this.$set(this.followerID, index, item.user.key)
        this.$refs['followerRef' + index].value = item.user.key
      })
    },
    add () {
      if (this.subtasks.length > 4) {
        this.$message.warning('每次最多添加5人，请提交后再添加')
      } else {
        this.subtasks.push({
          handler_id: undefined,
          expiration_date: undefined,
          description: undefined,
          standard_workload: undefined,
          level: undefined,
          checked: false,
          adjust_reason: undefined
        })
      }
    }
  }
}
</script>
<style lang="less" scoped>
.pop-title{
            color: #bbb;
            font-size: 12px;
        }
        .pop-table{
            margin-top: 6px;
            th{
                border: 1px solid #ccc;
                padding: 10px;
            }
            td{
                border: 1px solid #ccc;
                text-align: center;
                line-height: 1;
                padding: 10px 0;
            }
        }
.modal-addFollower{
        h3 {
            font-size: 14px;
            line-height: 1;
            font-family: Microsoft YaHei;
            font-weight: bold;
            color: rgba(51, 51, 51, 1);
            padding-bottom: 10px;
            .add-handler{
                font-size: 12px;
                font-weight: 400;
                color: #378EEF;
                float: right;
            }
        }

        .other-subtask .number{
        display: inline-block;
        width: 30px;
        height: 30px;
        padding-left: 7px;
        padding-top: 5px;
        background: #FDDA42;
        position: relative;
        top: -10px;
        left: -20px;
        border-radius: 3px 0px 28px 0px;
    }

    .other-subtask{
        margin-top: 10px;
        background: #F8F8F8;
        border-radius: 3px;
        padding:10px 20px 20px 20px;
        position: relative;
    }
    .del{
        font-size: 12px;
        cursor: pointer;
        position: absolute;
        right: 10px;
        top: 10px;
        color:#BBBBBB;
    }
}

</style>
