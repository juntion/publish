const _import = file => () => import('../../views/' + file + '.vue')

const toolManageRouter = [{
  name: 'toolManagement',
  path: '/toolManagement',
  component: _import('layouts/PageView'),
  redirect: '/toolManagement/mainCompany',
  children: [{
    name: 'mainCompany',
    path: 'mainCompany',
    component: _import('toolManagement/mainCompany/index'),
    meta: {
      title: '主体公司'
    }
  }, {
    name: 'companyInfomation',
    path: 'companyInfomation',
    component: _import('toolManagement/companyInfomation/index'),
    meta: {
      title: '公司信息'
    }
  }]
}]

export default [...toolManageRouter]
