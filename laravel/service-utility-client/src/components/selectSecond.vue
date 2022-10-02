<template>
  <div class="p-select-second" v-clickoutside="handleClose">
    <div class="select-value" v-html="selectValue" @click="showOptions"></div>
    <i class="iconfont icondown_defalut"  @click="showOptions"></i>
    <div class="options" v-show="showflag">
      <ul>
        <li v-for="(item, i) in data" :key="i" :class="item.child.length > 0 ? 'more' : ''">
          <div :title="item.text"  @click="() => selectVal(item)">{{ item.text }}</div>
          <ul v-if="item.child.length > 0">
            <template v-for="child in item.child">
              <li :key="child.id" v-if="child.id !== dataId"><div :title="child.text" @click="() => selectVal(child, item.text)">{{ child.text }}</div></li>
            </template>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
const clickoutside = {
  // 初始化指令
  bind (el, binding, vnode) {
    let documentHandler = (e) => {
      // 这里判断点击的元素是否是本身，是本身，则返回
      if (el.contains(e.target)) {
        return false
      }
      // 判断指令中是否绑定了函数
      if (binding.expression) {
        // 如果绑定了函数 则调用那个函数，此处binding.value就是handleClose方法
        binding.value(e)
      }
    }
    // 给当前元素绑定个私有变量，方便在unbind中可以解除事件监听
    el.__vueClickOutside__ = documentHandler
    document.addEventListener('click', documentHandler)
  },
  update () {},
  unbind (el, binding) {
    // 解除事件监听
    document.removeEventListener('click', el.__vueClickOutside__)
    delete el.__vueClickOutside__
  }
}

export default {
  name: 'selectSecond',
  data () {
    return {
      selectValue: '',
      showflag: false
    }
  },
  props: {
    data: Array,
    defaultValue: String,
    dataId: Number
  },
  mounted () {
    this.selectValue = this.defaultValue ? this.defaultValue : ''
  },
  directives: { clickoutside },
  methods: {
    showOptions () {
      this.showflag = !this.showflag
    },
    selectVal (data, text) {
      if (data.child.length === 0) {
        if (text) {
          this.selectValue = text
        } else {
          this.selectValue = data.text
        }
        data['dataId'] = this.dataId
        this.showflag = false
        this.$emit('getSelectValue', data)
      }
    },
    handleClose (e) {
      this.showflag = false
    }
  }
}
</script>

<style lang="less" scoped>
.p-select-second {
  height: 32px;
  border-radius: 3px;
  position: relative;

  .select-value {
    border: 1px solid #ccc;
    line-height: 30px;
    padding: 0 10px;
    cursor: pointer;
    background-color: #fff;
    border-radius: 3px;
  }
  .select-value:empty::after {
    content: '请选择';
  }
  .options {
    position: absolute;
    width: 100%;
    top: 38px;
    left: 0;
    box-shadow: 0px 8px 30px 0px rgba(102,102,102,0.25);
    border-radius: 3px;
    background-color: #fff;
    z-index: 2;

    ul {
      padding: 4px 0;
      background-color: #fff;
    }
    li {
      line-height: 32px;
      cursor: pointer;
      position: relative;

      >div {
        padding: 0 10px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
      }
      >ul {
        width: 260px;
        position: absolute;
        right: -268px;
        top: -4px;
        box-shadow: 0px 8px 30px 0px rgba(102,102,102,0.25);
        border-radius: 3px;
        display: none;
        max-height: 320px;
        overflow: auto;
      }
    }
    li.more>div {
      padding-right: 18px;
    }
    li:hover {
      >ul {
        display: block;
      }
    }
    li.more::after {
      content: '\e605';
      font-family: iconfont;
      display: block;
      transform: rotate(-90deg);
      position: absolute;
      right: 6px;
      line-height: 32px;
      top: 0;
    }
    li:hover {
      background-color: #eee;
    }
    >ul>li::before {
      content: '';
      display: block;
      position: absolute;
      height: 100%;
      width: 8px;
      right: -8px;
      top: 0;
    }
  }
  .options::after {
    content: '';
    display: block;
    position: absolute;
    height: 6px;
    width: 100%;
    top: -6px;
  }
}
.p-select-second .icondown_defalut {
  position: absolute;
  right: 10px;
  top: 0px;
  line-height: 32px;
  cursor: pointer;
  font-size: 12px;
}
.p-select-second.toTop {
  .options {
    top: auto;
    bottom: 38px;

    li>ul {
      top: auto;
      bottom: -4px;
    }
  }
}
</style>
