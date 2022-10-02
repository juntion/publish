<?php

namespace Modules\ERP\Entities;

class Invoice extends Model
{

    /**
     * @var string
     */
    protected $table = 'fs_invoice_number';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @return array
     */
    public function export(): array
    {
        return [
            'id'=>$this->id,
            'relate_id'=>$this->relate_id,
            'type'=>$this->type,
            'create_at'=>$this->create_at,
            'create_from'=>$this->create_from,
            'in_number'=>$this->in_number,
            'status'=>$this->status,
            'invocie_date'=>$this->invocie_date
        ];
    }
}
