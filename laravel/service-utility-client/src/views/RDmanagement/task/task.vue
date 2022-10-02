<template>
  <div>
    <div class="top-select">
      <a-select showSearch
                v-if="$route.query.project"
                placeholder="请选择项目"
                style="width:240px"
                class="select-btn"
                @search="serchFocus"
                :filterOption="false"
                v-model="projectsData.source_project_id"
                @popupScroll="popupScroll">
        <a-select-option v-for="item in projectsData.projectList"
                         :key="item.id">
           <img src="@/assets/images/daily.png" v-if="item.type == 0">
        <img src="@/assets/images/key.png" v-if="item.type == 1">
        {{item.name}}
         </a-select-option>
      </a-select>

      <a-select v-model="taskStatus"
                @change="changeType"
                style="width: 120px"
                id="link"
                :class="{'select-btn':true,'select-btn2':$route.query.project}">
        <a-select-option value="design">设计环节</a-select-option>
        <a-select-option value="dev">开发环节</a-select-option>
        <a-select-option value="test">测试环节</a-select-option>
      </a-select>
        <a-select v-model="designValue"
            v-if="taskStatus==='design'"
            mode="multiple"
            allowClear
            placeholder="请选择角色"
            @change="changeRole"
            style="min-width: 120px;height:32px"
            class="select-btn select-btn2 design">

        <a-select-option value="all">所有角色</a-select-option>
        <a-select-option value="0">交互</a-select-option>
        <a-select-option value="1">视觉</a-select-option>
        <a-select-option value="3">前端</a-select-option>
        <a-select-option value="4">移动端</a-select-option>
        <a-select-option value="2">美工</a-select-option>
    </a-select>
    <a-icon v-if="taskStatus==='design'" type="down" class="icon-down"/>
    </div>
    <div  class="task-content">
         <keep-alive>
            <taskDesign v-if="taskStatus==='design'"
                        :proId="projectsData.source_project_id"
                        :designValue="designValue"></taskDesign>
            <taskTest v-if="taskStatus==='test'"
                        :proId="projectsData.source_project_id"></taskTest>
            <taskDev v-if="taskStatus==='dev'"
                    :proId="projectsData.source_project_id"></taskDev>
        </keep-alive>
    </div>

  </div>
</template>
<style lang="less" scoped>
/deep/.tabslist{
    min-width: 1400px;
}
/deep/.arrow {
  font-size: 12px;
  color: #378eef;
  cursor: pointer;
}
.select-btn /deep/ .ant-select-selection--multiple .ant-select-selection__clear{
    right: 5px;
}
.icon-down{
    position: relative;
    left: -28px;
}
/deep/.ant-popover-inner-content{
        padding: 10px;
    }
 .task-content{
  overflow-y: auto;
  height:calc( ~"100vh - 266px");
}
/deep/.table-eidt{
    box-shadow: 0px 5px 15px 0px rgba(223, 226, 230, 0.8);
    table{
        display: none;
    }
}

.design /deep/.ant-select-selection--multiple .ant-select-selection__rendered{
    margin-left: 15px;
    margin-right: 11px;
    .ant-select-selection__choice__content{
        display: inline;
    }
     ul li{
         display: inline;
     }
    ul li::after{
        content: '/';
    }
    ul li:nth-last-child(1)::after {
        display:none !important;
    }
    ul li:nth-last-child(2)::after {
        display:none !important;
    }
}

