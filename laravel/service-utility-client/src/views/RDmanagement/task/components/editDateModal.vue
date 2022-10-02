<template>
    <div>
        <a-modal title="编辑预计交付日期"
                   class="modal-pms"
                    :confirmLoading="btnLoad"
                    @cancel="cancel"
                    @ok="ok"
                   :maskClosable="false"
                   v-model="visible"
                   width="700px">
            <a-form-model :model="form"  ref="form">
              <div class="radio_box">
                <a-row class="form-row" style="margin-bottom:15px">
                  <a-col :lg="24"
                         :md="24"
                         :sm="24">
                    <a-form-model-item label="预计交付日期" prop="expiration_date" :rules="[{ required: true, message: '请选择截止时间' ,trigger: 'change'}]">
                      <a-date-picker style="width:585px"
                                     format="YYYY-MM-DD"
                                     :allowClear="false"
                                     :disabledDate="disabledDate"
                                     v-model="form.expiration_date"
                                     @change="changeWorkload($event)"
                                     type="date"
                                     placeholder="选择日期">
                      </a-date-picker>
                       <span v-if="form.expiration_date" style="margin-left:6px">
                           还剩<span style="color:#F88D49"> {{moment(form.expiration_date).diff(moment().startOf('day'), 'day')}} </span>天
                      </span>
                    </a-form-model-item>
                  </a-col>
                </a-row>
                <a-row style="margin-bottom:15px">
                    <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            style="padding-right: 20px">
                        <a-form-model-item
                            class="colon"
                            prop="standard_workload"
                            :rules="[{ required: true, message: '请输入', trigger: 'blur' }]"
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
                                    :disabled="!form.checked"
                                    @change="changeWorkDay($event,form)"
                                    v-model="form.standard_workload"
                                    style="width:78%;margin-right:10px"
                                    :min="1" />
                                 <a-checkbox
                                 :disabled="!form.standard_workload"
                                 @change="adjustment($event,form)"
                                 v-model="form.checked">调整</a-checkbox>
                            </div>
                        </a-form-model-item>
                    </a-col>

                    <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            >
                        <a-form-model-item
                            class="colon"
                            prop="level"
                            :rules="[{ required: true, message: '请输入', trigger: 'blur' }]">
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
                                                <tr v-for="(item,index) in tableData" :key="index">
                                                   <td>{{item.day}}</td>
                                                   <td>{{item.level}}</td>
                                                   <td>{{item.grade}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </template>
                                    <span class="iconfont fz12 cup">&#xe640;</span>
                                </a-popover>
                            </span>
                                <a-input v-model="form.level" disabled/>
                        </a-form-model-item>
                    </a-col>
              </a-row>
              <a-row v-if="form.checked">
                  <a-col :lg="24"
                            :md="24"
                            :sm="24"
                            >
                        <a-form-model-item class="colon"
                        prop="adjust_reason"
                        :rules="[{ required: true, message: '请输入调整原因', trigger: 'blur' }]">
                        <span slot="label"> 调整原因 :<span style="color:#f88d49;margin-left:10px">标准工作量为自动根据预计交付日期计算,其变动会影响绩效等级和系数,请务必说明原因 </span></span>
                       <a-textarea
                            v-model="form.adjust_reason"
                            style="height:80px"
                            placeholder="请输入调整原因"

                            />
                        </a-form-model-item>
                    </a-col>
              </a-row>
              </div>
            </a-form-model>
          </a-modal>
    </div>
</template>
<style lang="less" scoped>

</style>
<script>
import { changeTaskDate, changeSubtasksDate, getWorkload, getAchievements } from '@/api/RDmanagement/task/dev'
import { bus } from '@/plugins/bus'
import moment from 'moment'
export default {
  data () {
    return {
      visible: false,
      btnLoad: false,
      form: {
        expiration_date: undefined,
        standard_workload: undefined,
        level: undefined,
        checked: false,
        adjust_reason: undefined
      },
      info: {},
      tableData: [
        { day: 'X＞15', level: 'S', grade: '1.4' },
        { day: '8＜X≤15', level: 'A', grade: '1.3' },
        { day: '5＜X≤8', level: 'B', grade: '1.2' },
        { day: '2＜X≤5', level: 'C', grade: '1.1' },
        { day: '1≤X≤2', level: 'D', grade: '1' }
      ]
    }
  },
  mounted () {
    bus.$on('editDateModalShow', data => {
      this.visible = true
      this.info = data
      this.form.checked = false
      this.form.expiration_date = moment(data.expiration_date)
      if (data.standard_workload) {
        this.form.standard_workload = data.standard_workload
        this.form.level = data.performance_level + '/' + data.standard_factor
      } else {
        this.changeWorkload(this.form.expiration_date)
      }
    })
  },
  beforeDestroy () {
    bus.$off('editDateModalShow')
  },
  methods: {
    moment,
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment().startOf('day')
    },
    async changeWorkload (e) {
      if (e) {
        let params = { expiration_date: e.format('YYYY-MM-DD') }
        const res = await getWorkload(params)
        this.form.standard_workload = res.data.standard_workload
        this.form.level = res.data.performance_level + '/' + res.data.standard_factor
      } else {
        this.allotForm.standard_workload = undefined
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
    ok () {
      this.$refs.form.validate(valid => {
        if (!valid) {
          return false
        }
        let k = this.info
        let params = this.form
        params.expiration_date = this.form.expiration_date.format('YYYY-MM-DD')
        this.btnLoad = true
        if (k.promulgator_id) {
          changeTaskDate(k.id, params).then(res => {
            this.visible = false
            this.$message.success('修改成功')
            this.$parent.getTaskAll()
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
          }).finally(() => {
            this.btnLoad = false
          })
        } else {
          changeSubtasksDate(k.id, params).then(res => {
            this.visible = false
            this.$message.success('修改成功')
            this.$parent.getTaskAll()
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
          }).finally(() => {
            this.btnLoad = false
          })
        }
      })
    },
    cancel () {
      this.visible = false
    }
  }
}
</script>
