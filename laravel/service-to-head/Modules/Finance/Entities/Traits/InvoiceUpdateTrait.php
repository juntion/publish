<?php


namespace Modules\Finance\Entities\Traits;


use Modules\Base\Entities\Model;

trait InvoiceUpdateTrait
{
    public static function bootInvoiceUpdateTrait()
    {
        static::updating(function (Model $model) {
            if ($model->isDirty('cleared')) {
                if ($model->cleared >= $model->amount) {
                    $model->cleared_status = 2;
                } else if ($model->cleared > 0) {
                    $model->cleared_status = 1;
                } else {
                    $model->cleared_status = 0;
                }
            }
        });
    }
}
