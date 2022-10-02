<template>
<div class="components-select-group">
  <a-select  show-search showArrow  v-model="versionId" :mode="mode" placeholder="请选择" style="width: 100%" @change="handleChange">
    <a-select-opt-group v-for="(item,index) in data" :key="index" >
      <span slot="label">
          <a-popover placement="bottom">
            <template slot="content" >
                <div class="pms-publishing-info">
                    <h3>产品详情</h3>
                    <div class="details">
                            <div class="marginB10">
                                <span class="left-details">发版产品名称:</span>
                                <span class="right-details">{{item.name}}</span>
                            </div>
                            <div class="marginB10">
                                <span class="left-details">状态:</span>
                                <span class="right-details" :style="{color: item.status ? '#3dcca6' : '#ff4a4a'}">{{item.status_desc}}</span>
                            </div>
                            <div class="marginB10">
                                <span class="left-details">管理员:</span>
                                <span class="right-details">
                                    <span v-for="(k,index) in item.admins" :key="index">
                                        {{k.user_name}}
                                        <span v-if="index !== item.admins.length-1">;</span>
                                    </span>
                                </span>
                            </div>
                            <div class="marginB10">
                                <span class="left-details">发版周期:</span>
                                <span class="right-details">{{item.release_cycle}}</span>
                            </div>
                            <div class="marginB10">
                                <span class="left-details">关联产品(线):</span>
                                <span class="right-details">
                                    <span v-for="(k,index) in item.friendly_products" :key="index">
                                        {{k.name}}
                                        <span v-if="index !== item.friendly_products.length-1">;</span>
                                    </span>
                                </span>
                            </div>
                            <div class="marginB10">
                                <span class="left-details">正式站地址:</span>
                                <span class="right-details">
                                    <a
                                     style="display: block;"
                                     :style="{'padding-bottom': index !== item.online_address.length-1 ?  '10px' : '0px'}"
                                     v-for="(link,index) in item.online_address"
                                     :key="index"
                                     :href="link"
                                     target="_blank">{{link}}</a>
                                     <span v-if="item.online_address.length===0"> -- </span>
                                 </span>
                            </div>
                            <div class="marginB10">
                                <span class="left-details">测试站地址:</span>
                                <span class="right-details">
                                    <a
                                     style="display: block;"
                                     :style="{'padding-bottom': index !== item.online_address.length-1 ?  '10px' : '0px'}"
                                     v-for="(link,index) in item.testing_address"
                                     :key="index"
                                     :href="link"
                                     target="_blank">{{link}}</a>
                                    <span v-if="item.testing_address.length===0"> -- </span>
                                </span>
                            </div>
                            <div class="marginB10">
                                <span class="left-details">简介:</span>
                                <span class="right-details">{{item.description ? item.description : '--'}}</span>

                            </div>
                            <div class="marginB10">
                                <span class="left-details">创建人:</span>
                                <span class="right-details">{{item.creator_name}} {{item.created_at}}</span>
                            </div>
                            <div class="marginB10" style="margin-bottom:0">
                                <span class="left-details">更新人:</span>
                                <span class="right-details">{{item.updater_name}} {{item.updated_at}}</span>
                            </div>
                        </div>
                </div>
            </template>
            <span class="cup">{{item.name}}</span>
        </a-popover>
      </span>
      <a-select-option :value="item2.id" v-for="(item2,index2) in item.versions" :key="index2" :disabled="item2.disabled">
        <a-popover placement="bottom" >
            <template slot="content">
                <div class="pms-publishing-info">
                     <h3>版本信息</h3>
                     <div class="details version-details">
                            <div class="marginB10">
                                <span class="left-details">版本号:</span>
                                <span class="right-details">{{item2.full_version}}</span>
                            </div>
                            <div class="marginB10">
                                <span class="left-details">状态:</span>
                                <span class="right-details" :style="{color:item2.status ===2 ? '#FEBC2E': '#666'}">{{item2.status_desc}}</span>
                            </div>
                            <div class="marginB10">
                                <span class="left-details">创建人:</span>
                                <span class="right-details">{{item2.creator_name}}</span>
                            </div>
                            <div class="marginB10">
                                <span class="left-details">预计发布测试时间:</span>
                                <span class="right-details">{{item2.expected_release_test_time}}（{{getWeek(item2.expected_release_test_time)}}）</span>
                            </div>
                             <div class="marginB10">
                                <span class="left-details">实际发布测试:</span>
                                <span class="right-details">
                                    <span v-if="item2.release_test_time">
                                        {{item2.release_test_time}}（{{getWeek(item2.release_test_time)}}）
                                        <p>{{item2.release_test_comment}}</p>
                                    </span>
                                    <span v-else> -- </span>
                                </span>
                            </div>
                            <div class="marginB10">
                                <span class="left-details">预计发布上线时间:</span>
                                <span class="right-details">{{item2.expected_release_online_time}}（{{getWeek(item2.expected_release_online_time)}}）</span>
                            </div>
                            <div class="marginB10">
                                <span class="left-details">实际发布上线:</span>
                                <span class="right-details">
                                    <span v-if="item2.release_online_time">
                                        {{item2.release_online_time}}（{{getWeek(item2.release_online_time)}}）
                                        <p>{{item2.release_online_comment}}</p>
                                    </span>
                                     <span v-else> -- </span>
                                </span>
                            </div>
                            <div class="marginB10" style="margin-bottom:0">
                                <span class="left-details">功能统计:</span>
                                <span class="right-details">共{{item2.feature_count}}个</span>
                            </div>
                        </div>
                </div>
            </template>
            <span class="cup">{{item2.product_name_full_version}}
                <span class="version-status">({{item2.status_desc}})</span>
            </span>
        </a-popover>
      </a-select-option>
    </a-select-opt-group>
  </a-select>
  </div>
