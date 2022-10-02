<template>
  <div class="from">
    <a-form :form="form">
      <div style="text-align:right;margin-bottom:10px;">
        <h1 class="dTeam">设计团队</h1>
        <span @click="add"
              class="addPM">
          <a-icon type="plus" /> 新增团队
        </span>
      </div>
      <a-form-item v-for="(k,index) in design_user"
                   :key="index"
                   :required="false"
                   class="team">
        <a-icon v-if="design_user.length > 1"
                class="delete-button"
                type="close"
                @click="() => remove(index)" />
        <div class="charge">

          <div>视觉负责人</div>
          <a-select style="width: 200px"
                    showSearch
                    allowClear
                    placeholder="请输入英文名搜索"
                    optionFilterProp="children"
                    @change="getChargeValue($event,k)"
                    @search="search($event, 1, index)"
                    :ref="'vision_' + index"
                   :defaultValue="k.vision_id"
                   :key="k.vision_id">
            <a-select-option v-for="item in options_1[index]"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
        </div>
        <div class="charge">
          <div>交互负责人</div>
          <a-select style="width: 200px"
                    showSearch
                    allowClear
                    placeholder="请输入英文名搜索"
                    @change="getChargeValue2($event,k)"
                    @search="search($event, 2, index)"
                    optionFilterProp="children"
                    :ref="'interactive_' + index"
                    :defaultValue="k.interactive_id"
                    :key="k.interactive_id">
            <a-select-option v-for="item in options_2[index]"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
        </div>
        <div class="charge">
          <div>主要负责人</div>
          <!-- :searchData="k.design" -->
          <!-- <peopleSelect class="chargeMen"
                        :searchData="k.design"
                        :valueData="k.design_user_id"
                        @getValue2="getChargeValue3($event,k)"></peopleSelect> -->
          <a-select style="width: 200px"
                    showSearch
                    allowClear
                    placeholder="请输入英文名搜索"
                    @change="getChargeValue3($event,k)"
                    @search="search($event, 3, index)"
                    optionFilterProp="children"
                    :ref="'design_user_' + index"
                    v-model="k.design_user_id">
            <a-select-option v-for="item in options_3[index]"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
        </div>
        <div class="charge">
          <div>美工负责人</div>
          <!-- <peopleSelect class="chargeMen"
                        :searchData="k.art"
                        :valueData="k.art_id"
                        @getValue2="getChargeValue4($event,k)"></peopleSelect> -->
          <a-select style="width: 200px"
                    showSearch
                    placeholder="请输入英文名搜索"
                    allowClear
                    @change="getChargeValue4($event,k)"
                    @search="search($event, 4, index)"
                    optionFilterProp="children"
                    :ref="'art_' + index"
                    :defaultValue="k.art_id"
                    :key="k.art_id">
            <a-select-option v-for="item in options_4[index]"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
        </div>
        <div class="charge">
          <div>移动端负责人</div>
          <!-- <peopleSelect class="chargeMen"
                        :searchData="k.mobile"
                        :valueData="k.mobile_id"
                        @getValue2="getChargeValue5($event,k)"></peopleSelect> -->
          <a-select style="width: 200px"
                    showSearch
                    allowClear
                    placeholder="请输入英文名搜索"
                    @change="getChargeValue5($event,k)"
                    @search="search($event, 5, index)"
                    optionFilterProp="children"
                    :ref="'mobile_' + index"
                    :defaultValue="k.mobile_id"
                    :key="k.mobile_id">
            <a-select-option v-for="item in options_5[index]"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
        </div>
        <div class="charge">
          <div>前端负责人</div>
          <!-- <peopleSelect class="chargeMen"
                        :searchData="k.web"
                        :valueData="k.web_id"
                        @getValue2="getChargeValue6($event,k)"></peopleSelect> -->
          <a-select style="width: 200px"
                    showSearch
                    allowClear
                    placeholder="请输入英文名搜索"
                    @change="getChargeValue6($event,k)"
                    @search="search($event, 6, index)"
                    optionFilterProp="children"
                    :ref="'web_' + index"
                    :defaultValue="k.web_id"
                    :key="k.web_id">
            <a-select-option v-for="item in options_6[index]"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
        </div>

      </a-form-item>
    </a-form>
  </div>
</template>

