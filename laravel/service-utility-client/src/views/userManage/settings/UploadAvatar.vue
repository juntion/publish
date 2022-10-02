<template>
  <div>
    <div class="setting-title">{{ $t('system.settings.AvatarSettingTitle') }}</div>
    <a-row type="flex">
      <a-col :span="12">
        <div class="upload">
          <input type="file" @change="getFile" ref="file" id="file" accept="video/BMPEG,image/gif,image/jpeg,image/png">
          <label for="file" style="line-height: 32px;" class="ant-btn ant-btn-default p-btn-1">
            {{ $t('system.settings.pleaseSelectPicture') }}
          </label>
        </div>
        <div class="img-format">{{ $t('system.settings.imgFormatTip') }}</div>
        <div class="cropper-content">
          <VueCropper
            ref="cropper"
            :img="src"
            :outputSize="option.size"
            :outputType="option.outputType"
            :info="true"
            :full="option.full"
            :canMove="option.canMove"
            :canMoveBox="option.canMoveBox"
            :original="option.original"
            :autoCrop="option.autoCrop"
            :fixed="option.fixed"
            :centerBox="option.centerBox"
            :infoTrue="option.infoTrue"
            :fixedBox="option.fixedBox"
            :autoCropWidth="option.autoCropWidth"
            :autoCropHeight="option.autoCropHeight"
            @realTime="realTime"
          ></VueCropper>
        </div>
        <div class="finish">
          <a-button type="primary" :loading="loading" @click="upload" class="p-btn">提交</a-button>
        </div>
      </a-col>
      <a-col :span="12" style="padding-left:40px;">
        <p class="avatar-tit">{{ $t('system.settings.avatarPreview') }}</p>
        <div class="img_review">
          <div style="margin-bottom: 20px;line-height: 120px">
            <div class="show-preview-120">
              <img :src=previewUrl.url class="img120px" :style="previewUrl.img">
            </div>
            <span style="margin-left: 30px;" class="img-size">120px*120px</span>
          </div>
          <div style="margin-bottom: 20px;line-height: 50px;">
            <div class="show-preview-50">
              <img :src=previewUrl.url class="img50px" :style="previewUrl.img">
            </div>
            <span style="margin-left: 66px;" class="img-size">50px*50px</span>
          </div>
          <div style="margin-bottom: 20px;line-height: 30px;">
            <div class="show-preview-30">
              <img :src=previewUrl.url class="img30px" :style="previewUrl.img">
            </div>
            <span style="margin-left: 76px;" class="img-size">30px*30px</span>
          </div>
        </div>
      </a-col>
    </a-row>
  </div>
</template>

<script>
import { VueCropper } from 'vue-cropper'
import { settingAvatar } from '../../../api/system/setting'

