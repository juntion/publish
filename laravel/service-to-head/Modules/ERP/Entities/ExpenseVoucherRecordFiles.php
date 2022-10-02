<?php


namespace Modules\ERP\Entities;


class ExpenseVoucherRecordFiles extends Model
{
    protected $table = 'ns_expense_voucher_record_files';

    protected $primaryKey = 'file_id';

    public function export(): array
    {
        return [
            'file_id'   =>$this->file_id,
            'fs_id'     =>$this->fs_id,
            'file_path' =>$this->file_path,
            'file_name' =>$this->file_name,
            'targe_name' =>$this->targe_name
        ];
    }
}
