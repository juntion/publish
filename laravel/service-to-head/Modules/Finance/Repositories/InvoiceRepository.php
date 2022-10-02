<?php

namespace Modules\Finance\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\AdminRepository;
use Modules\ERP\Repositories\InvoiceRepository as ErpInvoiceRepository;
use Modules\ERP\Repositories\ProductsInstockShippingRepository;
use Modules\Finance\Contracts\InvoiceRepository as ContractsInvoiceRepository;
use Modules\Finance\Entities\Invoice;
use Modules\Finance\Entities\InvoiceToReceipts;
use Modules\Finance\Entities\ClearAccounts;
use Modules\Finance\Entities\PaymentReceiptsVouchersDetail;
use Modules\Finance\Repositories\Traits\EsTrait;
use Prettus\Repository\Eloquent\BaseRepository;

class InvoiceRepository extends BaseRepository implements ContractsInvoiceRepository
{
    use EsTrait;

    public function model()
    {
        return Invoice::class;
    }

    /**
     * @param string $invoiceNumber
     * @return mixed
     */
    public function getErpProductsInvoice(string $invoiceNumber)
    {
        return ErpInvoiceRepository::getProductsInvoice($invoiceNumber);
    }

    /**
     *
     * @param int $relateId
     * @param int $relateType
     * @return mixed
     */
    public static function getErpProductsInstockShippingData(int $relateId, int $relateType=1)
    {
        if ($relateType == 2) {
            $fields = ['shipping_merge_id' => $relateId];
        } else {
            $fields = ['products_instock_id' => $relateId];
        }
        return ProductsInstockShippingRepository::getProductsInstockShippingData($fields);
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getErpAssistantData(int $id)
    {
        return AdminRepository::getAdminInfoByOriginId($id);
    }

    /**
     * @param array $fields
     * @return mixed
     */
    public function toSave(array $fields)
    {
        return Invoice::create($fields);
    }

    /**
     * @param array $whereFields
     * @param array $updateFields
     * @param bool $isSoftDelete
     * @return mixed
     */
    public function toUpdate(array $whereFields, array $updateFields, bool $isSoftDelete = false)
    {
        if ($isSoftDelete) {
            return Invoice::query()->withTrashed()->where($whereFields)->update($updateFields);
        }
        $invoice = Invoice::query()->where($whereFields)->first();
        return $invoice->update($updateFields);
    }

    /**
     * @param array $whereFields
     * @param int $cleared
     * @return mixed
     */
    public function invoiceClearedUpdate(array $whereFields, int $cleared)
    {
        $invoice = Invoice::query()->where($whereFields)->first();
        return $invoice->update([
            'cleared' => $invoice->cleared + $cleared,
        ]);
    }

    /**
     * @param array $fields
     * @return mixed
     */
    public function softDelete(array $fields)
    {
        return Invoice::where($fields)->delete();
    }

    /**
     * @param string $uuid
     * @return mixed
     */
    public function getDataByUuid(string $uuid)
    {
        return Invoice::find($uuid);
    }

    /**
     * 根据发票编号返回发票信息
     * @param string $number
     * @return mixed
     */
    public function getDataByNumber(string $number)
    {
        return Invoice::where('number', $number)->first();
    }

    /**
     * @param array $orderId
     * @return mixed
     */
    public function getPaymentReceiptsVouchersDetails(array $orderIds)
    {
        return PaymentReceiptsVouchersDetail::whereIn('order_id', $orderIds)->get();
    }

    /**
     * @param array $fields
     * @return mixed
     */
    public function toSaveInvoicesToReceipts(array $fields)
    {
        return InvoiceToReceipts::create($fields);
    }
    /**
     * @param array $fields
     * @return mixed
     */
    public function toSaveClearAccounts(array $fields)
    {
        return ClearAccounts::create($fields);
    }


    /**
     *
     * 通过ES查询首页数据
     * @param  int  $type
     * @param $limit
     * @param $key
     * @param  array  $admins
     * @param  string  $sort
     * @return mixed|void
     * @throws \Exception
     */
    public function getTypeIndexByES(int $type, $limit, $key, $admins = [], $sort = "DESC"){
        $key = strtolower($key);
        $query['bool']['must'][]= [
            'bool' => [
                'should' => [
                    [
                        'match_phrase' => [
                            'number' => $key
                        ]
                    ],
                    [
                        'prefix' => [
                            'number' => $key
                        ]
                    ],
                    [
                        'match_phrase' => [
                            'order_num' => $key
                        ]
                    ],
                    [
                        'match_phrase' => [
                            'order_number' => $key
                        ]
                    ],
                    [
                        'match_phrase' => [
                            'customer_company_number' => $key
                        ]
                    ],
                    [
                        'match_phrase' => [
                            'customer_company_name' => $key
                        ]
                    ],
                    [
                        'match_phrase' => [
                            'customer_number' => $key
                        ]
                    ],
                    [
                        'match_phrase' => [
                            'customer_email' => $key
                        ]
                    ]
                ]
            ]
        ];
        if ($type == 2) { // 同组
            $query['bool']['must'][] =
                [
                    'terms' => [
                        'assistant_uuid' => $admins
                    ]
                ];
        } elseif ($type == 3) {
            $query['bool']['must'][] =
                [
                    'term' => [
                        'assistant_uuid' => $admins
                    ]
                ];
        }

        $query = json_encode($query);
        try {
            $lists = Invoice::search($query)->orderBy('created_at', $sort)->paginate($limit);
            $lists = $this->resetNewPaginator($lists, $key);
        } catch (\Exception $exception) {
            $this->catchException($exception);
        }
        return $lists;
    }
    /**
     * 不同权限下的首页数据sql
     * @param  int  $type
     * @param $limit
     * @param  array  $adminIds
     * @return mixed
     */
    public function getTypeIndex(int $type, $limit ,$adminIds = [])
    {
        switch ($type) {
            case 1:
                return $this->paginate($limit);
                break;
            case 2:
                return $this->whereIn('assistant_uuid', $adminIds)->paginate($limit);
                break;
            case 3:
                return $this->where('assistant_uuid', $adminIds)->paginate($limit);
                break;
            default:
                return $this->paginate($limit);
                break;
        }
    }

    /**
     * 查询发票信息
     * @param  string  $uuid
     * @return mixed
     */
    public function findSelf(string $uuid)
    {
        return Invoice::query()->find($uuid);
    }

    /**
     * 查询发票信息
     * @param  array  $fields
     * @return mixed
     */
    public function getInvoiceByIdType($fields)
    {
        return Invoice::query()->where($fields)->first();
    }

    /**
     * 查询发票信息
     * @param  array  $fields
     * @return mixed
     */
    public function getInvoiceAllByIdType($fields)
    {
        return Invoice::query()->where($fields)->get();
    }

    /**
     * 查询清账记录信息
     * @param  array  $fields
     * @param  array  $fieldsIn
     * @return mixed
     */
    public function getClearAccounts(array $fields, array $fieldsIn)
    {
        return ClearAccounts::where($fields)->whereIn('type', $fieldsIn)->get();
    }
    /**
     * 查询核销记录信息
     * @param  array  $fields
     * @return mixed
     */
    public function getInvoicesToReceipts(array $fields)
    {
        return InvoiceToReceipts::where($fields)->get();
    }

    /**
     * 修改核销记录
     * @param array $fields
     * @param array $updateFields
     * @return mixed
     */
    public function invoiceToReceiptUpdate(array $fields, array $updateFields)
    {
        return InvoiceToReceipts::where($fields)->update($updateFields);
    }
}
