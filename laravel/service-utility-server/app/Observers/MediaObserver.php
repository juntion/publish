<?php

namespace App\Observers;

use App\Models\System\Media;
use Illuminate\Support\Facades\Auth;

class MediaObserver
{
    public function creating(Media $media)
    {
        if (empty($media->user_id) && ($user = Auth::user())) {
            $media->user_id = $user->id;
            $media->user_name = $user->name;
        }
    }
}
