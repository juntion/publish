<?php
require_once 'CommandBaseRequired.php';

use App\Models\OrdersPendingEmailQueue;

clearOrderPendingEmailCacheQueueData();

/**
 * 清除下单邮件记录表里的历史数据
 */
function clearOrderPendingEmailCacheQueueData()
{
    $filepath = DIR_FS_SQL_DEBUG . '/clearOrderPendingEmailCacheQueueDataLock.txt';
    $now = time();
    if (file_exists($filepath) && (int)file_get_contents($filepath) > $now) {
        queueLogReport('Too short from last execution time, program terminated');
        return;
    }
    (new OrdersPendingEmailQueue())->where('is_send', 1)->where('created_at', '<=', $now - 86400 * 30)->delete();
    file_put_contents($filepath, $now + 85000); //比一天稍短
}
