import enBasic from './basic/en'
import zhBasic from './basic/zh-CN'
import enAuth from './auth/en'
import zhAuth from './auth/zh-CN'
import enSystem from './system/en'
import zhSystem from './system/zh-CN'
import enUser from './user/en'
import zhUser from './user/zh-CN'
import enDepartment from './department/en'
import zhDepartment from './department/zh-CN'
import enPosition from './position/en'
import zhPosition from './position/zh-CN'
import enRole from './role/en'
import zhRole from './role/zh-CN'
import enTemplate from './template/en'
import zhTemplate from './template/zh-CN'
import enSubs from './subsystem/en'
import zhSubs from './subsystem/zh-CN'
const messages = {
  en: {
    auth: enAuth,
    system: enSystem,
    ...enBasic,
    user: enUser,
    department: enDepartment,
    position: enPosition,
    role: enRole,
    template: enTemplate,
    subsystem: enSubs
  },
  'zh-CN': {
    auth: zhAuth,
    system: zhSystem,
    ...zhBasic,
    user: zhUser,
    department: zhDepartment,
    position: zhPosition,
    role: zhRole,
    template: zhTemplate,
    subsystem: zhSubs
  }
}

export default messages
