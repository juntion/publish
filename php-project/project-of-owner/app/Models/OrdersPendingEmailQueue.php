<?php

namespace App\Models;

/*
CREATE TABLE IF NOT EXISTS `orders_pending_email_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orders_id` bigint(11) default 0,
  `is_send` tinyint(1) default 0 COMMENT '0：未发送;1:已发送;2:发现异常',
  `data` blob COMMENT '邮件本体数据',
  `exception` blob COMMENT '异常数据',
  `created_at` bigint(11) default 0 COMMENT '数据插入时的时间戳',
  PRIMARY KEY (`id`),
  KEY `orders_id` (`orders_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='下单邮件转定时发送数据';
*/
class OrdersPendingEmailQueue extends BaseModel
{

    protected $table='orders_pending_email_queue';
    public $timestamps = false;
//    protected $connection = "write";
    protected $fillable = [
        'orders_id',
        'is_send',
        'data',
        'exception',
        'created_at',
    ];
}
