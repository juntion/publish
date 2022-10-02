<?php


namespace Modules\ERP\Entities;


class PaymentMethod extends Model
{
    protected $table = 'payment_method';

    protected $primaryKey = 'id';

    public function export(): array
    {
        return [];
    }

    public function parent()
    {
        return $this->belongsTo(PaymentMethod::class, 'pid', 'id');
    }
}
