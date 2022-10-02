<template>
  <div class="from">
    <a-form :form="form"
            v-if="show">
      <div style="text-align:right;margin-bottom:10px;">
        <span @click="add"
              class="addPM">
          <a-icon type="plus" /> 创建子任务
        </span>
      </div>
      <div style="max-height:312px;overflow-y:auto;">
          <div v-for="(k) in form.getFieldValue('keys')"
               :key="k"
               class="box">
            <a-form-item style="display:inline-block;width:33%;margin-right: 10px;">
              <a-select placeholder="优先级"
                        v-decorator="[
                          `params[${k}].priority`,
                          {
                            rules: [
                              {
                                required: true,
                                type: 'number',
                                message: '请选择优先级',
                              },
                            ],
                          },
                        ]"
                        >
                <a-select-option :value="1"><span class="button_box_text"> 1</span><span class="after" style="color:#FF4A4A;float:right">高</span></a-select-option>
                <a-select-option :value="2"><span class="button_box_text button_box_color2"> 2</span></a-select-option>
                <a-select-option :value="3"><span class="button_box_text button_box_color3"> 3</span></a-select-option>
                <a-select-option :value="4"><span class="button_box_text button_box_color4"> 4</span></a-select-option>
                <a-select-option :value="5"><span class="button_box_text button_box_color5"> 5</span><span class="after" style="color:#BBBBBB;float:right">低</span></a-select-option>
              </a-select>
            </a-form-item>

            <a-form-item style="display:inline-block;width:33%;margin-right: 10px;">
              <a-select placeholder="处理人"
                        showSearch
                        optionFilterProp="children"
                        v-decorator="[
                          `params[${k}].user_id`,
                          {
                            validateTrigger: ['change', 'blur'],
                            rules: [
                              {
                                required: true,
                                type: 'number',
                                message: '请选择处理人',
                              },
                            ],
                          },
                        ]"
                        >
                <a-select-option v-for="item in options"
                                 :key="item.id">{{item.name}}</a-select-option>
              </a-select>
            </a-form-item>
            <a-form-item style="display:inline-block;width:31.1%"
                        :style="{width: form.getFieldValue('keys').length > 1 ? '28.8%' : '31.1%'}"
            >
                <!-- :style="{width: form.getFieldValue('keys').length > 1 ? '214px' : '238px'}" -->
              <a-date-picker style="width:100%"
                             :disabledDate="disabledDate"
                             v-decorator="[
                          `params[${k}].expiration_date`,
                          {
                            rules: [
                              {
                                type: 'object',
                                required: true,
                                message: '请选择时间',
                              },
                            ],
                          },
                        ]" />
            </a-form-item>
             <a-form-item style="margin-top:10px">
              <a-textarea placeholder="请输入子任务描述"
                       v-decorator="[
                          `params[${k}].description`,
                          {
                            validateTrigger: ['change', 'blur'],
                            rules: [
                              {
                                required: true,
                                whitespace: true,
                                message: '请输入任务描述',
                              },
                            ],
                          },
                        ]"
                        :style="{width: form.getFieldValue('keys').length > 1 ? '97.5%' : '100%'}"
                       style="height:80px" />
            </a-form-item>
            <span class="iconfont dynamic-delete-button" v-if="form.getFieldValue('keys').length > 1"
                    @click="remove(k)">&#xe631;</span>
          </div>
      </div>
      <div style="width:100%;text-align: right;margin-bottom: 20px">
           <a-button type="primary"
                    :loading="btnLoad"
                  @click="post">确定</a-button>
      </div>

    </a-form>
  </div>
</template>

<script>

import { testTaskHandler, designTaskHandler, devTaskHandler } from '@/api/RDmanagement/dropDown'
import { postSubtasksDev } from '@/api/RDmanagement/task/dev'
import { postSubtasksTest } from '@/api/RDmanagement/task/test'
import { postSubtasksDesign } from '@/api/RDmanagement/task/design'
import moment from 'moment'
let id = 2
export default {
  data () {
    return {
      options: [],
      show: true,
      btnLoad: false,
      formItemLayout: {
        labelCol: {
          xs: { span: 24 },
          sm: { span: 4 }
        },
        wrapperCol: {
          xs: { span: 24 },
          sm: { span: 20 }
        }
      },
      formItemLayoutWithOutLabel: {
        wrapperCol: {
          xs: { span: 24, offset: 0 },
          sm: { span: 20, offset: 4 }
        }
      }
    }
  },
  props: {
    id: {
      type: Number
    },
    postType: {
      type: Number
    }
  },
  mounted () {
    if (this.postType === 1) {
      devTaskHandler().then(res => {
        if (res.code === 200) {
          this.options = res.data.users
        }
      })
    } else if (this.postType === 2) {
      testTaskHandler().then(res => {
        if (res.code === 200) {
          this.options = res.data.users
        }
      })
    } else if (this.postType === 3) {
      designTaskHandler().then(res => {
        if (res.code === 200) {
          this.options = res.data.users
        }
      })
    }
  },
  beforeCreate () {
    this.form = this.$form.createForm(this, { name: 'dynamic_form_item' })
    this.form.getFieldDecorator('keys', { initialValue: [0, 1], preserve: true })
  },
  methods: {
    moment,
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment().startOf('day')
    },
    remove (k) {
      const { form } = this
      const keys = form.getFieldValue('keys')
      if (keys.length === 1) {
        return
      }
      form.setFieldsValue({
        keys: keys.filter(key => key !== k)
      })
    },
    add () {
      const { form } = this
      const keys = form.getFieldValue('keys')
      const nextKeys = keys.concat(id++)
      form.setFieldsValue({
        keys: nextKeys
      })
    },
    getChargeValue (e, k) {

    },
    post () {
      this.form.validateFields((err, values) => {
        if (!err) {
          values.params.map(item => {
            item.expiration_date = item['expiration_date'].format('YYYY-MM-DD')
            return { ...item }
          })
          let params = values.params.filter(d => d)
          if (this.postType === 1) {
            this.btnLoad = true
            postSubtasksDev(this.id, params).then(res => {
              if (res.code === 200) {
                this.$message.success('创建子任务成功')
                this.btnLoad = false
                this.form.resetFields()
                this.$emit('change', params)
              }
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else if (this.postType === 2) {
            this.btnLoad = true
            postSubtasksTest(this.id, params).then(res => {
              if (res.code === 200) {
                this.$message.success('创建子任务成功')
                this.btnLoad = false
                this.form.resetFields()
                this.$emit('change', params)
              }
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else if (this.postType === 3) {
            this.btnLoad = true
            postSubtasksDesign(this.id, params).then(res => {
              if (res.code === 200) {
                this.$message.success('创建子任务成功')
                this.btnLoad = false
                this.form.resetFields()
                this.$emit('change', params)
              }
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
<style lang="less" scoped>
.box {
  position: relative;
  margin-bottom: 10px;
  background-color: #F7F7F7;
  padding: 10px;
  .ant-form-item {
    margin-bottom: 0;
  }
}
.form {
  max-height: 660px;
}
.addPM {
  cursor: pointer;
  font-size: 12px;
  color:#378EEF;
}
.dynamic-delete-button {
  cursor: pointer;
  position: absolute;
  top: 8px;
  right: 10px;
  font-size: 12px;
  color: #bbbbbb;
  transition: all 0.3s;
}
.dynamic-delete-button:hover {
  color: #777;
}
.dynamic-delete-button[disabled] {
  cursor: not-allowed;
  opacity: 0.5;
}
</style>
