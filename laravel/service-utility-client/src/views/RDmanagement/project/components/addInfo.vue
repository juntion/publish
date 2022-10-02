<template>
  <div class="from">
    <a-form :form="form">
      <div style="text-align:right;margin-bottom:10px;">
          <span  @click="add" class="addPM">
              <a-icon type="plus" /> 添加
          </span>
      </div>
      <div  v-for="(k,index) in form.getFieldValue('keys')" class="box"
        :key="index">

      <a-form-item  :required="true" style="display:inline-block">
        <a-input
          v-decorator="[
            `names1[${index}]`,
            {
              validateTrigger: ['change', 'blur'],
              rules: [
                {
                  required: true,
                  whitespace: true,
                  message: '请填写产品名称',
                },
              ],
            },
          ]"
          placeholder="请填写产品名称"
          style="width: 220px; margin-right: 8px"
        />
      </a-form-item>
        <a-icon
          v-if="form.getFieldValue('keys').length > 1"
          class="dynamic-delete-button"
          type="close"
          :disabled="form.getFieldValue('keys').length === 1"
          @click="() => remove(k)"
        />
      </div>
    </a-form>
    </div>
</template>

<script>
let id = 1
export default {
  data () {
    return {
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
  beforeCreate () {
    this.form = this.$form.createForm(this, { name: 'dynamic_form_item' })
    this.form.getFieldDecorator('keys', { initialValue: [{ a1: 'aaa' }, { a2: 'bbb' }], preserve: true })
  },
  methods: {
    remove (k) {
      const { form } = this
      // can use data-binding to get
      const keys = form.getFieldValue('keys')
      // We need at least one passenger
      if (keys.length === 1) {
        return
      }
      // can use data-binding to set
      form.setFieldsValue({
        keys: keys.filter(key => key !== k)
      })
    },

    add () {
      const { form } = this
      // can use data-binding to get
      const keys = form.getFieldValue('keys')
      const nextKeys = keys.concat(id++)
      // can use data-binding to set
      // important! notify form to detect changes
      form.setFieldsValue({
        keys: nextKeys
      })
      // console.log(this.form.getFieldValue('keys'));
    }

  }
}
</script>
<style>
.box{
  position: relative;
  padding-bottom: 21px;
}
.form{
    max-height: 660px;
}
.addPM{
    cursor: pointer;
    font-size:12px;
    color:rgba(71,120,199,1);
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
</style>