.design /deep/.ant-select-selection__choice{
    padding: 0;
    background: #fff;
    border: 0;
    margin-right: 0;

    .ant-select-selection__choice__remove{
        display: none;
    }
}
.top-select {
  margin-bottom: 30px;
  /deep/.ant-select-selection {
    border: 0;
    box-shadow: none;
    border-radius: 0;
  }
  /deep/.ant-select-selection--single {
    height: 32px;
  }
  /deep/.ant-select-selection-selected-value {
    margin-left: 5px;
  }
  .select-btn {
    margin-right: 10px;
  }
  .select-btn::after {
    position: absolute;
    top: -1px;
    right: -7px;
    display: block;
    width: 0;
    height: 0;
    border-width: 17px 0 17px 8px;
    border-style: solid;
    border-color: transparent transparent transparent #fff;
    content: " ";
  }
  .select-btn2::before {
    position: absolute;
    top: 0;
    left: 0;
    display: block;
    width: 0;
    height: 0;
    z-index: 10;
    border-width: 17px 0 17px 8px;
    border-style: solid;
    border-color: transparent transparent transparent #f0f2f5;
    content: " ";
  }
}
</style>
<script>
import { getAllprojects, searchProjects } from '@/api/RDmanagement/project'
import taskDesign from './task-design'
import taskDev from './task-dev'
import taskTest from './task-test'
export default {
  components: { taskDesign, taskTest, taskDev },
  data () {
    return {
      taskStatus: 'design',
      designValue: ['all'],
      projectsData: {
        source_project_id: -1,
        projectList: [{ id: -1, name: '所有项目' }],
        total: '',
        page: 1,
        totalPages: null
      }
    }
  },
  watch: {
    taskStatus () {
      if (this.$route.query.project) {
        setTimeout(() => {
          document.getElementById('link').classList.add('select-btn2')
        }, 100)
      }
    }
  },

  created () {
    let userType = {}
    if (localStorage.getItem('userType')) {
      userType = JSON.parse(localStorage.getItem('userType'))
    }
    this.taskStatus = userType.link_type || 'design'
    if (this.$route.query.type) {
      this.taskStatus = this.$route.query.type
    }
    if (this.$route.query.project) {
      setTimeout(() => {
        document.getElementById('link').classList.add('select-btn2')
      }, 100)
    }
    // 获取项目列表
    let search = []
    search['status'] = 1
    getAllprojects({ page: 1, limit: 30, filters: search }).then(res => {
      if (res.code === 200) {
        // this.searchData.source_project_id = this.$route.query.id
        this.projectsData.projectList = res.data.data
        this.projectsData.projectList.unshift({ id: -1, name: '所有项目' })
        this.projectsData.total = res.data.total
        this.projectsData.totalPages = res.data.last_page
      }
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
  },
  methods: {
    changeRole (e) {
      if (e.length > 1 && e.indexOf('all') !== -1) {
        this.designValue.splice(e.indexOf('all'), 1)
      }
      if (e.length > 4) {
        this.designValue = ['all']
      }
    },
    changeType (e) {
      this.$router.push({ name: 'task', query: { type: e } })
    },
    //      项目列表的分页滚动
    proJectList (value) {
    //   this.loading = true
      this.projectsData.page = this.projectsData.page += 1
      let params = {}
      let search = []
      search['keyword'] = value
      search['status'] = 1
      if (this.projectsData.page === this.projectsData.total && this.projectsData.page > this.projectsData.total) {
        this.loading = false
        return false
      } else {
        if (value) {
          params = {
            page: this.projectsData.page,
            limit: 30,
            filters: search
          }
        } else {
          search['keyword'] = undefined
          params = {
            page: this.projectsData.page,
            limit: 30,
            filters: search
          }
        }
        getAllprojects(params).then(res => {
          if (res.code === 200) {
            this.projectsData.totalPages = res.data.last_page
            this.projectsData.projectList.push(...res.data.data)
            this.loading = false
          }
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    },
    popupScroll (e) {
      if (e.target.scrollTop + e.target.offsetHeight === e.target.scrollHeight) {
        this.proJectList(null)
      }
    },
    serchFocus (value) {
      this.projectsData.page = 0
      this.projectsData.projectList = []
      let values = '%' + value + '%'
      //   this.proJectList(values)
      this.$nextTick(() => {
        let self = this
        this.timer = searchProjects(1, this.timer, values, function (res) {
          self.projectsData.projectList = res.data.data
          self.projectsData.totalPages = res.data.last_page
        })
      })
    }
  }
}
</script>
