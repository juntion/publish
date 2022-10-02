<template>
    <div>
             <a-modal
                   :title="type===1 ?  `制定版本计划 (${info.name})` : `编辑版本计划 (${info.name})`"
                   class="modal-pms"
                   v-model="visible"
                   :confirmLoading="btnLoad"
                   @cancel="cancel"
                   @ok="ok"
                   :maskClosable="false"
                   destroyOnClose
                   width="1200px">
                    <div>
                              <a-form-model
                                :model="versionForm"
                                ref="versionForm">
                                <div class="modal-version-title">
                                    <span class="version-title-item">
                                        <span style="color:#FF4A4A">*</span> 版本号：
                                    </span>
                                    <span class="version-title-item">
                                       <span style="color:#FF4A4A">*</span> 预计发布测试时间：
                                    </span>
                                    <span class="version-title-item">
                                       <span style="color:#FF4A4A">*</span> 预计发布上线时间：
                                    </span>
                                    <a class="version-title-add" @click="addVersion" v-if="type===1">
                                        <span class="iconfont fz12">&#xe658;</span> 添加
                                    </a>
                                </div>
                                <div class="modal-version-list" v-for="(item,index) in versionForm.version_plan" :key="index">
                                    <div class="modal-version-list-item" :style="{'margin-bottom': index=== versionForm.version_plan.length-1 ? '0' : '10px'}">
                                        <div class="version-list-item-box">
                                            <span class="input-info-v">V</span>
                                            <a-form-model-item
                                            :prop="'version_plan.' + index + '.main_version'"
                                            :rules="[{ required: true, message: '请输入', trigger: 'blur' }]">
                                                <a-input-number :min="1" @blur="onChange(item,index)" :precision="0" class="input-info-before" v-model="item.main_version"/> -
                                            </a-form-model-item>
                                            <a-form-model-item
                                            :prop="'version_plan.' + index + '.second_version'"
                                            :rules="[{ required: true, message: '请输入', trigger: 'blur' }]">
                                                <a-input-number :min="0" @blur="onChange(item,index)" :precision="0"  v-model="item.second_version"/> -
                                            </a-form-model-item>
                                            <a-form-model-item
                                            :prop="'version_plan.' + index + '.third_version'"
                                            :rules="[{ required: true, message: '请输入', trigger: 'blur' }]">
                                                <a-input-number :min="0" @blur="onChange(item,index)" :precision="0" v-model="item.third_version"/>
                                            </a-form-model-item>
                                        </div>
                                        <div class="version-list-item-box">
                                            <a-form-model-item
                                            :prop="'version_plan.' + index + '.expected_release_test_time'"
                                            :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                                    <a-date-picker
                                                        style="width:253px"
                                                        @change="changeTestData($event,item)"
                                                        v-model="item.expected_release_test_time"
                                                        format="YYYY-MM-DD HH:mm:ss"
                                                        :disabled-date="disabledDate"
                                                        :disabled-time="disabledDateTime"
                                                        :show-time="{ defaultValue: moment('00:00', 'HH:mm:ss') }"
                                                        >
                                                    <span class="iconfont" slot="suffixIcon" style="font-size:12px;margin-top: -6px;">&#xe659;</span>
                                                    </a-date-picker>
                                                     <span v-if="item.expected_release_test_time" style="margin-left:10px">
                                                         {{getWeek(item.expected_release_test_time)}}
                                                        (还剩<span style="color:#F88D49"> {{item.expected_release_test_time.diff(moment().startOf('day'), 'day')}} </span>天)
                                                    </span>
                                            </a-form-model-item>

                                        </div>
                                        <div class="version-list-item-box">
                                            <a-form-model-item
                                            :prop="'version_plan.' + index + '.expected_release_online_time'"
                                            :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                                    <a-date-picker
                                                        style="width:253px"
                                                        @change="changeOnlineData($event,item)"
                                                        v-model="item.expected_release_online_time"
                                                        format="YYYY-MM-DD HH:mm:ss"
                                                        :disabled-date="disabledDate"
                                                        :disabled-time="disabledDateTime"
                                                        :show-time="{ defaultValue: moment('00:00:00', 'HH:mm:ss') }"
                                                        >
                                                         <span class="iconfont" slot="suffixIcon" style="font-size:12px;margin-top: -6px;">&#xe659;</span>
                                                    </a-date-picker>
                                                     <span v-if="item.expected_release_online_time" style="margin-left:10px">
                                                        {{getWeek(item.expected_release_online_time)}}
                                                        (还剩<span style="color:#F88D49"> {{item.expected_release_online_time.diff(moment().startOf('day'), 'day')}} </span>天)
                                                    </span>
                                            </a-form-model-item>
                                            <span @click="() => removeVersion(index)"
                                                    v-if="index > 1"
                                                    class="version-list-item-del cup"> <span class="iconfont">&#xe631;</span></span>
                                        </div>

                                      </div>
                                </div>

                              </a-form-model>
                    </div>
             </a-modal>
    </div>
