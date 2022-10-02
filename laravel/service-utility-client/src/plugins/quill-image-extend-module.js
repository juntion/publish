import { upload } from '../api/RDmanagement/project'

/**
 *@description 观察者模式 全局监听富文本编辑器
 */
export const QuillWatch = {
  watcher: {}, // 登记编辑器信息
  active: null, // 当前触发的编辑器
  on: function (imageExtendId, ImageExtend) { // 登记注册使用了ImageEXtend的编辑器
    if (!this.watcher[imageExtendId]) {
      this.watcher[imageExtendId] = ImageExtend
    }
  },
  emit: function (activeId, type = 1) { // 事件发射触发
    this.active = this.watcher[activeId]
    if (type === 1) {
      imgHandler()
    }
  }
}

/**
 * @description 图片功能拓展： 增加上传 拖动 复制
 */
export class ImageExtend {
  /**
     * @param quill {Quill}富文本实例
     * @param config {Object} options
     * config  keys: action, headers, editForm start end error  size response
     */
  constructor (quill, config = {}) {
    this.id = Math.random()
    this.quill = quill
    this.quill.id = this.id
    this.config = config
    this.file = '' // 要上传的图片
    this.imgURL = '' // 图片地址
    quill.root.addEventListener('paste', this.pasteHandle.bind(this), false)
    quill.root.addEventListener('dropover', function (e) {
      e.preventDefault()
    }, false)
    this.cursorIndex = 0
    QuillWatch.on(this.id, this)
  }

  /**
     * @description 粘贴
     * @param e
     */
  async pasteHandle (e) {
    QuillWatch.emit(this.quill.id, 0)
    let clipboardData = e.clipboardData
    let i = 0
    let items, item, types

    if (clipboardData) {
      items = clipboardData.items
      if (!items) {
        return
      }
      item = items[0]
      types = clipboardData.types || []

      for (; i < types.length; i++) {
        if (types[i] === 'Files') {
          item = items[i]
          break
        }
      }
      if (item && item.kind === 'file' && item.type.match(/^image\//i)) {
        e.preventDefault()
        this.file = item.getAsFile()
        let self = this
        // 如果图片限制大小
        if (self.config.size && self.file.size >= self.config.size * 1024 * 1024) {
          if (self.config.sizeError) {
            self.config.sizeError()
          }
        }
        await this.uploadImg()
        /* if (this.config.action) {
          this.uploadImg()
        } else {
          // this.toBase64()
        } */
      }
    }
  }

  /**
     * @description 将图片转为base4
     */
  /*  toBase64 () {
    const self = this
    const reader = new FileReader()
    reader.onload = (e) => {
      // 返回base64
      self.imgURL = e.target.result
      self.insertImg()
    }
    reader.readAsDataURL(self.file)
  } */

  /**
     * @description 上传图片到服务器
     */
  uploadImg () {
    const self = this
    let config = self.config
    // 构造表单
    let formData = new FormData()
    formData.append(config.name, self.file)
    upload(formData).then(data => {
      // success
      self.imgURL = config.response(data)
      self.insertImg()
      if (self.config.success) {
        self.config.success()
      }
    }).catch(error => {
      // error
      if (self.config.error) {
        self.config.error()
      }
      window.Bus.$message.error('图片上传失败：' + (error.response ? error.response.data.message : error.message))
    })
  }

  /**
     * @description 往富文本编辑器插入图片
     */
  insertImg () {
    const self = QuillWatch.active
    const selectionIndex = self.quill.selection.savedRange.index
    self.quill.insertEmbed(selectionIndex, 'image', self.imgURL)
    self.quill.update()
    self.quill.setSelection(selectionIndex + 1)
  }
}

/**
 * @description 点击图片上传
 */
export function imgHandler () {
  let fileInput = document.querySelector('.quill-image-input')
  if (fileInput === null) {
    fileInput = document.createElement('input')
    fileInput.setAttribute('type', 'file')
    fileInput.classList.add('quill-image-input')
    fileInput.style.display = 'none'
    // 监听选择文件
    fileInput.addEventListener('change', function () {
      let self = QuillWatch.active
      self.file = fileInput.files[0]
      fileInput.value = ''
      // 如果图片限制大小
      if (self.config.size && self.file.size >= self.config.size * 1024 * 1024) {
        if (self.config.sizeError) {
          self.config.sizeError()
        }
      }
      self.uploadImg()
      /* if (self.config.action) {
        self.uploadImg()
      } else {
        self.toBase64()
      } */
    })
    document.body.appendChild(fileInput)
  }
  fileInput.click()
}
