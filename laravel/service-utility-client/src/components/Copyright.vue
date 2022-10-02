<template>
  <div class="copy-right">{{ getYear }}</div>
</template>

<script>
export default {
  name: 'Copyright',
  data () {
    return {
      text: ''
    }
  },
  computed: {
    getYear () {
      let date = new Date()
      let y = date.getFullYear()
      return 'Copyright © 2009-' + y + ' FS.COM All Rights Reserved.'
    }
  }
}
</script>

<style lang="less" scoped>
  .copy-right {
    text-align: center;
    width: 100%;
  }
</style>
