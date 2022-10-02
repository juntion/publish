<template>
  <div class="wrapper layout-swiper">
    <swiper :options="swiperOption" ref="LayoutSwiper" v-if="list.length">
      <swiper-slide v-for="(item, index) in list" :key="index">
        <div class="swiper_item" :style="{backgroundImage: 'url(' + item.img + ')'}"></div>
        <div class="swiper_txt" :style="{backgroundImage: 'url(' + item.img_txt + ')'}"></div>
      </swiper-slide>
      <div class="swiper-pagination" slot="pagination"></div>
    </swiper>
  </div>
</template>

<script>
import '../../../../node_modules/swiper/dist/css/swiper.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'

export default {
  name: 'LayoutSwiper',
  components: {
    swiper,
    swiperSlide
  },
  props: {
    list: Array
  },
  data () {
    return {
      swiperOption: {
        pagination: {
          el: '.swiper-pagination',
          clickable: true
        },
        loop: true,
        autoplay: {
          delay: 5000,
          stopOnLastSlide: false
        }
      }
    }
  }
}
</script>

<style lang="less" scoped>
  .wrapper {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;

    .swiper-container {
      width: 100%;
      height: 100%;

      .swiper_item {
        width: 100%;
        height: 100%;
        background-position: center center,center center;
        background-size: cover,cover;
        background-repeat: no-repeat,no-repeat;
      }

      .swiper_txt {
        position: absolute;
        left: 0;
        top: -60px;
        transition: all 1s;
        opacity: 0;
        background-position: center center,center center;
        background-size: cover,cover;
        background-repeat: no-repeat,no-repeat;
        width: 100%;
        height: 100%;
      }

      .swiper-slide-active {
        .swiper_txt {
          top: 0;
          transition: all 1s;
          opacity: 1;
        }
      }
    }

    .swiper-pagination {
      position: absolute;
      bottom: 60px;
      padding-right: 540px;
      width: 100%;
      z-index: 6;
    }
  }
</style>

<style lang="less">
  .layout-swiper {
    .swiper-pagination-bullet {
      width: 50px;
      display: inline-block;
      height: 14px;
      margin-right: 10px;
      cursor: pointer;
      position: relative;
      border-radius: 0;
      background-color: rgba(0, 0, 0, 0);
      opacity: 1;
    }

    .swiper-pagination-bullet::before {
      content: '';
      display: block;
      position: absolute;
      width: 0;
      height: 2px;
      margin-top: 6px;
      left: 0;
      top: 0;
      background-color: #fff;
      transition: width 5s linear;
      opacity: 0;
    }

    .swiper-pagination-bullet::after {
      content: '';
      display: block;
      width: 100%;
      height: 2px;
      margin-top: 6px;
      background: rgba(255, 255, 255, 0.5);
      opacity: 0.3;
    }

    .swiper-pagination-bullet.swiper-pagination-bullet-active::before {
      width: 50px;
      opacity: 1;
    }
  }
</style>
