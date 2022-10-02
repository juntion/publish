# FS.com维护文档

- Author: aron
- Date: 2021.1.15 10:21

---

- [FS.com维护文档](#fscom%E7%BB%B4%E6%8A%A4%E6%96%87%E6%A1%A3)
  - [一. 部署](#%E4%B8%80-%E9%83%A8%E7%BD%B2)
    - [1.1 环境部署](#11-%E7%8E%AF%E5%A2%83%E9%83%A8%E7%BD%B2)
      - [1.1.1 apache](#111-apache)
        - [1.1.1.1 apache vhost配置](#1111-apache-vhost%E9%85%8D%E7%BD%AE)
      - [1.1.2 php](#112-php)
        - [1.1.2.1 php ini 配置](#1121-php-ini-%E9%85%8D%E7%BD%AE)
        - [1.1.2.2 php extention 扩展](#1122-php-extention-%E6%89%A9%E5%B1%95)
      - [1.1.3 supervisor](#113-supervisor)
        - [1.1.3.1 部署](#1131-%E9%83%A8%E7%BD%B2)
        - [1.1.3.2 主配置](#1132-%E4%B8%BB%E9%85%8D%E7%BD%AE)
        - [1.1.3.3 服务管理](#1133-%E6%9C%8D%E5%8A%A1%E7%AE%A1%E7%90%86)
    - [1.2 应用部署](#12-%E5%BA%94%E7%94%A8%E9%83%A8%E7%BD%B2)
      - [1.2.1 开发环节部署/安装](#121-%E5%BC%80%E5%8F%91%E7%8E%AF%E8%8A%82%E9%83%A8%E7%BD%B2%E5%AE%89%E8%A3%85)
        - [1.2.1.1 clone 代码](#1211-clone-%E4%BB%A3%E7%A0%81)
        - [1.2.1.2 安装开发依赖扩展包](#1212-%E5%AE%89%E8%A3%85%E5%BC%80%E5%8F%91%E4%BE%9D%E8%B5%96%E6%89%A9%E5%B1%95%E5%8C%85)
        - [1.2.1.3 psr4 自动加载性能](#1213-psr4-%E8%87%AA%E5%8A%A8%E5%8A%A0%E8%BD%BD%E6%80%A7%E8%83%BD)
        - [1.2.1.4 configure文件配置](#1214-configure%E6%96%87%E4%BB%B6%E9%85%8D%E7%BD%AE)
          - [1.2.1.4.1 配置说明](#12141-%E9%85%8D%E7%BD%AE%E8%AF%B4%E6%98%8E)
          - [1.2.1.4.2 创建configure](#12142-%E5%88%9B%E5%BB%BAconfigure)
        - [1.2.1.5 创建bpay文件](#1215-%E5%88%9B%E5%BB%BAbpay%E6%96%87%E4%BB%B6)
        - [1.2.1.6 启动项目自动队列脚本](#1216-%E5%90%AF%E5%8A%A8%E9%A1%B9%E7%9B%AE%E8%87%AA%E5%8A%A8%E9%98%9F%E5%88%97%E8%84%9A%E6%9C%AC)

---

## 一. 部署
### 1.1 环境部署

软件 | 版本|描述
---|---|---
php|5.6.4|程序语言
apache|2.4|Http服务
mysql|5.6|数据存储
redis|5.0|数据存储
supervisor|无版本要求| 后台应用进程管理

#### 1.1.1 apache
#####  1.1.1.1 apache vhost配置
```
<VirtualHost *:80>
	DocumentRoot  /alidata/www/fiberstore.com
        ServerName  www.fs.com
        ServerAlias www.fs.com fs.com ec2-52-88-166-186.us-west-2.compute.amazonaws.com
        DirectoryIndex index.php index.html
  <Directory /home/sites/fiberstore.com/>
        Options +Includes -Indexes
        Header always append X-Frame-Options SAMEORIGIN
	Require all granted
        AllowOverride All
        Order Allow,Deny
        Allow from all
        php_admin_value open_basedir /alidata/www/fiberstore.com:/tmp:/proc
  </Directory>
  
  #feisu代理
  #SSLProxyEngine on  
  #<Location "/cn">  
  #	 RequestHeader set X-Port 80
  #   ProxyPass http://feisu.whgxwl.com/cn/  
  #</Location>

  <LocationMatch "\.git">
     Order allow,deny
     Deny from all
  </LocationMatch>

  ErrorDocument 404 /not_found_404.html
  ErrorLog /alidata/logs/wwwlog/www.fs.com_80_error_apache.log
  CustomLog /alidata/logs/wwwlog/www.fs.com_80_access_apache.log json
</virtualhost>
```
#### 1.1.2 php
##### 1.1.2.1 php ini 配置
配置项 | 配置值
---|---
disable_functions | phpinfo,sleep,passthru,system,popen,chroot,escapeshellcmd,escapeshellarg,shell_exec,proc_open,proc_get_status
short_open_tag|On
memory_limit |50M
max_execution_time|30s
error_log|/var/log/php_errors.log
post_max_size|150M
file_uploads|On
upload_tmp_dir|/tmp
upload_max_filesize|2000M
max_file_uploads|20
session.gc_maxlifetime|1800
date.timezone|America/Los_Angeles
default_charset|UTF-8
suhosin.request.max_vars|1000
suhosin.post.max_vars|1000
suhosin.request.max_array_index_length|256
suhosin.post.max_array_index_length|256
suhosin.request.max_totalname_length|8192
suhosin.get.max_value_length|1024
suhosin.sql.bailout_on_error|off
suhosin.executor.disable_eval|on
suhosin.executor.include.whitelist|phar

##### 1.1.2.2 php extention 扩展
扩展 |
---|
bcmath|
calendar|
Core|
ctype|
curl|
date|
dom|
ereg|
fileinfo|
filter|
ftp|
gd|
geoip|
hash|
iconv|
imagick|
json|
libxml|
mbstring|
mcrypt|
mhash|
mysql|
mysqli|
mysqlnd|
OAuth|
openssl|
pcre|
PDO|
pdo_mysql|
pdo_sqlite|
Phar|
posix|
redis|
Reflection|
session|
SimpleXML|
soap|
sockets|
SPL|
sqlite3|
standard|
suhosin|
tokenizer|
wddx|
xml|
xmlreader|
xmlrpc|
xmlwriter|
zip|
zlib|

#### 1.1.3 supervisor
##### 1.1.3.1 部署
```
yum install-yepel-release 
yum install-ysupervisor
```
添加开机自启动
```
systemctl enable supervisor
```
##### 1.1.3.2 主配置
```
; Sample supervisor config file.

[unix_http_server]
file=/var/run/supervisor/supervisor.sock   ; (the path to the socket file)
;chmod=0700                 ; sockef file mode (default 0700)
;chown=nobody:nogroup       ; socket file uid:gid owner
;username=user              ; (default is no username (open server))
;password=123               ; (default is no password (open server))

;[inet_http_server]         ; inet (TCP) server disabled by default
;port=127.0.0.1:9001        ; (ip_address:port specifier, *:port for all iface)
;username=user              ; (default is no username (open server))
;password=123               ; (default is no password (open server))

[supervisord]
logfile=/var/log/supervisor/supervisord.log  ; (main log file;default $CWD/supervisord.log)
logfile_maxbytes=50MB       ; (max main logfile bytes b4 rotation;default 50MB)
logfile_backups=10          ; (num of main logfile rotation backups;default 10)
loglevel=info               ; (log level;default info; others: debug,warn,trace)
pidfile=/var/run/supervisord.pid ; (supervisord pidfile;default supervisord.pid)
nodaemon=false              ; (start in foreground if true;default false)
minfds=1024                 ; (min. avail startup file descriptors;default 1024)
minprocs=200                ; (min. avail process descriptors;default 200)
;umask=022                  ; (process file creation umask;default 022)
;user=chrism                 ; (default is current user, required if root)
;identifier=supervisor       ; (supervisord identifier, default is 'supervisor')
;directory=/tmp              ; (default is not to cd during start)
;nocleanup=true              ; (don't clean up tempfiles at start;default false)
;childlogdir=/tmp            ; ('AUTO' child log dir, default $TEMP)
;environment=KEY=value       ; (key value pairs to add to environment)
;strip_ansi=false            ; (strip ansi escape codes in logs; def. false)

; the below section must remain in the config file for RPC
; (supervisorctl/web interface) to work, additional interfaces may be
; added by defining them in separate rpcinterface: sections
[rpcinterface:supervisor]
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface

[supervisorctl]
serverurl=unix:///var/run/supervisor/supervisor.sock ; use a unix:// URL  for a unix socket
;serverurl=http://127.0.0.1:9001 ; use an http:// url to specify an inet socket
;username=chris              ; should be same as http_username if set
;password=123                ; should be same as http_password if set
;prompt=mysupervisor         ; cmd line prompt (default "supervisor")
;history_file=~/.sc_history  ; use readline history if available

; The below sample program section shows all possible program subsection values,
; create one or more 'real' program: sections to be able to control them under
; supervisor.

;[program:theprogramname]
;command=/bin/cat              ; the program (relative uses PATH, can take args)
;process_name=%(program_name)s ; process_name expr (default %(program_name)s)
;numprocs=1                    ; number of processes copies to start (def 1)
;directory=/tmp                ; directory to cwd to before exec (def no cwd)
;umask=022                     ; umask for process (default None)
;priority=999                  ; the relative start priority (default 999)
;autostart=true                ; start at supervisord start (default: true)
;autorestart=true              ; retstart at unexpected quit (default: true)
;startsecs=10                  ; number of secs prog must stay running (def. 1)
;startretries=3                ; max # of serial start failures (default 3)
;exitcodes=0,2                 ; 'expected' exit codes for process (default 0,2)
;stopsignal=QUIT               ; signal used to kill process (default TERM)
;stopwaitsecs=10               ; max num secs to wait b4 SIGKILL (default 10)
;user=chrism                   ; setuid to this UNIX account to run the program
;redirect_stderr=true          ; redirect proc stderr to stdout (default false)
;stdout_logfile=/a/path        ; stdout log path, NONE for none; default AUTO
;stdout_logfile_maxbytes=1MB   ; max # logfile bytes b4 rotation (default 50MB)
;stdout_logfile_backups=10     ; # of stdout logfile backups (default 10)
;stdout_capture_maxbytes=1MB   ; number of bytes in 'capturemode' (default 0)
;stdout_events_enabled=false   ; emit events on stdout writes (default false)
;stderr_logfile=/a/path        ; stderr log path, NONE for none; default AUTO
;stderr_logfile_maxbytes=1MB   ; max # logfile bytes b4 rotation (default 50MB)
;stderr_logfile_backups=10     ; # of stderr logfile backups (default 10)
;stderr_capture_maxbytes=1MB   ; number of bytes in 'capturemode' (default 0)
;stderr_events_enabled=false   ; emit events on stderr writes (default false)
;environment=A=1,B=2           ; process environment additions (def no adds)
;serverurl=AUTO                ; override serverurl computation (childutils)

; The below sample eventlistener section shows all possible
; eventlistener subsection values, create one or more 'real'
; eventlistener: sections to be able to handle event notifications
; sent by supervisor.

;[eventlistener:theeventlistenername]
;command=/bin/eventlistener    ; the program (relative uses PATH, can take args)
;process_name=%(program_name)s ; process_name expr (default %(program_name)s)
;numprocs=1                    ; number of processes copies to start (def 1)
;events=EVENT                  ; event notif. types to subscribe to (req'd)
;buffer_size=10                ; event buffer queue size (default 10)
;directory=/tmp                ; directory to cwd to before exec (def no cwd)
;umask=022                     ; umask for process (default None)
;priority=-1                   ; the relative start priority (default -1)
;autostart=true                ; start at supervisord start (default: true)
;autorestart=unexpected        ; restart at unexpected quit (default: unexpected)
;startsecs=10                  ; number of secs prog must stay running (def. 1)
;startretries=3                ; max # of serial start failures (default 3)
;exitcodes=0,2                 ; 'expected' exit codes for process (default 0,2)
;stopsignal=QUIT               ; signal used to kill process (default TERM)
;stopwaitsecs=10               ; max num secs to wait b4 SIGKILL (default 10)
;user=chrism                   ; setuid to this UNIX account to run the program
;redirect_stderr=true          ; redirect proc stderr to stdout (default false)
;stdout_logfile=/a/path        ; stdout log path, NONE for none; default AUTO
;stdout_logfile_maxbytes=1MB   ; max # logfile bytes b4 rotation (default 50MB)
;stdout_logfile_backups=10     ; # of stdout logfile backups (default 10)
;stdout_events_enabled=false   ; emit events on stdout writes (default false)
;stderr_logfile=/a/path        ; stderr log path, NONE for none; default AUTO
;stderr_logfile_maxbytes=1MB   ; max # logfile bytes b4 rotation (default 50MB)
;stderr_logfile_backups        ; # of stderr logfile backups (default 10)
;stderr_events_enabled=false   ; emit events on stderr writes (default false)
;environment=A=1,B=2           ; process environment additions
;serverurl=AUTO                ; override serverurl computation (childutils)

; The below sample group section shows all possible group values,
; create one or more 'real' group: sections to create "heterogeneous"
; process groups.

;[group:thegroupname]
;programs=progname1,progname2  ; each refers to 'x' in [program:x] definitions
;priority=999                  ; the relative start priority (default 999)

; The [include] section can just contain the "files" setting.  This
; setting can list multiple files (separated by whitespace or
; newlines).  It can also contain wildcards.  The filenames are
; interpreted as relative to this file.  Included files *cannot*
; include files themselves.

[include]
files = supervisord.d/*.ini
files = /alidata/www/fiberstore.com/queue_config/*.ini

```

##### 1.1.3.3 服务管理
- 启动:systemctl start supervisord
- 停止:systemctl stop supervisord
- 重启:systemctl restart supervisord



### 1.2 应用部署

#### 1.2.1 开发环节部署/安装

##### 1.2.1.1 clone 代码

```
git clone git@git.whgxwl.com:fs/fs.com.git
```
##### 1.2.1.2 安装开发依赖扩展包

```
composer install
```

##### 1.2.1.3 psr4 自动加载性能

```
composer dump-autoload -o 
```

##### 1.2.1.4 configure文件配置

###### 1.2.1.4.1 配置说明

name | value|描述
---|---|---
HTTP_SERVER | http://www.fs.com| http请求下 站点域名
HTTPS_SERVER | https://www.fs.com| https 请求下站点域名
HTTP_IMAGE_SERVER|http://img-en.fs.com/|http 资源图片路径 测试环境:http://static.whgxwl.com:6060 生产环境:http://img-en.fs.com
HTTPS_IMAGE_SERVER|http://img-en.fs.com/|http 资源图片路径 测试环境:https://static.whgxwl.com:6060 生产环境:https://img-en.fs.com
STATIC_RESOURCE_UP|true|是否使用资源服务器图片链接
SERVER_HEADER|fslb1|已废弃
ENABLE_SSL|true|是否使用http证书
PAYEEZY_STATUS|true|是否开启payeez信用卡渠道
FS_RECAPTCHA_SWITCH|1|登录注册 用户密码账号信息是否加密
DIR_WS_CATALOG|/|http 根路径
DIR_WS_IMAGES|images/|项目本地图片存储路径
DIR_WS_INCLUDES|includes/|项目inlcudes目录路径
DIR_WS_FUNCTIONS|DIR_WS_INCLUDES . 'functions/| 项目function 函数加载目录
DIR_WS_CLASSES|DIR_WS_INCLUDES . 'classes/'|项目类加载目录
DIR_WS_MODULES|DIR_WS_INCLUDES . 'modules/'|项目modlues 加载目录
DIR_WS_LANGUAGE| DIR_WS_INCLUDES . 'languages/'|项目语言包加载
DIR_WS_DOWNLOAD_PUBLIC|DIR_WS_CATALOG . 'pub/|项目pub 目录
DIR_WS_TEMPLATES|DIR_WS_INCLUDES . 'templates/'|项目templates
DIR_WS_FS_IMAGES| DIR_WS_TEMPLATES . 'fiberstore/images/'|项目images存放目录
DIR_WS_PHPBB|/|已废弃
DIR_FS_CATALOG|/alidata/www/fiberstore.com/|网站根目录
DIR_FS_DOWNLOAD|DIR_FS_CATALOG . 'download/'|网站下载目录
DIR_FS_DOWNLOAD_PUBLIC|DIR_WS_CATALOG . 'pub/'|已废弃
DIR_WS_UPLOADS|DIR_WS_IMAGES . 'uploads/'|网站上传目录
DIR_FS_UPLOADS|DIR_FS_CATALOG . DIR_WS_UPLOADS|网站上传绝对路径
DIR_FS_PIC_UPLOADS|DIR_FS_CATALOG . DIR_WS_UPLOADS.'picture/'|废弃
DIR_FS_EMAIL_TEMPLATES|DIR_FS_CATALOG . 'email/'|邮件模版目录
DB_TYPE|mysql|数据库类型
DB_CHARSET|utf8|数据库编码
DB_PREFIX|''|数据库前缀
DB_SERVER|''|前台写库地址 生产环境数据咨询:peter 或运维 测试环境联系aron
DB_SERVER_USERNAME|''|前台写库用户名 生产环境数据咨询:peter 或运维 测试环境联系aron
DB_SERVER_PASSWORD|''|前台写库密码 生产环境数据咨询:peter 或运维 测试环境联系aron
DB_DATABASE|fiberstore_spain|前台读库 使用数据库名称|
DB_SERVER_READ||前台读库地址 生产环境数据咨询:peter 或运维 测试环境联系aron
DB_SERVER_USERNAME_READ||前台读库 用户名生产环境数据咨询:peter 或运维 测试环境联系aron
DB_SERVER_PASSWORD_READ||前台读库密码生产环境数据咨询:peter 或运维 测试环境联系aron
DB_DATABASE_READ|fiberstore_spain|前台读库数据库名称
DB_READ_SERVER_ENABLE|true|前台数据库是否启用读写分离
USE_PCONNECT|flase|数据库是否使用长连接
STORE_SESSIONS|redis|session 存储方式1.redis 2. mysql 3.file
SQL_CACHE_METHOD||sql缓存方式|
DIR_FS_SQL_CACHE|/alidata/www/fiberstore.com/cache|sql缓存文件
DIR_FS_SQL_DEBUG|/alidata/www/fiberstore.com/debug|sql debug存放目录
SESSION_WRITE_DIRECTORY|/alidata/www/fiberstore.com/cache|session 生成存放目录,仅在 STORE_SESSIONS 为file 时生效
VAR_AUTO_STRING|false|废弃配置
IS_PROMOT|false|废弃配置
DEFAULT_FILTER|strip_tags,htmlspecialchars|废弃配置
URL_PATHINFO_DEPR|/|废弃配置
RESOURCES_FTP_IP||资源服务器ftp上传地址 生产环境数据咨询:peter 或运维 测试环境联系aron
RESOURCES_FTP_USERNAME||资源服务器ftp上传用户名 生产环境数据咨询:peter 或运维 测试环境联系aron
RESOURCES_FTP_PASSWORD||资源服务器ftp上传密码 生产环境数据咨询:peter 或运维 测试环境联系aron
CONTROL_FTP_IP||废弃配置
CONTROL_FTP_USERNAME||废弃配置
CONTROL_FTP_PASSWORD||废弃配置
AMAZON_KEY||亚马逊dynamodb秘钥
AMAZON_SECRET||亚马逊dynamodb秘钥
ENCRYPT_KEY||统计数据采集加密KEY,数据请找peter 运维提供
RSA_PRIVATE_KEY||用户登录注册 账号信息 前端加密私钥,peter 运维提供
RSA_MODULUS||用户登录注册 账号信息 前端加密私钥,peter 运维提供
HTTP_SERVER_ADMIN||废弃配置
US_WAREHOUSE_UP|true|是否关闭美西仓库
REDIS_HOST||redis 请求地址
REDIS_SELECT_DB|| redis 默认使用db
REDIS_PORT|| redis 端口号
REDIS_PASSWORD||redis密码
REDIS_PREFIX||redis前缀
FS_USE_PREDIS|true|是否使用predis
MYSQL_QUERY_CACHE|SQL_CACHE| sql查询时附带 sql_cache缓存
USE_CANCEL_ORDER_SECRET|false|取消订单接口是否使用密钥验证
CANCEL_ORDER_SECRET_KET|aa|取消订单接口请求key
CANCEL_ORDER_ACCESS_IP|127.0.0.1|取消订单 接口授权ip
USE_AUTOMATIC_CANCEL_ORDER|true|是否开启自动取消订单
FS_TEST_SERVICE|false|废弃配置 新加坡安装服务测试配置
RESOURCES_GO_SERVER|http://13.251.207.44:10004/upload|文件cli上传地址
CLI_UPLOAD_ENABLE|true|是否使用cli上传
ORDER_PENDING_EMAIL_QUEUE_SEND|true|订单邮件是否 使用队列
COMMUNITY_DB_SERVER||community 数据库请求地址 只读
COMMUNITY_DB_SERVER_USERNAME||community 数据库名称
COMMUNITY_DB_SERVER_PASSWORD||community数据库密码
COMMUNITY_DB_DATABASE|fs_blog|community数据库库名称
FERSU_EMAIL_USERNAME|service@feisu.com|前台邮件发送账号
FERSU_EMAIL_PASSWORD||前台发送邮件密码 peter 运维提供提供
AUTOAVATAX|true|美国消费税开关
AVATAX_TEST|production| 1. production生产环境 2. test 测试环境
$common_mysql_config|| 废弃配置
C_DB_SERVER||写库地址,为了避免前后台数据库读写延迟，导致数据异常强制数据查询库
C_DB_SERVER_USERNAME||写库用户名
C_DB_SERVER_PASSWORD||写库密码
C_DB_DATABASE|fiberstore_spain|写库 数据库库名称 
C_USE_PCONNECT|false|写库是否使用 长连接
AJAX_NUM|6|ajax 返回数据条数|需要排查是否可以废弃
TABLE_DOC_CATEGORIES|doc_categories|重复定义配置,需要废弃
TABLE_DOC_CATEGORIES_DESCRIPTION|doc_categories_description|重复定义配置,需要废弃
TABLE_DOC_ARTICLE|doc_article|重复定义配置,需要废弃
TABLE_DOC_ARTICLE_DESCRIPTION|doc_article_description|重复定义配置,需要废弃
TABLE_DOC_ARTICLE_CATEGORY|doc_article_category|重复定义配置,需要废弃


###### 1.2.1.4.2 创建configure
 - cd /alidata/www/fiberstore.com
 - touch includes/configure.php
 - vim includes/configure.php([模版参考链接](https://git.whgxwl.com:10025/fs/fs.com/blob/develop/includes/configure.php.example))

##### 1.2.1.5 创建bpay文件
- bpay ([bapay 文件获取地址](https://git.whgxwl.com:10025/fs/fs.com/wikis/bpay))
- tar -zxvf bpay.gz
- cp -R bapy /alidata/www/fiberstore.com/

##### 1.2.1.6 启动项目自动队列脚本

 - 队列清单

进程名称 | 描述 | 管理后台|文件地址
---|---|---|---
adminAutoGiven_00|客户分配|https://cn.fs.com/YX_0evWtMz4373v/supManage.php|app/Command/CustomersRegisterAllot.php
avaTax_00|消费税推送|https://cn.fs.com/YX_0evWtMz4373v/supManage.php|app/Command/avaTaxCommand.php
orderOvertime_00|订单超时取消|https://cn.fs.com/YX_0evWtMz4373v/supManage.php|/scripts/order_overtime/order_overtime.php
ordersPendingEmail_00|下单邮件发送|https://cn.fs.com/YX_0evWtMz4373v/supManage.php|app/Command/OrdersPendingEmailCommand.php
registerEmail_00|注册邮件发送|https://cn.fs.com/YX_0evWtMz4373v/supManage.php|app/Command/RegistEmailCommand.php
 
> 注意:非生产环境不要启动队列,否则会给客户发送错误邮件以及数据异常

- 启动方式1: 访问 https://cn.fs.com/YX_0evWtMz4373v/supManage.php, 前台队列管理界面，进行项目启动
- 启动方式2:
 ```
 cd  /alidata/www/fiberstore.com/queue_config
 supervisorctl start adminAutoGiven
 supervisorctl start avaTax
 supervisorctl start orderOvertime
supervisorctl start registerEmail
supervisorctl start ordersPendingEmail
 ```
