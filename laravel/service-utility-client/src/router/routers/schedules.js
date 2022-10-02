const _import = file => () => import('../../views/' + file + '.vue')

const schedulesRouter = [{
  name: 'schedules',
  path: '/schedules',
  component: _import('layouts/PageView'),
  redirect: '/schedules/index',
  children: [{
    name: 'schedulesIndex',
    path: 'index',
    component: _import('schedules/index'),
    meta: {
      title: '班次管理'
    }
  }]
}]

export default [...schedulesRouter]
