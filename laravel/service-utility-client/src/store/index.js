import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth/index'
import * as system from './modules/system/index'
import * as userManage from './modules/userManage/index'
import Position from './modules/position/index'
import Department from './modules/department/index'
import SubSystems from './modules/subsystem/index'
import * as rolePermission from './modules/rolePermission/index'
import * as templateCate from './modules/template'
import * as RDmanagement from './modules/RDmanagement/index'
import * as toolManagement from './modules/toolManagement/index'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth,
    ...system,
    ...userManage,
    Position,
    Department,
    SubSystems,
    ...rolePermission,
    ...templateCate,
    ...RDmanagement,
    ...toolManagement
  },
  strict: false
})
