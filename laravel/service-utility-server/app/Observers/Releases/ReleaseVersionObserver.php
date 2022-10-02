<?php

namespace App\Observers\Releases;

use App\ProjectManage\Models\ReleaseVersion;

class ReleaseVersionObserver
{
    public function created(ReleaseVersion $version)
    {
        $version->createStatusLog(null, $version->status);
    }

    public function updated(ReleaseVersion $version)
    {
        if ($version->isDirty('status')) {
            $version->createStatusLog($version->getOriginal('status'), $version->status);
        }
    }
}