</template>

<style lang="less" scoped>
    /deep/.ant-select-selection__choice__content,.ant-select-selection-selected-value{
        .version-status{
            display: none;
        }
    }
</style>
<script>
import { getProductAndVersion } from '@/api/RDmanagement/ProductMaintenance/edition.js'
import moment from 'moment'
export default {
  data () {
    return {
      disabled: false,
      data: [],
      versionId: [],
      choosedInfo: {}
    }
  },
  props: {
    value: {
      type: [Array, Number]
    },
    mode: {
      type: String,
      default: 'multiple'
    },
    productId: {
      type: Number
    }
  },
  watch: {

    value (newVal, oldVal) {
      this.versionId = newVal
      setTimeout(() => {
        this.handleChange(newVal, 1)
      }, 1000)
    },
    productId (newVal) {
      getProductAndVersion({ product_id: this.productId }).then(res => {
        this.data = res.data
      })
    }
  },
  mounted () {
    getProductAndVersion().then(res => {
      this.data = res.data
    })
  },
  methods: {
    moment,
    getWeek (date) { // 参数时间戳
      let week = moment(date).day()
      switch (week) {
        case 1:
          return '星期一'
        case 2:
          return '星期二'
        case 3:
          return '星期三'
        case 4:
          return '星期四'
        case 5:
          return '星期五'
        case 6:
          return '星期六'
        case 0:
          return '星期日'
      }
    },
    handleChange (value, index) {
      this.$emit('input', this.versionId)
      if (this.mode === 'multiple') {
        let products = []
        this.data = this.data.map(item => {
        // 通过选中的版本id获取其发版产品id
          item.versions.forEach(item2 => {
            if (value.indexOf(item2.id) !== -1) {
              if (item2.status === 2 && index !== 1) {
                let day = moment(item2.expected_release_online_time).diff(moment().startOf('day'), 'day')
                this.$message.warning(`所选版本已发布至测试站，预计还剩${day}天，将发布正式站上线，请注意评估研发进度!`)
              }
              products.push(item2.release_product_id)
            }
          })
          // 判断同一发版产品内的版本只能选择一个
          if (products.indexOf(item.id) !== -1) {
            item.versions.forEach(item2 => {
              if (value.indexOf(item2.id) === -1) {
                item2.disabled = true
              } else {
                item2.disabled = false
              }
            })
          } else {
            item.versions.forEach(item2 => {
              item2.disabled = false
            })
          }
          return item
        })
      } else {
        this.data.forEach(item => {
          item.versions.forEach(item2 => {
            if (item2.id === value) {
              if (item2.status === 2 && index !== 1) {
                let day = moment(item2.expected_release_online_time).diff(moment().startOf('day'), 'day')
                this.$message.warning(`所选版本已发布至测试站，预计还剩${day}天，将发布正式站上线，请注意评估研发进度!`)
              }
              this.choosedInfo = item2
              this.$emit('change', this.choosedInfo)
            }
          })
        })
      }
    }

  }
}
</script>