<script>
import { getBindPeople } from '@/api/RDmanagement/dropDown'
import { searchUserList } from '@/api/userManage/index.js'
export default {
  components: { },
  data () {
    return {
      options: [],
      options_1: [],
      options_2: [],
      options_3: [],
      options_4: [],
      options_5: [],
      options_6: [],
      design_user: this.valueData
    }
  },
  watch: {
    valueData (newVal, oldVal) {
      this.design_user = newVal
    }
  },
  props: {
    valueData: {
      type: Array
    }
  },
  beforeCreate () {
    this.form = this.$form.createForm(this, { name: 'dynamic_form_item' })
    this.form.getFieldDecorator('keys', { initialValue: [0], preserve: true })
  },
  created () {
    getBindPeople().then(res => {
      if (res.code === 200) {
        this.options = res.data.users
      }
    })
    if (this.valueData.length > 0) {
      this.valueData.forEach((item, index) => {
        this.options_3.push((item.design_user_id !== undefined) ? [{ id: item.design_user_id, name: item.design_user_name }] : [])
        if (item.members.filter((value) => value.type === 1).length === 0) this.options_2.push([])
        if (item.members.filter((value) => value.type === 2).length === 0) this.options_1.push([])
        if (item.members.filter((value) => value.type === 3).length === 0) this.options_6.push([])
        if (item.members.filter((value) => value.type === 4).length === 0) this.options_5.push([])
        if (item.members.filter((value) => value.type === 5).length === 0) this.options_4.push([])
        item.members.map(item1 => {
          if (item1.type === 1) {
            this.options_2.push([{ id: item1.user_id, name: item1.user_name }])
          } else if (item1.type === 2) {
            this.options_1.push([{ id: item1.user_id, name: item1.user_name }])
          } else if (item1.type === 3) {
            this.options_6.push([{ id: item1.user_id, name: item1.user_name }])
          } else if (item1.type === 4) {
            this.options_5.push([{ id: item1.user_id, name: item1.user_name }])
          } else if (item1.type === 5) {
            this.options_4.push([{ id: item1.user_id, name: item1.user_name }])
          }
        })
      })
    } else {
      this.options_1.push([])
      this.options_2.push([])
      this.options_3.push([])
      this.options_4.push([])
      this.options_5.push([])
      this.options_6.push([])
    }
  },
  methods: {
    search (e, type, index) {
      this.$nextTick(() => {
        let self = this
        this.timer = searchUserList(this.timer, e, function (data) {
          if (type === 1) {
            // self.options_1[index] = data.data.users
            // self.$forceUpdate()
            self.$set(self.options_1, index, data.data.users)
          } else if (type === 2) {
            self.$set(self.options_2, index, data.data.users)
          } else if (type === 3) {
            self.$set(self.options_3, index, data.data.users)
          } else if (type === 4) {
            self.$set(self.options_4, index, data.data.users)
          } else if (type === 5) {
            self.$set(self.options_5, index, data.data.users)
          } else if (type === 6) {
            self.$set(self.options_6, index, data.data.users)
          }
        })
      })
    },
    remove (index) {
      this.design_user.splice(index, 1)
      this.options_1.splice(index, 1)
      this.options_2.splice(index, 1)
      this.options_3.splice(index, 1)
      this.options_4.splice(index, 1)
      this.options_5.splice(index, 1)
      this.options_6.splice(index, 1)
    },
    add (index) {
      this.design_user.push({ design_user_id: undefined, members: [], vision_id: undefined, interactive_id: undefined, art_id: undefined, mobile_id: undefined, web_id: undefined })
    },
    getChargeValue (e, k, options) {
      let obj = { type: 2, user_id: e }
      let number = ''
      this.$set(k, 'vision_id', e)
      k.members.map((item, index) => {
        if (item.type === 2) {
          item.user_id = e
          number = index
        }
      })
      let res = k.members.some(item => {
        if (item.type === 2) {
          return true
        }
      })
      if (!res) {
        k.members.push(obj)
      }
      if (!e) {
        k.members.splice(number, 1)
      }
    },
    getChargeValue2 (e, k) {
      let obj = { type: 1, user_id: e }
      let number = ''
      this.$set(k, 'interactive_id', e)
      k.members.map((item, index) => {
        if (item.type === 1) {
          item.user_id = e
          number = index
        }
      })
      let res = k.members.some(item => {
        if (item.type === 1) {
          return true
        }
      })
      if (!res) {
        k.members.push(obj)
      }
      if (!e) {
        k.members.splice(number, 1)
      }
    },

    getChargeValue3 (e, k) {
      k.design_user_id = e
    },
    getChargeValue4 (e, k) {
      let obj = { type: 5, user_id: e }
      let number = ''
      this.$set(k, 'art_id', e)
      k.members.map((item, index) => {
        if (item.type === 5) {
          item.user_id = e
          number = index
        }
      })
      let res = k.members.some(item => {
        if (item.type === 5) {
          return true
        }
      })
      if (!res) {
        k.members.push(obj)
      }
      if (!e) {
        k.members.splice(number, 1)
      }
    },
    getChargeValue5 (e, k) {
      let obj = { type: 4, user_id: e }
      let number = ''
      this.$set(k, 'mobile_id', e)
      k.members.map((item, index) => {
        if (item.type === 4) {
          item.user_id = e
          number = index
        }
      })
      let res = k.members.some(item => {
        if (item.type === 4) {
          return true
        }
      })
      if (!res) {
        k.members.push(obj)
      }
      if (!e) {
        k.members.splice(number, 1)
      }
    },
    getChargeValue6 (e, k) {
      let obj = { type: 3, user_id: e }
      let number = ''
      this.$set(k, 'web_id', e)
      k.members.map((item, index) => {
        if (item.type === 3) {
          item.user_id = e
          number = index
          k.web_id = e
        }
      })
      let res = k.members.some(item => {
        if (item.type === 3) {
          return true
        }
      })
      if (!res) {
        k.members.push(obj)
      }
      if (!e) {
        k.members.splice(number, 1)
      }
    }

  }
}
</script>
<style lang="less" scoped>
.chargeMen {
  width: 200px;
}
.dTeam {
  float: left;
  font-weight: bold;
}
.charge {
  float: right;
  padding: 10px;
}
.form {
  max-height: 660px;
}
.addPM {
  cursor: pointer;
  font-size: 12px;
  color:#378EEF;
}
.team {
  position: relative;
  background: rgba(248, 248, 248, 1);
}
.delete-button {
  position: absolute;
  left: 640px;
  top: 10px;
  z-index: 10;
}
</style>
