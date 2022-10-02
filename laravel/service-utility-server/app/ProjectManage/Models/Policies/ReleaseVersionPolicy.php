<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\Releases\ReleaseVersionStatus;
use App\Models\User;
use App\ProjectManage\Models\ReleaseVersion;

class ReleaseVersionPolicy
{
    /**
     * @param User $user
     * @param ReleaseVersion $version
     * @return bool
     */
    public function update(User $user, ReleaseVersion $version)
    {
        return $version->status == ReleaseVersionStatus::TO_TEST &&
            in_array($user->id, $version->adminIds());
    }

    /**
     * @param User $user
     * @param ReleaseVersion $version
     * @return bool
     */
    public function delete(User $user, ReleaseVersion $version)
    {
        return in_array($version->status, [ReleaseVersionStatus::TO_TEST, ReleaseVersionStatus::IN_TEST]) &&
            in_array($user->id, $version->adminIds());
    }

    /**
     * @param User $user
     * @param ReleaseVersion $version
     * @return bool
     */
    public function releaseTest(User $user, ReleaseVersion $version)
    {
        return $version->status == ReleaseVersionStatus::TO_TEST &&
            in_array($user->id, $version->adminIds());
    }

    /**
     * @param User $user
     * @param ReleaseVersion $version
     * @return bool
     */
    public function releaseOnline(User $user, ReleaseVersion $version)
    {
        return $version->status == ReleaseVersionStatus::IN_TEST &&
            in_array($user->id, $version->adminIds());
    }
}
