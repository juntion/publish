<template>
  <div style="display: inline;position: relative;">
    <span @click="showMore"
          style="cursor: pointer;">
      高级筛选
      <a-icon type="down" />
    </span>

    <div class="modal" v-if="showSearch" @click="showSearch=false">
        <div class="searchMore"
            @click.stop="showSearch=true"
         >
            <div class="search">
                <div class="from">
                <a-form>
                    <div style="text-align:right;margin:0 20px 20px 20px;padding-top:20px;"
                        class="header">
                    <a-select v-model="data.andOr"
                                style="width: 60px;margin-left:20px;"
                                class="left">
                        <a-select-option value="and">且</a-select-option>
                        <a-select-option value="or">或</a-select-option>
                    </a-select>
                    <span @click="add"
                            class="addPM">
                        <a-icon type="plus" /> 新增条件
                    </span>
                    </div>
                    <div class="saixuan">

                        <div v-for="(item,index) in data.form" :key="index"  class="saixuan-box">
                            <a-select
                                        placeholder="请选择"
                                        v-model="item.condition"
                                        style="width: 128px;margin-right:10px"
                                        @change="handleChange($event,item)">
                                <a-select-option value="productLine">产品线</a-select-option>
                                <a-select-option value="productName">产品名称</a-select-option>
                                <a-select-option value="productModule">产品模块</a-select-option>
                                <a-select-option value="productCategory">模块标签</a-select-option>
                                <a-select-option value="productManager">产品负责人</a-select-option>
                                <a-select-option value="designMainManager">设计主负责人</a-select-option>
                                <a-select-option value="devManager">开发负责人</a-select-option>
                                <a-select-option value="testManager">测试负责人</a-select-option>
                                <a-select-option value="productMembers">产品成员</a-select-option>
                                <a-select-option value="interactionManager">交互负责人</a-select-option>
                                <a-select-option value="visualManager">视觉负责人</a-select-option>
                                <a-select-option value="frontEndManager">前端负责人</a-select-option>
                                <a-select-option value="mobileManager">移动负责人</a-select-option>
                                <a-select-option value="UIManager">美工负责人</a-select-option>
                                <a-select-option value="status">状态</a-select-option>
                                <a-select-option value="created_at">创建时间</a-select-option>
                                <a-select-option value="description">产品简介</a-select-option>
                            </a-select>
                            <a-select placeholder="请选择"
                                        style="width: 128px;margin-right:10px"
                                        v-model="item.judge"
                                    >
                                <a-select-option value="is" v-if="item.condition != 'created_at'">是</a-select-option>
                                <a-select-option value="like" v-if="item.condition == 'description' ">包含</a-select-option>
                                <a-select-option value="like" v-if="item.condition == 'productLine'">包含</a-select-option>
                                <a-select-option value="like" v-if="item.condition == 'productName'">包含</a-select-option>
                                <a-select-option value="like" v-if="item.condition ==  'productModule'">包含</a-select-option>
                                <a-select-option value="like" v-if="item.condition == 'productCategory'">包含</a-select-option>
                            </a-select>

                            <a-range-picker

                                        v-if="item.condition == 'created_at'"
                                        v-model="item.value"
                                        class="last"
                                    />
                            <!-- 人员下拉框 -->
                            <a-select    v-else-if="item.condition == 'productManager'"
                                        v-model="item.value"
                                        showSearch
                                        optionFilterProp="children"
                                        placeholder="请输入英文名搜索"
                                        @search="search"
                                        class="last"
                                        >
                                <a-select-option :value="item.id" v-for="item in options_2" :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                            <a-select    v-else-if="item.condition == 'productMembers'"
                                        v-model="item.value"
                                        showSearch
                                        optionFilterProp="children"
                                        placeholder="请输入英文名搜索"
                                        @search="search"
                                        class="last"
                                        >
                                <a-select-option :value="item.id" v-for="item in options_2" :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                            <a-select   v-else-if="item.condition == 'designMainManager'"
                                        v-model="item.value"
                                        showSearch
                                        optionFilterProp="children"
                                        placeholder="请输入英文名搜索"
                                        @search="search"
                                        class="last"
                                        >
                                <a-select-option :value="item.id" v-for="item in options_2" :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                            <a-select   v-else-if="item.condition == 'devManager'"
                                        v-model="item.value"
                                        showSearch
                                        optionFilterProp="children"
                                        placeholder="请输入英文名搜索"
                                        @search="search"
                                        class="last"
                                        >
                                <a-select-option :value="item.id" v-for="item in options_2" :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                            <a-select   v-else-if="item.condition == 'testManager'"
                                        v-model="item.value"
                                        showSearch
                                        optionFilterProp="children"
                                        placeholder="请输入英文名搜索"
                                        @search="search"
                                        class="last"
                                        >
                                <a-select-option :value="item.id" v-for="item in options_2" :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                            <a-select   v-else-if="item.condition == 'interactionManager'"
                                        v-model="item.value"
                                        showSearch
                                        optionFilterProp="children"
                                        placeholder="请输入英文名搜索"
                                        @search="search"
                                        class="last"
                                        >
                                <a-select-option :value="item.id" v-for="item in options_2" :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                            <a-select   v-else-if="item.condition == 'visualManager'"
                                        v-model="item.value"
                                        showSearch
                                        optionFilterProp="children"
                                        placeholder="请输入英文名搜索"
                                        @search="search"
                                        class="last"
                                        >
                                <a-select-option :value="item.id" v-for="item in options_2" :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                            <a-select   v-else-if="item.condition == 'frontEndManager'"
                                        v-model="item.value"
                                        showSearch
                                        optionFilterProp="children"
                                        placeholder="请输入英文名搜索"
                                        @search="search"
                                        class="last"
                                        >
                                <a-select-option :value="item.id" v-for="item in options_2" :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                            <a-select   v-else-if="item.condition == 'mobileManager'"
                                        v-model="item.value"
                                        showSearch
                                        optionFilterProp="children"
                                        placeholder="请输入英文名搜索"
                                        @search="search"
                                        class="last"
                                        >
                                <a-select-option :value="item.id" v-for="item in options_2" :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                            <a-select   v-else-if="item.condition == 'UIManager'"
                                        v-model="item.value"
                                        showSearch
                                        optionFilterProp="children"
                                        placeholder="请输入英文名搜索"
                                        @search="search"
                                        class="last"
                                        >
                                <a-select-option :value="item.id" v-for="item in options_2" :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                            <!-- 人员下拉框 -->

                            <a-select   v-else-if="item.condition == 'status'"
                                        v-model="item.value"
                                        placeholder="请选择"
                                        class="last"
                                        >
                                <a-select-option value="1" >开启中</a-select-option>
                                <a-select-option value="0" >关闭中</a-select-option>
                            </a-select>
                            <a-input placeholder="请输入"
                                    class="last"
                                    v-model="item.value"
                                    v-else-if="item.condition == 'description' || 'productLine' || 'productName' || 'productModule' || 'productCategory'"/>

                            <span v-if="data.form.length > 1"
                                    class="dynamic-delete-button iconfont"
                                    type="close"
                                    @click="() => remove(index)">&#xe631;</span>
                        </div>
                    </div>
                     <div class="btn">
                        <a-button type="primary"
                            @click="screen"
                            >筛选</a-button>
                    </div>
                </a-form>
                </div>
            </div>
        </div>
    </div>

  </div>
