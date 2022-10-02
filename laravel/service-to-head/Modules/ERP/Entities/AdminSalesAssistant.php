<?php

namespace Modules\ERP\Entities;


class AdminSalesAssistant extends Model
{
    protected $table = "admin_sales_to_assistant";

    protected $primaryKey = "id";

    public function export(): array
    {
        return [];
    }
}