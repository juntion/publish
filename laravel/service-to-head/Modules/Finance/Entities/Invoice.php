<?php

namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Base\Entities\Model;
use Modules\Base\Support\Search\Searchable;
use Modules\ERP\Repositories\CustomerRepository;
use Modules\Finance\Contracts\InvoiceRepository;
use Modules\Finance\Entities\Traits\InvoiceUpdateTrait;

class Invoice extends Model
{
    use SoftDeletes,Searchable,InvoiceUpdateTrait;

    /**
     * @var string
     */
    protected $table = 'f_invoices';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $guarded = [];

    public function clearAccounts()
    {
        return $this->hasMany(ClearAccounts::class, 'expend_number', 'number');
    }

    public function toSearchableArray()
    {
        $this->refresh();
        $data['assistant_uuid'] = $this->assistant_uuid;
        $data['created_at'] = $this->created_at;
        $data['number'] = $this->number;
        $data['customer_company_number'] =  $this->customer_company_number;
        $data['customer_company_name'] =  $this->customer_company_name;
        $data['customer_number'] =  $this->customer_number;
        $data['customer_email'] =  CustomerRepository::getCustomerByNumber($this->customer_number)->customers_email_address??'';

        $orderNumberArr = $orderNumArr = [];
        $repository = app()->make(InvoiceRepository::class);
        $instockArr = $repository->getErpProductsInstockShippingData($this->relate_id, $this->relate_type);
        foreach ($instockArr as $val) {
            $orderNumberArr[] = $val->order_number??$val->order_invoice;
            $orderNumArr[] = $val->orders_num;
        }
        $data['order_number'] = implode(',', $orderNumberArr);
        $data['order_num'] = implode(',', $orderNumArr);
        return $data;
    }
}
