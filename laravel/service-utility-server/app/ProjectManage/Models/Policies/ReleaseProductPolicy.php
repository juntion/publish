<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\Releases\ReleaseProductStatus;
use App\Models\User;
use App\ProjectManage\Models\ReleaseProduct;

class ReleaseProductPolicy
{
    /**
     * @param User $user
     * @param ReleaseProduct $product
     * @return bool
     */
    public function addVersions(User $user, ReleaseProduct $product)
    {
        $adminIds = $product->admins->pluck('user_id')->toArray();
        return $product->status == ReleaseProductStatus::ON && in_array($user->id, $adminIds);
    }
}
