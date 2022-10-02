import Vue from 'vue'
import VueRouter from 'vue-router'
import authRoutes from './routers/auth'
import systemRoutes from './routers/system'
import positionRouter from './routers/position'
import departmentRouter from './routers/department'
import subSystemRouter from './routers/subsystem'
import rolesRouter from './routers/roles'
import templateRouter from './routers/template'
import RDmanagementRouter from './routers/RDmanagement'
import toolManageRouter from './routers/toolManagement'
import schedulesRouter from './routers/schedules'
import Layout from '../views/layouts/BasicLayout'
import Cookies from 'js-cookie'
import auth, { checkToken } from '../api/auth'

Vue.use(VueRouter)
const RouterConfig = {
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    ...authRoutes,
    {
      path: '/',
      name: 'home',
      redirect: 'dashboard',
      component: Layout,
      meta: { auth: true },
      children: [
        ...systemRoutes,
        ...positionRouter,
        ...departmentRouter,
        ...subSystemRouter,
        ...rolesRouter,
        ...templateRouter,
        ...RDmanagementRouter,
        ...toolManageRouter,
        ...schedulesRouter
      ]
    }
  ]
}

const router = new VueRouter(RouterConfig)

const originalPush = router.push

router.push = function push (location, onResolve, onReject) {
  if (onResolve || onReject) {
    return originalPush.call(this, location, onResolve, onReject)
  }
  return originalPush.call(this, location).catch(err => err)
}

router.beforeEach(async (to, from, next) => {
  // 是否是其余系统请求获取token
  document.title = to.meta.title || 'uums 管理系统'
  let returnUrl = to.query.returnUrl
  let login = to.query.login // 是否需要去登录
  let guardName = to.query.guard_name
  if (returnUrl && to.name === 'authLogin') {
    Cookies.set('returnUrl', returnUrl)
    Cookies.set('guardName', guardName)
  }
  if (returnUrl && !login) {
    let token = Cookies.get('token')
    let tokenTicket = false
    if (token) {
      await checkToken().then(data => {
        tokenTicket = data
      })
    }
    if (tokenTicket) {
      let concatStr = returnUrl.indexOf('?') > 0 ? '&' : '?'
      Cookies.remove('returnUrl')
      window.location.href = returnUrl + concatStr + 'ticket=' + tokenTicket
    } else {
      if (Boolean(localStorage.getItem('token')) === true && Boolean(localStorage.getItem('user'))) {
        await auth.refreshToken().then(data => {
          let concatStr = returnUrl.indexOf('?') > 0 ? '&' : '?'
          window.location.href = returnUrl + concatStr + 'ticket=' + data.data.data.ticket
        }).catch(error => {
          window.Bus.$store.commit('AUTH_LOGOUT')
          window.Bus.$router.push('/auth/login')
        })
      } else {
        next({ path: '/auth/login', query: { login: true, returnUrl, guard_name: guardName } })
      }
    }
  } else {
    let forbidPages = []
    if (localStorage.getItem('user') !== null) {
      forbidPages = JSON.parse(localStorage.getItem('user'))['forbid_pages']
    }
    let forbid = false
    for (let item in forbidPages) {
      if (to.path === forbidPages[item]['route']) {
        forbid = true
      }
      break
    }
    let home = []
    if (localStorage.getItem('dashboard') !== null) {
      home = JSON.parse(localStorage.getItem('dashboard'))
    }
    let toPath = home.length === 0 ? '/dashboard' : home[0].route
    const routeAuth = to.matched.some(m => m.meta.auth) // 当前路由是否需要认证
    const isLogin = Boolean(Cookies.get('token')) || Boolean(localStorage.getItem('token')) // true 用户已登录， false 用户未登录
    // 若 Cookie 里没有token 但是localstorage 里有 则换取可用的token
    if (Boolean(Cookies.get('token')) === false && Boolean(localStorage.getItem('token'))) {
      await auth.refreshToken().catch(error => {
        window.Bus.$store.commit('AUTH_LOGOUT')
        window.Bus.$router.push('/auth/login')
      })
    }
    if (!routeAuth && isLogin) {
      next({
        path: '/'
      })
    } else if (routeAuth && !isLogin) {
      next({ path: '/auth/login', query: { redirect: to.path, login: true, returnUrl } })
    } else if (to.name === 'dashboard' && !to.query.noRedirect) {
      next({ path: toPath, query: { noRedirect: true } })
    } else if (forbid) {
      window.Bus.$message.error(window.Bus.$t('common.forbid'))
      next({ path: toPath, query: { noRedirect: true } })
    } else {
      next()
    }
  }
})

router.onError((error) => {
  const pattern = /Loading chunk(.*?) failed/g
  const isChunkLoadFailed = error.message.match(pattern)
  if (isChunkLoadFailed) {
    const h = window.Bus.$createElement
    window.Bus.$info({
      title: '系统资源加载失败',
      okText: '刷新',
      centered: true,
      keyboard: false,
      content: h('div', {}, [
        h('H2', '系统资源已更新，请刷新页面')
      ]),
      onOk () {
        window.location.reload(true)
      }
    })
  }
})

export default router
