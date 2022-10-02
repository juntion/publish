import PageView from '../../views/layouts/PageView'

const _import = file => () => import('../../views/' + file + '.vue')

const templateRouter = [
  {
    path: '/template',
    name: 'template',
    component: PageView,
    children: [
      {
        path: 'templateList',
        name: 'templateManage',
        component: _import('template/index')
      },
      {
        path: ':id/categories/:guard_name',
        name: 'sideBarCategory',
        component: _import('template/sideBarCategory')
      }
    ]
  }
]

export default [...templateRouter]
