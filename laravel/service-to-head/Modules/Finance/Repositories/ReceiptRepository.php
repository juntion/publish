<?php

namespace Modules\Finance\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Base\Support\Facades\Number;
use Modules\Finance\Contracts\ReceiptRepository as ContractsReceiptRepository;
use Modules\Finance\Entities\PaymentClaimApplication;
use Modules\Finance\Entities\PaymentReceipt;
use Modules\Finance\Entities\PaymentReceiptsToVoucher;
use Modules\Finance\Entities\PaymentReceiptsVouchersDetail;
use Modules\Finance\Exceptions\ReceiptException;
use Modules\Finance\Repositories\Traits\EsTrait;
use Prettus\Repository\Eloquent\BaseRepository;

class ReceiptRepository extends BaseRepository implements ContractsReceiptRepository
{
    use EsTrait;

    public function model()
    {
        return PaymentReceipt::class;
    }

    public function createByModel(PaymentReceipt $paymentReceipt)
    {
        if ($paymentReceipt->exists) return $paymentReceipt;

        if (!$paymentReceipt->transaction_serial_number || !$paymentReceipt->currency || !$paymentReceipt->amount || !$paymentReceipt->payment_method_id) {
            throw new ReceiptException(__('finance::receipt.validatorFailed'));
        }

        $paymentReceipt->uuid = $paymentReceipt->uuid ?? Str::uuid()->getHex()->toString();
        $paymentReceipt->number = $paymentReceipt->number ?? Number::create('DK')->get();
        $paymentReceipt->fee = $paymentReceipt->fee_fs ?? 0;
        $paymentReceipt->usable = $paymentReceipt->amount + $paymentReceipt->fee + ($paymentReceipt->float ?? 0);
        $paymentReceipt->used = $paymentReceipt->used ?? 0; // 如果设定了期初，就用期初
        $paymentReceipt->cleared = $paymentReceipt->cleared ?? 0; // 如果设定了期初，就用期初
        $paymentReceipt->claim_uuid = null;
        $paymentReceipt->claim_name = null;
        $paymentReceipt->claim_status = 0;
        $paymentReceipt->claim_type = 0;
        $paymentReceipt->claim_time = null;
        $paymentReceipt->application_uuid = null;

        if(!$paymentReceipt->payment_time) {
            $paymentReceipt->payment_time = Carbon::now();
        }

        $paymentReceipt->save();
        $paymentReceipt->refresh();

        return $paymentReceipt;
    }

    public function store(array $paymentReceipt)
    {
        $receipt = $this->create($paymentReceipt);
        return $receipt->refresh();
    }

    /**
     * 回滚成待认领状态
     * @param  PaymentClaimApplication $paymentClaimApplication
     */
    public function resetStatus2Unclaimed(PaymentReceipt $paymentReceipt)
    {
        $paymentReceipt->update([
            'claim_uuid' => null,
            'claim_name' => null,
            'claim_status' => 0,
            'claim_time' => null,
            'application_uuid' => null,
            'customer_company_number' => null,
            'customer_company_name' => null,
            'customer_number' => null,
        ]);
    }

    /**
     * 回滚成已认领状态
     * @param  PaymentClaimApplication $paymentClaimApplication
     */
    public function resetStatus2Claimed(PaymentReceipt $paymentReceipt)
    {
        $claim = $paymentReceipt->claims()
            ->where('apply_type', 1)
            ->where('check_status', 1)
            ->orderBy("created_at", "DESC")
            ->first();

        $paymentReceipt->update([
            'claim_uuid' => $claim->apply_uuid,
            'claim_name' => $claim->apply_name,
            'claim_status' => 2,
            'claim_time' => $claim->created_at,
            'application_uuid' => $claim->uuid
        ]);
    }

    /**
     * @param  string $uuid
     * @param  string $adminUuid
     * @return mixed
     */
    public function findSelf(string $uuid, string $adminUuid)
    {
        return PaymentReceipt::query()->where(function ($query) use ($adminUuid) {
            $query->whereIn('claim_status', [0, 1])->orWhere('claim_uuid', $adminUuid);
        })->withTrashed()->find($uuid);
    }

    /**
     * @param  string $uuid
     * @param  array $adminIds
     * @return mixed
     */
    public function findGroup(string $uuid, array $adminIds)
    {
        return PaymentReceipt::query()->where(function ($q1) use ($adminIds) {
            $q1->whereIn('claim_uuid', $adminIds)->orWhereIn('claim_status', [0, 1]);
        })
            ->withTrashed()
            ->find($uuid);
    }

