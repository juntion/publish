<template>
    <div>
        <el-form :model="dynamicValidateForm" ref="dynamicValidateForm" label-width="100px" class="demo-dynamic">

        <el-form-item
            v-for="(domain, index) in dynamicValidateForm.domains"
            :label="'Url' + index"
            :key="domain.key"
            :prop="'domains.' + index + '.value'"
            :rules="{
            required: true, message: 'url不能为空', trigger: 'blur'
            }"
        >
            <el-input v-model="domain.value"></el-input><el-button @click.prevent="removeDomain(domain)">删除</el-button>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" @click="submitForm('dynamicValidateForm')">提交</el-button>
            <el-button @click="addDomain">添加</el-button>
        </el-form-item>
        </el-form>
    </div>
</template>
<script>
import { log } from 'util'
export default {
  data () {
    return {
      dynamicValidateForm: {
        domains: [{
          value: ''
        }]

      }
    }
  },
  methods: {
    submitForm (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          alert('submit!')
        } else {
          return false
        }
      })
    },
    removeDomain (item) {
      var index = this.dynamicValidateForm.domains.indexOf(item)
      if (index !== -1) {
        this.dynamicValidateForm.domains.splice(index, 1)
      }
    },
    addDomain () {
      this.dynamicValidateForm.domains.push({
        value: ''
        // key: Date.now()
      })
    }
  }
}
</script>
