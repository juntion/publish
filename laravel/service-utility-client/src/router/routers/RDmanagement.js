/* eslint-disable */
const _import = file => () =>
    import ('../../views/' + file + '.vue')

const RDmanagementRouter = [{
    name: 'RDmanagement',
    path: '/RDmanagement',
    component: _import('layouts/PageView'),
    redirect: '/RDmanagement/ProductMaintenance',
    children: [{
            name: 'ProductMaintenance',
            path: 'ProductMaintenance',
            component: _import('RDmanagement/base'),
            redirect: '/RDmanagement/ProductMaintenance/editionManagement',
            children: [{
                    name: 'ProIndex',
                    path: 'index',
                    component: _import('RDmanagement/ProductMaintenance/index'),
                    meta: {
                        title: 'pms产品维护'
                    }
                },
                {
                    name: 'PMMaintenance',
                    path: 'PMMaintenance',
                    component: _import('RDmanagement/ProductMaintenance/PMMaintenance'),
                    meta: {
                        title: 'pms产品维护'
                    }
                },
                {
                    name: 'editionManagement',
                    path: 'editionManagement',
                    component: _import('RDmanagement/ProductMaintenance/editionManagement'),
                    meta: {
                        title: 'pms产品维护'
                    }
                },
                {
                    name: 'relationship',
                    path: 'relationship',
                    component: _import('RDmanagement/ProductMaintenance/relationship'),
                    meta: {
                        title: 'pms产品维护'
                    }
                }
            ]
        },
        {
            name: 'project',
            path: 'project',

            component: _import('RDmanagement/base'),
            redirect: 'project/home',
            children: [{
                name: 'projectHome',
                path: 'home',
                component: _import('RDmanagement/project/index'),
                meta: {
                    title: 'pms项目管理'
                }
            }, {
                name: 'dailyProjects',
                path: 'dailyProjects',
                component: _import('RDmanagement/project/dailyProjects')
            }, {
                name: 'test',
                path: 'test',
                component: _import('RDmanagement/project/test')
            }, {
                name: 'editDailyProjects',
                path: 'editDailyProjects',
                component: _import('RDmanagement/project/editDailyProjects')
            }, {
                name: 'proDetails',
                path: 'proDetails',
                component: _import('RDmanagement/project/projectDetails')
            }, {
                name: 'keyProjects',
                path: 'keyProjects',
                component: _import('RDmanagement/project/keyProjects')
            }, {
                name: 'projectDemandList',
                path: 'demandList',
                component: _import('RDmanagement/project/demandList'),
            }, {
                name: 'projectReleaseDemand',
                path: 'projectReleaseDemand',
                component: _import('RDmanagement/product/releaseDemand'),
            }, {
                name: 'projectTaskList',
                path: 'taskList',
                component: _import('RDmanagement/task/task')
            } ,{
                name: 'projectReleaseDesignTask',
                path: 'projectReleaseDesignTask',
                component: _import('RDmanagement/task/releaseDesignTask'),
                meta: {
                    title: 'pms任务管理'
                }
            },
            {
                name: 'projectReleaseTask',
                path: 'projectReleaseTask',
                component: _import('RDmanagement/task/releaseDevTask'),
                meta: {
                    title: 'pms任务管理'
                }
            }]
        },
        {
            name: 'recount',
            path: 'recount',

            component: _import('RDmanagement/base'),
            redirect: '/RDmanagement/recount/index',
            children: [{
                    name: 'recountindex',
                    path: 'index',
                    component: _import('RDmanagement/recount/index'),
                    meta: {
                        title: 'pms诉求管理'
                    }
                },
                {
                    name: 'recountAnalysis',
                    path: 'recountAnalysis',
                    component: _import('RDmanagement/recount/recountAnalysis')
                },
                {
                    name: 'postclaim',
                    path: 'postclaim',
                    component: _import('RDmanagement/recount/postclaim')
                },
                {
                    name: 'claimDetail',
                    path: 'claimDetail',
                    component: _import('RDmanagement/recount/claimDetail')
                },
                {
                    name: 'claimDismantling',
                    path: 'claimDismantling',
                    component: _import('RDmanagement/recount/claimDismantling')
                },
                {
                    name: 'eidtClaim',
                    path: 'eidtClaim',
                    component: _import('RDmanagement/recount/eidtClaim')
                }

            ]
        },
        {
            name: 'product',
            path: 'product',
            component: _import('RDmanagement/base'),
            redirect: '/RDmanagement/product/demandList',
            children: [{
                    name: 'demandList',
                    path: 'demandList',
                    component: _import('RDmanagement/product/demandList'),
                    meta: {
                        title: 'pms需求管理'
                    }
                },
                {
                    name: 'releaseDemand',
                    path: 'releaseDemand',
                    component: _import('RDmanagement/product/releaseDemand')
                },
                {
                    name: 'editDemand',
                    path: 'editDemand',
                    component: _import('RDmanagement/product/editDemand')
                },
                {
                    name: 'demandDetails',
                    path: 'demandDetails',
                    component: _import('RDmanagement/product/demandDetails')
                },
                {
                    name: 'task',
                    path: 'task',
                    component: _import('RDmanagement/task/task'),
                    meta: {
                        title: 'pms任务管理'
                    }
                },
                {
                    name: 'taskStatistics',
                    path: 'taskStatistics',
                    component: _import('RDmanagement/task/taskStatistics'),
                    meta: {
                        title: 'pms任务管理'
                    }
                },
                {
                    name: 'releaseDesignTask',
                    path: 'releaseDesignTask',
                    component: _import('RDmanagement/task/releaseDesignTask'),
                    meta: {
                        title: 'pms任务管理'
                    }
                },
                {
                    name: 'releaseTask',
                    path: 'releaseTask',
                    component: _import('RDmanagement/task/releaseDevTask'),
                    meta: {
                        title: 'pms任务管理'
                    }
                }
            ]
        },
        {
            name: 'workBench',
            path: 'workBench',
            component: _import('RDmanagement/base'),
            redirect: '/RDmanagement/workBench/index',
            children: [{
                name: 'workBenchIndex',
                path: 'index',
                meta: {
                    title: 'pms我的工作台'
                },
                component: _import('RDmanagement/workBench/index')
            }]
        },
        {
            name: 'bug',
            path: 'bug',
            component: _import('RDmanagement/base'),
            redirect: '/RDmanagement/bug/bugProduct',
            children: [{
                name: 'bugProduct',
                path: 'bugProduct',
                meta: {
                    title: 'bug生产版本'
                },
                component: _import('RDmanagement/bug/product')
            },{
                name: 'bugTest',
                path: 'bugTest',
                meta: {
                    title: 'bug测试版本'
                },
                component: _import('RDmanagement/bug/test')
            },
            {
                name: 'bugSetting',
                path: 'bugSetting',
                meta: {
                    title: '基础配置'
                },
                component: _import('RDmanagement/bug/bugSetting')
            },
            {
                name: 'releaseBug',
                path: 'releaseBug',
                meta: {
                    title: '提Bug'
                },
                component: _import('RDmanagement/bug/proposeBug')
            }]
        }
    ]
}]
export default [...RDmanagementRouter]