    /**
     * @param  string $uuid
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getReceiptVouchers(string $uuid)
    {
        return PaymentReceiptsToVoucher::query()
            ->where('receipt_uuid', $uuid)
            ->with('voucher')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * @param  string $uuid
     * @param  string $voucherUuid
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getVouchersDetails(string $uuid, string $voucherUuid)
    {
        return PaymentReceiptsVouchersDetail::query()
            ->where('receipt_uuid', $uuid)
            ->where('voucher_uuid', $voucherUuid)
            ->get();
    }

    /**
     * @param  string $number
     * @param  int $type
     * @param $adminIds
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed|object|null
     */
    public function findByNumber(string $number, int $type, $adminIds = [])
    {
        $query = PaymentReceipt::query()
            ->where('number', $number)
            ->where('claim_status', 2)
            ->whereRaw('`used` < `usable`');
        switch ($type) {
            case 1:
                return $query->get();
                break;
            case 2:
                return $query->whereIn('claim_uuid', $adminIds)->get();
                break;
            case 3:
                return $query->where('claim_uuid', $adminIds)->get();
                break;
        }
    }


    /**
     * 不同权限下的首页数据sql
     * @param  int $type
     * @param $limit
     * @param  array $adminIds
     * @return mixed
     */
    public function getTypeIndex(int $type, $limit, $adminIds = [], $sort = "DESC")
    {
        switch ($type) {
            case 1:
                return $this->withTrashed()->with(['application' => function ($q) {
                    $q->with('media');
                }])
                    ->orderBy('created_at', $sort)
                    ->orderBy('number', "DESC")
                    ->paginate($limit);
                break;
            case 2:
                return $this->withTrashed()->where(function ($q) use ($adminIds) {
                    $q->whereIn('claim_uuid', $adminIds)->orWhere('claim_status', '!=', 2);
                })->with(['application' => function ($q) {
                    $q->with('media');
                }])
                    ->orderBy('created_at', $sort)
                    ->orderBy('number', "DESC")
                    ->paginate($limit);
                break;
            case 3:
                return $this->withTrashed()->where(function ($q) use ($adminIds) {
                    $q->where('claim_uuid', $adminIds)->orWhere('claim_status', '!=', 2);
                })
                    ->with(['application' => function ($q) {
                        $q->with('media');
                    }])
                    ->orderBy('created_at', $sort)
                    ->orderBy('number', "DESC")
                    ->paginate($limit);
                break;
        }
    }


