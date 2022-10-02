<?php

namespace Modules\ERP\Entities;


class OrderTotal extends Model
{
    protected $table = "orders_total";

    public function export(): array
    {
        return [];
    }
}