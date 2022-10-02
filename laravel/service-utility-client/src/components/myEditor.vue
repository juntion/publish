<template>
    <div>
        <quill-editor v-model="contents"
                      ref="myQuillEditor"
                      :options="editorOption"
                      @change="onEditorChange">
        </quill-editor>
    </div>
</template>
<script>
import { quillEditor, Quill } from 'vue-quill-editor'
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import { ImageExtend, QuillWatch } from '../plugins/quill-image-extend-module'
import ImageResize from 'quill-image-resize-module'
Quill.register('modules/ImageResize', ImageResize)
Quill.register('modules/ImageExtend', ImageExtend)

const toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'], // toggled buttons
  [{ header: 1 }, { header: 2 }], // custom button values
  [{ list: 'ordered' }, { list: 'bullet' }],
  [{ indent: '-1' }, { indent: '+1' }], // outdent/indent
  [{ direction: 'rtl' }], // text direction
  [{ size: ['small', false, 'large', 'huge'] }], // custom dropdown
  [{ header: [1, 2, 3, 4, 5, 6, false] }],
  [{ color: [] }, { background: [] }], // dropdown with defaults from theme
  [{ font: [] }],
  [{ align: [] }],
  ['link', 'image'],
  ['clean']
]

export default {
  components: { quillEditor },
  computed: {
    randomId () {
      var Num = ''
      for (var i = 0; i < 6; i++) {
        Num += Math.floor(Math.random() * 10)
      }
      return Num
    }
  },
  data () {
    return {
      contents: this.value,
      editorOption: {
        modules: {
          ImageExtend: {
            name: 'image',
            response: (res) => {
              return res.data.image_url
            }
          },
          ImageResize: { // 添加
            displayStyles: { // 添加
              backgroundColor: 'black',
              border: 'none',
              color: 'white'
            },
            modules: ['Resize', 'DisplaySize', 'Toolbar'] // 添加
          },
          toolbar: {
            container: toolbarOptions,
            handlers: {
              image: function (value) {
                QuillWatch.emit(this.quill.id)
              }
            }
          }
        },
        placeholder: this.placeholder // 提示
      }
    }
  },
  watch: {
    value (newVal, oldVal) {
      this.contents = newVal
    }
  },
  props: {
    value: {
      type: String
    },
    placeholder: {
      type: String,
      default: '请输入项目描述'
    }
  },
  methods: {
    onEditorChange () {
      this.$emit('input', this.contents)
    }
  }
}
</script>
<style lang="less" scoped>
    /deep/.ql-editor.ql-blank::before{
    font-style: normal !important;
    }
    /deep/.ql-editor {
        height: 300px !important;

    }
    /deep/.ql-snow .ql-picker-label::before {
        position: relative;
        top: -8px;
    }
    /deep/.ql-snow .ql-color-picker .ql-picker-label svg {
        margin-bottom: 7px;
    }
    /deep/.ql-snow .ql-icon-picker .ql-picker-label svg {
        margin-bottom: 7px;
    }
</style>
