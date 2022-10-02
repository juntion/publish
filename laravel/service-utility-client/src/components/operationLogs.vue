<template>
  <div>
    <ul class="el-timeline  info-time-box">
      <li class="el-timeline-item"
          :class="'active'"
          v-for="(item,index) in data"
          :key="index">
        <div class="info-time">{{item.created_at}}</div>
        <div class="info-time-line">
          <div class="el-timeline-item__tail"></div>
          <div class="el-timeline-item__node el-timeline-item__node--normal el-timeline-item__node--">
          </div>
        </div>

        <div class="el-timeline-item__wrapper">
          <div class="el-timeline-item__content line-detial-box">
            <p>{{item.description}}
              <span v-if="item.changes && item.changes.length > 0"
                    @click="toggle(item)">
                <span v-if="item.show"
                      class="icon iconfont">&#xe642;</span>
                <span v-else
                      class="icon iconfont">&#xe650;</span>
              </span>
            </p>
            <div class="line-detial"
                 v-if="item.show">
              <p v-for="(k,index) in item.changes" v-if="k.name.indexOf('内容') === -1 && k.name.indexOf('描述') === -1"
                 :key="index">修改了{{k.name}}，旧值为 "{{k.old}}"，新值为 "{{k.new}}"。</p>
              <p v-else :key="index">修改了{{k.name}}，<a @click="showDrawer(k.old, k.new)">点击查看变动</a></p>
            </div>
          </div>

        </div>
      </li>

    </ul>
    <a-drawer width="900" placement="right" :closable="false" @close="onClose" :visible="visible">
      <myViewer :html="diffHml"></myViewer>
    </a-drawer>
  </div>
</template>
<script>
import HtmlDiff from '../plugins/HtmlDIff/Diff'
import myViewer from '@/components/myViewer'
export default {
  components: { myViewer },
  data () {
    return {
      activeClass: 0,
      oldHtml: '',
      newHtml: '',
      diffHml: '',
      visible: false
    }
  },
  computed: {

  },
  props: {
    data: {
      type: Array
    }
  },
  methods: {
    toggle (e) {
      e.show = !e.show
    },
    showDrawer (oldHtml, newHtml) {
      this.diffHml = HtmlDiff.execute(oldHtml, newHtml)
      this.visible = true
    },
    onClose () {
      this.visible = false
    }
  }

}
</script>
<style lang="less" scoped>
.info-time-box {
  li {
    display: flex;
    padding-bottom: 0px;
    .info-time {
      display: inline-block;
    }
    .info-time-line {
      position: relative;
      margin-left: 20px;
    }
    .el-timeline-item__wrapper {
      top: -1px;
    }
    .line-detial-box {
      .icon {
        cursor: pointer;
      }
      p {
        color: #666;
        font-size: 12px;
        padding-bottom: 10px;
        span {
          font-size: 12px;
        }
      }
      .line-detial {
        display: none;
        padding: 0px 10px 0 10px;
        p {
          color: #666;
          font-size: 12px;
          padding-bottom: 10px;
          max-width: 940px;
          span {
            cursor: pointer;
          }
        }
      }
    }
    .el-timeline .el-timeline-item:last-child .el-timeline-item__tail {
      display: none;
    }
  }
  .el-timeline-item.active .line-detial {
    display: block;
  }
}
</style>
<style>
  ins {
    background-color: #cfc !important;
    text-decoration: none !important;
  }

  del {
    color: #999 !important;
    background-color: #FEC8C8 !important;
  }
</style>
