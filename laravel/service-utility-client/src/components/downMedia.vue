<template>
  <div>
    <div class="showFile">

      <div class="fileList">
        <a-checkbox-group style="width:100%"
                          @change="onChange"
                          v-model="checkedList">
          <a-row>
            <a-col :span="span"
                   v-for="(k,index) in media"
                   :key="index">
              <a-checkbox :value="index">
                <div class="txt">
                  <span class="iconfont icon">&#xe655;</span><a style="word-break: break-all;" @click.stop.prevent="downLoad(k)">{{k.name}}</a><span class="size"> ({{parseInt(k.size/1024)}}kb)</span>
                  <p>{{k.user_name}} {{k.created_at}}</p>
                </div>
              </a-checkbox>
            </a-col>
          </a-row>
        </a-checkbox-group>
      </div>
      <div class="flieAction">
        <a-checkbox :indeterminate="indeterminate"
                    :checked="checkAll"
                    @change="onCheckAllChange"> 全选</a-checkbox><a @click="downloadMore"><span class="iconfont downLoad" style="font-size: 12px;">&#xe63f;</span>批量下载</a>
      </div>
    </div>
  </div>
</template>

<script>
import { download } from '@/api/RDmanagement/product'
import qs from 'qs'
export default {
  data () {
    return {
      checkedList: [],
      indeterminate: false,
      checkAll: false,
      visible: false,
      url: ''
    }
  },
  props: {
    media: {
      type: Array
    },
    span: {
      type: Number,
      default: 8
    }
  },
  watch: {
    media (newVal, oldVal) {

    }
  },
  methods: {
    onCheckAllChange (e) {
      let all = []
      this.media.forEach((item, index) => {
        all.push(index)
      })
      Object.assign(this, {
        checkedList: e.target.checked ? all : [],
        indeterminate: false,
        checkAll: e.target.checked
      })
    },
    onChange (checkedList) {
      let all = []
      this.media.forEach((item, index) => {
        all.push(index)
      })
      this.indeterminate = !!checkedList.length && checkedList.length < all.length
      this.checkAll = checkedList.length === all.length
    },
    // 批量下载
    downloadMore () {
      let params = { media: [] }
      this.checkedList.forEach(item => {
        let a = { id: this.media[item].id, file_name: this.media[item].file_name }
        params.media.push(a)
      })
      if (params.media.length > 0) {
        params = qs.stringify(params)
        download(params)
      } else {
        this.$message.error('请选择文件')
      }
    },
    downLoad (k) {
      let params = { media: [{ id: k.id, file_name: k.file_name }] }
      params = qs.stringify(params)
      if (k.mime_type.indexOf('image') !== -1) {
        // 预览
        window.open(k.url, '_blank')
      } else if (k.mime_type.indexOf('video') !== -1) {
        window.open(k.url, '_blank')
      } else {
        download(params)
      }
    },
    handleCancel () {
      this.visible = false
    }
  }
}
</script>
<style lang="less" scoped>
.ant-col-8{
    height: 50px !important;
}
/deep/.ant-checkbox + span{
    padding-left: 0;
    font-size: 12px;
}
.showFile {
  padding: 20px;
  padding-top: 30px;
  padding-bottom: 10px;
  width: 100%;
  // height: 201px;
  background: rgba(248, 248, 248, 1);
  border-radius: 3px;
  .fileList {
    display: flex;
    flex-wrap: wrap;
    .icon {
      color: #fdb824;
      font-size: 12px;
      margin-right: 4px;
    }
    .size {
      color: #c8c5c8;
    }
    .txt {
      position: relative;
      top: -30px;
      left: 28px;
      a{
            vertical-align: bottom;
            display: inline-block;
            max-width: 260px;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
      }
    }
  }
  .fileDown {
    line-height: 1;
    width: 33.3%;
    height: 30px;
    margin-bottom: 20px;
  }
  .flieAction {
    margin-top: -20px;
    position: relative;
    bottom: 0;
    // border-top: 1px solid #EEEEEE;
    border: 0;
    height: 34px;
    line-height: 34px;
    a {
      margin-left: 12px;
        span{
            margin-right:4px;
        }
    }
  }
}
</style>
