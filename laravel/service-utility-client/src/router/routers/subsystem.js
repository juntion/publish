import PageView from '../../views/layouts/PageView'

const _import = file => () => import('../../views/' + file + '.vue')

const subsystemRouter = [
  {
    name: 'subsystem',
    path: '/subsystem',
    component: PageView,
    children: [
      {
        name: 'subsystemManage',
        path: 'subsystemManage',
        component: _import('subsystem/list')
      },
      {
        name: 'subsystemForbidUsers',
        path: ':id/forbidUsers',
        component: _import('subsystem/forbidUsers')
      },
      {
        name: 'pageManage',
        path: 'pageList',
        component: _import('subsystem/pageList')
      }
    ]
  }
]

export default [...subsystemRouter]
