<template>
  <div class="erp_header">

      <div class='container' v-if="showGuide">
            <div class="fixBottom">
                <div class="pageBottom">
                     <div class="back" @click="goBack"  v-if=" srcData !== 'appeal/transition.jpg' && srcData !== 'product/transition.jpg'">
                    <img src="../../../assets/images/guide/button/back.png">
                    </div>
                    <div class="number" v-if="srcData !== 'appeal/transition.jpg' && srcData !== 'product/transition.jpg'">
                        <span style="font-size: 24px;">{{imgIndex}}</span>/ <span>{{imgTotal}}</span>

                    </div>
                    <div class="next" @click="goNext" @mouseenter="hoverEnter" @mouseleave="hoverLeave" >
                        <!-- <img :src="imgIndex < imgTotal  ? next :( srcData == 'appeal/transition.jpg' ? next :complete)"> -->
                        <div v-if="hover">
                            <img src="../../../assets/images/guide/button/next_hover.png" v-if="imgIndex < imgTotal || srcData == 'appeal/transition.jpg' || srcData == 'product/transition.jpg'">
                            <img src="../../../assets/images/guide/button/complete_hover.png" v-if="imgIndex === imgTotal && srcData !== 'appeal/transition.jpg' && srcData !== 'product/transition.jpg'">
                        </div>
                        <div v-if="!hover">
                            <img src="../../../assets/images/guide/button/next.png" v-if="imgIndex < imgTotal || srcData == 'appeal/transition.jpg' || srcData == 'product/transition.jpg'">
                            <img src="../../../assets/images/guide/button/complete.png" v-if="imgIndex === imgTotal && srcData !== 'appeal/transition.jpg' && srcData !== 'product/transition.jpg'">
                        </div>
                    </div>
                </div>

                <div class="over" @click="showGuide=false">
                    <img src="../../../assets/images/guide/button/over.png">
                </div>
            </div>
            <img :src="imgSrc">
      </div>
      <div class='popContainer' v-if="visible1">
           <div class="guide" >
                <span class="iconfont close" @click="close(1)">&#xe63e;</span>
                <img src="../../../assets/images/guide-1.png">
                <div>
                     <div style="margin-top:20px">
                         <span style="margin-right:15px"><span style="color:red">*</span> 角色选择</span>
                          <a-checkbox-group :options="plainOptions" v-model="type1"  />
                          <p style="color:red;margin-top:10px" v-if="type1.length==0">请选择角色</p>
                     </div>
                     <a-button type="primary" class="btn" @click="ok(1)">
                        开始指引
                      </a-button>

                </div>
            </div>
      </div>
       <div class='popContainer' v-if="visible2">
           <div class="guide" >
                <span class="iconfont close" @click="close(2)">&#xe63e;</span>
                <img src="../../../assets/images/guide-2.png">
                <div>
                    <!-- <a-form-model :model="{type2}" >
                        <a-form-model-item prop="type2" :rules="[{ required: true, message: '请选择角色', trigger: 'change' }]"> -->
                        <div style="margin-top:20px">
                            <span style="margin-right:15px"><span style="color:red">*</span> 角色选择</span>
                            <a-checkbox-group :options="plainOptions2" v-model="type2"  />
                            <p style="color:red;margin-top:10px" v-if="type2.length==0">请选择角色</p>
                        </div>
                        <!-- </a-form-model-item>
                    </a-form-model> -->
                     <a-button type="primary" class="btn" @click="ok(2)">
                        开始指引
                      </a-button>
                </div>
            </div>
      </div>
       <div class='popContainer' v-if="visible3">
           <div class="guide" >
                <span class="iconfont close" @click="close(3)">&#xe63e;</span>
                <img src="../../../assets/images/guide-3.png">
                <div>
                     <a-button type="primary" class="btn" @click="ok(3)">
                        开始指引
                      </a-button>
                </div>
            </div>
      </div>
       <div class='popContainer' v-if="visible4">
           <div class="guide" >
                <span class="iconfont close" @click="close(4)">&#xe63e;</span>
                <img src="../../../assets/images/guide-4.png">
                <div>
                     <a-button type="primary" class="btn" @click="ok(4)">
                        开始指引
                      </a-button>
                </div>
            </div>
      </div>
        <div class='popContainer' v-if="visible5">
           <div class="guide" >
                <span class="iconfont close" @click="close(5)">&#xe63e;</span>
                <img src="../../../assets/images/guide-5.png">
                <div>
                     <div style="margin-top:20px">
                         <span style="margin-right:15px;position: relative; top: -42px;"><span style="color:red">*</span> 角色选择</span>
                          <a-radio-group :options="plainOptions3" v-model="type3" style="width: 200px;text-align: left;" class="radio-group" />
                          <p style="color:red;margin-top:10px" v-if="type3.length==0">请选择角色</p>
                     </div>
                     <a-button type="primary" class="btn" @click="ok(5)">
                        开始指引
                      </a-button>
                </div>
            </div>
      </div>

    <a-layout-header class="header" :style="{'background':getColor}">
      <!--<a-icon class="header-trigger header-icon"-->
              <!--:type="collapsed"-->
              <!--@click="changeMenuCollapse" />-->

        <div class="menu-eidt-icon" :type="collapsed" @click="changeMenuCollapse">
            <i class="icon iconfont">&#xe6ff;</i>
        </div>
      <!--<a-button class="ErpBtn"-->
                <!--@click="goToErp"-->
                <!--shape="circle">{{$t('common.GotoErp')}}</a-button>-->
        <div class="erp-icons"  style="cursor: pointer;">
            <span title="ERP综合业务系统" class="icon iconfont" @click="goToErp">&#xe702;</span>
        </div>
        <div class="erp-icons"  style="cursor: pointer;">
            <span title="考勤系统"  @click="goTtalent"  class="icon iconfont">&#xe703;</span>
        </div>
         <div class="erp-icons"  style="cursor: pointer;">
            <span title="资源共享平台" @click="goShare" class="icon iconfont share-cion">&#xe71c;</span>
        </div>
      <div class="user-wrapper">
         <img style="margin-right:4px;" src="@/assets/images/set-f.png"  v-show="show">
          <div class="user-wrapper-operate" v-show="show">
              <a-dropdown :trigger="['click']" placement="bottomCenter" >
                 <span class="action eidt-action" title="操作指引">
                    <i class="icon iconfont">&#xe664;</i>
                 </span>
                  <a-menu slot="overlay" style="width:120px;">
                      <a-menu-item>
                          <a  rel="noopener noreferrer" @click="appealGuide"
                          >诉求管理指引</a
                          >
                      </a-menu-item>
                      <a-menu-item>
                          <a  rel="noopener noreferrer"
                           @click="productGuide"
                          >产品管理指引</a
                          >
                      </a-menu-item>
                      <a-menu-item>
                          <a  rel="noopener noreferrer"
                           @click="projectGuide"
                          >项目管理指引</a
                          >
                      </a-menu-item>
                      <a-menu-item>
                          <a  rel="noopener noreferrer"
                           @click="maintainGuide"
                          >产品维护指引</a
                          >
                      </a-menu-item>
                      <a-menu-item>
                          <a  rel="noopener noreferrer"
                           @click="bugGuide"
                          >Bug生产版本指引</a
                          >
                      </a-menu-item>
                      <a-menu-item>
                          <a  rel="noopener noreferrer"
                          href="https://cn.fs.com/YX_0evWtMz4373v/fs_sale_notice.php?actiondown=downfile&notice_file_id=4119"
                          >操作手册下载</a
                          >
                      </a-menu-item>

                  </a-menu>
              </a-dropdown>
          </div>
            <!--<img src="@/assets/images/refresh-icon.png"-->
             <!--@click="refresh"-->
             <!--style="margin-right: 20px;cursor: pointer;">-->
          <span class="action eidt-action" @click="refresh" title="刷新数据">
                <i class="icon iconfont">&#xe645;</i>
           </span>

        <!-- <a-button @click="refresh" style="margin-right: 20px;">
                <a-icon type="sync" />
                <span class="item-text">{{ $t('header.refresh') }}</span>
              </a-button> -->
            <LangSelect style="margin-right: 20px;"></LangSelect>
              <div class="user-wrapper-color">
                <a-dropdown :trigger="['click']" placement="bottomCenter">
                    <span class="action eidt-action eidt-action-color" title="主题颜色" style="height:44px;">
                        <span class="big_crice" :style="{'background':getColor}">
                            <i class="size_crice" :style="{'background':getColor}"></i>
                            </span>

                        </span>
                      <a-menu slot="overlay" style="padding:5px 4px;width: 100px">
                          <a-menu-item style="padding:0px 0px;" v-for="(item5,index5) in colorList" :key="index5" @click="selectColor(index5,item5)" @mouseenter="enter(index5,item5.color)" @mouseleave="leave">
                              <div  class="select-color-box" :style="{'background':hoverIndex==index5?hoverColor:item5.status?item5.color:'','margin-bottom': index5===colorList.length-1 ? '0' : '4px'}" :class="{ 'select-color':false}">
                                  <span class="colorLi"
                                        :key="index5"
                                        :style="{'background':item5.color}"
                                  >
                                </span>
                                  <span :style="{'color':hoverIndex==index5?textColor:item5.status?'#fff':'#666'}">{{item5.name}}</span>
                              </div>
                          </a-menu-item>

                      </a-menu>
                  </a-dropdown>
              </div>
                <a-dropdown :trigger="['click']">
          <span class="action">
            <a-avatar class="avatar"
                      size="small"
                      :src="getAuthUser.avatar"
                      v-if="getAuthUser !== null && getAuthUser.avatar !== ''" />
            <a-avatar class="avatar"
                      size="small"
                      icon="user"
                      v-else />
            <span>{{ getAuthUser ? getAuthUser.name : '' }}</span>
          </span>
          <a-menu slot="overlay">
            <a-menu-item key="0">
              <router-link :to="{ name: 'userInfoManage' }">
                <a-icon type="user" />
                <span class="item-text">{{ $t('header.center') }}</span>
              </router-link>
            </a-menu-item>
            <a-menu-item key="2">
              <a href="javascript:;"
                 @click="logout">
                <a-icon type="logout" />
                <span class="item-text">{{ $t('header.logout') }}</span>
              </a>
            </a-menu-item>
          </a-menu>
        </a-dropdown>
      </div>
    </a-layout-header>
    <div class="product"
         v-show="show">
      <ul class="classify">
        <li v-for="(item,index) in topNavList"
            :key="index"
            @click="topNavChange(item,index)"
            :class="{'active':$route.path.indexOf(item.path)!==-1}"
            :style="{'background':getColor}"
        >
          <router-link :to="{name:item.path}"><img :src="item.icon"><span>{{item.title}}</span></router-link>
        </li>
      </ul>
    </div>
  </div>