</template>

<style lang="less" scoped>
    .modal-version-title{
        margin-bottom: 10px;
        position: relative;
        .version-title-item:nth-child(1){
            display: inline-block;
            width: 30%;
        }
        .version-title-item:nth-child(2){
            display: inline-block;
            width: 35%;
        }
        .version-title-item:nth-child(3){
            display: inline-block;
            width: 35%;
        }
        .version-title-add{
            position: absolute;
            right: 0;
            top: 0;
        }
    }
    .modal-version-list-item{
        margin-bottom: 10px;
        display: flex;
        .version-list-item-box:nth-child(1){
            display: flex;
            width: 30%;
            .input-info-before{
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
            .input-info-v{
                display: inline-block;
                width: 36px;
                height: 32px;
                text-align: center;
                line-height: 30px;
                border: 1px solid #ccc;
                border-right: 0;
                border-radius: 3px 0 0 3px;
            }
        }
        .version-list-item-box:nth-child(2){
            width: 35%;
        }
        .version-list-item-box:nth-child(3){
            width: 35%;
            position: relative;
            .version-list-item-del{
                position: absolute;
                right: 0;
                top: 4px;
            }
        }

    }
</style>
<script>
import { bus } from '@/plugins/bus'
import moment from 'moment'
import { addVersions, editVersions } from '@/api/RDmanagement/ProductMaintenance/edition.js'
let versionPlan = [{
  main_version: undefined,
  second_version: undefined,
  third_version: undefined,
  expected_release_test_time: undefined,
  expected_release_online_time: undefined
},
{
  main_version: undefined,
  second_version: undefined,
  third_version: undefined,
  expected_release_test_time: undefined,
  expected_release_online_time: undefined
},
{
  main_version: undefined,
  second_version: undefined,
  third_version: undefined,
  expected_release_test_time: undefined,
  expected_release_online_time: undefined
}, {
  main_version: undefined,
  second_version: undefined,
  third_version: undefined,
  expected_release_test_time: undefined,
  expected_release_online_time: undefined
}, {
  main_version: undefined,
  second_version: undefined,
  third_version: undefined,
  expected_release_test_time: undefined,
  expected_release_online_time: undefined
}]
export default {
  data () {
    return {
      visible: false,
      btnLoad: false,
      id: undefined,
      versionPlan,
      type: 1,
      range (start, end) {
        const result = []
        for (let i = start; i < end; i++) {
          result.push(i)
        }
        return result
      },
      versionForm: {
        version_plan: []
      }
    }
  },
  props: {
    info: {
      type: Object
    },
    list: {
      type: Array
    }
  },
  watch: {
    list: {
      handler (newVal) {
        this.list = newVal
      },
      deep: true
    }
  },
  mounted () {
    bus.$on('addVersionModalShow', data => {
      this.visible = true
      if (data) {
        this.type = 2
        this.id = data.id
        let data2 = JSON.parse(JSON.stringify(data))
        data2.expected_release_online_time = moment(data2.expected_release_online_time)
        data2.expected_release_test_time = moment(data2.expected_release_test_time)
        this.versionForm.version_plan = [data2]
      } else {
        this.type = 1
        let firstVersion = this.list[0]
        if (firstVersion) {
          this.versionForm.version_plan = this.versionPlan.map((item, index) => {
            item.main_version = firstVersion.main_version
            item.second_version = firstVersion.second_version + index + 1
            item.third_version = 0
            return item
          })
        } else {
          this.versionForm.version_plan = [{
            main_version: undefined,
            second_version: undefined,
            third_version: undefined,
            expected_release_test_time: undefined,
            expected_release_online_time: undefined
          },
          {
            main_version: undefined,
            second_version: undefined,
            third_version: undefined,
            expected_release_test_time: undefined,
            expected_release_online_time: undefined
          },
          {
            main_version: undefined,
            second_version: undefined,
            third_version: undefined,
            expected_release_test_time: undefined,
            expected_release_online_time: undefined
          }, {
            main_version: undefined,
            second_version: undefined,
            third_version: undefined,
            expected_release_test_time: undefined,
            expected_release_online_time: undefined
          }, {
            main_version: undefined,
            second_version: undefined,
            third_version: undefined,
            expected_release_test_time: undefined,
            expected_release_online_time: undefined
          }]
        }
      }
    })
  },
  beforeDestroy () {
    bus.$off('addVersionModalShow')
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
    onChange (e, index, k) {
      if (e.main_version && e.second_version && e.third_version) {
        let arr = this.versionForm.version_plan.map(item => {
          if (item.main_version && item.second_version && item.third_version) {
            return [item.main_version, item.second_version, item.third_version].toString()
          }
        }).filter(Boolean)
        if (new Set(arr).size !== arr.length) {
          this.$message.error('版本号不可重复')
          this.versionForm.version_plan[index].main_version = undefined
          this.versionForm.version_plan[index].second_version = undefined
          this.versionForm.version_plan[index].third_version = undefined
        }
      }
    },
    disabledDate (current) {
      return current && current < moment().endOf('day')
    },
    disabledDateTime () {
      return {
        // disabledHours: () => this.range(0, 24).splice(4, 20),
        // disabledMinutes: () => this.range(30, 60),
        // disabledSeconds: () => []
      }
    },
    changeTestData (e, item) {
      if (item.expected_release_online_time && e && e.format('YYYY-MM-DD HH:mm:ss') > item.expected_release_online_time.format('YYYY-MM-DD HH:mm:ss')) {
        item.expected_release_test_time = undefined
        this.$message.error('预计发布上线时间必须大于测试时间')
      }
    },
    changeOnlineData (e, item) {
      if (item.expected_release_test_time && e && e.format('YYYY-MM-DD HH:mm:ss') < item.expected_release_test_time.format('YYYY-MM-DD HH:mm:ss')) {
        item.expected_release_online_time = undefined
        this.$message.error('预计发布上线时间必须大于测试时间')
      }
    },
    addVersion () {
      let version = {
        main_version: undefined,
        second_version: undefined,
        third_version: undefined,
        expected_release_test_time: undefined,
        expected_release_online_time: undefined
      }
      this.versionForm.version_plan.push(version)
    },
    removeVersion (index) {
      this.versionForm.version_plan.splice(index, 1)
    },
    cancel () {
      this.$refs.versionForm.resetFields()
    },
    ok () {
      this.$refs.versionForm.validate(valid => {
        if (valid) {
          const form = JSON.parse(JSON.stringify(this.versionForm))
          form.version_plan.forEach(item => {
            item.expected_release_online_time = moment(item.expected_release_online_time).format('YYYY-MM-DD HH:mm:ss')
            item.expected_release_test_time = moment(item.expected_release_test_time).format('YYYY-MM-DD HH:mm:ss')
          })
          this.btnLoad = true
          if (this.type === 1) {
            addVersions(this.info.id, form).then(res => {
              this.visible = false
              this.btnLoad = false
              this.$message.success('添加成功')
              this.$parent.getVersionsList(this.info.id)
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else {
            editVersions(this.id, form.version_plan[0]).then(res => {
              this.visible = false
              this.btnLoad = false
              this.$message.success('编辑成功')
              this.$parent.getVersionsList(this.info.id)
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          }
        } else {
          return false
        }
      })
    }
  }
}
</script>
