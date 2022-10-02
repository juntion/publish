<?php

namespace Modules\ERP\Entities;

class StatusHistory extends Model
{
    protected $table = 'orders_status_history';

    protected $primaryKey = 'orders_status_history_id';

    public function export(): array
    {
        return [];
    }

    public function orders(){
        return $this->belongsTo(Order::class, 'orders_id');
    }
}
