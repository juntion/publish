<template>
  <div class="settings-info">
    <div class="setting-bg"></div>
    <a-card :bordered="false" :bodyStyle="{ padding: '0', height: '100%' }" :style="{ height: '100%', width: '840px', margin: '150px auto', boxShadow: '1px 3px 10px 1px rgba(0, 0, 0, 0.15)' }">
      <div class="settings-info-main">
        <div class="settings-info-left">
          <a-menu
            mode="inline"
            :style="{ border: '0', width: 'auto', backgroundColor: 'rgba(0, 0, 0, 0)'}"
            :defaultSelectedKeys="defaultSelectedKeys"
            type="inner"
            @openChange="onOpenChange">
            <a-menu-item key="BaseSettings" style="padding-left: 64px;font-size:12px;">
              <router-link :to="{ name: 'BaseSettings' }">
                <i class="iconfont icon-basicsetting"></i>{{ $t('system.settings.baseSetting') }}
              </router-link>
            </a-menu-item>
            <a-menu-item key="AvatarSetting" style="padding-left: 64px;font-size:12px;">
              <router-link :to="{ name: 'AvatarSetting' }">
                <i class="iconfont icon-headportrait"></i>{{ $t('system.settings.AvatarSetting') }}
              </router-link>
            </a-menu-item>
            <a-menu-item key="PasswordSettings" style="padding-left: 64px;font-size:12px;">
              <router-link :to="{ name: 'PasswordSettings' }">
                <i class="iconfont icon-ChangePassword"></i>{{ $t('system.settings.passwordSetting') }}
              </router-link>
            </a-menu-item>
            <a-menu-item key="PositionSetting" v-if="canSetPosition" style="padding-left: 64px;font-size:12px;">
              <router-link :to="{ name: 'PositionSetting' }">
                <i class="iconfont icon-titlemanagement"></i>{{ $t('system.settings.PositionSetting') }}
              </router-link>
            </a-menu-item>
            <a-menu-item key="loginLog" style="padding-left: 64px;font-size:12px;">
              <router-link :to="{ name: 'loginLog' }">
                <i class="iconfont icon-record"></i>{{ $t('system.settings.loginLog') }}
              </router-link>
            </a-menu-item>
          </a-menu>
        </div>
        <div class="settings-info-right">
          <!--
          <div class="settings-info-title">
            <span>{{ $t('routers.' + $route.name + 'Title') }}</span>
          </div>
          -->
          <router-view></router-view>
        </div>
      </div>
    </a-card>
  </div>
</template>

<script>
export default {
  name: 'Index',
  data () {
    return {
      defaultSelectedKeys: [],
      openKeys: [],
      canSetPosition: false
    }
  },
  created () {
    this.updateMenu()
  },
  methods: {
    onOpenChange (openKeys) {
      this.openKeys = openKeys
    },
    updateMenu () {
      let canSetPositionLevelsArr = [2, 5, 13, 23, 24, 25]
      const routes = this.$route.matched.concat()
      this.defaultSelectedKeys = [routes.pop().name]
      let userLevel = JSON.parse(localStorage.getItem('user'))['admin_level']
      if (canSetPositionLevelsArr.indexOf(Number(userLevel)) !== -1) {
        this.canSetPosition = true
      }
    }
  }
}
</script>

<style lang="less" scoped>
  @bg_url: '../../../assets/images/'; //图片路径
  @import '../../../assets/css/vari.less';

  .iconfont {
    color: #999;
    margin-right: 10px;
  }

  .settings-info {
    display: flex;

    .setting-bg {
      position: absolute;
      width: 100%;
      height: 100%;
      left: 0;
      top: 0;
      background: url('@{bg_url}/settings_bg.png') no-repeat center;
    }
  }

  .settings-info-main {
    width: 100%;
    display: flex;
    height: 100%;
    overflow: auto;
    height: 460px;

    &.mobile {
      display: block;

      .settings-info-left {
        border-right: unset;
        background-color: #fbfbfb;
        width: 100%;
        height: 50px;
        overflow-x: auto;
        overflow-y: scroll;
        padding-top: 18px;
        padding-bottom: 18px;
      }

      .settings-info-right {
        padding: 30px;
      }
    }

    .settings-info-left {
      background-color: #fbfbfb;
      width: 200px;
      padding-top: 18px;
      padding-bottom: 18px;
      height: 100%;
    }

    .settings-info-right {
      flex: 1 1;
      padding: 30px;

      .settings-info-title {
        color: rgba(0, 0, 0, .85);
        font-size: 20px;
        font-weight: 500;
        line-height: 28px;
        margin-bottom: 12px;
      }

      .settings-info-view {
        padding-top: 12px;
      }
    }
  }
</style>

<style lang="less">
.settings-info-left {
  .ant-menu:not(.ant-menu-horizontal) .ant-menu-item-selected {
    background-color: #ebf3ff;
  }

  .ant-menu-item-selected {
    >a {
      color: #378eef;

      .iconfont {
        color: inherit;
      }
    }
  }

  a:hover {
    color: #378eef;

    .iconfont {
      color: inherit;
    }
  }

  .ant-menu-item-selected::after {
    border-color: #378eef;
  }
}

.settings-info-right {

  .ant-form-explain {
    position: absolute;
    right: 0;
    font-size: 12px;
    line-height: 14px;
    padding-top: 5px;
    text-align: right;
    color: #ff4a4a;
  }

  .ant-form-item-control-wrapper {
    width: 100%;
  }

  .setting-title {
    font-size: 12px;
    color: #bbb;
    line-height: 12px;
    margin-bottom: 30px;
  }

  .p-input {

    input {
      border: 0;
      outline: none;
      font-size: 12px;
      padding-left: 0;
    }

    input:focus, input:hover {
      border-color: #ccc;
      box-shadow: 0 0 0 0 rgba(0, 0, 0, 0)
    }
  }

  .has-error .ant-input-affix-wrapper .ant-input:hover, .has-error .ant-input-affix-wrapper .ant-input:focus {
     box-shadow: 0 0 0 0 rgba(0, 0, 0, 0)
  }

  .has-error .ant-input-affix-wrapper.p-input {
    border-color: #ff4a4a;
  }
}
</style>
