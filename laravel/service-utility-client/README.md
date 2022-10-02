## uums-client
- [前后端分离开发流程](https://git.whgxwl.com:10025/King.Li/document/blob/master/前后端分离开发流程.md)
- [相关文档](https://git.whgxwl.com:10025/King.Li/document/blob/master/README.md)
- [后端项目（uums-server）](https://git.whgxwl.com:10025/fs/uums-server)
- [前端项目规范](https://git.whgxwl.com:10025/fs/uums-client/wikis/pms%E5%89%8D%E7%AB%AF%E4%BB%A3%E7%A0%81%E8%A7%84%E8%8C%83)

### Set API request url
```
echo "VUE_APP_API_URL=http://backend.fs.local/api/supplier" > .env.local
```
### SET ERP URL
```
echo VUE_APP_ERP_URL=http://fs-manager.dev.test >> .env.local
```
### Project setup
```
yarn install
```

#### Compiles and hot-reloads for development
```
yarn run serve
```

#### Compiles and minifies for production
```
yarn run build
```

#### Run your tests
```
yarn run test
```

#### Lints and fixes files
```
yarn run lint
```

#### Run your end-to-end tests
```
yarn run test:e2e
```

#### Run your unit tests
```
yarn run test:unit
```

#### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).
