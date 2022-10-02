<template>
  <div class="layout-box">
    <div class="layout-bg">
      <LayoutSwiper :list="bannerList"></LayoutSwiper>
    </div>
    <a-card class="auth">
      <div class="auth-box">
        <div><img :src="logo" class="logo"></div>
        <div class="layout-txt">{{$t('auth.loginTit')}}</div>
        <div class="layout-chicken" v-html="getChicken"></div>
        <div class="layout-form">
          <router-view></router-view>
          <div class="clearFl return-to-login"
            v-if="$route.name !== 'authLogin'"
          >
            <i class="iconfont icon-return" style="font-size: 14px;font-weight: normal;"></i>
            <router-link
              class="return-login"
              v-if="$route.name !== 'authLogin'"
              :to="{ name: 'authLogin' }">{{$t('auth.returnLogin')}}
            </router-link>
          </div>
        </div>
      </div>
      <Copyright class="copy-right-box"></Copyright>
    </a-card>
  </div>
</template>

<script>
import Copyright from '@/components/Copyright'
import LayoutSwiper from './components/Swiper.vue'
import Logo from '@/assets/images/login-logo.png'
import Img1 from '@/assets/images/login_bg1.jpg'
import ImgTxt1 from '@/assets/images/login_bg1_1.png'
import Img2 from '@/assets/images/login_bg2.jpg'
import ImgTxt2 from '@/assets/images/login_bg2_1.png'
import Img3 from '@/assets/images/login_bg3.jpg'
import ImgTxt3 from '@/assets/images/login_bg3_1.png'

const BannerList = [
  { img: Img1, img_txt: ImgTxt1 },
  { img: Img2, img_txt: ImgTxt2 },
  { img: Img3, img_txt: ImgTxt3 }
]

const ChickenData = [
  '树木呼唤着：要活得轻松，<br>要充满光，还要闪亮。',
  '命运低语：你无法抵御风暴；<br>勇士低声回应：我就是风暴。',
  '日复一日的重叠中，<br>我们一点点崩毁，又一点点再生。',
  '周末，去童年待一个下午，<br>把忘掉的名字想起来。',
  '在心里留一块空白，<br>有人会为我们创造一片特殊的宁静。',
  '空气忙碌，四周是欢快的烟雾，<br>别去管它今天是哪一天。',
  '世间以树林、雾气和传说，<br>予我们以盛大的馈赠。',
  '停住晴朗的时间，<br>你在阳光里，我也在阳光里。',
  '我们都有移动的理由，<br>我移动，为了保持事物的完整。',
  '站在台风口，<br>猪也能飞起来。',
  '微笑就是阳光，<br>它能消除人们脸上的冬色。',
  '人生路还漫长，这一路你会经历艰辛，<br>所以不管你做什么，请留住你脸上的傻笑和热情。',
  '不被外人所关注的时刻，<br>也是你成长的最佳时刻。',
  '如果你不出去走走，<br>你就会以为这就是世界。',
  '到不了的地方都叫做远方，<br>我一直向往的却是比远方更远的地方。',
  '生命可以随心所欲，<br>但不能随波逐流。',
  '当一个人用工作去迎接光明，<br>光明很快就会来照耀着他。',
  '萌萌的你别瞅了，<br>赶紧登录上班班。',
  '也许我没有天分，<br>但我有梦的天真。',
  '人生没有彩排，<br>每天都是现场直播！',
  'A break of day ,<br>In hope we rise .',
  '说出来被人嘲笑的梦想，<br>才有实现的价值。',
  '既然庸庸碌碌也难逃一死，<br>何不奋起一搏？',
  '种一棵树最好的时间是十年前，<br>其次是现在。',
  '怕什么真理无穷，<br>进一寸有一寸的欢喜。',
  '春风得意马蹄疾，<br>一朝看尽长安花。',
  '有何胜利可言，<br>挺住就是一切。',
  '愿有人陪你颠沛流离，<br>如果没有，愿你成为自己的太阳。',
  '有时你乘起风，有时你沉默，<br>有时午夜有彩虹。',
  '理想就像一辆车，如果你认为一切<br>都在你的掌控之中，那么说明你还开得不够快！',
  'My jinji don\'t cry in this world out of time ,<br>Old time out of mind .',
  '是那些不再重来的，<br>使得生活如此甜蜜。',
  '今天的你，<br>真的有点好看。',
  '站在宇宙中央...<br>造一个梦...',
  '持微暗之火，<br>愿你寻得明灯。',
  '我们可以一次一次去撞南墙，<br>我们不能一个一个失去理想。',
  '生活就像一盒巧克力，<br>你永远不知道下一块是什么味道。',
  '你是夜晚啼叫的夜莺，<br>是清晨轻抚可爱面颊的清风。',
  '成年人的生活里，<br>没有“容易”二字。',
  '每个人都活在自己的故事里，<br>不必知道自己是谁，只需要知道自己该做谁。',
  '昨天一笔勾销吧，<br>今天，都尽管来吧!',
  'Look at the stars ,<br>Look how they shine for you .',
  '走过的路，是一阵魔术，<br>把所有的，好的坏的，都变成我的。',
  '时间过得飞快，转眼这些已成回忆；<br>每天都有新的问题，不知何时又回忆起',
  '能同途偶遇在这星球上，<br>燃亮飘渺人生，我多么够幸运。',
  'I\'m gonna live <br>like tomorrow doesn\'t exist .',
  'How wonderful life is ,<br>while you\'re in the world .',
  'May it be your joriney on .<br>To light the day .',
  '你啊你，是自在如风的少年，<br>飞在天地间，比梦还遥远。',
  '给今天如此好看的你，<br>送一束花，呐❀❀❀...'
]

