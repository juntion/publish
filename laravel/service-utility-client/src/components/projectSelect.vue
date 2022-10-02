<template>
    <div>
          <a-select showSearch
                placeholder="请选择项目"
                @search="serchFocus"
                :filterOption="false"
                v-model="projectsData.source_project_id"
                @change="onSelectChange"
                :allowClear="allowClear"
                @popupScroll="popupScroll">
        <a-select-option v-for="item in projectsData.projectList"
                         :key="item.id">
        <img src="@/assets/images/daily.png" v-if="item.type == 0">
        <img src="@/assets/images/key.png" v-if="item.type == 1">
        {{item.name}}
         </a-select-option>
      </a-select>
    </div>
</template>

<script>
import { getAllprojects, searchProjects } from '@/api/RDmanagement/project'
export default {
  data () {
    return {
      projectsData: {
        source_project_id: this.value,
        projectList: [],
        total: '',
        page: 1,
        totalPages: null
      }
    }
  },
  watch: {
    value (newVal, oldVal) {
      this.projectsData.source_project_id = newVal
    }
  },
  props: {
    value: {
      type: Number
    },
    allowClear: {
      type: Boolean,
      default: false
    },
    status: {
      type: Number
    }
  },
  methods: {
    onSelectChange () {
      this.$emit('input', this.projectsData.source_project_id)
      let name = ''
      this.projectsData.projectList.forEach((item) => {
        if (item.id === this.projectsData.source_project_id) {
          name = item.name
        }
      })
      this.$emit('onChange', name)
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
    serchFocus (value) {
      this.projectsData.page = 0
      this.projectsData.projectList = []
      let values = '%' + value + '%'
      //   this.proJectList(values)

      this.$nextTick(() => {
        let self = this
        this.timer = searchProjects(this.status, this.timer, values, function (res) {
          self.projectsData.projectList = res.data.data
          self.projectsData.totalPages = res.data.last_page
        })
      })
    },
    popupScroll (e) {
      if (e.target.scrollTop + e.target.offsetHeight === e.target.scrollHeight) {
        this.proJectList(null)
      }
    }
  },
  created () {
    let search = []
    search['status'] = 1
    getAllprojects({ page: 1, limit: 30, filters: search }).then(res => {
      if (res.code === 200) {
        this.projectsData.projectList = res.data.data
        this.projectsData.total = res.data.total
        this.projectsData.totalPages = res.data.last_page
      }
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
  }
}
</script>
