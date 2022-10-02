<template>
  <div class="from">
    <a-form :form="form"
            @submit="handleSubmit">
      <div style="text-align:right;margin-bottom:16px;"
           class="header">
        <span @click="add"
              class="addPM">
          <a-icon type="plus" /> {{text}}
        </span>
      </div>
      <div style="max-height:300px;overflow:auto;">
          <div>
            <div v-for="(k, index) in form.getFieldValue('keys')"
                 :key="k"
                 class="box flex-center">

              <a-form-item :required="true"
                           class="flex-28">
                <a-input v-decorator="[
                        `params[${k}].name`,
                        {
                          validateTrigger: ['change', 'blur'],
                          rules: [
                            {
                              required: true,
                              whitespace: true,
                              message: `请填写${placeholder}名称`,
                            },
                          ],
                        },
                      ]"
                         :placeholder="`请填写${placeholder}名称`"
                         style="margin-right: 10px;" />
              </a-form-item>

              <a-form-item class="flex-70">
                <a-input v-decorator="[
              `params[${k}].description`,
              {
                validateTrigger: ['change', 'blur'],
                rules: [
                  {
                    required: true,
                    whitespace: true,
                    message: `请填写${placeholder}简介`,
                  },
                ],
              },
            ]"           :class="{nofull:form.getFieldValue('keys').length > 1}"
                         :placeholder="`请填写${placeholder}简介`"
                          />
              </a-form-item>
              <!-- <a-icon v-if="form.getFieldValue('keys').length > 1"
                      class="dynamic-delete-button"
                      type="close"
                      :disabled="form.getFieldValue('keys').length === 1"
                      @click="() => remove(k)" /> -->
              <span class="iconfont del"
                    v-if="form.getFieldValue('keys').length > 1"
                    :disabled="form.getFieldValue('keys').length === 1"
                    @click="() => remove(k)">&#xe631;</span>
            </div>
          </div>
      </div>
    </a-form>
  </div>
</template>

<script>
let id = 4
export default {
  data () {
    return {
      products: [{
        name: undefined,
        description: undefined
      }]
    }
  },
  props: {
    text: {
      type: String,
      default: '新增产品'
    },
    placeholder: {
      type: String,
      default: '产品'
    }
  },
  beforeCreate () {
    this.form = this.$form.createForm(this, { name: 'dynamic_form_item' })
    this.form.getFieldDecorator('keys', { initialValue: [0, 1, 2, 3], preserve: true })
  },
  methods: {
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
    handleSubmit (e) {
      e.preventDefault()
      this.form.validateFields((err, values) => {
        if (!err) {
        }
      })
    }

  }
}
</script>
<style lang="less" scoped>
/deep/.el-scrollbar__wrap {
    margin-right:0px !important;
}
/deep/.ant-modal-footer{
    padding-top: 20px !important;
}
/deep/ .el-scrollbar__bar{
    display: none;
}
.nofull{
    width: 450px;
}
.box {
  position: relative;
  padding-bottom: 12px;
  .ant-form-item {
    margin-bottom: 0;
  }
}
.form {
  max-height: 660px;
}
.header {
  padding-bottom: 10px;
  border-bottom: 1px solid #eeeeee;
}
.addPM {
  cursor: pointer;
  font-size: 12px;
  color:#378EEF;
}
.del {
    position: absolute;
    // margin:0 10px 0 10px;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 10px;
    top: 10px;
    right: 0;
}
.el-scrollbar__bar.is-horizontal > div {
  display: none;
  height: 100%;
}
.dynamic-delete-button {
  cursor: pointer;
  position: absolute;
  top: 5px;
  right: -5px;
  font-size: 24px;
  color: #999;
  transition: all 0.3s;
}

.dynamic-delete-button:hover {
  color: #777;
}
.dynamic-delete-button[disabled] {
  cursor: not-allowed;
  opacity: 0.5;
}
.flex-center{
    display: flex;
    justify-content: space-between;
}
.flex-28{
    display: inline-block;width: 28.5%;margin-right: 10px;
}
.flex-70{
    display: inline-block;width: 70%;
}
</style>
