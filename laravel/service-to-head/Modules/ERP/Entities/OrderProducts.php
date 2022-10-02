<?php

namespace Modules\ERP\Entities;


class OrderProducts extends Model
{
    protected $table = "orders_products";

    public function export(): array
    {
        return [];
    }
}