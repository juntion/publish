const _import = file => () => import('../../views/' + file + '.vue')

const positionRouter = [
  {
    name: 'position',
    path: '/positions',
    component: _import('layouts/PageView'),
    redirect: '/positions/list',
    children: [
      {
        name: 'positionManage',
        path: 'list',
        component: _import('position/list')
      },
      {
        name: 'userListOfPosition',
        path: ':id/:action',
        component: _import('position/userListOfPosition')
      }
    ]
  }
]

export default [...positionRouter]
