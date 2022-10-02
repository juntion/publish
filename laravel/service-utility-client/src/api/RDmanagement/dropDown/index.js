/* eslint-disable */
import axios from '../../../plugins/axios'

// 所有分析、开发和设计人员下拉数据
export const getBindPeople = () => {
    return axios.get('/pm/dropDown/systemDevUser')
}


// 项目发布人（经理/负责人）下拉数据
export const getProjectPrincipal = () => {
    return axios.get('/pm/dropDown/projectPrincipal')
}

// 产品跟进人下拉数据
export const getProductFollower = () => {
    return axios.get('/pm/dropDown/productFollower')
}

// 产品成员下拉数据
export const getProductMember = () => {
    return axios.get('/pm/dropDown/productMember')
}

// 产品负责人下拉数据
export const getProductPrincipal = () => {
    return axios.get('/pm/dropDown/productPrincipal')
}

// 需求发布人下拉数据
export const getDemandPublisher = () => {
    return axios.get('/pm/dropDown/demandPublisher')
}

// 测试任务发布人下拉数据
export const testTaskPublisher = () => {
    return axios.get('/pm/dropDown/testTaskPublisher')
}

// 测试-获取该任务更新负责人下拉选项
export const getNewTestPrincipal = (id,params) => {
    return axios.get('/pm/tasks/test/' + id + '/principal',{params})
}

// 开发-获取该任务更新负责人下拉选项
export const getNewDevPrincipal = (id,params) => {
    return axios.get('/pm/tasks/dev/' + id + '/principal',{params})
}

// 测试任务负责人
export const getTestPrincipal = () => {
    return axios.get('/pm/dropDown/testPrincipal')
}

// 测试任务处理人下拉数据
export const testTaskHandler = () => {
    return axios.get('/pm/dropDown/testTaskHandler')
}

// 开发任务发布人下拉数据
export const devTaskPublisher = () => {
    return axios.get('/pm/dropDown/devTaskPublisher')
}

// 开发任务负责人
export const getdevPrincipal = () => {
    return axios.get('/pm/dropDown/devPrincipal')
}

// 开发任务处理人下拉数据
export const devTaskHandler = () => {
    return axios.get('/pm/dropDown/devTaskHandler')
}

// 设计任务发布人下拉数据
export const designTaskPublisher = () => {
    return axios.get('/pm/dropDown/designTaskPublisher')
}

// 设计任务负责人
export const getdesignPrincipal = () => {
    return axios.get('/pm/dropDown/designPrincipal')
}

// 设计任务处理人下拉数据
export const designTaskHandler = () => {
    return axios.get('/pm/dropDown/designTaskHandler')
}

// 交互负责人下拉数据
export const getInteractionPrincipal = () => {
    return axios.get('/pm/dropDown/interactionPrincipal')
}

// 视觉负责人下拉数据
export const getVisionPrincipal = () => {
    return axios.get('/pm/dropDown/visionPrincipal')
}

// 前端负责人下拉数据
export const getFrontEndPrincipal = () => {
    return axios.get('/pm/dropDown/frontEndPrincipal')
}

// 移动端负责人下拉数据
export const getMobilePrincipal = () => {
    return axios.get('/pm/dropDown/mobilePrincipal')
}

// 美工负责人下拉数据
export const getArtistPrincipal = () => {
    return axios.get('/pm/dropDown/artistPrincipal')
}
// 获取产品需求的下拉
export const getDemandsPrincipal = (id) => {
    return axios.get('/pm/demands/' + id + '/principal')
}
// 需求更改产品负责人
export const eidtDemandsPrincipal = (params, id) => {
    return axios.post('/pm/demands/' + id + '/principal', params)
}

// 需求下拉列表
export const demandList = (params) => {
    return axios.get('/pm/dropDown/demandList',{params})
}
// 部门列表
export const getlDepartment = () => {
    return axios.get('/pm/dropDown/department')
}
// 系统分析部excel导出
export const exportKpiExcel = (params) => {
    let url = process.env.VUE_APP_API_URL + '/pm/excel/assessment/analysis?' + params
    window.open(url, '_blank')
}
// 导出需求列表
export const getExcel = (params) => {
    let url = process.env.VUE_APP_API_URL + '/pm/demands/export?' + params
    window.open(url, '_blank')
  }

  //系统分析部人员下拉数据
export const getAnalysisPeople = () => {
    return axios.get('/pm/dropDown/departmentUser?department_id=212&deep=1')
}

// 程序负责人
export const getProgramPrincipal = () => {
    return axios.get('/pm/dropDown/bugs/programPrincipal')
}

// bug 跟进人
export const getFollower = () => {
    return axios.get('/pm/dropDown/bugs/follower')
}

// bug产品负责人
export const getBugProductPrincipal = () => {
    return axios.get('/pm/dropDown/bugs/productPrincipal')
}

// 测试负责人
export const getBugTestPrincipal = () => {
    return axios.get('/pm/dropDown/bugs/testPrincipal')
}


// 任务负责人下拉选项
export const getTaskPrincipal = (params) => {
    return axios.get('/pm/dropDown/taskPrincipal',{params})
}
