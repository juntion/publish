<?php

namespace App\Observers;

use App\ProjectManage\Models\Product;

class ProductObserver
{
    public function created(Product $product)
    {
        $product->createStatusLog(null, $product->status);
    }

    public function updated(Product $product)
    {
        if ($product->isDirty('status')) {
            $product->createStatusLog($product->getOriginal('status'), $product->status);
        }
    }
}