</template>

<script>

import { mapGetters } from 'vuex'
import LangSelect from '@/components/LangSelect'
import { bus } from '../../../plugins/bus'
import { checkToken } from '../../../api/auth'
const plainOptions = ['诉求人员', '产品人员']
const plainOptions2 = ['产品人员', '研发人员']
const plainOptions3 = ['提Bug人员', '研发人员', '风控团队', '产品负责人', '测试负责人']
export default {
  name: 'Header',
  components: { LangSelect },
  data () {
    return {
      hover: false,
      imgIndex: 1,
      loadIndex: 0,
      imgType: '',
      imgTotal: '',
      srcData: '',
      next: require('../../../assets/images/guide/button/next.png'),
      complete: require('../../../assets/images/guide/button/complete.png'),
      allwidth: document.body.clientWidth,
      plainOptions,
      plainOptions2,
      plainOptions3,
      activeNum: -1,
      showGuide: false,
      topNavList: [
        { title: '我的工作台', icon: require('@/assets/images/work-icon.png'), path: 'workBench' },
        { title: '诉求', icon: require('@/assets/images/appeal-icon.png'), path: 'recount' },
        { title: '产品', icon: require('@/assets/images/product-icon.png'), path: 'product' },
        { title: '项目', icon: require('@/assets/images/project-icon.png'), path: 'project' },
        { title: 'Bug', icon: require('@/assets/images/bug-icon.png'), path: 'bug' },
        { title: '产品维护', icon: require('@/assets/images/pm-icon.png'), path: 'ProductMaintenance' }
      ],
      type1: ['诉求人员'],
      type2: ['产品人员'],
      type3: '提Bug人员',
      visible1: false,
      visible2: false,
      visible3: false,
      visible4: false,
      visible5: false,
      logoutLoading: false,
      show: this.$route.path.indexOf('/RDmanagement') !== -1,
      colorList: [
        { color: '#378EEF', bgcColor: '#3180d7', name: '经典蓝', status: false },
        { color: '#0D4986', bgcColor: '#d2394e', name: '深海蓝', status: false },
        { color: '#2B3953', bgcColor: '#27334b', name: '典雅黑', status: false },
        { color: '#8D6B48', bgcColor: '#492fa9', name: '麝香褐', status: false },
        { color: '#13B5B1', bgcColor: '#492fa9', name: '薄荷绿', status: false }
      ],
      hoverColor: '#ffffff',
      hoverIndex: -1,
      textColor: '#666',
      getColor: ''
    }
  },
  computed: {
    imgSrc () {
      return require('@/assets/images/guide/' + this.srcData)
    },
    ...mapGetters(['getAuthUser', 'getMenuCollapse']),
    collapsed () {
      return this.getMenuCollapse ? 'menu-unfold' : 'menu-fold'
    }
  },
  created () {
    if (localStorage.getItem('color') !== null) {
      this.getColor = localStorage.getItem('color')
    }
    if (localStorage.getItem('colorList') !== null) {
      this.colorList = JSON.parse(localStorage.getItem('colorList'))
    }
    if (this.collapsed === 'menu-unfold') {
      let clientWidth = this.allwidth - 135
      this.$store.commit('changeValue', clientWidth)
      //            menuCollapse
    } else {
      let clientWidth = this.allwidth - 300
      this.$store.commit('changeValue', clientWidth)
    }
  },

  watch: {
    srcData (val) {
      this.srcData = val
    },
    '$store.state.recount.guidaStatus1' (val) {
      this.visible1 = val
    },
    '$store.state.recount.guidaStatus2' (val) {
      this.visible2 = val
    },
    '$store.state.recount.guidaStatus3' (val) {
      this.visible3 = val
    },
    '$store.state.recount.guidaStatus4' (val) {
      this.visible4 = val
    },
    '$store.state.recount.guidaStatus5' (val) {
      this.visible5 = val
    },
    collapsed () {
      if (this.collapsed === 'menu-unfold') {
        let clientWidth = this.allwidth - 135
        this.$store.commit('changeValue', clientWidth)
        //            menuCollapse
      } else {
        let clientWidth = this.allwidth - 300
        this.$store.commit('changeValue', clientWidth)
      }
    },
    getAuthUser (val) {
      if (!val) this.$router.push({ name: 'authLogin' })
    },
    '$route' (to, from) {
      if (to.path !== from.path) {
        this.show = this.$route.path.indexOf('/RDmanagement') !== -1
      }
    }
  },
  methods: {
    async goShare () {
      let ticket = false
      await checkToken().then(data => {
        ticket = data
      })
      window.open(process.env.VUE_APP_BROWSER_SHARE_URL + '/uums/auth/login' + '?ticket=' + ticket + '&rediect=share')
    },
    goTtalent () {
      window.open('https://www.italent.cn')
    },
    close (index) {
      if (index === 1) {
        this.visible1 = false
      } else if (index === 2) {
        this.visible2 = false
      } else if (index === 3) {
        this.visible3 = false
      } else if (index === 4) {
        this.visible4 = false
      } else if (index === 5) {
        this.visible5 = false
      }
    },
    hoverEnter () {
      this.hover = true
    },
    hoverLeave () {
      this.hover = false
    },
    ok (index) {
      if (index === 1) {
        if (this.type1.length > 0) {
          this.visible1 = false
          this.showGuide = true
          this.imgIndex = 1
          if (this.type1.indexOf('诉求人员') !== -1 && this.type1.indexOf('产品人员') === -1) {
            this.imgTotal = 9
            this.imgType = 1
            this.srcData = 'appeal/petitioner/petitioner-' + this.imgIndex + '.jpg'
          } else if (this.type1.indexOf('诉求人员') === -1 && this.type1.indexOf('产品人员') !== -1) {
            this.imgTotal = 17
            this.imgType = 11
            this.srcData = 'appeal/product/product-' + this.imgIndex + '.jpg'
          } else {
            this.imgTotal = 9
            this.imgType = 12
            this.srcData = 'appeal/petitioner/petitioner-' + this.imgIndex + '.jpg'
          }
        }
      } else if (index === 2) {
        if (this.type2.length > 0) {
          this.visible2 = false
          this.showGuide = true
          this.imgIndex = 1
          if (this.type2.indexOf('产品人员') !== -1 && this.type2.indexOf('研发人员') === -1) {
            this.imgTotal = 14
            this.imgType = 2
            this.srcData = 'product/product/product-' + this.imgIndex + '.jpg'
          } else if (this.type2.indexOf('研发人员') !== -1 && this.type2.indexOf('产品人员') === -1) {
            this.imgTotal = 22
            this.imgType = 21
            this.srcData = 'product/dev/dev-' + this.imgIndex + '.jpg'
          } else {
            this.imgTotal = 14
            this.imgType = 22
            this.srcData = 'product/product/product-' + this.imgIndex + '.jpg'
          }
        }
      } else if (index === 3) {
        this.visible3 = false
        this.showGuide = true
        this.imgIndex = 1
        this.imgTotal = 10
        this.imgType = 3
        this.srcData = 'project/project-' + this.imgIndex + '.jpg'
      } else if (index === 4) {
        this.visible4 = false
        this.showGuide = true
        this.imgIndex = 1
        this.imgTotal = 9
        this.imgType = 4
        this.srcData = 'pm/pm-' + this.imgIndex + '.jpg'
      } else if (index === 5) {
        this.visible5 = false
        this.showGuide = true
        this.imgIndex = 1
        if (this.type3 === '提Bug人员') {
          this.imgTotal = 10
          this.imgType = 51
          this.srcData = 'bug/picker/picker-' + this.imgIndex + '.jpg'
        } else if (this.type3 === '研发人员') {
          this.imgTotal = 8
          this.imgType = 52
          this.srcData = 'bug/dev/dev-' + this.imgIndex + '.jpg'
        } else if (this.type3 === '风控团队') {
          this.imgTotal = 4
          this.imgType = 53
          this.srcData = 'bug/risk/risk-' + this.imgIndex + '.jpg'
        } else if (this.type3 === '产品负责人') {
          this.imgTotal = 8
          this.imgType = 54
          this.srcData = 'bug/product/product-' + this.imgIndex + '.jpg'
        } else if (this.type3 === '测试负责人') {
          this.imgTotal = 4
          this.imgType = 55
          this.srcData = 'bug/test/test-' + this.imgIndex + '.jpg'
        }
      }
    },
    goNext () {
      if (this.imgIndex < this.imgTotal) {
        this.imgIndex = this.imgIndex + 1
        if (this.imgType === 1) {
          this.srcData = 'appeal/petitioner/petitioner-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 11) {
          this.srcData = 'appeal/product/product-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 12) {
          this.srcData = 'appeal/petitioner/petitioner-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 2) {
          this.srcData = 'product/product/product-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 21) {
          this.srcData = 'product/dev/dev-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 22) {
          this.srcData = 'product/product/product-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 3) {
          this.srcData = 'project/project-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 4) {
          this.srcData = 'pm/pm-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 51) {
          this.srcData = 'bug/picker/picker-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 52) {
          this.srcData = 'bug/dev/dev-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 53) {
          this.srcData = 'bug/risk/risk-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 54) {
          this.srcData = 'bug/product/product-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 55) {
          this.srcData = 'bug/test/test-' + this.imgIndex + '.jpg'
        }
      } else {
        if (this.imgType === 12) {
          if (this.imgIndex === this.imgTotal) {
            if (this.loadIndex) {
              this.imgIndex = 1
              this.imgTotal = 17
              this.imgType = 11
              this.srcData = 'appeal/product/product-' + this.imgIndex + '.jpg'
              this.loadIndex = 0
            } else {
              this.srcData = 'appeal/transition.jpg'
              this.loadIndex = 1
            }
          }
        } else if (this.imgType === 22) {
          if (this.loadIndex) {
            this.imgIndex = 1
            this.imgTotal = 22
            this.imgType = 21
            this.srcData = 'product/dev/dev-' + this.imgIndex + '.jpg'
            this.loadIndex = 0
          } else {
            this.srcData = 'product/transition.jpg'
            this.loadIndex = 1
          }
        } else {
          this.showGuide = false
        }
      }
    },
    loading () {

    },
    goBack () {
      if (this.imgIndex > 1) {
        this.imgIndex = this.imgIndex - 1
        if (this.imgType === 1) {
          this.srcData = 'appeal/petitioner/petitioner-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 11) {
          this.srcData = 'appeal/product/product-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 12) {
          this.srcData = 'appeal/petitioner/petitioner-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 2) {
          this.srcData = 'product/product/product-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 21) {
          this.srcData = 'product/dev/dev-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 22) {
          this.srcData = 'product/product/product-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 3) {
          this.srcData = 'project/project-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 4) {
          this.srcData = 'pm/pm-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 51) {
          this.srcData = 'bug/picker/picker-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 52) {
          this.srcData = 'bug/dev/dev-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 53) {
          this.srcData = 'bug/risk/risk-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 54) {
          this.srcData = 'bug/product/product-' + this.imgIndex + '.jpg'
        } else if (this.imgType === 55) {
          this.srcData = 'bug/test/test-' + this.imgIndex + '.jpg'
        }
      }
    },
    appealGuide () {
      this.visible1 = true
    },
    productGuide () {
      this.visible2 = true
    },
    projectGuide () {
      this.visible3 = true
    },
    maintainGuide () {
      this.visible4 = true
    },
    bugGuide () {
      this.visible5 = true
    },

    enter (index, color) {
      this.hoverIndex = index
      this.hoverColor = color
      this.textColor = '#fff'
    },
    leave () {
      this.hoverIndex = -1
      this.hoverColor = '#fff'
      this.textColor = '#666'
    },
    selectColor (index, item) {
      this.hoverIndex = index
      this.colorList.map((k, index2) => {
        if (index === index2) {
          k.status = true
        } else {
          k.status = false
        }
      })
      this.hoverColor = item.color
      this.textColor = '#fff'
      localStorage.setItem('colorList', JSON.stringify(this.colorList))
      localStorage.setItem('color', this.hoverColor)
      this.getColor = localStorage.getItem('color')
    },
    topNavChange (item, index) {
    //   this.activeNum = index
      // this.$router.push({ name: item.path })
    },
    changeMenuCollapse () {
      this.$store.dispatch('setMenuCollapse', !this.getMenuCollapse)
    },
    logout () {
      this.$confirm({
        title: this.$t('header.logoutConfirm'),
        confirmLoading: this.logoutLoading,
        onOk: async () => {
          this.logoutLoading = true
          localStorage.removeItem('token')
          localStorage.removeItem('demandPage')
          localStorage.removeItem('designPage')
          await this.$store.dispatch('logout').then(() => {
            this.logoutLoading = false
          }).catch(err => {
            this.$message.error(err.response.data.message || err.message)
          })
        }
      })
    },
    async refresh () {
      await this.$store.dispatch('refresh').then(data => {
        this.$message.success(this.$t('header.refreshSuccess'))
        window.location.reload()
      }).catch(err => {
        this.$message.error(err.response.data.message || err.message)
      })
      bus.$emit('updateMenu')
    },
    async goToErp () {
      let ticket = false
      await checkToken().then(data => {
        ticket = data
      })
      window.open(process.env.VUE_APP_ERP_URL + '?ticket=' + ticket)
    }
  }
}
</script>
<style scoped lang="less">
    .share-icon{
        vertical-align: -2px;
    }
    /deep/ .ant-modal-content .ant-modal-body{
        padding:20px !important;
    }
    .radio-group /deep/.ant-radio-wrapper{
        width: 90px;
    }
