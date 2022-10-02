<template>
  <div>
    <div class="showFile">
      <!-- <a-modal :visible="visible"
               :closable="false"
               :footer="null"
               @cancel="handleCancel">
        <img style="width: 100%;"
             id="img" :src="url"/>
      </a-modal> -->
      <div class="fileList">
        <a-checkbox-group style="width:100%"
                          @change="onChange"
                          v-model="checkedList">
          <a-row v-for="(k,index) in media"
                 :key="index"
                 style=" margin-bottom: 10px;">
            <a-checkbox :value="index">
              <span class="iconfont icon">&#xe655;</span><a style="word-break: break-all;" @click.stop.prevent="downLoad(k)">{{k.name}}</a>
            </a-checkbox>
          </a-row>
        </a-checkbox-group>
      </div>
      <div class="flieAction">
        <a-checkbox :indeterminate="indeterminate"
                    :checked="checkAll"
                    @change="onCheckAllChange"><span class="quanxuan">全选</span></a-checkbox><a @click="downloadMore"><span class="iconfont downLoad" style="font-size:12px">&#xe63f;</span>批量下载</a>
      </div>
    </div>
  </div>
</template>

<script>
import qs from 'qs'
import { download } from '@/api/RDmanagement/product'
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
    }
  }
}
</script>
<style lang="less" scoped>

.showFile {
  // padding: 20px;

  width: 100%;
  // height: 201px;
  border-radius: 3px;
  .fileList {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 20px;
    .icon {
      color: #fdb824;
      font-size: 12px;
      margin-right: 4px;
    }
  }
  .fileDown {
    line-height: 1;
    width: 33.3%;
    height: 30px;
    margin-bottom: 20px;
  }
  .flieAction {
    position: relative;
    bottom: 0;
    height: 34px;
    line-height: 34px;
    .quanxuan{
        display: inline-block;
        margin-left:-4px;
        margin-right:-8px;
        font-size: 12px;
    }
    a {
      margin-left: 20px;
    }
  }
}
</style>
