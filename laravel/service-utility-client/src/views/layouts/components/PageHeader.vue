<template>
  <div class="page-header">
    <div class="page-header-index-wide">
      <Breadcrumb class="breadcrumb"></Breadcrumb>
      <div class="detail">
        <div class="main" v-if="!$route.meta.hiddenHeaderContent">
          <slot name="pageMenu"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Breadcrumb from './Breadcrumb'

export default {
  name: 'PageHeader',
  components: { Breadcrumb }
}
</script>

<style lang="less" scoped>
  .page-header {
    background: #fff;
    padding: 16px 32px 0;
    border-bottom: 1px solid #e8e8e8;

    .breadcrumb {
      margin-bottom: 16px;
    }

    .detail {
      display: flex;
      /*margin-bottom: 16px;*/

      .main {
        width: 100%;
        flex: 0 1 auto;
      }
    }
  }
</style>
