<template>
  <p>404</p>
</template>

<script>
export default {
  name: 'NotFound',
  methods: {
    back () {
      this.$router.back()
    }
  }
}
</script>

<style scoped>
  .notfound_page {
    width: 600px;
    margin: 100px auto;
    text-align: center;
  }
</style>