export default {
  name: 'UploadAvatar',
  components: { VueCropper },
  data () {
    return {
      previewUrl: {
        url: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHYAAAB2CAYAAAAdp2cRAAABoElEQVR4Xu3TAREAAAiDQNe/tD3+sAHgdh1pYCRVUFdY9AkKW1jUAIrVYguLGkCxWmxhUQMoVostLGoAxWqxhUUNoFgttrCoARSrxRYWNYBitdjCogZQrBZbWNQAitViC4saQLFabGFRAyhWiy0sagDFarGFRQ2gWC22sKgBFKvFFhY1gGK12MKiBlCsFltY1ACK1WILixpAsVpsYVEDKFaLLSxqAMVqsYVFDaBYLbawqAEUq8UWFjWAYrXYwqIGUKwWW1jUAIrVYguLGkCxWmxhUQMoVostLGoAxWqxhUUNoFgttrCoARSrxRYWNYBitdjCogZQrBZbWNQAitViC4saQLFabGFRAyhWiy0sagDFarGFRQ2gWC22sKgBFKvFFhY1gGK12MKiBlCsFltY1ACK1WILixpAsVpsYVEDKFaLLSxqAMVqsYVFDaBYLbawqAEUq8UWFjWAYrXYwqIGUKwWW1jUAIrVYguLGkCxWmxhUQMoVostLGoAxWqxhUUNoFgttrCoARSrxRYWNYBitdjCogZQrBZbWNQAitVi0bAPiWgAd40QU0oAAAAASUVORK5CYII=',
        img: 'width:100%;height:100%'
      },
      loading: false,
      // 转base64码后的data字段
      src: '', // 先设置一个默认图片
      option: {
        img: '',
        outputSize: 1, // 剪切后的图片质量（0.1-1）
        full: false, // 输出原图比例截图 props名full
        outputType: 'jpeg', // 裁剪生成图片的格式
        canScale: false, // 图片是否允许滚轮缩放
        autoCrop: true, // 是否默认生成截图框
        autoCropWidth: 120, // 默认生成截图框宽度
        autoCropHeight: 120, // 默认生成截图框高度
        fixedBox: true, // 固定截图框大小 不允许改变
        fixed: true, // 是否开启截图框宽高固定比例
        fixedNumber: [7, 5], // 截图框的宽高比例
        canMoveBox: true, // 截图框能否拖动
        original: false, // 上传图片按照原始比例渲染
        centerBox: false, // 截图框是否被限制在图片里面
        infoTrue: true // true 为展示真实输出图片宽高 false 展示看到的截图框宽高
      }
    }
  },
  methods: {
    getFile (e) {
      let _this = this
      const files = e.target.files[0]
      if (!e || !window.FileReader) return // 看支持不支持FileReader
      let reader = new FileReader()
      reader.readAsDataURL(files) // 这里是最关键的一步，转换就在这里
      reader.onloadend = function () {
        _this.src = this.result
      }
    },
    realTime (data) {
      if (data.url !== '') {
        this.$refs.cropper.getCropData((img) => {
          this.previewUrl.url = img
        })
      }
    },
    upload () {
      this.$refs.cropper.getCropBlob(data => {
        const isLt1M = data.size / 1024 / 1024 < 1
        if (!isLt1M) this.$message.warning(this.$t('system.settings.warningAvatarSize'))
        let fd = new FormData()
        fd.append('avatar', data)
        this.loading = true
        settingAvatar(fd).then(data => {
          this.$message.success(this.$t('system.settings.avatarUploadSuccess'))
          this.$store.commit('updateAvatarSuccess', data.data)
          this.loading = false
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
          this.loading = false
        })
      })
    }
  }
}
</script>

<style lang="less">
  .cropper-content {
    width: 226px;
    height: 226px;
    border: 1px solid #e4ebf0;
    border-radius: 3px;
    background: #f5f8fa url('../../../assets/images/upload_box_bg.png') no-repeat center;
  }

  .vue-cropper {
    background: none !important;
  }

  .cropper-crop-box span.cropper-view-box {
    outline: none !important;
    user-select: none !important;
    border-radius: 50% !important;
    border: 1px solid #39f !important;
  }

  .cropper-face {
    border-radius: 50% !important;
  }

  .upload {
    margin-bottom: 9px;
  }

  input[type='file'] {
    display: none;
    z-index: 10;
    width: 120px;
    font-size: 0;
    height: 30px;
  }

  .finish {
    margin-top: 20px;
  }

  .show-preview-120 {
    width: 120px;
    height: 120px;
    overflow: hidden;
    border-radius: 50%;
    background-color: #f5f8fa;
    float: left;
  }

  .show-preview-50 {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #f5f8fa;
    float: left;
    margin-left: 35px;
    overflow: hidden;
  }

  .show-preview-30 {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #f5f8fa;
    float: left;
    margin-left: 45px;
    overflow: hidden;
  }

  span.cropper-view-box {
    border: 1px solid #39f !important;
    outline: none;
    user-select: none;
    border-radius: 50% !important;
  }

  .img-format {
    font-size: 12px;
    color: #999;
    line-height: 14px;
    margin-bottom: 19px;
  }

  .avatar-tit {
    font-size: 14px;
    line-height: 16px;
    margin-bottom: 29px;
  }

  .img-size {
    font-size: 12px;
    color: #999;
  }
</style>
