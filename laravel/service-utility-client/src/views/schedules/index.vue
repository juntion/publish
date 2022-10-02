<template>
<div>
  <!-- 班次管理弹框 -->
  <editSchedules></editSchedules>
  <a-calendar @panelChange="onPanelChange" v-model="time" :disabledDate="disabledDate" :validRange="[moment('2021-01-01'),moment().add(10, 'year')]">
    <div slot="dateCellRender" slot-scope="value"  class="frequency-box">
    <div  v-for="(item,index) in getListData(value)" :key="index">
     <div v-if="item" :style="{color: (item.type ===1 || item.type ===2)? '#FEBC2E' : '#3DCCA6'}">
        <span class="class-radio"  :style="{background: (item.type ===1 || item.type ===2)? '#FEBC2E' : '#3DCCA6'}"></span>
        <span v-if="item.type ===1" style="color:#666">标准班次</span>
        <span v-if="item.type ===2" style="color:#666">半天班次</span>
        <span v-if="item.type ===3">公休日</span>
        <span v-if="item.type ===4">节假日</span>
     </div>
       <span class="iconfont" v-if="item && canDo('schedules.update')" title="班次管理" @click.stop="edit(item)">&#xe637;</span>
    </div>
    </div>
  </a-calendar>
 </div>
</template>
<script>
import { bus } from '@/plugins/bus'
import { getSchedules } from '@/api/schedules/index'
import editSchedules from './modal/editSchedules'
import moment from 'moment'
import { canDo } from '@/plugins/common'
export default {
  components: { editSchedules },
  data () {
    return {
      schedules: [],
      show: false,
      time: moment()
    }
  },
  created () {
    let y = new Date().getFullYear()
    let m = new Date().getMonth() + 1
    getSchedules(y, m).then(res => {
      this.schedules = res.data.schedules
    })
  },
  methods: {
    canDo,
    moment,
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment('2021-01-01 00:00:00').startOf('day')
    },
    onPanelChange (value, mode) {
      getSchedules(value.year(), value.month() + 1).then(res => {
        this.schedules = res.data.schedules
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    edit (e) {
      bus.$emit('editSchedulesModalShow', e)
    },
    getListData (value) {
      const time = value.format('YYYY-MM-DD')
      let data = []
      let timeList = this.schedules.map(item => {
        return item.date
      })
      let index = timeList.indexOf(time)
      data = [this.schedules[index]]
      return data
    }
  }
}
</script>
<style scoped lang="less">
/deep/.ant-fullcalendar-fullscreen .ant-fullcalendar-header .ant-radio-group{
    display: none;
}
/deep/.ant-fullcalendar-value{
    text-align: left;
    font-size: 18px;
}
/deep/.ant-fullcalendar-header{
    text-align: left;
    background: #fff;
    padding: 20px;
    margin-bottom: 20px;
}
/deep/.ant-fullcalendar{
    background: #fff;
    .ant-fullcalendar-calendar-body{
        padding: 30px 20px;
    }

}
/deep/.ant-fullcalendar-fullscreen .ant-fullcalendar-column-header{
     text-align: left;
     font-size: 14px;
     padding-left: 10px;
}
/deep/.ant-fullcalendar-fullscreen .ant-fullcalendar-date:hover{
    background: rgba(204, 204, 204, .1);
}
/deep/.ant-fullcalendar-fullscreen .ant-fullcalendar-selected-day .ant-fullcalendar-date{
    background: rgba(55, 142, 239, .1);
}
 /deep/.ant-fullcalendar-date:hover{
        .iconfont{
            display: block;
        }
  }
.frequency-box {
  width: 100%;
  height: 100%;
  font-size: 14px;
  padding-top: 5px;
.class-radio{
    display: inline-block;
    width: 5px;
    height: 5px;
    background: #FEBC2E;
    border-radius: 50%;
    vertical-align: middle;
    margin-right: 4px;
  }
  .iconfont{
    display: none;
    font-size: 12px;
    position: absolute;
    top: 10px;
    right: 10px;
    color: #378EEF;
  }

}
</style>
