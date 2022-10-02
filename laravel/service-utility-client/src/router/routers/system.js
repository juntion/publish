import PageView from '../../views/layouts/PageView'

const _import = file => () => import('../../views/' + file + '.vue')

const systemRouter = [
  {
    name: 'dashboard',
    path: '/dashboard',
    component: _import('dashboard/Index')
  },
  {
    name: 'userManage',
    path: '/userManage',
    component: PageView,
    children: [
      {
        name: 'userInfoManage',
        path: 'userInfo',
        component: _import('userManage/settings/Index'),
        redirect: 'userInfo/settings/base',
        children: [
          {
            path: 'settings/base',
            name: 'BaseSettings',
            component: _import('userManage/settings/BaseSetting')
          },
          {
            path: 'settings/password',
            name: 'PasswordSettings',
            component: _import('userManage/settings/PasswordSetting')
          },
          {
            path: 'setting/avatar',
            name: 'AvatarSetting',
            component: _import('userManage/settings/UploadAvatar')
          },
          {
            path: 'setting/position',
            name: 'PositionSetting',
            component: _import('userManage/settings/Position')
          },
          {
            path: 'setting/loginLog',
            name: 'loginLog',
            component: _import('userManage/settings/LoginLog')
          }
        ]
      },
      {
        path: 'userList',
        name: 'userList',
        component: _import('userManage/users/userList')
      },
      {
        name: 'usersSubsForbid',
        path: 'user/:id/subsystemForbid',
        component: _import('userManage/users/subsystemForbidList')
      },
      {
        name: 'userPermissions',
        path: 'user/:id/permission',
        component: _import('userManage/users/userPermission')
      }
    ]
  },
  {
    name: '404',
    path: '/404',
    component: _import('NotFound')
  }
]

export default [...systemRouter]
