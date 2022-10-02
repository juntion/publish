#!/bin/bash
#encoding=utf-8
#代码自动部署脚本
export COMPOSER_HOME=/home/www/.composer
$(which php) $(which composer) install
$(which php) $(which composer) dump-autoload

#交互式命令自动执行
/usr/bin/expect <<-EOF
spawn $(which php) artisan migrate
expect {
"*yes/no" { send "yes\r";}
}
expect eof

spawn $(which php) artisan db:seed --class=PermissionsTableSeeder
expect {
"*yes/no" { send "yes\r";}
}
expect eof

spawn $(which php) artisan db:seed --class=PageSeeder
expect {
"*yes/no" { send "yes\r";}
}
expect eof
EOF