    /**
     *
     * 通过ES查询首页数据
     * @param  int $type
     * @param $limit
     * @param $key
     * @param  array $admins
     * @param  string $sort
     * @return mixed|void
     * @throws \Exception
     */
    public function getTypeIndexByES(int $type, $limit, $key, $admins = [], $sort = "DESC")
    {
        $key = strtolower($key);
        $must = [
            [
                'match_phrase' => [
                    'number' => $key // 到款编号
                ]
            ],
            [
                'prefix' => [
                    'number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'transaction_serial_number' => $key
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
                    'payer_name' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'payer_email' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'order_number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'payment_remark' => $key
                ]
            ]
        ];
        if ((is_numeric($key) && $key < 21474836)) {
            $must[] = [
                'term' => [
                    'amount' =>  $key * 100
                ]
            ];
        }
        $query['bool']['must'][] = [
            'bool' => [
                'should' => $must
            ]
        ];
        if ($type == 2) { // 同组
            $query['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        [
                            'terms' => [
                                'claim_uuid' => $admins
                            ]
                        ],
                        [
                            'terms' => [
                                'claim_status' => [0, 1]
                            ]
                        ]
                    ]
                ]
            ];
        } elseif ($type == 3) {
            $query['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        [
                            'term' => [
                                'claim_uuid' => $admins
                            ]
                        ],
                        [
                            'terms' => [
                                'claim_status' => [0, 1]
                            ]
                        ]
                    ]
                ]
            ];
        }
        $query = json_encode($query);
        try {
            $lists = PaymentReceipt::search($query)->orderBy('created_at', $sort)->paginate($limit);
            $lists->setCollection($lists->getCollection()->load(['application' => function ($q) {
                $q->with('media');
            }]));
            $lists = $this->resetNewPaginator($lists, $key);
        } catch (\Exception $exception) {
            $this->catchException($exception);
        }
        return $lists;
    }

    /**
     * 使用金额
     * @param  PaymentReceipt $paymentReceipt
     * @param  int $amount
     * @return mixed
     */
    public function useAmount(PaymentReceipt $paymentReceipt, int $amount)
    {
        $paymentReceipt->increment('used', $amount);
    }

    /**
     * @param  PaymentReceipt $paymentReceipt
     * @param  int $float
     * @return mixed
     */
    public function updateFloat(PaymentReceipt $paymentReceipt, int $float)
    {
        $paymentReceipt->update([
            'float' => DB::raw("`float` + " . $float),
            'usable' => DB::raw("`usable` + " . $float),
        ]);
    }

    /**
     * @param  string $uuid
     * @param  int $used
     * @return mixed|void
     */
    public function revokeUsed(string $uuid, int $used)
    {
        $this->find($uuid)->decrement('used', $used);
    }

    /**
     * @param  string $number
     * @return mixed
     */
    public function getReceiptByNumber(string $number)
    {
        return $this->findByField('number', $number)->first();
    }

    /**
     * @param string $transaction_serial_number
     * @return mixed
     */
    public function getReceiptByTransaction(string $transaction_serial_number)
    {
        return $this->findByField('transaction_serial_number', $transaction_serial_number)->first();
    }

    public function findByOrderNumberAndNumber(string $orderNumber, string $number, int $type, $admins)
    {
        $query = PaymentReceipt::query()
            ->where('claim_status', 2)
            ->whereRaw('used < usable');
        if ($number) {
            $query->where('number', $number);
        }
        $query->where(function ($q) use ($orderNumber){
            $q->whereHas('details', function ($q) use ($orderNumber) {
                return $q->where('order_number', $orderNumber);
            })->orWhere('order_number', $orderNumber);
        });
        switch ($type) {
            case 1:
                return $query->get();
                break;
            case 2:
                return $query->whereIn('claim_uuid', $admins)->get();
                break;
            case 3:
                return $query->where('claim_uuid', $admins)->get();
                break;
        }
    }

    public function updateFee(PaymentReceipt $receipt, int $fee)
    {
        $receipt->update([
            'fee' => DB::raw("`fee` + " . $fee),
            'usable' => DB::raw("`usable` + " . $fee),
        ]);
    }

    public function updateUsedAndClearByUuid(string $uuid, int $used)
    {
        $this->find($uuid)->update([
            'used' => DB::raw("`used` + " . $used),
            'cleared' => DB::raw("`cleared` + " . $used),
        ]);
    }


    public function updateCleared(string $uuid, int $cleared)
    {
        $this->find($uuid)->update([
            'cleared' => DB::raw("`cleared` + " . $cleared)
        ]);
    }


    public function getReceiptByNumberAndType(string $number, $type, $admins)
    {
        $receipt = PaymentReceipt::query()->where('number', $number);
        switch ($type) {
            case 1:
                return $receipt->first();
                break;
            case 2:
                return $receipt->whereIn('claim_uuid', $admins)
                    ->where('claim_status', 2)
                    ->first();
                break;
            case 3:
                return $receipt->where('claim_uuid', $admins)
                    ->where('claim_status', 2)
                    ->first();
                break;
        }
    }

    public function getReceiptByNumbersAndType(array $numbers, $type, $admins)
    {
        $receipt = PaymentReceipt::query()
            ->whereIn('number', $numbers)
            ->where('claim_status', 2)
            ->whereRaw('used < usable');
        switch ($type) {
            case 1:
                return $receipt->get();
                break;
            case 2:
                return $receipt->whereIn('claim_uuid', $admins)->get();
                break;
            case 3:
                return $receipt->where('claim_uuid', $admins)->get();
                break;
        }
    }

    /**
     * @param $id
     * @param  array  $columns
     * @return mixed
     * @throws ReceiptException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->find($id, $columns);
        if (is_null($model)) {
            throw new ReceiptException(__('finance::receipt.notFound'));
        }
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * @param  string  $companyNumber
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUnusedReceiptByGNumber($companyNumber)
    {
        return PaymentReceipt::query()->where('customer_company_number', $companyNumber)
            ->whereRaw('`used` < `usable`')
            ->get();
    }
}