.fixBottom{
    background-color: rgba(0, 0, 0, .25);
    position: fixed;
    bottom: 10px;
    width: 100%;
    height: 90px;
}
.container{
    position: fixed;
    overflow-y:auto;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    .pageBottom{
         position: absolute;
         left: 50%;
         top: 50%;
         transform: translate(-50%,-50%);
         display: flex;
    }
    .back{
        height: 50px;
        cursor: pointer;
        &:hover{
             background-image: url('../../../assets/images/guide/button/back_hover.png');
        }
         &:hover img{
             opacity: 0;
         }
    }
    .next{
        cursor: pointer;
    }
    .number{
        font-size: 16px;
        color: #fff;
        line-height: 50px;
        padding: 0 20px;
    }
    .over{
        position: absolute;
        top: 20px;
        left: 91%;
        cursor: pointer;
        &:hover{
             background-image: url('../../../assets/images/guide/button/over_hover.png');
        }
         &:hover img{
             opacity: 0;
         }

    }
    // background-image: url('../../../assets/images/guide/acquirer-1.jpg');
    // background-size: contain;
    // background-position: center;
    // background-repeat: no-repeat;
    // background-color: black;
    z-index: 10000;
}
.popContainer{
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    // background: rgba(0,0,0,0.3);
    z-index: 10000;
    .close{
        font-size: 14px;
        position: absolute;
        right: 20px;
        top: 20px;
        z-index: 1000;
        cursor: pointer;
        color: #fff;
    }
    .guide{
        position: absolute;
        left: 50%;
        top: 50%;
        transform:translate(-50%,-50%);
        text-align: center;
        width:380px;
        // height:472px;
        background:rgba(255,255,255,1);
        box-shadow:0px 5px 15px 0px rgba(223,226,230,0.8);
        border-radius:8px;
        .btn{
            margin: 20px 0;
        }
        img{
            position: relative;
            left: -68px;
        }
    }
}