</template>
<script>

import { getProductMember, getProductPrincipal, getdesignPrincipal, getdevPrincipal, getTestPrincipal, getInteractionPrincipal, getVisionPrincipal, getFrontEndPrincipal, getMobilePrincipal, getArtistPrincipal } from '@/api/RDmanagement/dropDown'
import { searchUserList } from '@/api/userManage/index.js'
import moment from 'moment'
export default {
  data () {
    return {
      showSearch: false,
      data: {
        andOr: 'and',
        form: [
          { condition: undefined, judge: undefined, value: undefined },
          { condition: undefined, judge: undefined, value: undefined },
          { condition: undefined, judge: undefined, value: undefined }
        ]
      },
      productManager: [],
      designMainManager: [],
      devManager: [],
      testManager: [],
      productMembers: [],
      interactionManager: [],
      visualManager: [],
      frontEndManager: [],
      mobileManager: [],
      UIManager: [],
      options_2: []
    }
  },
  created () {
    getProductPrincipal().then(res => {
      this.productManager = res.data.users
    })
    getdesignPrincipal().then(res => {
      this.designMainManager = res.data.users
    })
    getdevPrincipal().then(res => {
      this.devManager = res.data.users
    })
    getTestPrincipal().then(res => {
      this.testManager = res.data.users
    })
    getProductMember().then(res => {
      this.productMembers = res.data.users
    })
    getInteractionPrincipal().then(res => {
      this.interactionManager = res.data.users
    })
    getVisionPrincipal().then(res => {
      this.visualManager = res.data.users
    })
    getFrontEndPrincipal().then(res => {
      this.frontEndManager = res.data.users
    })
    getMobilePrincipal().then(res => {
      this.mobileManager = res.data.users
    })
    getArtistPrincipal().then(res => {
      this.UIManager = res.data.users
    })
  },
  methods: {
    moment,
    search (e) {
      this.$nextTick(() => {
        let self = this
        this.timer = searchUserList(this.timer, e, function (data) {
          self.options_2 = data.data.users
        })
      })
    },
    screen () {
      let data = JSON.parse(JSON.stringify(this.data))
      data.form.map(item => {
        if (item.condition === 'created_at') {
          if (item.value) {
            item.value[0] = moment(item.value[0]).format('YYYY-MM-DD')
            item.value[1] = moment(item.value[1]).format('YYYY-MM-DD')
          }
        }
      })
      this.$emit('search', data)
    },
    showMore () {
      this.showSearch = !this.showSearch
    },
    handleChange (e, item) {
      item.value = undefined
      item.judge = undefined
    },
    remove (index) {
      this.data.form.splice(index, 1)
    },
    add () {
      this.data.form.push({ condition: undefined, judge: undefined, value: undefined })
    }
  }
}
</script>
<style lang="less" scoped>
.last{
    width: 232px;
    margin-right:10px
}
.modal{
    // background: rgba(0, 0, 0, 0.6);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 10;
}
.searchMore {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  top: 200px;
  width: 570px;
  background-color: #fff;
  z-index: 100;
  box-shadow:0px 8px 25px 0px rgba(102,102,102,0.25);
}
.ant-form-item {
  margin-bottom: 16px !important;
}
.header {
  height: 62px;
  line-height: 32px;
  border-bottom: 1px solid #ccdfe2e6;
}

.left {
  position: absolute;
  top: 20px;
  left: 0;
}
.form {
  max-height: 660px;
}
.addPM {

  cursor: pointer;
  font-size: 12px;
  color:#378EEF;
}
.dynamic-delete-button {
  cursor: pointer;
  position: relative;
  top: 0px;
  font-size: 12px;
  color: #bbbbbb;
  transition: all 0.3s;
}
.dynamic-delete-button:hover {
  color: #777;
}
.dynamic-delete-button[disabled] {
  cursor: not-allowed;
  opacity: 0.5;
}
</style>
