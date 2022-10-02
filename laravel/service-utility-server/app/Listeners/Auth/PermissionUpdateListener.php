<?php

namespace App\Listeners\Auth;

use App\Enums\Permission\PermissionLogType;
use App\Events\Auth\PermissionUpdate;
use App\Models\SubsystemRpcInfo;

class PermissionUpdateListener
{

    protected $except = [
        'erp'
    ];

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PermissionUpdate $event
     * @return void
     */
    public function handle(PermissionUpdate $event)
    {
        foreach (SubsystemRpcInfo::getRpcClients() as $sys => $rpcClient) {
            if (in_array($sys, $this->except)) continue;
            try {
                switch ($event->type) {
                    case PermissionLogType::ROLE_PERMISSION:
                        $rpcClient->getRpcClient()->clearPermissionRolesCache($event->keys);
                        break;
                    case PermissionLogType::USER_ROLE:
                        $rpcClient->getRpcClient()->clearUserRolesCache($event->keys);
                        break;
                    case PermissionLogType::USER_PERMISSION:
                        $rpcClient->getRpcClient()->clearUserPermissionsCache($event->keys);
                        break;
                }
            } catch (\Exception $e) {
                logger()->channel('rpc')->debug($e->getMessage());
            }
        }
    }
}