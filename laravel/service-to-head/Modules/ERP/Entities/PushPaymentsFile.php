<?php


namespace Modules\ERP\Entities;



class PushPaymentsFile extends Model
{
    protected $table = 'ns_push_payments_file';

    protected $primaryKey = 'id';

    public function export(): array
    {
        return [
            'id'=>$this->id,
            'ns_push_payments_id'=>$this->ns_push_payments_id,
            'file_name'=>$this->file_name,
            'file_storage_name'=>$this->file_storage_name,
            'file_path'=>$this->file_path,
            'add_time'=>$this->add_time,
            'is_finance'=>$this->is_finance,
            'is_cancel'=>$this->is_cancel
        ];
    }
}
