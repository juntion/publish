<?php


namespace App\Services\taxExemption;

use App\Models\ProuctInstockShippingApply;
use App\Models\AvataxCertificateToCustomers;
use App\Services\BaseService;
use Aws\CloudFront\Exception\Exception;

/**
 * 免税信息展示以及操作
 *
 * @author aron
 * @date 2019.11.11
 * Class SubscriptionService
 * @package App\Services\Subscription
 */
class TaxExemptionService extends BaseService
{
    private $ProuctInstockShippingApply;
    private $AvataxCertificateToCustomers;

    public function __construct()
    {
        parent::__construct();

        //Model类
        $this->ProuctInstockShippingApply = new ProuctInstockShippingApply();
        $this->AvataxCertificateToCustomers = new AvataxCertificateToCustomers();
    }
    /**
     * 获取客户免税状态
     *
     * @param int $status
     * @param bool $valid
     * @param  array $actual_tax_code
     * @return string
     */
    public function getStatus($status, $valid = true, $actual_tax_code = [])
    {
        $statusData = '';
        switch ($status) {
            case 1:
                $statusData = 'Submitted';
                break;
            case 3:
                if (!$valid || in_array($actual_tax_code['id'], [19.,20])) {
                    if ($actual_tax_code['tag'] != 'TC_EX_EXPI') {
                        $statusData = 'Rejected';
                    } else {
                        $statusData = 'Expired';
                    }
                } else {
                    $statusData = 'Active';
                }
                break;
        }
        return $statusData;
    }

    /**
     * 查询客户免税信息是否在该表已经存在
     *
     * @param int $customers_number_new
     * @return bool
     */
    public function getApplyId($customers_number_new)
    {
        $applyId = 0;
        try {
            if ($customers_number_new) {
                $result = $this->ProuctInstockShippingApply
                    ->where('apply_type', 15)
                    ->where('create_order', 2)
                    ->where('customers_NO', $customers_number_new)
                    ->select('id')
                    ->limit(1)
                    ->get()
                    ->toArray();
                if ($result) {
                    $applyId = $result[0]['id'];
                }
            }
        } catch (\Exception $e) {
            return $applyId;
        }
        return $applyId;
    }

    /**
     * 验证客户在后台是否有可通过的免税
     *
     * @param $customers_number_new
     * @param $delivery_country_name
     * @return mixed
     */
    public function getTaxFreeApplyFromAdmin($customers_number_new, $delivery_country_name)
    {
        $date = date('Y-m-d H:i:s');

        return $this->ProuctInstockShippingApply
            ->select('id', 'vat_number', 'billing_country')
            ->where('apply_type', 15)
            ->where('create_order', 2)
            ->where('customers_NO', $customers_number_new)
            ->where('verify_time', '<', $date)
            ->where('cooperate_to_time', '>', $date)
            ->where('country', $delivery_country_name)
            ->get();
    }

    /**
     * 将客户申请第三方免税信息填充在products_instock_shipping_apply表
     *
     * @param array $data
     * @return int
     */
    public function createApplyData($data)
    {
        $applyId = 0;
        if ($data) {
            $result = $this->ProuctInstockShippingApply->create($data);
            $applyId = $result->id;
        }
        return $applyId;
    }

    /**
     * 将客户申请第三方免税信息填充在avatax_certificate_to_customers表
     *
     * @param array $data
     */
    public function createAvatax($data)
    {
        if ($data) {
            $this->AvataxCertificateToCustomers->create($data);
        }
    }

    /**
     * 修改products_instock_shipping_apply表状态
     *
     * @param int $customers_number_new
     * @param int $avatax_certificate_id
     */
    public function editApply($customers_number_new, $avatax_certificate_id)
    {
        try {
            if ($avatax_certificate_id) {
                $result = $this->AvataxCertificateToCustomers
                    ->where('customers_number_new', $customers_number_new)
                    ->where('avatax_certificate_id', $avatax_certificate_id)
                    ->select('releate')
                    ->limit(1)
                    ->get()
                    ->toArray();
                if ($result[0]) {
                    $releate = $result[0]['releate'];
                    $this->ProuctInstockShippingApply
                        ->where('id', $releate)
                        ->update(['is_delete'=>1]);
                }
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * 修改avatax_certificate_to_customers表状态
     *
     * @param int $customers_number_new
     * @param int $avatax_certificate_id
     */
    public function editAvatax($customers_number_new, $avatax_certificate_id)
    {
        if ($avatax_certificate_id) {
            $data = [
                'is_delete' => 1
            ];
            $this->AvataxCertificateToCustomers
                ->where('customers_number_new', $customers_number_new)
                ->where('avatax_certificate_id', $avatax_certificate_id)
                ->update($data);
        }
    }

    /**
     * 查询avatax_certificate_to_customers
     *
     * @param int $customers_number_new
     * @param int $avatax_certificate_id
     * @return array
     */
    public function getAvataxState($customers_number_new)
    {
        $stateArr = [];
        try {
            if ($customers_number_new) {
                $result= $this->AvataxCertificateToCustomers
                    ->where('customers_number_new', $customers_number_new)
                    ->where('is_delete', 0)
                    ->lists('state');
                if ($result) {
                    $stateArr = $result;
                }
            }
        } catch (\Exception $e) {
            return $stateArr;
        }
        return $stateArr;
    }
}
