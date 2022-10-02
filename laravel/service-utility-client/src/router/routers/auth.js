const _import = file => () => import('../../views/' + file + '.vue')

const authRouter = [
  {
    path: '/auth',
    component: _import('auth/Layout'),
    meta: { auth: false },
    redirect: '/auth/login',
    children: [
      {
        name: 'authLogin',
        path: '/auth/login',
        component: _import('auth/Login')
      },
      {
        name: 'authSendResetEmail',
        path: '/auth/password',
        component: _import('auth/SendResetMail')
      },
      {
        name: 'authPasswordReset',
        path: '/auth/password/reset/:token',
        component: _import('auth/PasswordReset')
      }
    ]
  }
]
export default authRouter
