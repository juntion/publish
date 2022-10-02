<template>
  <div>
    <div class="addTag">
      <a-tag @click="showInput"
             v-if="canDo('pm.products.labels')"
             style="background: #fff">
        <a-icon type="plus" />添加标签
      </a-tag>
    </div>
    <div class="tagBox">
        <span style="margin-right:6px"
              v-if="inputVisible">
          <a-input ref="input"
                   type="text"
                   size="small"
                   :style="{ width: '78px' ,height:'20px'}"
                   v-model="inputValue"
                   @blur="handleInputConfirm"
                   @keyup.enter="handleInputConfirm" />
        </span>
        <template v-for="(tag, index) in tags">
          <a-tag :key="index"
                 :closable="canDo('pm.products.deleteLabel')"
                 @close="showModal($event,tag)"
                 color="blue">
            <span @dblclick="editName(tag.id,tag.name)"
                  :ref="'name'+tag.id">
              {{tag.name}}
            </span>
            <span :ref="'editInput'+tag.id"
                  :class="{active:showEdit}">
              <a-input type="text"
                       size="small"
                       :ref="'input'+tag.id"
                       :style="{ width: '120px' ,height:'100%'}"
                       v-model="editname"
                       @blur="editTag(tag.id,tag)"
                       @pressEnter="editTag(tag.id,tag)" />
            </span>
          </a-tag>
        </template>

    </div>

  </div>
</template>
<script>
import { canDo } from '@/plugins/common'
import { addModuleTag, editTagName, delTags, getProducts } from '@/api/RDmanagement/ProductMaintenance/index.js'
export default {
  data () {
    return {
      tags: this.label,
      inputVisible: false,
      inputValue: '',
      showEdit: true,
      editname: '',
      removeTag: {}
    }
  },
  watch: {
    label (newVal) {
      this.tags = newVal
    },
    tags: function (newVal, oldVal) {
      // this.tags = newVal
    },
    tagId: function (newVal) {
      this.tagId = newVal
    }
  },
  props: {
    label: { type: Array },
    tagId: { type: Number },
    fn: { type: Function }
  },
  created () {
  },
  methods: {
    canDo,
    getTags (id) {
      getProducts(id).then(res => {
        this.tags = res.data.products
      })
    },
    editTag (id, k) {
      let editInput = 'editInput' + id
      let name = 'name' + id
      if (this.editname !== k.name) {
        k.name = this.editname
        editTagName(id, this.editname).then(res => {
          if (res.code === 200) {
            this.getTags(this.tagId)
            this.fn()
            this.$message.success('修改成功')
          }
        })
      }
      this.$refs[editInput][0].className = 'active'
      this.$refs[name][0].className = ''
    },
    editName (id, k) {
      if (this.canDo('pm.products.labelName')) {
        let editInput = 'editInput' + id
        let input = 'input' + id
        let name = 'name' + id
        this.editname = k
        this.$refs[editInput][0].className = ''
        this.$refs[name][0].className = 'active'
        this.$nextTick(function () {
          this.$refs[input][0].focus()
        })
      }
    },
    showModal (e, k) {
      e.preventDefault()
      this.removeTag = k
      this.handleClose(this.removeTag)
    },
    //   删除标签
    handleClose (removedTag) {
      delTags(removedTag.id).then(res => {
        if (res.code === 200) {
          this.getTags(this.tagId)
          this.fn()
          this.$message.success('删除标签成功')
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    showInput () {
      this.inputVisible = true
      this.$nextTick(function () {
        this.$refs.input.focus()
      })
    },
    // 添加标签
    handleInputConfirm () {
      const inputValue = this.inputValue
      let tags = this.tags
      if (inputValue && tags.indexOf(inputValue) === -1) {
        tags = [{ name: inputValue }, ...tags]
        addModuleTag(this.tagId, inputValue).then(res => {
          if (res.code === 200) {
            this.getTags(this.tagId)
            this.fn()
            this.$message.success('添加标签成功')
          }
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }

      Object.assign(this, {
        tags,
        inputVisible: false,
        inputValue: ''
      })
    }
  }
}
</script>
<style lang="less" scoped>
.tagBox {
    padding:20px 0 14px 0;
}
.active {
  display: none;
}
.addTag {
  text-align: right;
    padding-bottom: 4px;
    border-bottom: 1px solid #eee;
}
.addTag /deep/ .ant-tag{
color:#378EEF;
    border: none;
    margin-right: 0;
    padding-right: 0;
}
/deep/.ant-tag-blue {
  margin-bottom: 6px;
    height:30px;
    line-height: 28px;
    color:#26A3E0;
    background:rgba(38,163,224,0.2);
    border-radius:4px;
    border:none;
}
/deep/ .ant-tag .anticon-close{
    color:#26A3E0;
}
 /deep/ .ant-modal-footer{
    display: none;
    }
</style>
