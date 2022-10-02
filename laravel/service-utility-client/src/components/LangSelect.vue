<template>
  <!--<a-select :defaultValue="getLanguage" style="width: 80px" @change="handleSetLanguage">-->
    <!--<a-select class="eidt-selet-lang" style="width: 80px" @change="handleSetLanguage">-->
    <!--<a-icon slot="suffixIcon" type="global" />-->
    <!--<a-select-option-->
            <!--v-for="(item, key) in languages"-->
            <!--:value="key"-->
            <!--:key="key"-->
    <!--&gt;-->
      <!--{{item}}-->
    <!--</a-select-option>-->
  <!--</a-select>-->
    <!--新加-->
    <a-dropdown class="eidt-dropdown" :trigger="['click']" placement="bottomCenter">
        <a class="ant-dropdown-link"  title="语言选择" @click="e => e.preventDefault()">
            <i class="icon iconfont">&#xe64b;</i>
        </a>
        <a-menu slot="overlay" style="width: 100px;text-align: center;">
            <a-menu-item>
                <a href="javascript:;" @click="handleSetLanguage('zh-CN')">中文</a>
            </a-menu-item>
            <a-menu-item>
                <a href="javascript:;" @click="handleSetLanguage('en')">English</a>
            </a-menu-item>
        </a-menu>
    </a-dropdown>
</template>

<script>
import { mapGetters } from 'vuex'
import { languages } from '../plugins/lang'
import { getDomain } from '../plugins/common'
import Cookie from 'js-cookie'

export default {
  data () {
    return {
      languages: languages
    }
  },
  computed: {
    ...mapGetters(['getLanguage'])
  },
  methods: {
    handleSetLanguage (val) {
      let lang = val
      Cookie.set('switch_language', lang, { path: '/', domain: getDomain() })
      this.$i18n.locale = lang
      this.$store.dispatch('setLanguage', lang)
    }
  }
}
</script>

<style lang="less" scoped>
    .user-wrapper /deep/ .ant-select-selection-selected-value{
        display: none !important;
    }
    .eidt-dropdown .iconfont{
        color:#fff;
        font-size: 17px;
    }
</style>
