<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('Admin.{uuid}', function ($admin, $uuid) {
    return $admin && $admin->getKey() === $uuid;
});
