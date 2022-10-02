<?php
namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\RechnungInvoiceRepository as ContractsRechnungInvoiceRepository;
use Modules\ERP\Entities\RechnungInvoice;
use Modules\ERP\Entities\RechnungInvoiceOrder;

class RechnungInvoiceRepository implements ContractsRechnungInvoiceRepository
{
    public function getRechnungInfoById($id)
    {
        return RechnungInvoice::where('id',$id)->orderByDesc('id')->get()->first();
    }

    public function getRechnungOrderInfoById($id)
    {
        return RechnungInvoiceOrder::where('products_instock_id',$id)->where('is_delete',0)->orderByDesc('id')->get()->first();
    }

    public function rechnungUpdate(array $fields, array $updateFields){
        return RechnungInvoice::where($fields)->update($updateFields);
    }

    public function rechnungOrderUpdate(array $fields, array $updateFields){
        return RechnungInvoiceOrder::where($fields)->update($updateFields);
    }
}