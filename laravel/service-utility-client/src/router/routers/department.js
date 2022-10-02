const _import = file => () => import('../../views/' + file + '.vue')

const departmentRouter = [
  {
    name: 'department',
    path: '/department',
    component: _import('layouts/PageView'),
    redirect: '/department/departmentManage',
    children: [
      {
        name: 'departmentManage',
        path: 'departmentManage',
        component: _import('department/departmentTree')
      },
      {
        name: 'departmentUser',
        path: ':id/:action',
        component: _import('position/userListOfPosition')
      }
    ]
  }
]

export default departmentRouter