.menu-eidt-icon{
    display: inline-block;
    cursor: pointer;
}
.menu-eidt-icon i{
    font-size: 18px;
    color: #fff;
    margin-left: 24px;
}
.erp-icons{
     display: inline-block;
 }
.erp-icons span{
    font-size: 18px;
    color: #fff;
    margin-left: 20px;
}
.active {
  background-color: RGBA(46, 129, 216, 1);
}

.header {
  height: 64px;
  padding: 0 12px 0 0;
  background: #378eef;
  -webkit-box-shadow: 0 1px 4px rgba(0, 21, 41, 0.08);
  box-shadow: 0 1px 4px rgba(0, 21, 41, 0.08);
  position: relative;
  .user-wrapper {
    float: right;
    height: 100%;
      display: flex;
      align-items: center;
    .action {
      cursor: pointer;
      margin-right:20px;
      display: inline-block;
      transition: all 0.3s;
      color: rgba(0, 0, 0, 0.65);

      &:hover {
        background: rgba(0, 0, 0, 0.025);
      }

      .avatar {
        margin: 20px 8px 20px 0;
        /*color: #1890ff;*/
        /*background: hsla(0, 0%, 100%, 0.85);*/
        //background: #1890ff;
        vertical-align: middle;
      }
    }
  }
    .eidt-action i{
        font-size: 17px;
        color:#ffffff;
        /*position: relative;*/
        /*top: 2px;*/
    }
    .big_crice{
        display: block;
        width:17px;
        height:17px;
        background:rgba(55,142,239,1);
        border:1px solid rgba(255,255,255,1);
        border-radius:50%;
        line-height: 17px;
        text-align: center;
        position: relative;
        top:2px;
    }
    .size_crice{
        display: inline-block;
        text-align: center;
        width:13px;
        height:13px;
        background:rgba(55,142,239,0.5);
        border:1px solid rgba(255,255,255,0.5);
        border-radius:50%;
    }
}

