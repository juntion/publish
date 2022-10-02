<?php
require_once 'CommandBaseRequired.php';

use App\Services\Quote\QuoteService;

$quotes_s = new QuoteService();
//捕获所有异常
while (true) {
    $res = $quotes_s->updateQuotesExpiredStatus();
    if(empty($res)){
        time_sleep_until(60 + time());
    }
}