<template>
    <a-modal :title="$t('user.modal.userSideTemplates')"
             v-model="userSideBarShow"
             width="1000px"
    >
        <template slot="footer">
            <a-button @click="handleCancel">{{$t('user.modal.close')}}</a-button>
        </template>
        <a-table
                :columns="columns"
                :dataSource="UserTemplatesData"
                :loading="UserTemplatePageLoading"
                rowKey="id"
                :pagination='false'
        >
            <template slot-scope="text, record" slot="name">
                <a @click="goToTemplate(record.id, record.guard_name)">{{record.name}}</a>
            </template>
            <template slot-scope="text, record" slot="locale">
                <p class="localeSpan"
                   v-for="(item, key) in JSON.parse(record.locale)"
                   :key="key"
                >
                    <a-tag color="blue">{{key}}</a-tag>
                    <span>{{item}}</span>
                </p>
            </template>
        </a-table>
    </a-modal>
</template>

<script>
import { getUserSide } from '../../../../api/userManage'
import { bus } from '../../../../plugins/bus'

export default {
  name: 'userSideBarModal',
  data () {
    return {
      userSideBarShow: false,
      columns: [
        {
          title: () => this.$t('user.modal.templateName'),
          dataIndex: 'name',
          scopedSlots: { customRender: 'name' },
          width: '15%'
        },
        {
          title: () => this.$t('user.modal.comment'),
          dataIndex: 'comment',
          width: '30%'
        },
        {
          title: () => this.$t('user.modal.languages'),
          dataIndex: 'locale',
          scopedSlots: { customRender: 'locale' },
          width: '20%'
        },
        {
          title: () => this.$t('user.modal.guard'),
          dataIndex: 'guard_name',
          width: '10%'
        }
      ],
      UserTemplatesData: [],
      UserTemplatePageLoading: false
    }
  },
  methods: {
    getUserSideTemplate (id) {
      this.UserTemplatePageLoading = true
      getUserSide({ id }).then(data => {
        this.UserTemplatePageLoading = false
        this.UserTemplatesData = data.data.sidebar_templates
      }).catch(error => {
        this.UserTemplatePageLoading = false
        this.$message.error(error.response.data.message || error.message)
      })
    },
    handleCancel () {
      this.userSideBarShow = false
    },
    goToTemplate (id, guardName) {
      this.$router.push({
        name: 'sideBarCategory',
        params: {
          id,
          guard_name: guardName
        }
      })
    }
  },
  mounted () {
    bus.$on('showUserTemplate', id => {
      this.getUserSideTemplate(id)
      this.userSideBarShow = true
    })
  }
}
</script>

<style scoped>

</style>
