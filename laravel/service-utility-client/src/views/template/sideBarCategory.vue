<template>
    <a-spin :spinning="spinning">
        <a-card>
        <a-button type="primary" v-if="canDo('sidebars.categories.store')" @click="addNewCate">{{$t('template.list.addCate')}}</a-button>
        <a-tree
                :defaultExpandAll="true"
                @rightClick="rightClick"
                :selectedKeys="selectKey"
                :treeData="formatData(getTemplateTreeData)"
                showIcon
                draggable
                @drop="onDrop"
        >
            <a-icon type="file" slot="file"/>
            <a-icon v-for="(item, key) in defaultIcons" :key="key" :type="item" :slot="item"/>
        </a-tree>

        <div class="rightClickMenu"
             ref="rightMenu"
             v-show="isShow"
             @mouseleave="hideMenu"
             :style="menuStyle"
        >
            <div v-if="isMenu">
                <a
                        class="MenuItem"
                        ref="item1"
                        @click="addCatePages"
                        @mouseover="changeState(1)"
                        @mouseout="resetState(1)"
                        v-if="canDo('sidebars.categories.addPages')"
                >
                    {{$t('template.action.addCatePage')}}
                </a>
                <a
                        class="MenuItem"
                        @click="addNewChildCate"
                        ref="item2"
                        @mouseover="changeState(2)"
                        @mouseout="resetState(2)"
                        v-if="canDo('sidebars.categories.store')"
                >
                    {{$t('template.action.addChildCate')}}
                </a>
                <a
                        class="MenuItem"
                        ref="item3"
                        @click="confirmDelete"
                        @mouseover="changeState(3)"
                        @mouseout="resetState(3)"
                        v-if="canDo('sidebars.categories.delete')"
                >
                    {{$t('template.action.deleteCate')}}
                </a>
                <a
                        class="MenuItem"
                        @click="updateCateData()"
                        ref="item4"
                        @mouseover="changeState(4)"
                        @mouseout="resetState(4)"
                        v-if="canDo('sidebars.categories.update')"
                >
                    {{$t('template.action.updateCate')}}
                </a>
            </div>
            <div v-else>
                <a
                        class="MenuItem"
                        @click="confirmRemovePage"
                        ref="item6"
                        @mouseover="changeState(6)"
                        @mouseout="resetState(6)"
                        v-if="canDo('sidebars.categories.removePages')"
                >
                    {{$t('template.action.removePage')}}
                </a>
            </div>
        </div>
        <!-- 添加新的侧边栏 -->
        <addCateModal></addCateModal>
        <!-- 更新模态框 -->
        <updateCateModal></updateCateModal>
        <!-- 关联页面模态框 -->
        <addCatePagesModal></addCatePagesModal>
    </a-card>
    </a-spin>
</template>

<script>
import { bus } from '../../plugins/bus'
import addCateModal from './modal/addCateModal'
import updateCateModal from './modal/updateCateModal'
import addCatePagesModal from './modal/addTemplatePagesModal'
import { mapGetters } from 'vuex'
import { defaultIcons, canDo } from '../../plugins/common'
import {
  categoriesBatchSort,
  categoriesSort,
  delCategories,
  delCategoriesPage,
  getTemplateTree, pagesBatchSort,
  updateCategories
} from '../../api/sidebar'

