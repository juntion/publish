const _import = file => () => import('../../views/' + file + '.vue')

const rolesRouter = [
  {
    name: 'rolePermission',
    path: '/role',
    component: _import('layouts/PageView'),
    redirect: '/roles/list',
    children: [
      {
        name: 'roleManage',
        path: 'list',
        component: _import('role/roleList')
      },
      {
        name: 'updateRolePermissions',
        path: ':id/permission',
        component: _import('role/permissionTree')
      },
      {
        name: 'permissionManage',
        path: '/permissions/list',
        component: _import('role/permissionList')
      }
    ]
  }
]

export default [...rolesRouter]
