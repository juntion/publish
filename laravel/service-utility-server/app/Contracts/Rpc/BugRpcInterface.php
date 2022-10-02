<?php

namespace App\Contracts\Rpc;

interface BugRpcInterface
{
    /**
     * 状态同步
     * @param string $erpBugNumber
     * @param int $status
     * @return mixed
     */
    public function syncStatus(string $erpBugNumber, int $status);
}
