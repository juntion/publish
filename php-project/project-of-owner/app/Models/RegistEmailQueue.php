<?php

namespace App\Models;

/*
CREATE TABLE IF NOT EXISTS `regist_email_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) default 0,
  `is_send` tinyint(1) default 0 COMMENT '0：未发送;1:已发送;2:发现异常',
  `data` blob COMMENT '邮件本体数据',
  `exception` blob COMMENT '异常数据',
  `response` blob COMMENT '影响字段',
  `created_at` bigint(11) default 0 COMMENT '数据插入时的时间戳',
  PRIMARY KEY (`id`),
  KEY `customers_id` (`customers_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='注册邮件转定时发送数据';
*/
class RegistEmailQueue extends BaseModel
{

    protected $table='regist_email_queue';
    public $timestamps = false;
//    protected $connection = "write";
    protected $fillable = [
        'customers_id',
        'is_send',
        'data',
        'exception',
        'created_at',
    ];
}