export default {
  name: 'sideBarCategory',
  components: { addCateModal, updateCateModal, addCatePagesModal },
  data () {
    return {
      templateId: '',
      isShow: false,
      menuStyle: {
        left: 0,
        top: 0
      },
      selectKey: [],
      defaultIcons,
      isMenu: false,
      pagesData: [],
      spinning: false
    }
  },
  methods: {
    canDo,
    rightClick (event) {
      let data = event.node.dataRef
      this.$store.commit('SET_CURRENT_CATE_DATA', data)
      this.isShow = true
      this.isMenu = event.node.dataRef.type === 'menu'
      this.menuStyle.left = (event.event.x - 20) + 'px'
      this.menuStyle.top = event.event.y + 'px'
      let selectKey = [event.node.eventKey]
      this.selectKey = selectKey
    },
    changeState (index) {
      let vm = this
      let mask = vm.$refs['item' + index]
      mask.style.background = '#e6f7ff'
    },
    resetState (index) {
      let vm = this
      let mask = vm.$refs['item' + index]
      mask.style.background = '#fff'
    },
    hideMenu () {
      this.isShow = false
    },
    addNewCate () {
      bus.$emit('addCateModalShow', 0)
    },
    getDataTree () {
      let params = {
        id: this.$route.params.id
      }
      getTemplateTree(params).then(data => {
        this.pagesData = data.data.trees
        this.$store.commit('SET_TEMPLATE_TREE_DATA', data)
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    updateCateData () {
      this.isShow = false
      bus.$emit('updateCateModalShow')
    },
    confirmDelete () {
      let _this = this
      this.$confirm({
        title: _this.$t('template.notify.confirmDeleteCate'),
        onOk () {
          _this.delCate()
        },
        onCancel () {}
      })
    },
    delCate () {
      this.isShow = false
      let params = {
        id: this.getCurrentCateData.key
      }
      delCategories(params).then(data => {
        if (data.status === 'success') {
          this.$message.success(this.$t('template.notify.deleteCateSuccess'))
          this.getDataTree()
        } else {
          this.$message.error(this.$t('template.notify.deleteCateError'))
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    addNewChildCate () {
      this.isShow = false
      bus.$emit('addCateModalShow', this.getCurrentCateData.key)
    },
    getTemplatePages () {
      this.$store.dispatch('fetchTemplatePages', { guard_name: this.$route.params.guard_name }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    addCatePages () {
      bus.$emit('addCatePageModalShow')
    },
    confirmRemovePage () {
      let _this = this
      this.$confirm({
        title: _this.$t('template.notify.confirmRemovePage'),
        onOk () {
          _this.removeCatePage()
        },
        onCancel () {}
      })
    },
    removeCatePage () {
      this.isShow = false
      let params = {
        id: this.getCurrentCateData.cate_id,
        page_ids: [this.getCurrentCateData.page_id]
      }
      delCategoriesPage(params).then(data => {
        if (data.status === 'success') {
          this.$message.success(this.$t('template.notify.removePageSuccess'))
          this.getDataTree()
        } else {
          this.$message.error(this.$t('template.notify.removeError'))
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    async onDrop (info) {
      let dropPosition = info.dropPosition // 托向的位置
      let dropIsPage = info.dragNode.isLeaf // 拖动的是页面
      let tragetIsPage = info.node.isLeaf // 目标节点是否为页面
      let dropPosArr = info.dragNode.pos.split('-') // 节点0-0-0 -> [0,0,0]
      let tragetPosArr = info.node.pos.split('-') // 目标节点 0-0-1 -> [0,1,1]
      let len1 = dropPosArr.length
      let len2 = tragetPosArr.length
      if (dropIsPage) { // 拖动的页面
        if (!tragetIsPage) {
          this.$message.error(this.$t('template.notify.DropPageError'))
          return false
        }
        if (len1 !== len2) {
          this.$message.error(this.$t('template.notify.cantChangeCate'))
          return false
        }
        // 深拷贝，方便后面该值
        let pages = this.pagesData.slice()
        let id = ''
        for (let i = 0; i <= len1 - 2; i++) {
          if (i > 0) {
            pages = pages[dropPosArr[i]]
            if (i < len1 - 2) {
              pages = pages['children']
            } else {
              id = pages['id']
              pages = pages['pages']
            }
          }
          if (dropPosArr[i] !== tragetPosArr[i]) {
            this.$message.error(this.$t('template.notify.cantChangeCate'))
            return false
          }
        }
        this.spinning = true
        let index = dropPosArr[len1 - 1]
        let dragNodeData = pages[index]
        pages.splice(index, 1)
        if (dropPosition !== -1 && dropPosition < tragetPosArr[tragetPosArr.length - 1]) {
          dropPosition = tragetPosArr[tragetPosArr.length - 1]
        }
        let targetIndex = dropPosition === -1 ? 0 : dropPosition
        pages.splice(targetIndex, 0, dragNodeData)
        this.spinning = true
        await this.updatePageSort(pages, id).then(data => {
          this.$message.success(this.$t('template.notify.dropPageSuccess'))
          this.getDataTree()
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
        this.spinning = false
      } else { // 拖动是分类
        if (tragetIsPage) {
          this.$message.error(this.$t('template.notify.DropCateError'))
          return false
        }
        this.spinning = true
        let seamParent = true // 默认不跨栏目
        let isInsertInto = false // 默认不是直接插入进去
        if (len1 !== len2) {
          seamParent = false
        }
        if (seamParent) {
          for (let i = 0; i <= len1 - 2; i++) {
            if (tragetPosArr[i] !== dropPosArr[i]) {
              seamParent = false
              break
            }
          }
        }
        if (dropPosition === Number(tragetPosArr[len2 - 1])) {
          isInsertInto = true
        }
        let dropNodeData = this.pagesData.slice()
        let targetNodeData = this.pagesData.slice()
        // 拿到被拖动的数据
        for (let i = 0; i <= len1 - 1; i++) {
          if (i > 0) {
            dropNodeData = dropNodeData[dropPosArr[i]]
            if (i < len1 - 1) {
              dropNodeData = dropNodeData['children']
            }
          }
        }
        // 拿到需要排序或插入的目标数据
        let parentId = 0
        if (isInsertInto) { // 直接插入
          for (let i = 0; i <= len2 - 1; i++) {
            if (i > 0) {
              targetNodeData = targetNodeData[tragetPosArr[i]]
              if (i < len2 - 1) {
                targetNodeData = targetNodeData['children']
              }
            }
          }
          this.spinning = true
          await this.insertInto(dropNodeData, targetNodeData).then(data => {
            this.$message.success(this.$t('template.notify.dropCateSuccess'))
            this.getDataTree()
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
          this.spinning = false
          return true
        } else { // 拖到某一个上下
          for (let i = 0; i <= len2 - 2; i++) {
            if (i > 0) {
              targetNodeData = targetNodeData[tragetPosArr[i]]
              parentId = targetNodeData.id
              targetNodeData = targetNodeData['children']
            }
          }
          if (seamParent) { // 拖动和目标是同一个节点下的，只需要更新顺序即可
            this.spinning = true
            let index = dropPosArr[len1 - 1]
            if (dropPosition !== -1 && dropPosition < tragetPosArr[tragetPosArr.length - 1]) {
              dropPosition = tragetPosArr[tragetPosArr.length - 1]
            }
            await this.updateCateSort(dropNodeData, targetNodeData, index, dropPosition).then(data => {
              this.$message.success(this.$t('template.notify.dropCateSuccess'))
              this.getDataTree()
            }).catch(error => {
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
            this.spinning = false
            return true
          } else { // 拖进某一个里面
            if (dropPosition !== -1 && dropPosition < tragetPosArr[tragetPosArr.length - 1]) {
              dropPosition = tragetPosArr[tragetPosArr.length - 1]
            }
            await this.insertIntoCateAndSort(dropNodeData, targetNodeData, dropPosition, parentId).then(data => {
              this.$message.success(this.$t('template.notify.dropCateSuccess'))
              this.getDataTree()
            }).catch(error => {
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
            this.spinning = false
          }
        }
      }
    },
    async updatePageSort (pages, id) {
      let params = []
      for (let item in pages) {
        let data = {
          id: id,
          page_id: pages[item]['id'],
          sort: (100 - item) * 10
        }
        params.push(data)
      }
      await pagesBatchSort(params).then(data => {
      }).catch(error => {
        this.spinning = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    async insertInto (drag, target) {
      // 更新父id
      drag.parent_id = target.id
      drag.sort = 0
      await updateCategories(drag)
      await categoriesSort(drag)
    },
    async updateCateSort (drag, target, index, newIndex) {
      this.spinning = true
      newIndex = Number(index) === 0 ? newIndex - 1 : newIndex
      newIndex = newIndex === -1 ? 0 : newIndex
      target.splice(index, 1)
      target.splice(newIndex, 0, drag)
      let sendData = []
      for (let item in target) {
        let params = {
          id: target[item].id,
          sort: (100 - item) * 10
        }
        sendData.push(params)
      }
      await categoriesBatchSort(sendData)
    },
    async insertIntoCateAndSort (drag, target, index, pid) {
      index = index === -1 ? 0 : index
      drag.parent_id = pid
      target.splice(index, 0, drag)
      updateCategories(drag)
      let sendData = []
      for (let item in target) {
        let params = {
          id: target[item].id,
          sort: (100 - item) * 10
        }
        sendData.push(params)
      }
      await categoriesBatchSort(sendData)
    },
    formatData (params) {
      let res = []
      params.forEach(item => {
        let data = {}
        data.title = JSON.parse(item.locale)[this.getLanguage]
        data.key = item.id.toString()
        data.slots = {
          icon: item.icon
        }
        data.comment = item.comment
        data.locale = item.locale
        data.type = 'menu'
        data.parent_id = item.parent_id
        data.children = []
        if (item.children.length > 0) {
          data.children = this.formatData(item.children)
        }
        if (item.pages.length > 0) {
          item.pages.forEach(i => {
            let page = {}
            page.title = JSON.parse(i.locale)[this.getLanguage]
            page.locale = i.locale
            page.key = 'parent_id_' + item.id + 'page_' + i.id
            page.type = 'page'
            page.isLeaf = true
            page.slots = {
              icon: 'file'
            }
            page.cate_id = item.id
            page.page_id = i.id
            data.children.push(page)
          })
        }
        res.push(data)
      })
      return res
    }
  },
  created () {
    this.templateId = this.$route.params.id
    this.$store.commit('SET_CURRENT_TEMPLATE_ID', this.$route.params.id)
    this.getDataTree()
    this.getTemplatePages()
  },
  computed: {
    ...mapGetters(['getTemplateTreeData', 'getCurrentCateData', 'getLanguage'])
  },
  mounted () {
    bus.$on('updateCateTreeData', data => {
      this.getDataTree()
    })
  }
}
</script>

<style scoped>
    .floatRight{
        float: right;
    }
    .rightClickMenu {
        position: fixed;
        width: 180px;
        border: 1px solid #e8e8e8;
        background: #fff;
    }
    .MenuItem{
        display: block;
        text-align: center;
        padding: 5px 10px;
        margin: 5px 0;
        color: #333;
    }
    .ant-tree-node-content-wrapper{
        width: 100%;
    }
</style>
