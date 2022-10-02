<template>
    <a-modal :title="$t('role.modal.tip')"
        v-model="delRoleModalShow"
        width="380px"
        class="del-box"
        @ok="delRoleData">
        <p class="label"><span>{{$t('role.modal.tip1')}}</span><span class="label-txt">{{$t('role.modal.del')}}</span><span>{{$t('role.modal.tip2')}}</span></p>
        <p class="txt">{{$t('role.modal.tipTxt')}}</p>
    </a-modal>
</template>

<script>
import { bus } from '../../../plugins/bus'
import { languages } from '../../../plugins/lang'
import Vue from 'vue'
import { addRoles } from '../../../api/role'
import { mapGetters } from 'vuex'
import { setInputErrors } from '../../../plugins/common'

export default {
  name: 'addRoleModal',
  data () {
    return {
      delRoleModalShow: false
    }
  },
  methods: {
    delRoleData () {
      this.$emit('delHandel')
      this.delRoleModalShow = false
    }
  },
  mounted () {
    bus.$on('showDelModal', data => {
      this.delRoleModalShow = true
    })
  },
  computed: {
    ...mapGetters(['getSubsData', 'getLanguage', 'getCurrentSub'])
  }
}
</script>

<style lang="less">
.del-box{
  .txt{
    text-align: center;
    color: #F88D49;
    font-size: 16px;
    margin-top: 10px;
  }
  .label{
    color: #666666;
    text-align: center;
    font-size: 16px;
  }
  .label-txt{
    color: #FF4A4A;
    padding: 0 2px;
  }
  .ant-modal-footer{
    display: flex!important;
    justify-content: center;
    align-items: center!important;
  }
  .ant-btn-primary{
    margin-left: 46px!important;
  }
}

</style>