export default {
  name: 'Layout',
  components: {
    LayoutSwiper,
    Copyright
  },
  data () {
    return {
      logo: Logo,
      bannerList: BannerList,
      chickenData: ChickenData
    }
  },
  computed: {
    getChicken () {
      return this.chickenData[parseInt(Math.random() * 50)]
    }
  }
}
</script>

<style lang="less" scoped>
  @imgUrl: '../../assets/images/';

  .layout-box {
    position: absolute;
    width: 100%;
    height: 100%;
    min-height: 710px;
    overflow-y: auto;
  }

  .layout-bg {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
  }

  .auth {
    width: 540px;
    height: 100%;
    position: absolute;
    right: 0;
    top: 0;
    background-color: rgba(0,0,0,0);
    border: 0;
    z-index: 9;

    .auth-box {
      margin: auto;
      width: 100%;

      .logo {
        display: block;
        margin: 0 auto 30px;
      }

      .layout-txt {
        text-align: center;
        font-size: 20px;
        margin-bottom: 60px;
        font-weight: 500;
      }

      .layout-form {
        padding-left: 78px;
        padding-right: 78px;
      }

      .layout-chicken {
        font-size: 14px;
        line-height: 24px;
        text-align: center;
        color: #999;
        margin-bottom: 83px;
      }
    }

    .return-to-login {
      text-align: center;
      color: #378eef;
      font-weight: 600;
      font-size: 14px;

      .return-login {
        color: #378eef;
        font-weight: 600;
        font-size: 14px;
      }
    }
  }
</style>

<style lang="less">
  .layout-box {
    .ant-card-body {
      display: flex;
      height: 100%;
      background: rgba(255,255,255,0.95);
      padding-bottom: 150px;
    }

    .ant-form-item:after{
      content:".";
      display: block;
      height: 0;
      overflow: hidden;
      clear: both;
      visibility: hidden;
    }

    .ant-form-item.has-value::before {
      position: absolute;
      width: 100%;
      height: 2px;
      top: 49px;
      background-color: #378eef;
      z-index: 9;
    }

    .ant-input {
      border: 0;
      border-bottom: 1px solid #dbdadc;
      background: none;
      border-radius: 0;
      padding-left: 73px !important;
      padding: 11px;
      height: 50px;
      font-size: 14px;
      font-family: 'Microsoft YaHei';
      background: none !important;
    }

    .ant-input:focus {
      border-color: #dbdadc;
      box-shadow: none;
    }

    .ant-input-affix-wrapper:hover .ant-input:not(.ant-input-disabled) {
      border-color: #dbdadc;
    }

    .has-error .ant-input-affix-wrapper .ant-input:focus {
      box-shadow: none;
      border-color: #ff4a4a;
    }

    .ant-form {
      background: none;
    }

    .ant-input-prefix {
      border-right: 1px solid #dbdbdb;
      padding: 0 20px 0 7px;
      font-size: 16px;

      .anticon {
        color: #666 !important;
      }
    }

    .ant-btn-primary {
      height: 54px;
      line-height: 54px;
      font-size: 14px;
      color: #fff;
      border-radius: 27px;
      border: 0;
      width: 100%;
      outline: none;
      padding: 0;
      background: linear-gradient(45deg,#417cda,#337aec);
      box-shadow: 0 6px 10px 1px #b6cef6;
    }

    .ant-btn-primary:disabled, .ant-btn-primary:disabled:hover {
      color: #fff;
    }

    .ant-btn-primary:hover {
      opacity: 0.9;
      background: linear-gradient(45deg,#417cda,#337aec);
      border-color: none;
    }

    .copy-right-box {
      position: absolute;
      font-size: 12px;
      color: #ccc;
      line-height: 12px;
      bottom: 20px;
      width: 100%;
      box-sizing: border-box;
      left: 0;
    }

    .ant-form-explain {
      font-size: 12px;
      color: #ff4a4a;
      padding-top: 6px;
      line-height: 12px;
    }

    .layout-eye {
      right: 20px;
      font-size: 12px;
      line-height: 19px !important;
      cursor: pointer;
    }

    .layout-eye.icon-eyeclose {
      transform: scale(0.67511);
      margin-right: -4px;
      display: block;
    }
  }
</style>