.item-text {
  margin: 0 10px;
}

.header-trigger {
  font-size: 20px;
  line-height: 64px;
  padding: 0 24px;
  cursor: pointer;
  transition: color 0.3s;

  &:hover {
    background: rgba(0, 0, 0, 0.025);
  }
}
.ErpBtn {
  background: #ffb6c1;
}

.erp_header {
  position: relative;
  .product {
    color: #fff;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    .classify {
      display: flex;
      li {
        .router-link-active {
            background-color: rgba(0, 0, 0, 0.1);
        }

        a {
          display: inline-block;
          height: 64px;
          line-height: 64px;
          cursor: pointer;
          color: #fff;
          font-size: 15px;
          padding: 0 24px;
          text-decoration: none;
        }
        img {
          vertical-align: middle;
          margin-right: 10px;
          position: relative;
          top: -2px;
        }
      }
    }
  }
}
  @media screen and (max-width: 1600px) {
            .erp_header .product .classify li a {
                    padding: 0 8px;
                }
        }
@media screen and (max-width: 1400px) {
            .erp_header .product  {
                    left:40%;
                }
        }
.colorLi {
    margin-right:10px;
    display: block;
    width: 14px;
    height: 14px;
    border: 1px solid rgba(255, 255, 255, 1);
    border-radius: 50%;
}
    .select-color-box{
        display: flex;
        align-items: center;
        border-radius: 3px;
        padding: 5px  10px 4px 5px;
        margin-bottom:4px;
    }

</style>
