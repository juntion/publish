<template>
    <div>
        <a-modal title="班次管理"
                class="modal-pms"
                   v-model="visible"
                   :confirmLoading="btnLoad"
                   :maskClosable="false"
                   destroyOnClose
                   @ok="ok"
                   @cancel="cancel"
                   width="380px">
                    <div class="schedules-box">
                        <div class="marginB20">
                            <p class="schedules-title marginB20">选中日期: {{info.date}} {{getWeek(info.date)}}</p>
                            <span class="schedules-title-line marginB20"></span>
                            <p class="marginB10">班次:
                                 <a-popover placement="bottomLeft"
                                        arrowPointAtCenter>
                                <template slot="content">
                                    <div class="pop-content">
                                       <p> <span class="pop-left-title">标准班次:</span><span>以1天为单位;</span></p>
                                       <p> <span class="pop-left-title">半天班次:</span><span>以0.5天为单位;</span></p>
                                       <p> <span class="pop-left-title">公休日:</span><span>以0天为单位;</span></p>
                                       <p> <span class="pop-left-title">节假日:</span><span>以0天为单位;</span></p>
                                    </div>
                                </template>
                                <a-icon
                                        class="question"
                                        type="question-circle" />
                                </a-popover>
                            </p>
                            <a-select v-model="schedulesForm.type"
                                @change="changeType"
                                style="width: 100%;"
                               >
                                <a-select-option :value="1">标准班次</a-select-option>
                                <a-select-option :value="2">半天班次</a-select-option>
                                <a-select-option :value="3">公休日</a-select-option>
                                <a-select-option :value="4">节假日</a-select-option>
                            </a-select>
                        </div>
                        <el-form :model="schedulesForm" ref="schedulesForm" >
                             <el-form-item style="margin-bottom:20px" label="上午工作时间" prop="morning" :rules="[{ required: required1, message: '请选择', trigger: 'change' }]">
                                  <el-time-picker
                                    style="width:100%"
                                    size="small"
                                    is-range
                                    v-model="schedulesForm.morning"
                                    value-format="HH:mm"
                                    format="HH:mm"
                                    range-separator="至"
                                    start-placeholder="开始时间"
                                    end-placeholder="结束时间"
                                    placeholder="选择时间范围">
                                  </el-time-picker>
                            </el-form-item>
                             <el-form-item label="下午工作时间" prop="afternoon" :rules="[{ required: required2, message: '请选择', trigger: 'change' }]">
                                 <el-time-picker
                                    style="width:100%"
                                    size="small"
                                    is-range
                                    v-model="schedulesForm.afternoon"
                                    value-format="HH:mm"
                                    format="HH:mm"
                                    range-separator="至"
                                    start-placeholder="开始时间"
                                    end-placeholder="结束时间"
                                    placeholder="选择时间范围">
                                  </el-time-picker>
                            </el-form-item>
                        </el-form>

                    </div>
             </a-modal>
    </div>
</template>
<style lang="less">
    .modal-pms{
         .schedules-box .ant-select-selection{
                // border-color:#DCDFE6;
         }
        .el-form-item{
            margin-bottom: 0;
            line-height: 1;
            .el-form-item__content{
                line-height: 1;
            }
            .el-form-item__label{
                line-height: 1;
                margin-bottom: 10px;
                font-size: 12px;
                color: rgba(0, 0, 0, 0.65);;
            }
            .el-range-separator{
                width: 6%;
            }
        }
    }
</style>
<style lang="less" scoped>
        .schedules-title-line{
            display: block;
            height: 1px;
            width: 100%;
            background: #eee;
        }
        .pop-content{
            max-width:216px;
            .pop-left-title{
                color: #bbb;
                margin-right: 10px;
            }
        }

</style>
<script>
import { bus } from '@/plugins/bus'
import { editSchedules } from '@/api/schedules/index'
import moment from 'moment'
export default {
  data () {
    return {
      visible: false,
      btnLoad: false,
      info: {},
      schedulesForm: {
        type: undefined,
        morning: undefined,
        afternoon: undefined
      },
      required1: true,
      required2: true

    }
  },
  mounted () {
    bus.$on('editSchedulesModalShow', data => {
      this.visible = true
      this.info = data
      this.schedulesForm.type = data.type
      if (data.morning_to_work) {
        this.schedulesForm.morning = [data.morning_to_work, data.morning_off_work]
      } else {
        this.schedulesForm.morning = undefined
      }
      if (data.noon_to_work) {
        this.schedulesForm.afternoon = [data.noon_to_work, data.noon_off_work]
      } else {
        this.schedulesForm.afternoon = undefined
      }
      //   this.changeType(data.type)
      switch (data.type) {
        case 1:
          this.required1 = true
          this.required2 = true
          break
        case 2:
          this.required1 = true
          this.required2 = false
          break
        case 3:
          this.required1 = false
          this.required2 = false
          break
        case 4:
          this.required1 = false
          this.required2 = false
          break
        default:
          break
      }
    })
  },
  methods: {
    moment,
    getWeek (date) { // 参数时间戳
      let week = moment(date).day()
      switch (week) {
        case 1:
          return '周一'
        case 2:
          return '周二'
        case 3:
          return '周三'
        case 4:
          return '周四'
        case 5:
          return '周五'
        case 6:
          return '周六'
        case 0:
          return '周日'
      }
    },
    changeType (e) {
      switch (e) {
        case 1:
          this.required1 = true
          this.required2 = true
          this.schedulesForm.morning = ['09:30', '12:30']
          this.schedulesForm.afternoon = ['14:00', '18:30']
          break
        case 2:
          this.required1 = true
          this.required2 = false
          this.schedulesForm.morning = ['09:30', '12:00']
          this.schedulesForm.afternoon = undefined
          break
        case 3:
          this.required1 = false
          this.required2 = false
          this.schedulesForm.morning = undefined
          this.schedulesForm.afternoon = undefined
          break
        case 4:
          this.required1 = false
          this.required2 = false
          this.schedulesForm.morning = undefined
          this.schedulesForm.afternoon = undefined
          break
        default:
          break
      }
    },
    cancel () {

    },
    ok () {
      this.$refs['schedulesForm'].validate((valid) => {
        if (valid) {
          let params = this.schedulesForm
          if (params.morning) {
            params.morning_to_work = this.schedulesForm.morning[0]
            params.morning_off_work = this.schedulesForm.morning[1]
          }
          if (params.afternoon) {
            params.noon_to_work = this.schedulesForm.afternoon[0]
            params.noon_off_work = this.schedulesForm.afternoon[1]
          }
          this.btnLoad = true
          editSchedules(this.info.id, params).then(res => {
            this.btnLoad = false
            this.visible = false
            this.$message.success('修改成功')
            let time = this.$parent.time
            this.$parent.onPanelChange(time)
          }).catch(error => {
            this.btnLoad = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        } else {
          return false
        }
      })
    }

  }
}
</script>
