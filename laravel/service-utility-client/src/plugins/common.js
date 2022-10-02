import _ from 'lodash'

export const formatDataTree = (params) => {
  let res = []
  params.forEach(function (item) {
    let data = {}
    data.title = item.name
    data.key = item.id.toString()
    data.comment = item.comment
    data.locale = item.locale
    data.type = item.icon
    data.parent_id = item.parent_id
    data.children = []
    if (item.children.length > 0) {
      data.children = formatDataTree(item.children)
    }
    if (item.pages.length > 0) {
      item.pages.forEach(function (i) {
        let page = {}
        page.title = i.name
        page.locale = i.locale
        page.key = i.route_name
        page.isLeaf = true
        page.cate_id = item.id
        page.page_id = i.id
        data.children.push(page)
      })
    }
    res.push(data)
  })
  return res
}

/*
 * 系统默认的icon
 * */
export const defaultIcons = [
  'home', 'bars', 'lock', 'user', 'star', 'dashboard', 'table', 'cluster', 'setting', 'folder', 'idcard'
]

// 高级筛选的数据处理
export const filtering = (e, may, must) => {
  if (e.andOr === 'and') {
    e.form.forEach(item => {
      if (item.condition) {
        if (item.condition === 'created_at' || item.condition === 'finishTime' || item.condition === 'finish_time' || item.condition === 'verify_time') {
          must[item.condition + ',between'] = item.value[0] + ',' + item.value[1]
        } else if (item.condition === 'attentionAble.user_id') {
          if (item.value.indexOf(',') !== -1) {
            must[item.condition + ',inList'] = item.value
          } else {
            must[item.condition + ',' + item.judge] = item.value
          }
        } else {
          if (must[item.condition + ',' + item.judge]) {
            must[item.condition + ',' + item.judge] = must[item.condition + ',' + item.judge] + ',' + item.value
            must[item.condition + ',inList'] = must[item.condition + ',' + item.judge]
            delete must[item.condition + ',' + item.judge]
          } else {
            must[item.condition + ',' + item.judge] = item.value
          }
        }
      }
    })
  } else {
    e.form.forEach((item, index) => {
      if (item.condition) {
        if (item.condition === 'created_at' || item.condition === 'finishTime' || item.condition === 'finish_time' || item.condition === 'verify_time') {
          may[item.condition + ',between'] = item.value[0] + ',' + item.value[1]
        } else if (item.condition === 'attentionAble.user_id') {
          if (item.value.indexOf(',') !== -1) {
            may[item.condition + ',inList'] = item.value
          } else {
            may[item.condition + ',' + item.judge] = item.value
          }
        } else {
          if (may[item.condition + ',' + item.judge]) {
            may[item.condition + ',' + item.judge] = may[item.condition + ',' + item.judge] + ',' + item.value
            may[item.condition + ',inList'] = may[item.condition + ',' + item.judge]
            delete may[item.condition + ',' + item.judge]
          } else {
            may[item.condition + ',' + item.judge] = item.value
          }
        }
      }
    })
  }
}

// formData格式转换
export const objToFd = (obj, form, name) => {
  const fd = form || new FormData()
  if (typeof obj !== 'object' || obj instanceof File) {
    fd.append(name, obj)
    return fd
  }
  const keyName = name || ''
  for (const prop in obj) {
    // 判断是自己的属性 且不为空
    if (prop != null && obj.hasOwnProperty(prop) && obj[prop] != null && obj[prop] !== '') {
      const val = obj[prop]
      if (val instanceof Array) {
        // 如果是数组
        val.map((item, index) => {
          if (keyName) {
            objToFd(item, fd, keyName + '[' + prop + ']' + '[' + index + ']')
          } else {
            objToFd(item, fd, prop + '[' + index + ']')
          }
        })
      } else {
        if (keyName) {
          objToFd(val, fd, keyName + '[' + prop + ']')
        } else {
          objToFd(val, fd, prop)
        }
      }
    }
  }
  return fd
}

