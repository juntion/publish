<template>
    <div>
             <a-modal title="检验结果"
                    class="modal-pms"
                   v-model="visible"
                   :confirmLoading="btnLoad"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                   <div class="tips-box" v-if="tipsShow">
                       注意：无法发布，以下功能未满足条件。请联系对应人员操作后，再次发布！
                       <span class="iconfont fz12" @click="closeTips">&#xe631;</span>
                   </div>
                   <div class="tips-text">
                        <p  class="marginB5">任务未验收完成：{{errInfo.not_finished.length}}条</p>
                        <div class="marginB20 overflow-tip-list" v-if="errInfo.not_finished.length">
                          <div v-for="(child, j) in errInfo.not_finished" :key="j">
                            任务：
                            <span style="margin-bottom:4px" v-for="(item, i) in child.task_number" :key="item">
                              {{item}}{{ i === child.task_number.length - 1 ? '' : '、' }}
                            </span>
                            <span v-if="child.demand_number">（{{ child.demand_number }}）</span>
                          </div>
                        </div>
                        <p :class="{marginB5:errInfo.not_confirmed.length}" style="margin-top: 20px;">功能未确认：{{errInfo.not_confirmed.length}}条</p>
                        <div class="overflow-tip-list">
                          <div v-for="(child1, j1) in errInfo.not_confirmed" :key="j1">
                            任务：
                            <span style="margin-bottom:4px" v-for="(item1, i) in child1.task_number" :key="item1">
                              {{item1}}{{ i === child1.task_number.length - 1 ? '' : '、' }}
                            </span>
                            <span v-if="child1.demand_number">（{{ child1.demand_number }}）</span>
                          </div>
                        </div>
                   </div>
                   <div slot="footer" class="tac">
                         <a-button @click="ok"  type="primary">好的</a-button>
                    </div>
             </a-modal>
    </div>
</template>

<style lang="less" scoped>
    .tips-box{
        position: relative;
        width: 340px;
        background: #FFF2EA;
        color: #F88D49;
        padding:8px 30px 10px 10px;
        border: 1px solid #FFD8BF;
        border-radius: 5px;
        margin-bottom: 20px;
        & >.iconfont{
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    }
    .tips-text{
        line-height: 1;
        .overflow-tip-list{
            max-height: 108px;
            overflow-y: auto;
            line-height: 18px;
        }
    }
</style>
<script>
import { bus } from '@/plugins/bus'
export default {
  data () {
    return {
      visible: false,
      btnLoad: false,
      tipsShow: true,
      errInfo: {
        not_confirmed: [],
        not_finished: []
      }

    }
  },
  mounted () {
    bus.$on('checkResultsModalShow', data => {
      this.errInfo = data
      this.tipsShow = true
      this.visible = true
    })
  },
  beforeDestroy () {
    bus.$off('checkResultsModalShow')
  },
  methods: {
    ok () {
      this.visible = false
    },
    closeTips () {
      this.tipsShow = false
    }
  }
}
</script>
