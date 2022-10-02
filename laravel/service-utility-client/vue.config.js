const webpack = require('webpack')
let configs = []
process.env.VUE_APP_VERSION = process.env.npm_package_version

module.exports = {
  // 其他配置....
  productionSourceMap: true,
  configureWebpack: {
    plugins: [
      new webpack.ProvidePlugin({
        'window.Quill': 'quill/dist/quill.js',
        'Quill': 'quill/dist/quill.js'
      }),
      ...configs
    ]
  }
}
