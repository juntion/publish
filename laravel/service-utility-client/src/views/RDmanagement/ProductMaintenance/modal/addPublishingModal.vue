<template>
    <div>
         <a-modal  :title="type===1 ? '添加发版产品' : '编辑发版产品'"
                   class="modal-pms"
                   v-model="visible"
                   :confirmLoading="btnLoad"
                   @cancel="cancel"
                   @ok="ok"
                   :maskClosable="false"
                   destroyOnClose
                   width="700px">
                        <a-form-model
                                :model="addForm"
                                ref="addForm">
                            <a-form-model-item prop="name" label="产品名称" style="margin-bottom:20px" :rules="[{ required: true, message: '请填写名称', trigger: 'blur' }]">
                                    <a-input placeholder="请输入发版产品名称"
                                                    v-model="addForm.name"
                                                    />
                            </a-form-model-item>
                            <a-form-model-item prop="admin_ids" label="产品管理员" style="margin-bottom:20px" :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                <a-select   placeholder="请输入"
                                            mode="multiple"
                                            @search="search"
                                            :getPopupContainer="triggerNode => triggerNode.parentNode"
                                            :defaultActiveFirstOption="false"
                                            :showArrow="false"
                                            :filterOption="false"
                                            v-model="addForm.admin_ids"
                                            >
                                        <a-select-option v-for="d in searchUser" :key="d.id">{{d.name}}</a-select-option>
                                </a-select>
                            </a-form-model-item>
                            <a-form-model-item prop="cycle" label="发布周期" style="margin-bottom:20px" :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                <a-cascader :getPopupContainer="triggerNode => triggerNode.parentNode" :options="cycle" placeholder="请选择" v-model="addForm.cycle" />
                            </a-form-model-item>

                            <div style="position: relative;margin-bottom:20px">
                                <a @click="addProduct('product_ids')" class="publishing-add-icon"><span class="iconfont fz12">&#xe658;</span> 添加</a>
                                <a-form-model-item
                                        :prop="'product_ids.' + index + '.value'"
                                        :rules="[{ required: true, message: '请选择', trigger: 'change' }]"
                                        class="colon positionRe"
                                        v-for="(item,index) in addForm.product_ids" :key="index">
                                         <span class="fz12" slot="label" v-if="index === 0">关联产品 :<span style="color:#f88d49;margin-left:10px"> 关联后，需求和任务可以自动检查其发版产品及版本号，并给予提示； </span></span>
                                        <a-cascader
                                            v-model="item.value"
                                            @change="onChange($event,index,1)"
                                            :getPopupContainer="triggerNode => triggerNode.parentNode"
                                            :fieldNames="fields"
                                            :style="{'margin-bottom': index===addForm.product_ids.length-1 ?  '0' :'10px',width:addForm.product_ids.length > 1 ?  '96%' :'100%'}"
                                            :options="products"
                                            :load-data="loadData"
                                            placeholder="请选择"
                                            change-on-select
                                            />
                                        <span @click="() => removeProduct(index,'product_ids')"
                                                    style="margin-left: 10px;"
                                                    v-if="addForm.product_ids.length>1"
                                                    class="delFile del-icon cup"> <span class="iconfont">&#xe631;</span></span>
                                </a-form-model-item>
                            </div>
                            <div style="position: relative;margin-bottom:20px">
                                <a @click="addProduct('online_address')" class="publishing-add-icon"><span class="iconfont fz12">&#xe658;</span> 添加</a>
                                <a-form-model-item
                                        v-for="(item,index) in addForm.online_address" :key="index">
                                         <span class="fz12" slot="label" v-if="index === 0">正式站地址</span>
                                          <a-input
                                            placeholder="请输入正式站地址"
                                            @blur="onChange(item.value,index,2)"
                                            :style="{'margin-bottom': index===addForm.online_address.length-1 ?  '0' :'10px',width:addForm.online_address.length > 1 ?  '96%' :'100%'}"
                                            v-model="item.value"
                                             />
                                        <span @click="() => removeProduct(index,'online_address')"
                                                    style="margin-left: 10px;"
                                                    v-if="addForm.online_address.length>1"
                                                    class="delFile del-icon cup"> <span class="iconfont">&#xe631;</span></span>
                                </a-form-model-item>
                            </div>
                            <div style="position: relative;margin-bottom:20px">
                                <a @click="addProduct('testing_address')" class="publishing-add-icon"><span class="iconfont fz12">&#xe658;</span> 添加</a>
                                <a-form-model-item
                                        v-for="(item,index) in addForm.testing_address" :key="index">
                                         <span class="fz12" slot="label" v-if="index === 0">测试站地址</span>
                                          <a-input
                                            placeholder="请输入测试站地址"
                                             @blur="onChange(item.value,index,3)"
                                            :style="{'margin-bottom': index===addForm.testing_address.length-1 ?  '0' :'10px',width:addForm.testing_address.length > 1 ?  '96%' :'100%'}"
                                            v-model="item.value"
                                             />
                                        <span @click="() => removeProduct(index,'testing_address')"
                                                    style="margin-left: 10px;"
                                                    v-if="addForm.testing_address.length>1"
                                                    class="delFile del-icon cup"> <span class="iconfont">&#xe631;</span></span>
                                </a-form-model-item>
                            </div>
                            <a-form-model-item prop="description" label="简介">
                                 <a-textarea placeholder="请输入简介内容" v-model="addForm.description" :rows="4" />
                            </a-form-model-item>
                        </a-form-model>
        </a-modal>
    </div>
