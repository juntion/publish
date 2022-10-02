### 安装
```shell
composer install

#修改`.env`
cp .env.example .env

php artisan key:generate

php artisan jwt:secret

#数据结构迁移
php artisan migrate

#创建超管账号
php artisan permission:create-super-admin

#系统初始化数据填充
php artisan db:seed

#迁移后台用户和部门数据
php artisan db:seed --class=FiberstoreSeeder

#建立public/storage软链接，homestead需要以管理员身份启动
php artisan storage:link
```

### 性能优化
在生产环境下，我们可以使用缓存来提升系统性能
```shell
# 配置缓存
php artisan config:cache

# 缓存事件自动发现
php artisan event:cache

# 路由缓存
php artisan route:cache

# 类映射加载优化
php artisan optimize

# 自动加载优化
composer dumpautoload
```
**注意**：每次部署必须更新缓存

### 队列任务

队列默认是同步(`sync`)执行，若想队列异步执行，请将 `QUEUE_CONNECTION` 改成 `redis`

#### 安装 Supervisor
```
yum install -y supervisor
```
Supervisor 依赖 Python 2，Python 3 貌似不行，请务必注意.

#### 配置
配置文件 `/etc/supervisord.d/laravel-worker.ini`
```
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/artisan queue:work --daemon --sleep=3 --tries=3
autostart=true
autorestart=true
user=nginx
numprocs=8
redirect_stderr=true
stdout_logfile=/path/storage/logs/laravel-worker.log
```

#### 启动队列任务
```
service supervisord start
supervisorctl start laravel-worker:*
# 修改 supervisor 配置要重新加载
supervisorctl reread
supervisorctl update

# 平滑重启队列 
php artisan queue:restart
```

### 测试
```
# 测试配置文件
cp .env.example .env.testing

phpunit
```
- 由于生成日志会大大影响运行测试的效率，默认关闭测试日志，若想查看详细的测试日志，请去掉 `phpunit.xml`中 `logging` 部分的注释
- 代码覆盖率测试也可以手动执行命令
```
phpunit --coverage-html=./storage/logs/phpunit/coverage
```
- 代码覆盖率测试需安装 `xdebug` 扩展