// 提交前过滤空数据
export const removeProperty = (object) => {
  for (let key in object) {
    if (object[key] === '') {
      object[key] = undefined
    } else if (object[key] === null) {
      object[key] = undefined
    } else if (Array.isArray(object[key]) && object[key].length === 0) {
      object[key] = undefined
    }
  }
}

// 上传文件的限制
export const allow = ['.csv', '.txt', '.xls', '.xlsx', '.doc', '.pdf', '.docx', '.ppt', '.rar', '.zip', '.jpg', '.jpeg',
  '.bmp', '.gif', '.png', '.image/jpeg', '.tif', '.rp', '.xmind', '.vsd', '.mp4']
export const allowSize = 200

// 验证权限 控制button是否显示
export const canDo = (key) => {
  let permissions = JSON.parse(localStorage.getItem('permissions'))
  let index = _.findIndex(permissions, ['name', key])
  return index >= 0
}

// 默认客服区域
export const serviceArea = [{
  id: 1,
  locale: '{"zh-CN":"国内客服","en":"Chinese Customer Service"}'
},
{
  id: 2,
  locale: '{"zh-CN":"西雅图客服","en":"Seattle Customer Service"}'
},
{
  id: 4,
  locale: '{"zh-CN":"德国客服","en":"German Customer Service"}'
},
{
  id: 5,
  locale: '{"zh-CN":"澳大利亚客服","en":"Australia Customer Service"}'
},
{
  id: 6,
  locale: '{"zh-CN":"英国客服","en":"Britain Customer Service"}'
},
{
  id: 7,
  locale: '{"zh-CN":"新加坡客服","en":"Singapore Customer Service"}'
},
{
  id: 8,
  locale: '{"zh-CN":"特拉华客服","en":"Delaware Customer Service"}'
},
{
  id: 9,
  locale: '{"zh-CN":"俄罗斯客服","en":"Russia Customer Service"}'
}
]

// 默认销售类型
export const salesType = [{
  id: 1,
  locale: '{"zh-CN":"英文站","en":"English"}'
},
{
  id: 2,
  locale: '{"zh-CN":"西语站","en":"Spanish"}'
},
{
  id: 3,
  locale: '{"zh-CN":"法语站","en":"French"}'
},
{
  id: 4,
  locale: '{"zh-CN":"俄语站","en":"Russian"}'
},
{
  id: 5,
  locale: '{"zh-CN":"德语站","en":"German"}'
},
{
  id: 6,
  locale: '{"zh-CN":"中文站","en":"Chinese"}'
},
{
  id: 8,
  locale: '{"zh-CN":"日语站","en":"Japanese"}'
},
{
  id: 9,
  locale: '{"zh-CN":"英国站","en":"Britain"}'
},
{
  id: 10,
  locale: '{"zh-CN":"澳大利亚","en":"Australia"}'
},
{
  id: 11,
  locale: '{"zh-CN":"新加坡站","en":"Singapore "}'
},
{
  id: 12,
  locale: '{"zh-CN":"墨西哥站","en":"Mexico "}'
},
{
  id: 13,
  locale: '{"zh-CN":"德语英文站","en":"German English"}'
},
{
  id: 14,
  locale: '{"zh-CN":"意大利","en":"Italy"}'
}

]

export const setInputErrors = (error, form) => {
  if (typeof error.response.data['errors'] !== 'undefined') {
    let validations = error.response.data['errors']
    let options = {}
    let fieldsValue = form.getFieldsValue()
    _.forEach(validations, function (item, index) {
      options[index] = { value: typeof fieldsValue !== 'undefined' ? _.get(fieldsValue, index) : null, errors: [] }
      _.forEach(item, function (msg) {
        options[index].errors.push({ message: msg, field: index })
      })
    })
    form.setFields(options)
    return true
  }
  return false
}

// 验证密码的正则

export const passReg = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9$@$!%*#?&]{8,16}$/

export const getDomain = () => {
  let arr = document.domain.split('.').reverse()
  return '.' + arr[1] + '.' + arr[0]
}
