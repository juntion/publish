<?php

namespace App\Observers\Releases;

use App\ProjectManage\Models\ReleaseProduct;

class ReleaseProductObserver
{
    public function created(ReleaseProduct $product)
    {
        $product->createStatusLog(null, $product->status);
    }

    public function updated(ReleaseProduct $product)
    {
        if ($product->isDirty('status')) {
            $product->createStatusLog($product->getOriginal('status'), $product->status);
        }
    }
}
