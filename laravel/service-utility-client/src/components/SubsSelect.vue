<template>
    <a-select style="width: 180px"
              showSearch
              :placeholder="$t('common.guard')"
              v-decorator="['guard_name']"
              :defaultValue="getCurrentSub"
              @change="handleChange"
    >
        <a-select-option
                v-for="(item, key) in getSubsData"
                :key="key"
                :value="item.guard_name">
            {{JSON.parse(item.locale)[getLanguage]}}
        </a-select-option>
    </a-select>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'SubsSelect',
  data () {
    return {
      valiData: {}
    }
  },
  methods: {
    handleChange (val) {
      this.$store.commit('SET_CURRENT_SELECTED_SUB', val)
    }
  },
  computed: {
    ...mapGetters(['getSubsData', 'getCurrentSub', 'getLanguage'])
  }
}
</script>

<style scoped>

</style>
