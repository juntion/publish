<template>
    <div>
        <div class="modal-box modal-task">
      <el-dialog :title="title"
                 :visible.sync="dialogVisible"
                 width="1200px">
            <div class="radio_box"
                style="padding-bottom: 10px;margin-top: -20px;">
            <a-table :dataSource="data3"
                    :columns="columns3"
                    :pagination="false"
                    :loading="modalLoading"
                    :rowKey="(record, index) => index">
                <div slot="type"
                    slot-scope="type,record">
                    <span v-if="type==='design'">设计
                        <span v-if="record.role_type===0">(交互)</span>
                        <span v-if="record.role_type===1">(视觉)</span>
                        <span v-if="record.role_type===2">(美工)</span>
                        <span v-if="record.role_type===3">(前端)</span>
                        <span v-if="record.role_type===4">(移动端)</span>
                    </span>
                    <span v-if="type==='dev'">开发</span>
                    <span v-if="type==='test'">测试</span>
                </div>
                <div slot="number"
                    slot-scope="number,record">
                    <span  class="tree" v-if="record.task_type===1">总</span>
                    <span v-if="record.type==='design'">
                        <span  class="tree" style="background:rgba(62,204,166,.2);color:rgba(62,204,166,1)" v-if="record.task_type===3">子</span>
                        <span  class="tree" style="background:rgba(254,188,46,.2);color:rgba(254,188,46,1)" v-if="record.task_type===2">子</span>
                    </span>
                    <span v-else>
                        <span  class="tree" style="background:rgba(62,204,166,.2);color:rgba(62,204,166,1)" v-if="record.task_type===3">子</span>
                    </span>
                    {{number}}
                </div>
                <!-- <div slot="principal_user_name"
                      slot-scope="text">
                    <span >{{text ? text : '--'}}</span>
                </div>
                <div slot="follower_name"
                      slot-scope="text">
                    <span >{{text ? text : '--'}}</span>
                </div>
                <div slot="expiration_date"
                      slot-scope="text">
                    <span >{{text ? text : '--'}}</span>
                </div>
                <div slot="start_date"
                      slot-scope="text">
                    <span >{{text ? text : '--'}}</span>
                </div>
                <div slot="finish_date"
                      slot-scope="text">
                    <span >{{text ? text : '--'}}</span>
                </div>
                 <div slot="expected_time"
                      slot-scope="text">
                    <span >{{text ? text : '--'}}</span>
                </div>
                 <div slot="actual_time"
                      slot-scope="text">
                    <span >{{text ? text : '--'}}</span>
                </div> -->
                 <div slot="overdue_time"
                      slot-scope="text">
                    <span style="color:#FF4A4A">{{text }}</span>
                </div>
                <div slot="operation"
                    slot-scope="operation,record">
                        <span class="iconfont arrow"
                        @click="goTask(record)">&#xe643;</span>
                </div>
            </a-table>
            </div>
      </el-dialog>
    </div>
    </div>
</template>
<script>
import { getDemandsTask } from '@/api/RDmanagement/product/index'
const columns3 = [
  {
    title: '研发环节',
    key: 'type',
    dataIndex: 'type',
    scopedSlots: { customRender: 'type' }
  },
  {
    title: '任务ID',
    key: 'number',
    dataIndex: 'number',
    scopedSlots: { customRender: 'number' }
  },
  {
    title: '负责人',
    key: 'principal_user_name',
    dataIndex: 'principal_user_name',
    scopedSlots: { customRender: 'principal_user_name' }
  },
  {
    title: '跟进人',
    key: 'follower_name',
    dataIndex: 'follower_name',
    scopedSlots: { customRender: 'follower_name' }
  },
  {
    title: '目标交付日期',
    key: 'expiration_date',
    dataIndex: 'expiration_date',
    scopedSlots: { customRender: 'expiration_date' }
  },
  {
    title: '开始时间',
    key: 'start_date',
    dataIndex: 'start_date',
    scopedSlots: { customRender: 'start_date' }
  },
  {
    title: '完成时间',
    key: 'finish_date',
    dataIndex: 'finish_date',
    scopedSlots: { customRender: 'finish_date' }
  },
  {
    title: '预计消耗（天）',
    key: 'expected_time',
    dataIndex: 'expected_time',
    scopedSlots: { customRender: 'expected_time' }
  },
  {
    title: '实际消耗',
    key: 'actual_time',
    dataIndex: 'actual_time',
    scopedSlots: { customRender: 'actual_time' }
  },
  {
    title: '超期时长',
    key: 'overdue_time',
    dataIndex: 'overdue_time',
    scopedSlots: { customRender: 'overdue_time' }
  },
  {
    title: '状态',
    key: 'status_desc',
    dataIndex: 'status_desc',
    scopedSlots: { customRender: 'status_desc' }
  },
  {
    title: '操作',
    key: 'operation',
    dataIndex: 'operation',
    scopedSlots: { customRender: 'operation' }
  }
]
export default {
  data () {
    return {
      data3: [],
      columns3,
      dialogVisible: false,
      modalLoading: false
    }
  },
  props: {
    id: {
      type: Number
    },
    title: {
      type: String,
      default: 'Task信息'
    }
  },
  watch: {
    id: {
      handler: function (o, n) {
        this.modalLoading = true
        getDemandsTask(this.id).then(res => {
          this.modalLoading = false
          this.data3 = res.data
        })
      }
    }
  },
  created () {

  },
  methods: {
    goTask (e) {
      this.$router.push({ name: 'task', query: { number: e.number, type: e.type } })
    }
  }
}
</script>
<style lang="less" scoped>
.arrow {
  font-size: 12px;
  color: #378eef;
  cursor: pointer;
}
.modal-box /deep/ .el-dialog__body {
  padding: 20px 20px 0 20px;
}
.modal-box /deep/ .el-dialog__title {
  color: #666;
  font-size: 16px;
  font-weight: bold;
}
    .tree {
    line-height: 18px;
    display: inline-block;
    width: 18px;
    height: 18px;
    text-align: center;
    background: rgba(255, 74, 74, 0.2);
    color: #ff4a4a;
    }
    .son {
    color: #3dcca6;
    background: rgba(61, 204, 166, 0.2);
    }
</style>
