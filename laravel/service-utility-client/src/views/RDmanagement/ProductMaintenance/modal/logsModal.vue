<template>
    <div>
         <!-- 操作记录弹框 -->
         <a-modal title="状态变动记录"
                   class="modal-pms"
                   v-model="logsShow"
                   :footer="null"
                   width="700px">
                <a-table :dataSource="data"
                   :columns="columns"
                   :scroll="{ y: 380 }"
                   style="margin-top:-22px"
                   :pagination="false"
                   :rowKey="(record, index) => index">
                </a-table>
                <!-- <span slot="footer"></span> -->
         </a-modal>
    </div>
</template>
<script>
import { bus } from '@/plugins/bus'
const columns = [
  {
    title: '时间',
    key: 'created_at',
    width: 150,
    dataIndex: 'created_at'
  },
  {
    title: '状态',
    key: 'status',
    dataIndex: 'status',
    scopedSlots: { customRender: 'status' }
  },
  {
    title: '操作人',
    key: 'user_name',
    width: 107,
    dataIndex: 'user_name'
  },
  {
    title: '描述',
    key: 'comment',
    width: 308,
    dataIndex: 'comment'
  }
]
export default {
  data: function () {
    return {
      logsShow: false,
      columns
    }
  },
  props: {
    data: {
      type: Array
    }
  },
  mounted () {
    bus.$on('logsModalShow', data => {
      this.logsShow = true
    })
  },
  beforeDestroy () {
    bus.$off('logsModalShow')
  }
}
</script>
