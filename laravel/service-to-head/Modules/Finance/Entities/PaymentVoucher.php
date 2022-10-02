<?php

namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Entities\Admin;
use Modules\Base\Entities\Model;
use Modules\Base\Support\Search\Searchable;
use Modules\ERP\Contracts\CustomerCompanyRepository;
use Modules\ERP\Contracts\CustomerRepository;
use Modules\ERP\Contracts\OrderCustomerCompanyService;

class PaymentVoucher extends Model
{
    use Searchable,SoftDeletes;

    protected $table = 'f_payment_vouchers';

    protected $fillable
        = [
            'uuid', 'number', 'currency', 'usable', 'used', 'type', 'order_number', 'remark', 'creator_uuid',
            'creator_name', 'customer_company_number', 'customer_company_name', 'customer_number'
        ];

    public function media()
    {
        return $this->hasMany(PaymentVouchersFile::class, 'vouch_uuid' , 'uuid');
    }

    public function logs()
    {
        return $this->hasMany(PaymentVouchersLog::class, 'uuid', 'uuid');
    }

    public function user()
    {
        return $this->belongsTo(Admin::class, 'creator_uuid', 'uuid');
    }

    public function getMediaCollection()
    {
        return "vouchers";
    }

    public function receiptsToVoucher()
    {
        return $this->hasMany(PaymentReceiptsToVoucher::class, 'voucher_uuid' , 'uuid');
    }

    public function receipts()
    {
        return $this->hasManyThrough(
            PaymentReceipt::class,
            PaymentReceiptsToVoucher::class,
            'voucher_uuid',
            'uuid',
            'uuid',
            'receipt_uuid'
            );
    }

    public function details()
    {
        return $this->hasMany(PaymentReceiptsVouchersDetail::class, 'voucher_uuid', 'uuid');
    }

    public function toSearchableArray()
    {
        $this->refresh();
        $data['number'] = $this->number;
        $data['usable'] =  $this->usable;
        $data['order_number'] =  $this->order_number;
        $data['remark'] =  $this->remark;
        $data['creator_uuid'] =  $this->creator_uuid;
        $data['created_at'] =  $this->created_at;

        $data['DK_number'] = implode(',', $this->receiptsToVoucher->pluck('receipt_number')->toArray());

        if($this->customer_number) {
            $customerNumber = $this->customer_number;
            $data['customer_number'] = $this->customer_number;
            $orderInfo = null;
        } else {
            $companyService = app()->make(OrderCustomerCompanyService::class);

            $orderNumber = $this->order_number;
            // 获取客户编号
            $orderInfo = $companyService->getCustomerAndCompanyInfoByOrderNumber($orderNumber);

            $customerNumber = $orderInfo->customerNumber;
        }

        if (empty($customerNumber)) {
            $data['customer_number'] = "";
            $data['company_number'] = "";
            $data['customer_email'] = "";
            return $data;
        }

        $customerRepository = app()->make(CustomerRepository::class);
        // 获取客户信息
        $customer = (isset($orderInfo->Info) && !empty($orderInfo->Info)) ? $orderInfo->Info : $customerRepository->getCustomerByNumber($customerNumber);

        if (is_null($customer)) {
            $data['customer_number'] = "";
            $data['company_number'] = "";
            $data['customer_email'] = "";
            return $data;
        }


        $data['customer_number'] = $customer->customers_number_new;
        $data['customer_email'] = $customer->customers_email_address;;

        if($this->customer_company_number) {
            $data['company_number'] = $this->customer_company_number;
        } else {
            // 获取公司信息
            $companyRepository = app()->make(CustomerCompanyRepository::class);
            $company = $companyRepository->getCompanyByCustomerNumber($customerNumber);

            if (is_null($company)) {
                $data['company_number'] = "";
            } else {
                $data['company_number'] = $company->company_number;
            }
        }

        return $data;
    }
}