</template>
<script>
import { bus } from '@/plugins/bus'
import { getProducts } from '@/api/RDmanagement/ProductMaintenance/index.js'
import { searchUserList } from '@/api/userManage/index.js'
import { addPublishingProducts, editPublishingProducts } from '@/api/RDmanagement/ProductMaintenance/edition.js'
export default {
  data () {
    return {
      type: 1,
      id: 0,
      visible: false,
      btnLoad: false,
      searchUser: [],
      products: [],
      fields: { label: 'name', value: 'id', children: 'children' },
      addForm: {
        name: undefined,
        admin_ids: [],
        cycle: [],
        release_type: undefined,
        release_day: undefined,
        product_ids: [{ value: undefined }],
        online_address: [{ value: undefined }],
        testing_address: [{ value: undefined }],
        description: undefined
      }
    }
  },
  computed: {
    cycle () {
      let week = [
        {
          value: 1,
          label: '星期一'
        },
        {
          value: 2,
          label: '星期二'
        }, {
          value: 3,
          label: '星期三'
        }, {
          value: 4,
          label: '星期四'
        }, {
          value: 5,
          label: '星期五'
        }, {
          value: 6,
          label: '星期六'
        }, {
          value: 7,
          label: '星期日'
        }
      ]
      let month = []
      for (let index = 1; index < 32; index++) {
        month.push({ value: index, label: index })
      }
      let cycleData = [
        {
          value: 1,
          label: '每周',
          children: week
        },
        {
          value: 2,
          label: '每两周',
          children: week
        },
        {
          value: 3,
          label: '每月',
          children: month
        }
      ]
      return cycleData
    }
  },
  async mounted () {
    getProducts().then(res => {
      this.products = res.data.products.map(item => {
        return { ...item, isLeaf: false }
      })
    })
    bus.$on('addPublishingModalShow', data => {
      this.visible = true
      if (data) {
        this.type = 2
        this.id = data.id
        this.addForm.name = data.name
        this.addForm.description = data.description || undefined
        this.addForm.cycle = [data.release_type, data.release_day]

        // 异步加载的产品回显
        let arr = []
        data.friendly_products.forEach(item => {
          if (item.type === 0) {
            arr.push({ value: [item.id] })
          } else {
            let keyIndex
            this.products.forEach((item2, index) => {
              if (item2.id === item.parent_id) {
                keyIndex = index
              }
            })
            getProducts(item.parent_id).then(res => {
              this.products[keyIndex].children = res.data.products
              arr.push({ value: [item.parent_id, item.id] })
            })
          }
        })
        this.addForm.product_ids = arr

        this.addForm.admin_ids = data.admins.map(item => {
          return item.user_id
        })
        this.searchUser = data.admins.map(item => {
          return { id: item.user_id, name: item.user_name }
        })
        if (data.online_address.length) {
          this.addForm.online_address = data.online_address.map(item => {
            return { value: item }
          })
        } else {
          this.addForm.online_address = [{ value: undefined }]
        }
        if (data.testing_address.length) {
          this.addForm.testing_address = data.testing_address.map(item => {
            return { value: item }
          })
        } else {
          this.addForm.testing_address = [{ value: undefined }]
        }
      } else {
        this.type = 1
        this.addForm = {
          name: undefined,
          admin_ids: [],
          cycle: [],
          release_type: undefined,
          release_day: undefined,
          product_ids: [{ value: undefined }],
          online_address: [{ value: undefined }],
          testing_address: [{ value: undefined }],
          description: undefined
        }
      }
    })
  },
  beforeDestroy () {
    bus.$off('addPublishingModalShow')
  },
  methods: {
    onChange (e, index, type) {
      let arr
      switch (type) {
        case 1:
          arr = this.addForm.product_ids.map(item => {
            if (item.value) {
              return item.value.toString()
            }
          })
          if (new Set(arr).size !== arr.length) {
            this.$message.error('关联产品不可重复')
            this.addForm.product_ids[index] = { value: undefined }
          }

          break
        case 2:
          arr = this.addForm.online_address.map(item => {
            if (item.value) {
              return item.value
            }
          }).filter(Boolean)

          if (new Set(arr).size !== arr.length) {
            this.$message.error('地址不可重复')
            this.addForm.online_address[index].value = undefined
          }
          break
        case 3:
          arr = this.addForm.testing_address.map(item => {
            if (item.value) {
              return item.value
            }
          }).filter(Boolean)
          if (new Set(arr).size !== arr.length) {
            this.$message.error('地址不可重复')
            this.addForm.testing_address[index].value = undefined
          }
          break

        default:
          break
      }
    },
    cancel () {
      this.$refs.addForm.resetFields()
      this.addForm.product_ids = [{ value: undefined }]
      this.addForm.online_address = [{ value: undefined }]
      this.addForm.testing_address = [{ value: undefined }]
    },
    ok () {
      this.$refs.addForm.validate(valid => {
        if (valid) {
          const form = Object.assign({}, this.addForm)
          form.release_type = form.cycle[0]
          form.release_day = form.cycle[1]
          form.product_ids = form.product_ids.map(item => {
            return item.value[item.value.length - 1]
          }
          ).filter(Boolean)
          form.online_address = form.online_address.map(item => {
            return item.value
          }
          ).filter(Boolean)
          if (!form.description) {
            form.description = undefined
          }
          form.testing_address = form.testing_address.map(item => {
            return item.value
          }
          ).filter(Boolean)
          this.btnLoad = true
          if (this.type === 1) {
            addPublishingProducts(form).then(res => {
              this.visible = false
              this.btnLoad = false
              this.$message.success('添加成功')
              this.$refs.addForm.resetFields()
              this.addForm.product_ids = [{ value: undefined }]
              this.addForm.online_address = [{ value: undefined }]
              this.addForm.testing_address = [{ value: undefined }]
              this.$parent.getProList()
              this.$parent.getAdminUser()
              this.$parent.getConfirmNum()
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else {
            editPublishingProducts(this.id, form).then(res => {
              this.visible = false
              this.btnLoad = false
              this.$message.success('修改成功')
              this.$refs.addForm.resetFields()
              this.addForm.product_ids = [{ value: undefined }]
              this.addForm.online_address = [{ value: undefined }]
              this.addForm.testing_address = [{ value: undefined }]
              this.$parent.getProList()
              this.$parent.getAdminUser()
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          }
        } else {
          return false
        }
      })
    },
    loadData (selectedOptions) {
      // 动态加载产品
      const targetOption = selectedOptions[selectedOptions.length - 1]
      targetOption.loading = true
      getProducts(targetOption.id).then(res => {
        targetOption.loading = false
        targetOption.children = res.data.products.map(item => {
          return { id: item.id, name: item.name, isLeaf: true }
        })
        this.products = [...this.products]
      })
    },
    search (e) {
      this.$nextTick(() => {
        let self = this
        this.timer = searchUserList(this.timer, e, function (data) {
          self.searchUser = data.data.users
        })
      })
    },
    addProduct (name) {
      this.addForm[name].push({
        value: undefined
      })
    },
    removeProduct (index, name) {
      this.addForm[name].splice(index, 1)
    }
  }
}
</script>
<style lang="less" scoped>
    .del-icon{
        position: absolute;
        right: -23px;
    }
    .publishing-add-icon{
      position: absolute;
      top: 0;
      right: 0;
      z-index: 100;
      cursor: pointer;
  }
</style>
